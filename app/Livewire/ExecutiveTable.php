<?php

namespace App\Livewire;

use App\Models\Broker;
use App\Models\Currency;
use App\Models\Executive;
use App\Models\Item;
use App\Models\Organization;
use App\Models\Project;
use Carbon\Carbon;
use Livewire\Component;

class ExecutiveTable extends Component
{
    public $executive;
    public $index;
    public $implementation_date;

    // fields
    public $quantity;
    public $price;
    public $total_ils;

    // get data from executive table
    public $accounts;
    public $affiliate_names;
    public $receiveds;
    public $details;

    // inputs edit form
    public $editForm = false;
    public $btn_label = null;


    // get data from models
    public $brokers;
    public $projects;
    public $items;
    public $currencies;


    public function mount($executive , $index,$accounts, $affiliate, $receiveds, $details, $brokers, $projects, $items, $currencies, $btn_label = 'إضافة', $editForm = false)
    {
        $this->executive = $executive;
        $this->index = $index;
        $this->btn_label = $btn_label;
        $this->editForm = $editForm;

        // get data from executive table
        $this->accounts = $accounts;
        $this->affiliate_names = $affiliate;
        $this->receiveds = $receiveds;
        $this->details = $details;

        // get data from models
        $this->brokers = $brokers;
        $this->projects = $projects;
        $this->items =  $items;
        $this->currencies = $currencies;


        $this->implementation_date =  $this->executive->implementation_date ?? Carbon::now()->format('Y-m-d');
        // $this->budget_number = $this->executive->budget_number ?? (Allocation::latest()->first() ? Allocation::latest()->first()->budget_number + 1 : 1);

        // fields
        $this->quantity = $this->executive->quantity ?? '';
        $this->price = $this->executive->price ?? '';
        $this->total_ils = $this->executive->total_ils ?? '';
    }

    public function total()
    {
        $this->total_ils = ($this->quantity == '' ? 0 : $this->quantity)    * ($this->price == '' ? 0 : $this->price);
        $this->update('quantity', $this->quantity);
        $this->update('price', $this->price);
        $this->update('total_ils', $this->total_ils);
    }
    public function update($name, $value){
        $this->executive->$name = $value;
        $this->executive->save();
    }
    public function render()
    {
        return view('livewire.executive-table');
    }
}
