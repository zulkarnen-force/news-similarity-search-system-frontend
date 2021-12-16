<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,Sortable;

    protected $fillable = [
        'name',
        'password'
    ];

    public $sortable = ['name','created_at'];

}
