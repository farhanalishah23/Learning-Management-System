<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;
    protected $table = 'courses';
    protected $guarded = [];

    protected $appends = ['shortTitle','shortDescription' ];
    public function getShortTitleAttribute(){
        return \Illuminate\Support\Str::limit($this->title, 30);
    }
    public function getShortDescriptionAttribute(){
        return \Illuminate\Support\Str::limit($this->description, 90);
    }
    public function attachments(){
        return  $this->hasMany(CourseAttachment::class,'course_id');
    }
    public function primaryAttachment(){
        return  $this->hasOne(CourseAttachment::class,'course_id');
    }
    public function categories(){
        return $this->hasMany(Category::class , 'category_id');
    }
    public function teacher(){
        return $this->hasOne(CourseTeacher::class, 'course_id');
    }
    public function students(){
        return $this->hasMany(CourseStudent::class, 'course_id');
    }
    public function task(){
        return $this->belongsTo(Task::class);
    }
}
