<?php

namespace Devist\laragin\Core;

class Bootstrap
{
    public function routes()
    {
        app()->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }
}
