<?php

namespace App\Observers;

use App\Models\Executive;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;

class ExecutiveObserver
{
    /**
     * Handle the Executive "created" event.
     */
    public function created(Executive $executive): void
    {
        Logs::create([
            'type' => 'create' ,
            'message' => 'تم إضافة تنفيذ جديد لمؤسسة : ' . $executive->broker_name . " وتاريخه : " . $executive->implementation_date,
            'data' => 'executive' ,
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
        ]);
    }

    /**
     * Handle the Executive "updated" event.
     */
    public function updated(Executive $executive): void
    {
        Logs::create([
            'type' => 'update' ,
            'message' => 'تم تحديث بيانات تنفيذ لمؤسسة : ' . $executive->broker_name . " وتاريخه : " . $executive->implementation_date,
            'data' => 'executive' ,
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
        ]);
    }

    /**
     * Handle the Executive "deleted" event.
     */
    public function deleted(Executive $executive): void
    {
        Logs::create([
            'type' => 'delete' ,
            'message' => 'تم حذف تنفيذ لمؤسسة : ' . $executive->broker_name . " وتاريخه : " . $executive->implementation_date,
            'data' => 'executive' ,
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
        ]);
    }

    /**
     * Handle the Executive "restored" event.
     */
    public function restored(Executive $executive): void
    {

    }

    /**
     * Handle the Executive "force deleted" event.
     */
    public function forceDeleted(Executive $executive): void
    {
        //
    }
}
