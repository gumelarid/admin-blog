<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    use HasFactory;

    protected $table = 'user_role';
    protected $primaryKey = 'role_id';
    protected $guarded = ['role_id'];

    public function user(){
        return $this->hasOne(User::class, 'role_id');
    }
}
