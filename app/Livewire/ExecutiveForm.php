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

class ExecutiveForm extends Component
{
    public $executive;
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

    public function __construct()
    {
        // get data from executive table
        $this->accounts = Executive::select('account')->distinct()->pluck('account')->toArray();
        $this->affiliate_names = Executive::select('affiliate_name')->distinct()->pluck('affiliate_name')->toArray();
        $this->receiveds = Executive::select('received')->distinct()->pluck('received')->toArray();
        $this->details = Executive::select('detail')->distinct()->pluck('detail')->toArray();

        // get data from models
        $this->brokers = Executive::select('broker_name')->distinct()->pluck('broker_name')->toArray();
        $this->projects = Executive::select('project_name')->distinct()->pluck('project_name')->toArray();
        $this->items =  Executive::select('item_name')->distinct()->pluck('item_name')->toArray();
        $this->currencies = Currency::get();
    }

    public function mount($executive, $btn_label = 'إضافة', $editForm = false)
    {
        $this->executive = $executive;
        $this->btn_label = $btn_label;
        $this->editForm = $editForm;


        $this->implementation_date =  $this->executive->implementation_date ?? Carbon::now()->format('Y-m-d');
        // $this->budget_number = $this->executive->budget_number ?? (Allocation::latest()->first() ? Allocation::latest()->first()->budget_number + 1 : 1);

        // fields
        $this->quantity = $this->executive->quantity ?? '';
        $this->price = $this->executive->price ?? '';
        $this->total_ils = $this->executive->total_ils ?? '';


    }

    public function total(){
        $this->total_ils = ($this->quantity == '' ? 0 : $this->quantity)    * ($this->price == '' ? 0 : $this->price);
    }
    public function render()
    {
        return view('livewire.executive-form');
    }
}
