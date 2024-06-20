<?php

namespace App\Models;

use Carbon\Carbon;
use App\GenderEnum;
use App\TeacherStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    protected $appends = ['full_name', 'age'];

    protected function casts()
    {
        return [
            'status'    => TeacherStatus::class,
            'gender'    =>   GenderEnum::class,
        ];
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->birthdate)->age;
    }

    public function getFullNameAttribute()
    {
        $fullName = "{$this->last_name}, {$this->first_name}";
        if (!empty($this->middle_name)) {
            $fullName .= " {$this->middle_name[0]}.";
        }
        return $fullName;
    }

     public function subjects(){
        return $this->hasMany(Subject::class);
     }
}
