<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetailModel extends Model
{
    use HasFactory;

    protected $table = 'user_detail';

    protected $primaryKey = 'id';

    protected $guarded = [];
}
