<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role','image','status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $appends = ['shortCreatedAt','shortName'];
    public function getShortNameAttribute(){
        return \Illuminate\Support\Str::limit($this->name, 10);
    }
    public function getShortCreatedAtAttribute(){
        return \Carbon\Carbon::parse($this->created_at)->diffForHumans();
    }
    public function studentCourses(){
        return $this->hasMany(CourseStudent::class,'student_id','id');
    }
    public function managedCourses(){
        return $this->hasMany(CourseTeacher::class, 'teacher_id', 'id');
    }
    public function hasRole($role){
        return $this->role == $role;
    }

}
