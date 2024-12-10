<?php

namespace App\Observers;

use App\Models\AccreditationProject;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;

class AccreditationProjectObserver
{
    /**
     * Handle the AccreditationProject "created" event.
     */
    public function created(AccreditationProject $accreditationProject): void
    {
        Logs::create([
            'type' => 'create' ,
            'message' => 'تم إضافة مشروع جديد على الإعتمادية' ,
            'data' => 'accreditation_project' ,
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
        ]);
    }

    /**
     * Handle the AccreditationProject "updated" event.
     */
    public function updated(AccreditationProject $accreditationProject): void
    {
        Logs::create([
            'type' => 'update' ,
            'message' => 'تم تحديث بيانات مشروع من الإعتمادية' ,
            'data' => 'accreditation_project' ,
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
        ]);
    }

    /**
     * Handle the AccreditationProject "deleted" event.
     */
    public function deleted(AccreditationProject $accreditationProject): void
    {

    }

    /**
     * Handle the AccreditationProject "restored" event.
     */
    public function restored(AccreditationProject $accreditationProject): void
    {
        //
    }

    /**
     * Handle the AccreditationProject "force deleted" event.
     */
    public function forceDeleted(AccreditationProject $accreditationProject): void
    {
        //
    }
}
