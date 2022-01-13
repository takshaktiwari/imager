<?php

namespace Takshak\Imager\Generators;

use Illuminate\Support\Str;
use Takshak\Imager\Contracts\ImagerContract;
use Takshak\Imager\Traits\GeneratorTrait;

class AvatarGenerator implements ImagerContract
{
	use GeneratorTrait;
	
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
		$this->name = urlencode($name);
		return $this;
	}

	public function size($name)
	{
		$this->size = $size;
		return $this;
	}

	public function fontsize($fontsize)
	{
		$this->fontsize = $fontsize;
		return $this;
	}

	public function length($length)
	{
		$this->length = $length;
		return $this;
	}


	public function rounded($rounded=true)
	{
		$this->rounded = $rounded;
		return $this;
	}

	public function bold($bold=true)
	{
		$this->bold = $bold;
		return $this;
	}

	public function color($color)
	{
		$this->color = Str::of($color)->after('#');
		return $this;
	}

	public function background($background)
	{
		$this->background = Str::of($background)->after('#');
		return $this;
	}

	public function uppercase($uppercase = true)
	{
		$this->uppercase = $uppercase;
		return $this;
	}

	public function imageUrl()
	{
		return $this->imageUrl = Str::of($this->baseUrl)->append('?')
		->append('name='.$this->name)
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