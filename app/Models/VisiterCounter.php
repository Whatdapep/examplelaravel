<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisiterCounter extends Model
{

    protected $table = 'www_counter';
    protected $primaryKey = 'seq';
    protected $fillable = [
        'ip_address',
        'visit_date',
        'visit_time',
        'session_id'
    ];

    public $timestamps = false;
}
