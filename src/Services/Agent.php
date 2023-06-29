<?php

namespace Devist\Laragin\Services;

use hisorange\BrowserDetect\Parser as Browser;

class Agent
{
    public static function parse()
    {
        return Browser::browserName().' - '.Browser::deviceFamily();
    }
}
