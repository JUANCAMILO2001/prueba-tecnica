<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    use HasFactory;
    protected $table = 'ciudads';
    protected $primaryKey = 'id';
    protected $fillable = [
      'name',
      'country',
      'population',
    ];

    public function users()
    {
        return $this->hasMany('App\Models\User', 'city_id');
    }
}
