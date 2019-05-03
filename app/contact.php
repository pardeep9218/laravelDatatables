<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class contact extends Model
{
    protected $fillable = [
        'title', 'address', 'location', 'email', 'contact', 'timings'
    ];
}
