<?php

namespace Takshak\Imager\Facades;

use Illuminate\Support\Facades\Facade;
use Takshak\Imager\Services\ImagerService;

class Imager extends Facade
{
	protected static function getFacadeAccessor()
	{
		return ImagerService::class;
	}

}