<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory;

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
