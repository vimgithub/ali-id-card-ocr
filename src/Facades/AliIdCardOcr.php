<?php

namespace Zev\AliIdCardOcr\Facades;

use Illuminate\Support\Facades\Facade;


class AliIdCardOcr extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'aliIdCardOcr';
    }
}
