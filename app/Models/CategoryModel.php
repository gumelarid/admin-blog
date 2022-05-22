<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use HasFactory;

    protected $table = 'category';
    protected $primaryKey = 'category_id';
    protected $keyType = 'string';
    protected $guarded = [];

    public function article(){
        return $this->hasOne(ArticleModel::class, 'category_id');
    }
}
