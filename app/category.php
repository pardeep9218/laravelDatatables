<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class category extends Model
{
    use SoftDeletes;
    //
    protected $fillable = [
        'name', 'slug', 'parent',
    ];
    protected $dates = ['deleted_at'];

    /**
   * Override parent boot and Call deleting event
   *
   * @return void
   */
   protected static function boot() 
    {
      parent::boot();

      static::deleting(function($categories) {
         foreach ($categories->children()->get() as $child) {
            $child->delete();
         }
      });
    }

    public function parent()
    {
        return $this->belongsTo('App\Category', 'parent','id');
    }

    public function children()
    {
        return $this->hasMany('App\Category', 'parent', 'id');
    }

    public function grandchildren()
    {
        return $this->children()->with('grandchildren');
    }

    public function grandparent()
    {
        return $this->parent()->with('grandparent');
    }

    public  function products(){
      return $this->belongsToMany('App\Product', 'products_categories', 'category_id', 'product_id');
    }

}
