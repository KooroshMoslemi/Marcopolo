<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'general_name', 'model_name', 'price','description','overview','category_id','brand_id','is_active',
    ];

    public function brand(){
        return $this->belongsTo('App\Brand');//,brand_id
    }

    public function category(){
        return $this->belongsTo('App\Category');//,category_id
    }

    public function tags(){
        return $this->belongsToMany('App\Tag');
    }

    public function media(){
        return $this->belongsToMany('App\Media');
    }

    public function payments(){
        return $this->belongsToMany('App\Payment');
    }
}
