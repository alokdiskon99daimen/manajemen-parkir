<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class LogAktivitas extends Model
{
    protected $table = 'tb_log_aktivitas';

    public $timestamps = true;

    protected $fillable = [
        'id_user',
        'ip',
        'user_agent',
        'method',
        'activity',
        'before',
        'after',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
