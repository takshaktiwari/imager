<?php

namespace Takshak\Imager\Services;

use Image;
use Takshak\Imager\Traits\GeneratorTrait;

class ImagerService
{
    use GeneratorTrait;

    protected $img;
    protected $width;
    protected $height;
    protected $basePath;
    protected $quality = 80;
    protected $extension = 'jpg';

    public function __construct($image=null)
    {
        if ($image) {
            $this->img = Image::make($image);
            return $this;
        }
    }

    public function init($image)
    {
        $this->img = Image::make($image);
        return $this;
    }

    public function image($image)
    {
        $this->init($image);
        return $this;
    }

    public function resizeHeight($height='')
    {
        $this->height = $height ? $height : $this->height;
        $this->img->resize(null, $this->height, function ($constraint) {
            $constraint->aspectRatio();
        });
        return $this;
    }

    public function resize($width='', $height='')
    {
        $this->width = $width ? $width : $this->width;
        $this->height = $height ? $height : $this->height;

        $this->img->resize($this->width, $this->height);
        return $this;
    }

    public function resizeFit($width='', $height='')
    {
        $this->width = $width ? $width : $this->width;
        $this->height = $height ? $height : $this->height;

        $this->resizeWidth($this->width);
        if ($this->img->height() > $this->height) {
            $this->resizeHeight($this->height);
        }
        return $this;
    }

    public function inCanvas($bg=null)
    {
        $this->img = Image::canvas($this->width, $this->height, $bg)->insert($this->img, 'center');
        return $this;
    }
}
