<?php

namespace App\Livewire;

use App\Models\Allocation;
use App\Models\Broker;
use App\Models\Currency;
use App\Models\Item;
use App\Models\Organization;
use App\Models\Project;
use Carbon\Carbon;
use Livewire\Component;

class AllocationForm extends Component
{

    public $allocation;
    public $budget_number;
    public $budget_number_error = '';
    public $date_allocation;


    // fields
    public $quantity;
    public $price;
    public $total_dollar;
    public $allocation_field;
    public $amount;
    public $currency_allocation;
    public $currency_received;

    // inputs edit form
    public $editForm = false;
    public $btn_label = null;


    // get data from models
    public $brokers;
    public $organizations;
    public $projects;
    public $items;
    public $currencies;


    public function __construct()
    {
        // get data from models
        $this->brokers = Allocation::select('broker_name')->distinct()->pluck('broker_name')->toArray();
        $this->organizations = Allocation::select('organization_name')->distinct()->pluck('organization_name')->toArray();
        $this->projects = Allocation::select('project_name')->distinct()->pluck('project_name')->toArray();
        $this->items =  Allocation::select('item_name')->distinct()->pluck('item_name')->toArray();
        $this->currencies = Currency::get();
    }


    public function mount($allocation, $btn_label = 'إضافة', $editForm = false)
    {
        $this->allocation = $allocation;
        $this->btn_label = $btn_label;
        $this->editForm = $editForm;


        $this->date_allocation =  $this->allocation->date_allocation ?? Carbon::now()->format('Y-m-d');
        $this->budget_number = $this->allocation->budget_number ?? (Allocation::orderBy('budget_number', 'desc')->first() ? Allocation::orderBy('budget_number', 'desc')->first()->budget_number + 1 : 1);
        // fields
        $this->quantity = $this->allocation->quantity ?? '';
        $this->price = $this->allocation->price ?? '';
        $this->total_dollar = $this->allocation->total_dollar ?? '';
        $this->allocation_field = $this->allocation->allocation ?? '';
        $this->amount = $this->allocation->amount ?? '';

        if(($this->allocation->currency_allocation ?? null) != null){
            $currency = Currency::where('code', $this->allocation->currency_allocation)->first();
            $this->currency_allocation = $currency->code;
        }else{
            $this->currency_allocation =  'USD';
        }
        if(($this->allocation->currency_received ?? null) != null){
            $currency = Currency::where('code', $this->allocation->currency_received)->first();
            $this->currency_received = $currency->code;
        }else{
            $this->currency_received =  'USD';
        }
    }

    public function budget_number_check($value){
        $check = Allocation::where('budget_number', $value)->first();
        if($check != null){
            $this->budget_number_error = 'رقم الموازنة المستعمل موجود سابقا';
        }else{
            $this->budget_number_error = '';
        }
        $this->date_allocation = Carbon::now()->format('Y-m-d');
    }

    public function total(){
        if(is_numeric($this->quantity) && is_numeric($this->price)){
            $this->total_dollar = ($this->quantity == '' ? 0 : $this->quantity)    * ($this->price == '' ? 0 : $this->price);
            $currency_allocation_value = Currency::where('code', $this->currency_allocation)->first()->value;
            $this->allocation_field = $this->total_dollar / $currency_allocation_value;
            $this->amount = $this->allocation_field * $currency_allocation_value;
        }

    }
    public function allocationFun(){
        if(is_numeric($this->allocation_field)){
            $currency_allocation_value = Currency::where('code', $this->currency_allocation)->first()->value;
            if($this->allocation_field != ''){
                $this->amount = $this->allocation_field * $currency_allocation_value;
            }
        }
    }

    public function calculate($field)
    {
        try {
            // تحديد الحقل الذي تسبب في الحدث وتحديث قيمته فقط
            if ($field === 'quantity') {
                $this->quantity = eval("return {$this->quantity};");
                $this->total();
            } elseif ($field === 'price') {
                $this->price = eval("return {$this->price};");
                $this->total();
            } elseif ($field === 'allocation') {
                $this->allocation_field = eval("return {$this->allocation_field};");
                $this->allocationFun();
            }
        } catch (\Throwable $e) {
            // إرسال رسالة تنبيه للمستخدم
            $this->dispatchBrowserEvent('alert', ['message' => 'يرجى إدخال معادلة صحيحة!']);
        }
    }

    public function render()
    {
        return view('livewire.allocation-form');
    }
}
