<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

     // Определите связь многие ко многим с офферами
     public function offers()
     {
         return $this->belongsToMany(Offer::class, 'topics');
     }
}
