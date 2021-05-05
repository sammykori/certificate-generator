<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $table = 'certificates';
    protected $primaryKey = 'id';
    protected $fillable = array('name', 'email', 'course', 'module', 'completion_date');
    protected $casts = [
        'id' => 'string'
    ];
}
