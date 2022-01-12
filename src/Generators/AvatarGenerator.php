<?php

namespace Takshak\Imager\Generators;

use Illuminate\Support\Str;
use Takshak\Imager\Contracts\ImagerContract;
use Takshak\Imager\Traits\ImagerTrait;

class AvatarGenerator implements ImagerContract
{
	use ImagerTrait;
	
	protected $baseUrl = 'https://ui-avatars.com/api';
	protected $imageUrl;
	protected $newImage;

	protected $name;
	protected $size = 128;
	protected $fontsize = 0.5;
	protected $length = 2;
	protected $rounded = false;
	protected $bold = false;
	protected $color = '8b5d5d';
	protected $background = 'f0e9e9';
	protected $uppercase = true;

	public function __construct()
	{
		$this->imageUrl = $this->baseUrl;

	}

	public function name($name)
	{
		return $this->name = $name;

	}

	public function size($name)
	{
		return $this->size = $size;

	}

	public function fontsize($fontsize)
	{
		return $this->fontsize = $fontsize;

	}

	public function length($length)
	{
		return $this->length = $length;

	}

	public function rounded($rounded=true)
	{
		return $this->rounded = $rounded;

	}

	public function bold($bold=true)
	{
		return $this->bold = $bold;

	}

	public function color($color)
	{
		return $this->color = $color;

	}

	public function background($background)
	{
		return $this->background = $background;

	}

	public function uppercase($uppercase = true)
	{
		return $this->uppercase = $uppercase;

	}

	public function imageUrl()
	{
		return $this->imageUrl = Str::of($this->imageUrl)->append('?')
		->append('&size='.$this->size)
		->append('&font-size='.$this->fontsize)
		->append('&length='.$this->length)
		->append('&rounded='.$this->rounded)
		->append('&bold='.$this->bold)
		->append('&color='.$this->color)
		->append('&background='.$this->background)
		->append('&uppercase='.$this->uppercase);
	}


}