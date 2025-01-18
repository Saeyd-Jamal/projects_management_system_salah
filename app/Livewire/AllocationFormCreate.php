<?php

namespace App\Livewire;

use App\Models\AccreditationProject;
use App\Models\Allocation;
use App\Models\Broker;
use App\Models\Currency;
use App\Models\Item;
use App\Models\Organization;
use App\Models\Project;
use Carbon\Carbon;
use Livewire\Component;

class AllocationFormCreate extends Component
{

    public $allocation;
    public $budget_number;
    public $budget_number_error = '';
    public $date_allocation;

    public $num_allo = 0;


    // fields
    public $field = [
        "1" => [
            'quantity' => '',
            'price' => '',
            'total_dollar' => '',
            'allocation_field' => '',
            'amount' => '',
            'currency_allocation' => 'USD',
            'currency_allocation_value' => ''
        ],
    ];


    // inputs edit form
    public $editForm = false;
    public $btn_label = null;


    // get data from models
    public $brokers;
    public $organizations;
    public $projects;
    public $items;
    public $currencies;


    private function initializeFields()
    {
        $this->field = [
            [
                'quantity' => '',
                'price' => '',
                'total_dollar' => '',
                'allocation_field' => '',
                'amount' => '',
                'currency_allocation' => 'USD',
                'currency_allocation_value' => Currency::where('code', 'USD')->first()->value
            ]
        ];
    }

    public function addAllocation()
    {
        $this->num_allo++;
    
        // إضافة تخصيص جديد افتراضي إلى الحقول
        $this->field[$this->num_allo] = [
            'quantity' => '',
            'price' => '',
            'total_dollar' => '',
            'allocation_field' => '',
            'amount' => '',
            'currency_allocation' => 'USD',
            'currency_allocation_value' => Currency::where('code', 'USD')->first()->value
        ];
    }
    public function removeAllocation($index)
    {
        unset($this->field[$index]);
        $this->field = array_values($this->field); // إعادة ترتيب الفهرس
        $this->num_allo = count($this->field); // تحديث العدد
    }

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
        $this->initializeFields();

        $this->allocation = $allocation;
        $this->btn_label = $btn_label;
        $this->editForm = $editForm;


        $this->date_allocation =  $this->allocation->date_allocation ?? Carbon::now()->format('Y-m-d');
        if(AccreditationProject::where('type', 'allocation')->count() > 0){
            // $this->budget_number  =  $this->allocation->budget_number ?? (AccreditationProject::where('type', 'allocation')->orderBy('budget_number', 'desc')->whereYear('date_allocation', Carbon::now()->format('Y'))->first() ? AccreditationProject::where('type', 'allocation')->orderBy('budget_number', 'desc')->whereYear('date_allocation', Carbon::now()->format('Y'))->first()->budget_number + 1 : 1);
            if($this->allocation->budget_number != null){
                $this->budget_number  =  $this->allocation->budget_number;
            }else{
                $budget_number = AccreditationProject::where('type', 'allocation')->whereYear('date_allocation', Carbon::now()->format('Y'))->orderBy('budget_number', 'desc')->first();

                if($budget_number != null){
                    $budget_number_allocation =  Allocation::whereYear('date_allocation', Carbon::now()->format('Y'))->orderBy('budget_number', 'desc')->first() ? Allocation::whereYear('date_allocation', Carbon::now()->format('Y'))->orderBy('budget_number', 'desc')->first()->budget_number : 1;
                    if($budget_number_allocation > $budget_number->budget_number){
                        $budget_number  =  $budget_number_allocation;
                    }else{
                        $budget_number  =  $budget_number->budget_number;
                    }
                    $this->budget_number  =  $budget_number + 1;
                }else{
                    $this->budget_number  =  1;
                }
            }

        }else{
            $this->budget_number  =  $this->allocation->budget_number ?? (Allocation::whereYear('date_allocation', Carbon::now()->format('Y'))->orderBy('budget_number', 'desc')->first() ? Allocation::whereYear('date_allocation', Carbon::now()->format('Y'))->orderBy('budget_number', 'desc')->first()->budget_number + 1 : 1);
        }
    }

    public function budget_number_check($value){
        $check = Allocation::where('budget_number', $value)->whereYear('date_allocation', Carbon::now()->format('Y'))->first();
        if($check != null){
            $this->budget_number_error = 'رقم الموازنة المستعمل موجود سابقا';
        }else{
            $this->budget_number_error = '';
        }
        $this->date_allocation = Carbon::now()->format('Y-m-d');
    }

    public function total($index)
    {
        if (is_numeric($this->field[$index]['quantity']) && is_numeric($this->field[$index]['price'])) {
            $this->field[$index]['total_dollar'] = 
                ($this->field[$index]['quantity'] == '' ? 0 : $this->field[$index]['quantity']) *
                ($this->field[$index]['price'] == '' ? 0 : $this->field[$index]['price']);
            
            $currency_allocation_value = 1 / $this->field[$index]['currency_allocation_value'];
            $this->field[$index]['allocation_field'] = $this->field[$index]['total_dollar'];
            $this->field[$index]['amount'] = $this->field[$index]['allocation_field'] * $currency_allocation_value;
        }
    }



    public function changeCurrency($index)
    {
        $currency_allocation_value = Currency::where('code', $this->field[$index]['currency_allocation'])->first()
            ? Currency::where('code', $this->field[$index]['currency_allocation'])->first()->value
            : 1;

        $this->field[$index]['currency_allocation_value'] = (float) number_format((1 / $currency_allocation_value), 4);

        $this->allocationFun($index); // استدعاء الدالة لتحديث القيمة بناءً على الحقل المحدد
    }



    public function allocationFun($index)
    {
        if (is_numeric($this->field[$index]['allocation_field'])) {
            if ($this->field[$index]['allocation_field'] != '') {
                $amount = number_format(
                    ($this->field[$index]['allocation_field'] / (float) $this->field[$index]['currency_allocation_value']),
                    2,
                    '.',
                    ''
                );

                $formattedNumber = floatval($amount);
                $this->field[$index]['amount'] = $formattedNumber;
            }
        }
    }

    


    public function calculate($index, $field)
    {
        try {
            // تحديث الحقل الذي تسبب في الحدث فقط
            if ($field === 'quantity') {
                $this->field[$index]['quantity'] = eval("return {$this->field[$index]['quantity']};");
                $this->total($index); // استدعاء دالة الإجمالي
            } elseif ($field === 'price') {
                $this->field[$index]['price'] = eval("return {$this->field[$index]['price']};");
                $this->total($index); // استدعاء دالة الإجمالي
            } elseif ($field === 'allocation_field') {
                $this->field[$index]['allocation_field'] = eval("return {$this->field[$index]['allocation_field']};");
                $this->allocationFun($index); // استدعاء دالة الحساب
            } elseif ($field === 'currency_allocation_value') {
                $this->field[$index]['currency_allocation_value'] = eval("return {$this->field[$index]['currency_allocation_value']};");
                $this->allocationFun($index); // استدعاء دالة الحساب
            }
        } catch (\Throwable $e) {
            // إرسال رسالة تنبيه للمستخدم
            // $this->dispatchBrowserEvent('alert', ['message' => 'يرجى إدخال معادلة صحيحة!']);
        }
    }


    public function render()
    {
        return view('livewire.allocation-form-create');
    }
}
