<?php

namespace Takshak\Imager\Generators;

use Illuminate\Support\Str;
use Takshak\Imager\Traits\GeneratorTrait;
use Takshak\Imager\Contracts\ImagerContract;

class PlaceholderGenerator implements ImagerContract
{
	use GeneratorTrait;
	
	protected $baseUrl = 'https://via.placeholder.com';
	protected $imageUrl;
	protected $newImage;

	protected $width = 500;
	protected $height = 500;
	protected $format = 'jpg';
	protected $text = 'Lorem+Ipsom';
	protected $background = 'cccccc';
	protected $color = '333';

	public function __construct()
	{
		$this->imageUrl = $this->baseUrl;
	}

	public function width($width)
	{
		$this->width = $width;
		return $this;
	}
	public function height($height)
	{
		$this->height = $height;
		return $this;
	}
	public function format($format)
	{
		$this->format = $format;
		return $this;
	}
	public function extension($ext='jpg')
	{
		return $this->format($ext);
	}

	public function text($text)
	{
		$this->text = urldecode($text);
		return $this;
	}
	public function background($background)
	{
		$this->background = Str::of($background)->after('#');
		return $this;
	}
	public function color($color)
	{
		$this->color = Str::of($color)->after('#');
		return $this;
	}

	public function imageUrl()
	{
		return $this->imageUrl = Str::of($this->imageUrl)->append('/')
		->append($this->width.'x'.$this->height)
		->append('.'.$this->format.'/')
		->append($this->background.'/')
		->append($this->color.'/')
		->append('?text='.$this->text);
	}

}