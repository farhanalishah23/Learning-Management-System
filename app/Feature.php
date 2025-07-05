<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $table = 'features';

    protected $guarded = [];

    protected $appends = ['shortDescription','shortTitle'];
    public function getShortDescriptionAttribute(){
        return \Illuminate\Support\Str::limit($this->description, 100);
    }
    public function getShortTitleAttribute(){
        return \Illuminate\Support\Str::limit($this->title, 30);
    }
}
