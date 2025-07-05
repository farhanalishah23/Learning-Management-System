<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseTeacher extends Model
{
    protected $table='course_teachers';

    protected $guarded = [];

    public function teacher(){
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function students(){
        return $this->hasMany(CourseStudent::class, 'course_id', 'course_id');
    }
    public function teacherCourseTask(){
        return $this->hasOne(TaskAnswer::class , 'course_id','course_id');
    }
    public function teacherStudents(){
        return $this->hasMany(CourseStudent::class , 'course_id','course_id');
    }
    public function task(){
        return $this->belongsTo(Task::class, 'course_id', 'course_id');
    }
    public function taskAnswer(){
        return $this->belongsTo(TaskAnswer::class , 'course_id','course_id');
    }
}
