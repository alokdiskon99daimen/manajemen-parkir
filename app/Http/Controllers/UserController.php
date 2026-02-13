<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::with('roles')->select('id','name','email');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('role', function ($row) {
                    return $row->roles->pluck('name')->implode(', ');
                })
                ->addColumn('aksi', function ($row) {
                    return '
                        <div class="flex justify-center gap-2">
                            <a href="'.route('user.edit',$row->id).'" class="text-blue-600 hover:underline mr-2">
                                Edit
                            </a>
                            <form action="'.route('user.destroy',$row->id).'" method="POST">
                                '.csrf_field().method_field('DELETE').'
                                <button class="text-red-600 hover:underline"
                                    onclick="return confirm(\'Yakin ingin menghapus data ini??\')">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    ';
                })

                ->rawColumns(['aksi','role'])
                ->make(true);
        }

        return view('user.index');
    }

    public function create()
    {
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role'     => 'required',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('user.index');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $userRole = $user->roles->pluck('name')->first();

        return view('user.edit', compact('user','roles','userRole'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'role' => 'required',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $user->syncRoles([$request->role]);

        return redirect()->route('user.index');
    }
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')
            ->with('success', 'User berhasil dihapus');
    }
}
