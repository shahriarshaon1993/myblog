<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogcategory extends Model
{
    use HasFactory;

    protected $table = 'blogcategories';

    // Laravel Mass Assignment
    protected $guarded = ['id'];
}