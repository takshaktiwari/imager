<?php

namespace Takshak\Imager\Traits;

use Str;
use Image;
use Illuminate\Filesystem\Filesystem;

trait GeneratorTrait {

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

	public function dimensions($width, $height)
	{
		$this->width = $width;
		$this->height = $height;
		return $this;
	}

	public function extension($extension)
	{
		$this->extension = $extension;
		return $this;
	}

	public function resizeWidth($width='')
	{
		if(!$this->img){
			$this->image();
		}

	    $this->width = $width ? $width : $this->width;
	    $this->img->resize($this->width, null, function ($constraint) {
	        $constraint->aspectRatio();
	    });
	    
	    return $this;
	}

	public function response($extension=null)
	{
		if(!$this->img){
			$this->image();
		}
		$this->extension = $extension ? $extension : $this->extension;
		
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

	public function saveS3($path, $width = null, $visibility = 'public')
    	{
	        if (!$this->img) {
	            $this->image();
	        }
	
	        if ($width) {
	            $this->resizeWidth($width);
	        }
	
	        $this->filePath = $path;
	
	        $imageContent = (string)$this->img->encode();
	        \Storage::disk('s3')->put($path, $imageContent, $visibility);
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
			$this->image();
		}

		if ($width) {
			$this->resizeWidth($width);
		}

		if ($this->basePath) {
			$path = Str::of($this->basePath)->append('/'.$path)
			->replace('//', '/')->replace('//', '/');
		}

		$this->filePath = $path;
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

	public function saveModel($model, $column, $filePath=null)
	{
		$this->filePath = $filePath ? $filePath : $this->filePath;
		$model->$column = $this->filePath;
		$model->save();
		return $this;
	}

	public function blur($amount=1)
	{
		$this->blur = $amount;
		$this->img->blur($amount);
		return $this;
	}

	public function greyscale()
	{
		$this->greyscale = true;
		$this->img->greyscale();
		return $this;
	}

	public function rotate($deg=45)
	{
		$this->rotate = $deg;
		$this->img->rotate($deg);
		return $this;
	}

	public function flip($direction='h')
	{
		$this->direction = $direction;
		$this->img->flip($direction);
		return $this;
	}

	public function others($method, $raw = false)
	{
		$method($this->img);
		return $raw ? $this->img : $this;
	}

	public function destroy()
	{
		$this->img = null;
		return $this;
	}

}
