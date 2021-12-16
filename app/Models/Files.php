<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Files extends Model
{
    use HasFactory,Sortable;

    protected $fillable = [
        'filename',
        'path',
        'created_by'
    ];



    public function report()
    {
        return $this->hasOne(User::class,'id','created_by');
    }
}
