<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskAnswer extends Model
{
    protected $table = 'task_answers';

    protected $guarded=[];

    public function student(){
    return $this->belongsTo(User::class , 'student_id');
    }
    public function courseTask(){
        return $this->belongsTo(CourseTeacher::class);
    }

}
