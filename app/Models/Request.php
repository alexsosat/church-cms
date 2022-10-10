<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $fillable = [
        'requesting_user_id',
        'authorizing_user_id',
        'status',
        'type',
        'member_id',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requesting_user_id');
    }

    public function authorizer()
    {
        return $this->belongsTo(User::class, 'authorizing_user_id');
    }
    
}
