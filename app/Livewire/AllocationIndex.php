<?php

namespace App\Livewire;

use App\Models\Allocation;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class AllocationIndex extends Component
{
    // use WithPagination;

    // protected $paginationTheme = 'bootstrap'; // تأكد من تعيين الشكل المناسب للتصفح

    public $filterArray = [
        'budget_number' => '',
        'from_date_allocation' => '',
        'to_date_allocation' => '',

    ];

        // get data from models
        public $brokers;
        public $organizations;
        public $projects;
        public $items;

    public function mount(){

        // get data from models
        $this->brokers = Allocation::select('broker_name')->distinct()->pluck('broker_name')->toArray();
        $this->organizations = Allocation::select('organization_name')->distinct()->pluck('organization_name')->toArray();
        $this->projects = Allocation::select('project_name')->distinct()->pluck('project_name')->toArray();
        $this->items =  Allocation::select('item_name')->distinct()->pluck('item_name')->toArray();
    }
    // دالة الفلتر
    public function filter()
    {
        // إعادة التهيئة إلى الصفحة الأولى عند تغيير الفلتر
        // $this->resetPage();
        $this->render();
    }

    // دالة render لعرض البيانات
    public function render()
    {
        // جلب البيانات وتطبيق الفلاتر
        $allocations = Allocation::query();

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
                } else {
                    // تطبيق فلتر LIKE للحقول النصية
                    $allocations->where($key, 'LIKE', "%{$value}%");
                }
            }
        }

        // التصفح
        $allocations = $allocations->paginate(10);

        // إعادة عرض البيانات إلى الـ view
        return view('livewire.allocation-index', compact('allocations'));
    }
}
