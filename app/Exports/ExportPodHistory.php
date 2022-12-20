<?php

namespace App\Exports;

use App\Models\MasterSyncData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ExportPodHistory implements FromCollection, WithHeadings
{
    
    private $pod_id;
    private $startdate;
    private $endddate;

    public function __construct($id, $startdate, $enddate) 
    {
        $this->pod_id = $id;
        $this->startdate = $startdate;
        $this->endddate = $enddate;
    }

    public function collection()
    {

       if(empty($this->startdate))
       {
       
        return MasterSyncData::select('pod_id', 'hub_id', 'Date', 'Time', 'AB_T1', 'AB_H1', 'POD_T1', 'POD_H1', 'TDS_V1', 'PH_V1', 'NUT_T1', 'NP_I1', 'SV_I1', 'BAT_V1', 'FLO_V1', 'FLO_V2', 'STS_PSU', 'STS_NP1', 'STS_NP2', 'STS_SV1', 'STS_SV2', 'WL1H', 'WL1L', 'WL2H', 'WL2L', 'WL3H', 'WL3L', 'RL1', 'RL2', 'RL3', 'RL4', 'RL5', 'PMODE', 'api_type')
               ->where('pod_id',$this->pod_id)
               ->get();

       }
       else
       {

     
        return MasterSyncData::select('pod_id', 'hub_id', 'Date', 'Time', 'AB_T1', 'AB_H1', 'POD_T1', 'POD_H1', 'TDS_V1', 'PH_V1', 'NUT_T1', 'NP_I1', 'SV_I1', 'BAT_V1', 'FLO_V1', 'FLO_V2', 'STS_PSU', 'STS_NP1', 'STS_NP2', 'STS_SV1', 'STS_SV2', 'WL1H', 'WL1L', 'WL2H', 'WL2L', 'WL3H', 'WL3L', 'RL1', 'RL2', 'RL3', 'RL4', 'RL5', 'PMODE', 'api_type')
               ->where('pod_id',$this->pod_id)
               ->where('created_at','>=',$this->startdate.' 00:00:01')
               ->where('created_at','<=',$this->endddate.' 23:59:59')->get();
       }
    }

     public function headings(): array
    {       
       return [
         'pod_id', 'hub_id', 'Date', 'Time', 'AB_T1', 'AB_H1', 'POD_T1', 'POD_H1', 'TDS_V1', 'PH_V1', 'NUT_T1', 'NP_I1', 'SV_I1', 'BAT_V1', 'FLO_V1', 'FLO_V2', 'STS_PSU', 'STS_NP1', 'STS_NP2', 'STS_SV1', 'STS_SV2', 'WL1H', 'WL1L', 'WL2H', 'WL2L', 'WL3H', 'WL3L', 'RL1', 'RL2', 'RL3', 'RL4', 'RL5', 'PMODE', 'api_type'
       ];
    }
}
