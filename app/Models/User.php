<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

    protected $fillable = [
        'role_id',
        'nama',
        'email',
        'password_hash',
        'is_active',
        'must_change_password'
    ];

    protected $hidden = ['password_hash'];

    protected $casts = [
        'is_active' => 'boolean',
        'must_change_password' => 'boolean',
    ];

    // Laravel Auth default cari kolom "password", jadi kita arahkan ke "password_hash"
    public function getAuthPasswordName(): string
    {
        return 'password_hash';
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id'); // owner key default roles.id
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'user_id'); // user_id di siswa -> users.id
    }

    public function guruBk()
    {
        return $this->hasOne(GuruBk::class, 'user_id');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id');
    }
}
