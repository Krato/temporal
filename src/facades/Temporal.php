<?php
namespace EricLagarda\Temporal\Facades;

use Illuminate\Support\Facades\Facade;

class Temporal extends Facade
{
    protected static function getFacadeAccessor() {
        return 'temporal';
    }
}