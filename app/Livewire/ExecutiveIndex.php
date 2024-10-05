<?php

namespace App\Livewire;

use App\Models\Currency;
use App\Models\Executive;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ExecutiveIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap'; // تأكد من تعيين الشكل المناسب للتصفح

    public $paginationItems = 10;

    public $ILS = 0;

    public $total_amounts = 0;
    public $total_payments = 0;
    public $remaining_balance = 0;


    public $filterArray = [
        // 'budget_number' => '',
        'from_implementation_date' => '',
        'to_implementation_date' => '',
        'broker_name' => '',
        'organization_name' => '',
        'project_name' => '',
        'item_name' => '',
        'account' => '',
        'affiliate_name' => '',
        'received_name' => '',
    ];

    public $filterB = false;

    public function filterBox(){
        $this->filterB = !$this->filterB;
        $this->render();
        new Executive();
    }



    public $executiveNew;
    public $executivesAdd = 0;

    // get data from executive table
    public $accounts;
    public $affiliates;
    public $receiveds;
    public $details;


    // get data from models
    public $brokers;
    public $projects;
    public $items;
    public $currencies;


    public function mount(){

        $this->executiveNew = new Executive();
        // get data from executive table
        $this->accounts = Executive::select('account')->distinct()->pluck('account')->toArray();
        $this->affiliates = Executive::select('affiliate_name')->distinct()->pluck('affiliate_name')->toArray();
        $this->receiveds = Executive::select('received')->distinct()->pluck('received')->toArray();
        $this->details = Executive::select('detail')->distinct()->pluck('detail')->toArray();

        // get data from models
        $this->brokers = Executive::select('broker_name')->distinct()->pluck('broker_name')->toArray();
        $this->projects = Executive::select('project_name')->distinct()->pluck('project_name')->toArray();
        $this->items =  Executive::select('item_name')->distinct()->pluck('item_name')->toArray();
        $this->currencies = Currency::get();

    }
    // دالة الفلتر
    public function filter()
    {
        // إعادة التهيئة إلى الصفحة الأولى عند تغيير الفلتر
        $this->render();
    }


    public function addRow()
    {
        $this->executivesAdd += 1;

    }

    // دالة render لعرض البيانات
    public function render()
    {
        // جلب البيانات وتطبيق الفلاتر
        $executives = executive::query();
        $filterCheck = false;
        foreach ($this->filterArray as $key => $value) {
            if (!empty($value)) {
                if ($key == 'from_implementation_date') {
                    // تحويل التاريخ إلى تنسيق Y-m-d
                    $key = 'implementation_date';
                    $value = Carbon::parse($value)->format('Y-m-d');
                    $executives->where($key, '>=', $value);
                } elseif ($key == 'to_implementation_date'){
                    // تحويل التاريخ إلى تنسيق Y-m-d
                    $key = 'implementation_date';
                    $value = Carbon::parse($value)->format('Y-m-d');
                    if ($value == '') {
                        $value = Carbon::now()->format('Y-m-d');
                    }
                    $executives->where($key, '<=', $value);
                }else{
                    // تطبيق فلتر LIKE للحقول النصية
                    $executives->where($key, 'LIKE', "%{$value}%");
                }
            }
        }

        foreach ($this->filterArray as $value) {
            if (!empty($value)) {
                $filterCheck = true;
                break; // خروج من الحلقة بمجرد العثور على قيمة غير فارغة
            }
        }

        if($filterCheck == false){
            $allocations = Executive::query();
        }

        $this->total_amounts = $executives->sum('total_ils');
        $this->total_payments = $executives->sum('amount_payments');
        $this->remaining_balance = $this->total_amounts - $this->total_payments;



        if($this->paginationItems == "all"){
            $executives = $executives->paginate(100);
        }else{
            $executives = $executives->paginate(intval($this->paginationItems));
        }

        $this->ILS = Currency::where('code', 'ILS')->first()->value;

        // إعادة عرض البيانات إلى الـ view
        return view('livewire.executive-index', compact('executives','filterCheck'));
    }
}
