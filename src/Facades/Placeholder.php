<?php

namespace Takshak\Imager\Facades;

use Illuminate\Support\Facades\Facade;
use Takshak\Imager\Generators\PlaceholderGenerator;

class Placeholder extends Facade
{
	protected static function getFacadeAccessor()
	{
		return PlaceholderGenerator::class;
	}
}