<?php

namespace Takshak\Imager\Traits;

use Str;
use Image;
use Illuminate\Filesystem\Filesystem;

trait GeneratorTrait {

	protected $basePath;

	public function image($imageUrl='')
	{
		$this->imageUrl = $imageUrl ? $imageUrl : $this->imageUrl();
		$this->newImage = Image::make($this->imageUrl);
		return $this;
	}

	public function resizeWidth($width='')
	{
	    $this->width = $width ? $width : $this->width;
	    $this->newImage->resize($this->width, null, function ($constraint) {
	        $constraint->aspectRatio();
	    });
	    
	    return $this;
	}

	public function response()
	{
		if (!$this->newImage) {
			$this->image();
		}
		
		return $this->newImage->response();
	}

	public function basePath($path)
	{
	    $this->basePath = $path;
	    return $this;
	}

	public function save($path, $width=null, $quality=80)
	{
		$this->image();
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
		if ($width) {
			$this->resizeWidth($width);
		}

	    $path = Str::of($this->basePath)->append('/'.$path)
	    ->replace('//', '/')->replace('//', '/');

	    $this->checkDirectory($path);
	    $this->newImage->save($path, $quality);
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
