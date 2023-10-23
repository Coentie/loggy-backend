<?php

namespace App\Transforms\Issue;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AggregateIssuesDatePeriodTransformer
{
    public static function transform(): array
    {
        $labels = [];
        $values = [];

        CarbonPeriod::create(Carbon::now()->subMonth(), '1 day', Carbon::now())
            ->forEach(function (Carbon $carbon) use(&$labels, &$values) {
                $labels[] = $carbon->format('m-d');
                $values[] = rand(3, 1000);
            });

        return [
            'labels' => $labels,
            'values' => $values,
        ];
    }
}
