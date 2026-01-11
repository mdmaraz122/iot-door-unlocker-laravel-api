<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LockLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
    ];
    // Define relationship to User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
