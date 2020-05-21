<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'tck', 'user_id', 'status', 'password', 'role', 'description', ''
    ];
}
