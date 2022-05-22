<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $primaryKey = 'user_id';
    protected $keyType = 'string';

    protected $guarded = [
    ];


    public function role()
    {
        return $this->belongsTo(RoleModel::class, 'role_id');
    }

    public function article(){
        return $this->hasOne(ArticleModel::class, 'user_id');
    }
}
