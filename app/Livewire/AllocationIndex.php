<?php

namespace App\Livewire;

use App\Models\Allocation;
use App\Models\Currency;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class AllocationIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap'; // تأكد من تعيين الشكل المناسب للتصفح

    public $paginationItems = 10;

    public $amounts_allocated = 0;
    public $amounts_received = 0;
    public $remaining = 0;
    public $collection_rate = 0;

    public $filterArray = [
        'budget_number' => '',
        'from_date_allocation' => '',
        'to_date_allocation' => '',
        'broker_name' => '',
        'organization_name' => '',
        'project_name' => '',
        'item_name' => '',
    ];

    public $filterB = false;

    public function filterBox(){
        $this->filterB = !$this->filterB;
        $this->render();
    }


    // get data from models
    public $brokers;
    public $organizations;
    public $projects;
    public $items;
    public $currencies;

    public function mount(){

        // get data from models
        $this->brokers = Allocation::select('broker_name')->distinct()->pluck('broker_name')->toArray();
        $this->organizations = Allocation::select('organization_name')->distinct()->pluck('organization_name')->toArray();
        $this->projects = Allocation::select('project_name')->distinct()->pluck('project_name')->toArray();
        $this->items =  Allocation::select('item_name')->distinct()->pluck('item_name')->toArray();
        $this->currencies = Currency::get();

    }
    // دالة الفلتر
    public function filter()
    {
        // إعادة التهيئة إلى الصفحة الأولى عند تغيير الفلتر
        $this->render();
    }

    // دالة render لعرض البيانات
    public function render()
    {
        // جلب البيانات وتطبيق الفلاتر
        $allocations = Allocation::query();
        $filterCheck = false;
        foreach ($this->filterArray as $key => $value) {
            if (!empty($value)) {
                if ($key == 'from_date_allocation') {
                    // تحويل التاريخ إلى تنسيق Y-m-d
                    $key = 'date_allocation';
                    $value = Carbon::parse($value)->format('Y-m-d');
                    $allocations->where($key, '>=', $value);
                } elseif ($key == 'to_date_allocation'){
                    // تحويل التاريخ إلى تنسيق Y-m-d
                    $key = 'date_allocation';
                    $value = Carbon::parse($value)->format('Y-m-d');
                    if ($value == '') {
                        $value = Carbon::now()->format('Y-m-d');
                    }
                    $allocations->where($key, '<=', $value);
                }else{
                    // تطبيق فلتر LIKE للحقول النصية
                    $allocations->where($key, 'LIKE', "%{$value}%");
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
            $allocations = Allocation::query();
        }
        // $filterCheck = !empty(array_filter($this->filterArray));

        $this->amounts_allocated = $allocations->sum('amount');
        $this->amounts_received = $allocations->sum('amount_received');
        $this->remaining = $this->amounts_allocated - $this->amounts_received;

        if($this->amounts_allocated != 0 && $this->amounts_received != 0){
            $this->collection_rate = ($this->amounts_received / $this->amounts_allocated) * 100;
        }else{
            $this->collection_rate = 0;
        }


        if($this->paginationItems == "all"){
            $allocations = $allocations->get();
        }else{
            $allocations = $allocations->paginate(intval($this->paginationItems));
        }


        // إعادة عرض البيانات إلى الـ view
        return view('livewire.allocation-index', compact('allocations', 'filterCheck'));
    }
}
