<?php

namespace App\Livewire;

use App\Models\Allocation;
use App\Models\Executive;
use Livewire\Component;

class DynamicFormLoader extends Component
{
    public $selectedForm = 'allocations';
    public $load = '';
    public $allocation;
    public $executive;

    public function mount()
    {
        $this->allocation = new Allocation();
        $this->executive = new Executive();
    }
    public function loadForm()
    {
        $this->load = $this->selectedForm;
    }
    public function render()
    {
        return view('livewire.dynamic-form-loader');
    }
}
