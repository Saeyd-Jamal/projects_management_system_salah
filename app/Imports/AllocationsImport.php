<?php

namespace App\Imports;

use App\Models\Allocation;
use App\Models\Currency;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AllocationsImport implements ToModel,WithHeadingRow
{
    public function formatDate($date){
        if(is_numeric($date)){
            return Carbon::createFromFormat('Y-m-d', Date::excelToDateTimeObject($date)->format('Y-m-d'));
        }else{
            return $date;
        }
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        ($row['alaaml'] == 'دولار') ? $row['alaaml'] = 'USD' : $row['alaaml'] = 'JOD';
        ($row['alaaml'] == 'دينار أردني') ? $row['alaaml'] = 'JOD' : $row['alaaml'] = 'USD';
        ($row['alaaml'] == 'دينار كويتي') ? $row['alaaml'] = 'KWD' : $row['alaaml'] = 'USD';
        ($row['alaaml'] == 'شيكل') ? $row['alaaml'] = 'ILS' : $row['alaaml'] = 'USD';
        ($row['alaaml'] == 'يورو') ? $row['alaaml'] = 'EUR' : $row['alaaml'] = 'USD';
        $currency_allocation = Currency::where('code', $row['alaaml'])->first();

        ($row['aaml'] == 'دولار') ? $row['aaml'] = 'USD' : $row['aaml'] = 'EUR';
        ($row['aaml'] == 'دينار أردني') ? $row['aaml'] = 'JOD' : $row['aaml'] = 'USD';
        ($row['aaml'] == 'دينار كويتي') ? $row['aaml'] = 'KWD' : $row['aaml'] = 'USD';
        ($row['aaml'] == 'شيكل') ? $row['aaml'] = 'ILS' : $row['aaml'] = 'USD';
        ($row['aaml'] == 'يورو') ? $row['aaml'] = 'EUR' : $row['aaml'] = 'USD';
        $currency_received = ($row['aaml'] != null) ? Currency::where('code', $row['aaml'])->first() : null;

        return new Allocation([
            'date_allocation' => $this->formatDate($row['tarykh_altkhsys']),
            'budget_number' => $row['rkm_almoazn'],
            'broker_name' => $row['alasm_almkhtsr'],
            'organization_name' => $row['almoss'],
            'project_name' => $row['mshroaa'],
            'item_name' => $row['alsnf'],
            'quantity' => $row['alkmy'],
            'price' => $row['saar'],
            'total_dollar' => $row['agmaly_dolar'],
            'allocation' => $row['altkhsys'],
            'currency_allocation' => $currency_allocation != null ? $currency_allocation->code : null,
            'currency_allocation_value' => $currency_allocation != null ? $currency_allocation->value : null,
            'amount' => $row['almblgh_baldolar'],
            'implementation_items' => $row['bnod_altnfyth'],
            'date_implementation' => $this->formatDate($row['tarykh_alastlam']),
            'implementation_statement' => $row['byan'],
            'amount_received' => $row['almblgh'],
            'currency_received' => $currency_received != null ? $currency_received->code : null,
            'currency_received_value' => $currency_received != null ? $currency_received->value : null,
            'notes' => $row['mlahthat'],
            'number_beneficiaries' => $row['aadd_almstfydyn'],
        ]);
    }
    public function chunkSize(): int
    {
        return 100; // حجم القطعة الواحدة
    }
}
