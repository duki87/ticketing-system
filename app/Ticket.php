<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Ticket extends Model
{
    use Sortable;
    
    protected $fillable = [
        'tck_no', 'user_id', 'status', 'subject', 'description', 'closed_at'
    ];

    public $sortable = ['status', 'created_at'];

    public function replies()
    {
        return $this->hasMany('App\Reply', 'ticket_id');
    } 

    public function admin_replies()
    {
        return $this->hasMany('App\Reply', 'ticket_id')->whereNotNull(['admin_id']);
    } 

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    } 
}
