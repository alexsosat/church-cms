<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'is_baptized',
        'baptized_date',
        'user_id',
        'image',
    ];

    public function church()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function image(): string
    {
        if ($this->image == null) {
            return asset('img/placeholder.png');
        }

        return '/' . $this->image;
    }

    public function imagePath(): ?string
    {
        if ($this->image != null) {
            $path = explode('/', $this->image);
            return $path[1] . '/' . $path[2];
        } else {
            return null;
        }

    }
}
