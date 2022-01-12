<?php
namespace Takshak\Imager\Services;

use Str;
use Image;
use Storage;

class ImagerService
{
	protected $img;
	protected $width;
	protected $height;
	protected $basePath;
	protected $quality = 80;
	protected $ext = 'jpg';

    public function __construct($image=null)
    {
    	if ($image) {
        	$this->img = Image::make($image);
    	}
    }

    public function init($image)
    {
    	$this->img = Image::make($image);
    	return $this;
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

    public function resizeWidth($width='')
    {
    	$width = $width ? $width : $this->width;
        $this->img->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        
        return $this;
    }

    public function resizeHeight($height='')
    {
    	$height = $height ? $height : $this->height;
        $this->img->resize(null, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        return $this;
    }

    public function resize($width='', $height='')
    {
    	$width = $width ? $width : $this->width;
    	$height = $height ? $height : $this->height;

        $this->img->resize($width, $height);
        return $this;
    }

    public function resizeFit($width='', $height='')
    {
        $width = $width ? $width : $this->width;
        $height = $height ? $height : $this->height;

        $this->resizeWidth($width);
        if ($this->img->height() > $height) {
            $this->resizeHeight($height);
        }
        return $this;
    }

    public function inCanvas($bg=null)
    {
        $this->img = Image::canvas($this->width, $this->height, $bg)->insert($this->img, 'center');
        return $this;
    }

    public function extension($ext)
    {
        $this->ext = $ext;
        return $this;
    }

    public function quality($quality)
    {
        $this->quality = $quality;
        return $this;
    }

    public function basePath($path)
    {
    	$this->basePath = $path;
    	return $this;
    }

    public function save($path, $width=null)
    {
    	$path = Str::of($this->basePath)->append('/'.$path)
    	->replace('//', '/')->replace('//', '/');

    	if ($width) {
    		$this->resizeWidth($width);
    	}

        $this->checkDirectory($path);
        $this->img->save($path, $this->quality, $this->ext);
        return $this;
    }

    public function checkDirectory($path)
    {
        if (!is_dir($path)) {
            $directory = Str::of($path)->beforeLast('/');
            Storage::makeDirectory($directory);
        }
    }

    public function response()
    {
    	return $this->img->response();
    }


}