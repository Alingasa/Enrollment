<?php

namespace App\Models;

use App\GradeEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'school_id',
        '_token',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'contact_number',
        'gender',
        'birthdate',
        'civil_status',
        'religion',
        'purok',
        'sitio_street',
        'barangay',
        'municipality',
        'province',
        'zip_code',
        'guardian_name',
        'grade_level',
        'strand_id',
        'profile_image',
        'status',
        'status_type',
    ];

    protected $appends = ['full_name', 'age'];

    public function casts(){
        return [
            'grade_level'       => GradeEnum::class,
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

    public function strand(){
        return $this->belongsTo(Strand::class);
    }

    public function section(){
        return $this->belongsTo(Section::class);
    }
}
