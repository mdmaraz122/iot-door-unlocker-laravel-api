<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'pass_key',
        'remember_token',
        'status',
    ];
    // Define relationship to LockLog model
    public function lockLogs()
    {
        return $this->hasMany(LockLog::class);
    }
}
