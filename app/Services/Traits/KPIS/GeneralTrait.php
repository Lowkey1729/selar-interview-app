<?php

namespace App\Services\Traits\KPIS;

use Carbon\Carbon;

trait GeneralTrait
{
    protected function setDateIfNotSet(&$data)
    {
        $data['date']['dateType'] = 'days';

        if (!isset($data['date']['from']) && !isset($data['date']['to'])) {
            $data['date']['dateType'] = 'month';
            $data['date']['from'] = $data['date']['to'] = pickDate('month');
        }

    }


}
