<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class location extends Model
{
    protected $table = 'location';
    protected $fillable = [
      'id',
      'name',
      'lat',
      'long',
      'desc',
     
  ];
}
