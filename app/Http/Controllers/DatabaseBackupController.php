<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class DatabaseBackupController extends Controller
{
    public function index()
    {
        return view('database.index');
    }

    // EXPORT FULL DATABASE
    public function exportSql()
    {
        $dbName = DB::getDatabaseName();
        $tables = DB::select('SHOW TABLES');

        $key = 'Tables_in_' . $dbName;
        $sql = "-- Backup Database {$dbName}\n\n";

        foreach ($tables as $table) {
            $tableName = $table->$key;

            // DROP + CREATE TABLE
            $createTable = DB::select("SHOW CREATE TABLE {$tableName}")[0]->{'Create Table'};
            $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
            $sql .= $createTable . ";\n\n";

            // DATA
            $rows = DB::table($tableName)->get();
            foreach ($rows as $row) {
                $columns = array_map(fn($v) => "`{$v}`", array_keys((array)$row));
                $values  = array_map(fn($v) => DB::getPdo()->quote($v), array_values((array)$row));

                $sql .= "INSERT INTO `{$tableName}` (" . implode(',', $columns) . ") ";
                $sql .= "VALUES (" . implode(',', $values) . ");\n";
            }

            $sql .= "\n\n";
        }

        $fileName = 'backup_' . date('Ymd_His') . '.sql';

        return response($sql)
            ->header('Content-Type', 'application/sql')
            ->header('Content-Disposition', "attachment; filename={$fileName}");
    }

    // IMPORT FULL DATABASE
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:sql'
        ]);

        try {
            $sql = file_get_contents($request->file('file')->getRealPath());

            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            // SPLIT PALING AMAN
            $statements = array_filter(array_map('trim', explode(';', $sql)));

            foreach ($statements as $statement) {
                DB::statement($statement . ';');
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            return back()->with('success', 'Database berhasil direstore');
        } catch (\Throwable $e) {
            return back()->with('error', 'Restore gagal: ' . $e->getMessage());
        }
    }
}
