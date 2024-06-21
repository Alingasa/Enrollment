<?php

namespace App\Models;

use App\DaySelectionEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    public function casts(){
        return [
            'day'  => 'array',
        ];
    }

    public function strand(){
      return $this->belongsTo(Strand::class);
    }

    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }


    public function section(){
        return $this->belongsTo(Section::class);
    }

    public function enrollments(){
        return $this->belongsToMany(related: Enrollment::class , table: 'enrollment_subject');
    }

    public function room(){
        return $this->belongsTo(Room::class);
    }


}
