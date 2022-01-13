<?php

namespace Takshak\Imager\Generators;

use Illuminate\Support\Str;
use Takshak\Imager\Contracts\ImagerContract;
use Takshak\Imager\Traits\GeneratorTrait;

class PicsumGenerator implements ImagerContract
{
	use GeneratorTrait;

	protected $baseUrl = 'https://picsum.photos';
	protected $newImage;

	protected $imageUrl;
	protected $imgHeight = 500;
	protected $imgWidth = 500;
	protected $extension = 'jpg';
	protected $imgId;
	protected $seed;
	protected $grayscale;
	protected $blur;
	protected $random;

	public function __construct()
	{
		$this->imageUrl = $this->baseUrl;
	}

	public function id($id)
	{
		$this->imgId = $id;
		return $this;
	}

	public function seed($key)
	{
		$this->seed = $key;
		return $this;
	}

	public function width($width=500)
	{
		$this->imgWidth = $width;
		return $this;
	}

	public function height($height=500)
	{
		$this->imgHeight = $height;
		return $this;
	}

	public function dimensions($width=500, $height=500)
	{
		$this->imgWidth = $width;
		$this->imgHeight = $height;
		return $this;
	}

	public function grayscale($bool=true)
	{
		$this->grayscale = $bool;
		return $this;
	}

	public function blur($scale=1)
	{
		$this->blur = $scale;
		return $this;
	}

	public function random($number='')
	{
		$this->random = $number ? $number : rand();
		return $this;
	}

	public function extension($ext='jpg')
	{
		$this->extension = $ext;
		return $this;
	}
	public function format($ext='jpg')
	{
		return $this->extension($ext);
	}

	public function imageUrl()
	{
		$url = Str::of($this->baseUrl);

		if ($this->imgId) {
			$url = $url->append('/id/'.$this->imgId);

		}elseif($this->seed){
			$url = $url->append('/seed/'.$this->seed);
		}

		$url = $url->append('/'.$this->imgWidth);
		$url = $url->append('/'.$this->imgHeight);
		$url = $url->append('.'.$this->extension);

		$url = $url->append('?');

		if ($this->grayscale) {
			$url = $url->append('&grayscale=');
		}
		if ($this->blur) {
			$url = $url->append('&blur='.$this->blur);
		}
		if ($this->random) {
			$url = $url->append('&random='.$this->random);
		}

		$url = $url->replace('?&', '?');
		$url = $url->replace('=&', '&');

		return $this->imageUrl = $url;
	}

	

}