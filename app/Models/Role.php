<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = ['nama_role'];

    // timestamps default true, sudah cocok dengan migration

    public function users()
    {
        return $this->hasMany(User::class, 'role_id'); // role_id di users mengarah ke roles.id
    }
}
