<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleModel extends Model
{
    use HasFactory;
    protected $table = 'articles';
    protected $primaryKey = 'article_id';
    protected $keyType = 'string';
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
