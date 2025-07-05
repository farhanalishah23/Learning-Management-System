<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testmonial extends Model
{
    protected $table = 'testimonials';

    protected $guarded = [];

    protected $appends = ['shortDescription'];
    public function getShortDescriptionAttribute(){
        return \Illuminate\Support\Str::limit($this->description, 50);
    }
}
