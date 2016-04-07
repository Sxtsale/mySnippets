<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Snippets extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'snippet_id', 'revision_id', 'extension', 'snippet', 'username',
    ];
    
}
