<?php

namespace Devist\Laragin\Core;

class Bootstrap
{
    public static function routes()
    {
        foreach (config('laragin.strategies') as $strategy) {
            $strategy;
        }
    }
}
