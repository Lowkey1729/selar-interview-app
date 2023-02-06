<?php

namespace App\Services\Traits\KPIS;

use Carbon\Carbon;

trait GeneralTrait
{
    /**
     * @param $data
     * @return void
     */
    protected function setDateIfNotSet(&$data)
    {


        if (!isset($data['date']['from']) && !isset($data['date']['to'])) {
            $data['date']['dateType'] = 'month';
            $data['date']['from'] = $data['date']['to'] = pickDate('month');
        } else {
            $data['date']['dateType'] = 'days';
            $data['date']['from'] = Carbon::parse($data['date']['from']);
            $data['date']['to'] = Carbon::parse($data['date']['to']);
        }

    }


}
