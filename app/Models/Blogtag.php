<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogtag extends Model
{
    use HasFactory;

    protected $table = 'blogtags';

    // Laravel Mass Assignment
    protected $guarded = ['id'];
}