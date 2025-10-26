<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usertype extends Model
{
    use HasFactory;
    protected $table = 'usertype';
    protected $fillable = [
        'name'
    ];

}
