<?php

namespace App\Models;

use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Strand extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function setNameAttribute($value){

        return $this->attributes['name'] = ucwords($value);

    }

    public function enrollments(){

        return $this->hasMany(Enrollment::class);

    }
}
