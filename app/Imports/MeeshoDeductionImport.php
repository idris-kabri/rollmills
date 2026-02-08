<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\MeeshoDeduction;

class MeeshoDeductionImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $date = $row['deduction_date'];
            $campaign_id = $row['campaign_id'];
            $ad_cost = $row['ad_cost'];
            $discount = $row['credits_waivers_discounts'];
            $gst = str_replace('-', '', $row['gst']);
            $total_ad_cost = str_replace('-', '', $row['total_ads_cost']);
            $meesho_order = MeeshoDeduction::where('campaign_id', $campaign_id)->where('date', $date)->where('total_sum', $total_ad_cost)->first();
            if (!$meesho_order) {
                $meesho_deduction = new MeeshoDeduction();
                $meesho_deduction->date = $date;
                $meesho_deduction->campaign_id = $campaign_id;
                $meesho_deduction->sub_total = $ad_cost;
                $meesho_deduction->discount = $discount;
                $meesho_deduction->gst = $gst;
                $meesho_deduction->total_sum = $total_ad_cost;
                $meesho_deduction->save();
            }
        }
    }
}
