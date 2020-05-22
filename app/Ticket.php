<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'tck_no', 'user_id', 'status', 'subject', 'description', 'closed_at'
    ];

    public function replies()
    {
        return $this->hasMany('App\Reply', 'ticket_id');
    } 

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    } 
}
