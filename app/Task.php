<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $guarded = [];

    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function courseTask(){
        return $this->belongsTo(CourseStudent::class ,'course_id' , 'id');
    }
    public function courseTeacher(){
        return $this->belongsTo(CourseTeacher::class ,'course_id' , 'id');
    }
}
