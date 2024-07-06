<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use App\Models\Teacher;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'name',
        'email',
        'password',
    ];

    // protected $with = [
    //     'teacher'
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function setPassword($value){
        return $this->attributes['password'] = Hash::make($value);
    }

    public function teacher(){
        return $this->hasOne(Teacher::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {

        if($panel->getId() == 'admin'){
           return empty($this->teacher);
        }
    }

    public function getRoleAttribute()
    {
        return ($this->teacher()->exists()) ? 'Teacher' : 'Admin';
    }
}
