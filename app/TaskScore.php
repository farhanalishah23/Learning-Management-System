<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskScore extends Model
{
    protected $table = 'task_scores';
    protected $guarded = [];

    public function student(){
        return $this->belongsTo(User::class, 'student_id');
    }
    public function course(){
        return $this->belongsTo(Course::class,'course_id');
    }
}
