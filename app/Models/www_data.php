<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class www_data extends Model
{

    protected $table = 'www_data';
    protected $primaryKey = 'No';
    protected $fillable = [
        'Category',
        'Question',
        'Note',
        'Name',
        'Namer',
        'IP',
        'Email',
        'Reply',
        'ReplayDate',
        'Date',
        'nphoto',
        'ndata',
        'pageview',
        'nmedia',
        'DataDisable',
        'DataSort'
    ];
    public $timestamps = false;
}
