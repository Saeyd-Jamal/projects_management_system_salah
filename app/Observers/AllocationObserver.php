<?php

namespace App\Observers;

use App\Models\Allocation;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;

class AllocationObserver
{
    /**
     * Handle the Allocation "created" event.
     */
    public function created(Allocation $allocation): void
    {
        Logs::create([
            'type' => 'create' ,
            'message' => 'تم إضافة تخصيص جديد ورقم الموزانة : ' . $allocation->budget_number,
            'data' => 'allocation' ,
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
        ]);
    }

    /**
     * Handle the Allocation "updated" event.
     */
    public function updated(Allocation $allocation): void
    {
        Logs::create([
            'type' => 'update' ,
            'message' => 'تم تحديث بيانات تخصيص ورقم موازنته : ' . $allocation->budget_number,
            'data' => 'allocation',
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
        ]);
    }

    /**
     * Handle the Allocation "deleted" event.
     */
    public function deleted(Allocation $allocation): void
    {
        Logs::create([
            'type' => 'delete' ,
            'message' => 'تم حذف تخصيص ورقم موازنته : ' . $allocation->budget_number,
            'data' => 'allocation' ,
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
        ]);
    }

    /**
     * Handle the Allocation "restored" event.
     */
    public function restored(Allocation $allocation): void
    {
        //
    }

    /**
     * Handle the Allocation "force deleted" event.
     */
    public function forceDeleted(Allocation $allocation): void
    {
        //
    }
}
