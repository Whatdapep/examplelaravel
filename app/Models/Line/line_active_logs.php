<?php

namespace App\Model\Api\Line;

use Illuminate\Database\Eloquent\Model;

class line_active_logs extends Model
{
    //
    protected $table = 'line_active_logs';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    "id",
    "event_type",
    "replyToken",
    "userId",
    "source_type",
    "message_type",
    "message",
    "line_timestamp",
    "line_mode",
    "destination",
    "created_at",
    "updated_at",
    "keep_logs",
    // "device",
     ];
    /**
     * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [
        'replyToken','destination','userId'
    ];
}
