<?php

namespace Takshak\Imager\Generators;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Takshak\Imager\Traits\GeneratorTrait;

class PlaceholderGenerator
{
	use GeneratorTrait;
	
	protected $width = 500;
	protected $height = 500;
	protected $background = '#ccc';
	protected $img;

	protected $extension = 'jpg';
	protected $text = 'Lorem Ipsom';
	protected $textFormat;
	protected $basePath;
	protected $filePath;

	protected $blur;
	protected $greyscale;
	protected $flip;
	protected $rotate;

	public function __construct($value='')
	{
		$this->textFormat = [
			'size'	=>	24,
			'color'	=>	'#000',
			'align'	=>	'center',
			'valign'	=>	'center',
			'angle'		=>	null
		];
	}

	public function background($background)
	{
		$this->background = $background;
		return $this;
	}

	public function image($width=null, $height=null, $background=null)
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

	public function text($text='Placeholder Image', $format=[])
	{
		if(!$this->img){
			$this->image();
		}

		$this->text = $text ? $text : $this->text;
		$this->textFormat['size'] = isset($format['size']) 
			? $format['size'] 
			: $this->textFormat['size'];

		$this->textFormat['color'] = isset($format['color']) 
			? $format['color'] 
			: $this->textFormat['color'];

		$this->textFormat['align'] = isset($format['align']) 
			? $format['align'] 
			: $this->textFormat['align'];

		$this->textFormat['valign'] = isset($format['valign']) 
			? $format['valign'] 
			: $this->textFormat['valign'];

		$this->textFormat['angle'] = isset($format['angle']) 
			? $format['angle'] 
			: $this->textFormat['angle'];

		if(is_array($text)){
			foreach ($text as $key => $line) {
				$y = $this->height - (count($text) * $format['size']);
				$y = $y / 2;
				$y = $y + ($this->textFormat['size'] * $key);

				$this->img->text($line, $this->width/2, $y, function($font) {
					$this->fontFormat($font);
				});
			}

			return $this;
		}

		$this->img->text($this->text, $this->width/2, $this->height/2, function($font){
			$this->fontFormat($font);
		});

		return $this;
	}

	public function fontFormat($font)
	{
		$font->file(__DIR__.'/../../fonts/Poppins-Regular.ttf');
	    $font->size($this->textFormat['size']);
	    $font->color($this->textFormat['color']);
	    $font->align($this->textFormat['align']);
	    $font->valign($this->textFormat['valign']);

	    if(isset($this->textFormat['angle']))
	    {
	    	$font->angle($this->textFormat['angle']);
	    }
	}

	public function url()
	{
		$params = [
			'w' => $this->width,
			'h' => $this->height,
			'bg' => $this->background,
			'ext' => $this->extension,
			'text' => $this->text,
			'text_color' => $this->textFormat['color'],
			'text_size' => $this->textFormat['size'],
			'text_align' => $this->textFormat['align'],
			'text_valign' => $this->textFormat['valign'],
		];

		if ($this->textFormat['angle']) {
			$params['text_angle'] = $this->textFormat['angle'];
		}
		if ($this->blur) {
			$params['blur'] = $this->blur;
		}
		if ($this->greyscale) {
			$params['greyscale'] = $this->greyscale;
		}
		if ($this->flip) {
			$params['flip'] = $this->flip;
		}
		if ($this->rotate) {
			$params['rotate'] = $this->rotate;
		}

		return route('imgr.placeholder', $params);
	}
}