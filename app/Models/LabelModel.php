<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabelModel extends Model
{
    use HasFactory;
    protected $table = 'label';

    protected $primaryKey = 'id_label';

    protected $guarded = [];
    
    function Navigation(){
        return $this->hasOne(LabelModel::class, 'id_label');
    }
}
