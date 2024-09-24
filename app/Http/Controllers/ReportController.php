<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\Executive;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class ReportController extends Controller
{
    protected $monthNameAr;

    public function __construct(){
        // مصفوفة لأسماء الأشهر باللغة العربية
        $this->monthNameAr = [
            '01' => 'يناير',
            '02' => 'فبراير',
            '03' => 'مارس',
            '04' => 'أبريل',
            '05' => 'مايو',
            '06' => 'يونيو',
            '07' => 'يوليو',
            '08' => 'أغسطس',
            '09' => 'سبتمبر',
            '10' => 'أكتوبر',
            '11' => 'نوفمبر',
            '12' => 'ديسمبر'
        ];
    }

    public function filterAllocations($data){
        $allocations = Allocation::query();
        if(isset($data["broker"])){
            $allocations = $allocations->whereIn("broker_name",$data["broker"]);
        }
        if(isset($data["organization"])){
            $allocations = $allocations->whereIn("organization_name",$data["organization"]);
        }
        if(isset($data["project"])){
            $allocations = $allocations->whereIn("project_name",$data["project"]);
        }
        if(isset($data["item"])){
            $allocations = $allocations->whereIn("item_name",$data["item"]);
        }
        return $allocations;
    }

    public function filterExecutives($data){
        $executives = Executive::query();
        if(isset($data["broker"])){
            $executives = $executives->whereIn("broker_name",$data["broker"]);
        }
        if(isset($data["account"])){
            $executives = $executives->whereIn("account",$data["account"]);
        }
        if(isset($data["affiliate"])){
            $executives = $executives->whereIn("affiliate_name",$data["affiliate"]);
        }
        if(isset($data["project"])){
            $executives = $executives->whereIn("project_name",$data["project"]);
        }
        if(isset($data["item"])){
            $executives = $executives->whereIn("item_name",$data["item"]);
        }
        if(isset($data["received"])){
            $executives = $executives->whereIn("received",$data["received"]);
        }
        return $executives;
    }



    public function index()
    {
        // البيانات من نموذج Allocation
        $brokersFromAllocation = Allocation::select('broker_name')->distinct()->pluck('broker_name')->toArray();
        $organizations = Allocation::select('organization_name')->distinct()->pluck('organization_name')->toArray();
        $projectsFromAllocation = Allocation::select('project_name')->distinct()->pluck('project_name')->toArray();
        $itemsFromAllocation = Allocation::select('item_name')->distinct()->pluck('item_name')->toArray();

        // البيانات من نموذج Executive
        $brokersFromExecutive = Executive::select('broker_name')->distinct()->pluck('broker_name')->toArray();
        $projectsFromExecutive = Executive::select('project_name')->distinct()->pluck('project_name')->toArray();
        $itemsFromExecutive = Executive::select('item_name')->distinct()->pluck('item_name')->toArray();

        // دمج البيانات من كلا النموذجين مع إزالة التكرارات
        $brokers = array_unique(array_merge($brokersFromAllocation, $brokersFromExecutive));
        $projects = array_unique(array_merge($projectsFromAllocation, $projectsFromExecutive));
        $items = array_unique(array_merge($itemsFromAllocation, $itemsFromExecutive));


        $accounts = Executive::select('account')->distinct()->pluck('account')->toArray();
        $affiliates = Executive::select('affiliate_name')->distinct()->pluck('affiliate_name')->toArray();
        $receiveds = Executive::select('received')->distinct()->pluck('received')->toArray();
        $details = Executive::select('detail')->distinct()->pluck('detail')->toArray();


        return view('dashboard.pages.report',compact('brokers','organizations','projects','items','accounts','affiliates','receiveds','details'));
    }


    public function export(Request $request)
    {
        $time = Carbon::now();

        $month = $request->month;
        $to_month = $request->to_month;

        $allocations = $this->filterAllocations($request->all());
        $executives = $this->filterExecutives($request->all());

        if($request->report_type == 'brokers_balance'){

            $brokers = $allocations->select('broker_name')->distinct()->pluck('broker_name')->toArray();

            $allocations = $this->filterAllocations($request->all())->get();

            // دوال الموجوع اخر سطر في التقرير
            $allocationsTotal = collect($allocations)->map(function ($allocation) use ($month,$to_month) {
                return [
                    "amount" => $allocation->amount ?? '0',
                    'amount_received' => $allocation->amount_received ?? '0',
                ];
            });
            $allocationsTotalArray = [
                'amount' => collect($allocationsTotal->pluck('amount')->toArray())->sum(),
                'amount_received' => collect($allocationsTotal->pluck('amount_received')->toArray())->sum(),
            ];

            if($request->export_type == 'view'){
                $pdf = PDF::loadView('dashboard.reports.brokers_balance',['allocations' => $allocations,'allocationsTotal' => $allocationsTotalArray,'brokers' => $brokers,'month' => $month,'to_month' => $to_month],[],
                [
                    'mode' => 'utf-8',
                    'format' => 'A4',
                    'default_font_size' => 12,
                    'default_font' => 'Arial',
                ]);
                return $pdf->stream();
            }
        }
    }
}
