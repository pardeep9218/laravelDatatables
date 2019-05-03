<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    public  function colors(){
    	return $this->belongsToMany('App\Color', 'products_colors', 'product_id', 'color_id');
    }
    
    public  function categories(){
    	return $this->belongsToMany('App\Category', 'products_categories', 'product_id', 'category_id');
    }
}
