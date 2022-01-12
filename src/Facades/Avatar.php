<?php

namespace Takshak\Imager\Facades;

use Illuminate\Support\Facades\Facade;
use Takshak\Imager\Generators\AvatarGenerator;

class Avatar extends Facade
{
	
	protected static function getFacadeAccessor()
	{
		return AvatarGenerator::class;
	}

}