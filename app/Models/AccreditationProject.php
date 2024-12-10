<?php

namespace App\Models;

use App\Observers\AccreditationProjectObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccreditationProject extends Model
{
    use HasFactory;

    protected $table = 'accreditation_projects';
    protected $guarded = ['id'];


    public static function boot()
    {
        parent::boot();
        AccreditationProject::observe(AccreditationProjectObserver::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
