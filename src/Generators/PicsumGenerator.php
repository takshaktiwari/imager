<?php

namespace Takshak\Imager\Generators;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Storage;
use Takshak\Imager\Traits\GeneratorTrait;

class PicsumGenerator
{
	use GeneratorTrait;

	public $width;
	public $height;
	public $bucket;
	public $disk;
	public $storage;
	public $sourceDir;
	public $img;
	public $extension = 'jpg';

	public function __construct()
	{
		$this->width = 1500;
		$this->height = 1500;
		$this->disk = 'local';
		$this->sourceDir = 'imgr-bucket/';

		$this->disk();

		if ($this->isEmpty()) {
			$this->seed();
		}
	}

	public function bucket($bucket='imgr-bucket/')
	{
		$this->sourceDir = $bucket;
		(new Filesystem)->ensureDirectoryExists($this->storage->path($this->sourceDir));
		return $this;
	}

	public function disk($disk='local')
	{
		$this->storage = Storage::disk($disk);
		(new Filesystem)->ensureDirectoryExists($this->storage->path($this->sourceDir));
		return $this;
	}

	public function seed($count=10)
	{	
		for ($i=0; $i < $count; $i++) { 
			$fileName = Str::of(microtime())->slug('-')->append('.jpg');
			copy(
				'https://picsum.photos/'.$this->width.'/'.$this->height,
				$this->storage->path($this->sourceDir).$fileName
			);
		}
		return $this;
	}

	public function flush()
	{
		(new Filesystem)->cleanDirectory($this->storage->path($this->sourceDir));
		return $this;
	}

	public function refresh($count=10)
	{
		$this->flush();
		$this->seed($count);
		return $this;
	}

	public function isEmpty()
	{
		$files = $this->storage->files($this->sourceDir);
		return count($files) ? false : true;
	}

	public function image($width=null, $height=null)
	{
		$files = $this->storage->files($this->sourceDir);
		shuffle($files);

		$this->img = \Image::make($this->storage->path(end($files)))->crop($this->width, $this->height);
		return $this;
	}


}