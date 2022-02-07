<?php

namespace Takshak\Imager\Generators;

use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class PlaceholderGenerator
{
	protected $width = 500;
	protected $height = 500;
	protected $background = '#ccc';
	protected $img;

	protected $extension = 'jpg';
	protected $text = 'Lorem Ipsom';
	protected $color = '333';
	protected $basePath;

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

	public function background($background)
	{
		$this->background = $background;
		return $this;
	}

	public function dimensions($width, $height)
	{
		$this->width = $width;
		$this->height = $height;
		return $this;
	}

	public function canvas($width=null, $height=null, $background=null)
	{
		if($width){
			$this->width = $width;
		}
		if($height){
			$this->height = $height;
		}
		if($background){
			$this->background = $background;
		}

		$this->img = \Image::canvas($this->width, $this->height, $this->background);
		return $this;
	}

	public function fill($background)
	{
		if(!$this->img){
			$this->canvas();
		}

		$this->img->fill($background);
		return $this;
	}

	public function text($text='Placeholder Image', $format=[])
	{
		if(!$this->img){
			$this->canvas();
		}

		$this->text = $text ? $text : $this->text;

		$format['size'] = isset($format['size']) ? $format['size'] : 24;

		if(is_array($text)){
			foreach ($text as $key => $line) {
				$y = $this->height - (count($text) * $format['size']);
				$y = $y / 2;
				$y = $y + ($format['size'] * $key);

				$this->img->text($line, $this->width/2, $y, function($font) use ($format) {
					$font->file(__DIR__.'/../../fonts/Poppins-Regular.ttf');
				    $font->size($format['size']);
				    $font->color(isset($format['color']) ? $format['color'] : '#000');
				    $font->align(isset($format['align']) ? $format['align'] : 'center');
				    $font->valign(isset($format['valign']) ? $format['valign'] : 'center');

				    if(isset($format['valign']))
				    {
				    	$font->angle($format['valign']);
				    }
				});
			}

			return $this;
		}

		$this->img->text(
			$this->text, 
			$this->width/2, 
			$this->height/2, 
			function($font) use ($format) {
				$font->file(__DIR__.'/../../fonts/Poppins-Regular.ttf');
			    $font->size($format['size']);
			    $font->color(isset($format['color']) ? $format['color'] : '#000');
			    $font->align(isset($format['align']) ? $format['align'] : 'center');
			    $font->valign(isset($format['valign']) ? $format['valign'] : 'center');

			    if(isset($format['valign']))
			    {
			    	$font->angle($format['valign']);
			    }
		});

		return $this;
	}

	public function resizeWidth($width='')
	{
		if(!$this->img){
			$this->canvas();
		}

	    $this->width = $width ? $width : $this->width;
	    $this->img->resize($this->width, null, function ($constraint) {
	        $constraint->aspectRatio();
	    });
	    
	    return $this;
	}

	public function response()
	{
		if(!$this->img){
			$this->canvas();
		}
		return $this->img->response($this->extension);
	}

	public function basePath($path)
	{
	    $this->basePath = $path;
	    return $this;
	}

	public function save($path, $width=null, $quality=80)
	{
		$this->store($path, $width, $quality=80);
		return $this;
	}

	public function copy($path, $width=null, $quality=80)
	{
		$this->store($path, $width, $quality=80);
		return $this;
	}

	public function store($path, $width=null, $quality=80)
	{
		if(!$this->img){
			$this->canvas();
		}

		if ($width) {
			$this->resizeWidth($width);
		}

		if ($this->basePath) {
			$path = Str::of($this->basePath)->append('/'.$path)
			->replace('//', '/')->replace('//', '/');
		}
	    
	    $this->checkDirectory($path);
	    $this->img->save($path, $quality);
	    return $this;
	}

	public function checkDirectory($path)
	{
	    if (!is_dir($path)) {
	        $directory = Str::of($path)->beforeLast('/');
	        (new Filesystem)->ensureDirectoryExists($directory);
	    }
	}

}