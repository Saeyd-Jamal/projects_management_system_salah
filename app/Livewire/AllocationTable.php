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
use Livewire\WithPagination;

class AllocationTable extends Component
{
    public $allocation;
    public $index;

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

    // get data from models
    public $brokers;
    public $organizations;
    public $projects;
    public $items;
    public $currencies;

    public function mount($allocation, $index)
    {
        $this->allocation = $allocation;
        $this->index = $index;
        
        // get data from models
        $this->brokers = Allocation::select('broker_name')->distinct()->pluck('broker_name')->toArray();
        $this->organizations = Allocation::select('organization_name')->distinct()->pluck('organization_name')->toArray();
        $this->projects = Allocation::select('project_name')->distinct()->pluck('project_name')->toArray();
        $this->items =  Allocation::select('item_name')->distinct()->pluck('item_name')->toArray();
        $this->currencies = Currency::get();

        $this->date_allocation =  $this->allocation->date_allocation ?? Carbon::now()->format('Y-m-d');
        $this->budget_number = $this->allocation->budget_number ?? (Allocation::latest()->first() ? Allocation::latest()->first()->budget_number + 1 : 1);
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
        $this->update('budget_number', $value);

        $this->date_allocation = Carbon::now()->format('Y-m-d');

    }

    public function total(){
        $this->total_dollar = ($this->quantity == '' ? 0 : $this->quantity)    * ($this->price == '' ? 0 : $this->price);
        $currency_allocation_value = Currency::where('code', $this->currency_allocation)->first()->value;
        $this->allocation_field = $this->total_dollar / $currency_allocation_value;
        $this->amount = $this->allocation_field * $currency_allocation_value;

        $this->update('price', $this->price);
        $this->update('quantity', $this->quantity);
        $this->update('total_dollar', $this->total_dollar);
        $this->update('allocation', $this->allocation_field);
        $this->update('currency_allocation', $this->currency_allocation);
        $this->update('currency_allocation_value', $currency_allocation_value);
        $this->update('amount', $this->amount);
    }
    public function allocationFun(){
        $currency_allocation_value = Currency::where('code', $this->currency_allocation)->first()->value;
        if($this->allocation_field != ''){
            $this->amount = $this->allocation_field * $currency_allocation_value;
        }
        $this->update('allocation', $this->allocation_field);
        $this->update('currency_allocation', $this->currency_allocation);
        $this->update('currency_allocation_value', $currency_allocation_value);
        $this->update('amount', $this->amount);
    }
    public function update($name, $value){
        if($name == 'currency_received'){
            $this->update('currency_received', $value);
            $currency_received_value = Currency::where('code', $this->currency_received)->first()->value;
            $this->update('currency_received_value', $currency_received_value);
        }else{
            $this->allocation->$name = $value;
        }
        $this->allocation->save();

    }
    public function render()
    {
        return view('livewire.allocation-table');
    }
}
