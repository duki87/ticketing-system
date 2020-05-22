<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = [
        'admin_id', 'ticket_id', 'reply'
    ];

    public function ticket()
    {
        return $this->hasOne('App\Ticket', 'id', 'ticket_id');
    } 

    public function admin()
    {
        return $this->hasOne('App\User', 'id', 'admin_id');
    }
}
