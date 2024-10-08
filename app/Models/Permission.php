<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'role_id',
        'name',
        'ability',
    ];

    // relationship
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
