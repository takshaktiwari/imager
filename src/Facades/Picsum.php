<?php

namespace Takshak\Imager\Facades;

use Illuminate\Support\Facades\Facade;
use Takshak\Imager\Generators\PicsumGenerator;

class Picsum extends Facade
{
	
	protected static function getFacadeAccessor()
	{
		return PicsumGenerator::class;
	}

}