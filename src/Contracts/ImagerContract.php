<?php

namespace Takshak\Imager\Contracts;

interface ImagerContract {

	public function imageUrl();

	public function image();

	public function response();
	
	public function save($path, $width, $quality);

}
