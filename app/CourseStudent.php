<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseStudent extends Model
{
    protected $table = 'course_students';

    protected $guarded = [];

    public function student(){
        return $this->belongsTo(User::class, 'student_id');
    }
    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function teacher(){
        return $this->belongsTo(CourseTeacher::class, 'course_id','course_id');
    }
    public function task(){
        return $this->HasOne(Task::class, 'course_id' ,'course_id');
    }
    public function taskAnswers(){
        return $this->hasMany(TaskAnswer::class, 'student_id', 'student_id')->where('course_id', $this->course_id);
    }

}
