<?php

namespace Takshak\Imager\Traits;

use Image;

trait GeneratorTrait {

	public function image($imageUrl='')
	{
		$this->imageUrl = $imageUrl ? $imageUrl : $this->imageUrl();

		$this->newImage = Image::make($this->imageUrl);
		return $this;
	}

	public function response()
	{
		if (!$this->newImage) {
			$this->image();
		}
		
		return $this->newImage->response();
	}

	public function save($path, $quality='80', $extension='jpg')
	{
		if (!$this->newImage) {
			$this->image();
		}
		$this->newImage->save($path, $quality, $extension);
		return $this;
	}

}
