<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSyncData extends Model
{
    use HasFactory;

     protected $fillable=[
        'pod_id',
        'hub_id',
        'Date',
        'Time',
        'AB_T1',
        'AB_H1',
        'POD_T1',
        'POD_H1',
        'TDS_V1',
        'PH_V1',
        'NUT_T1',
        'NP_I1',
        'SV_I1',
        'BAT_V1',
        'FLO_V1',
        'FLO_V2',
        'STS_PSU',
        'STS_NP1',
        'STS_NP2',
        'STS_SV1',
        'STS_SV2',
        'WL1H',
        'WL1L',
        'WL2H',
        'WL2L',
        'WL3H',
        'WL3L',
        'RL1',
        'RL2',
        'RL3',
        'RL4',
        'RL5',
        'PMODE',
        'api_type'
        ];


}
