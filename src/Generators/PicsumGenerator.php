<?php

namespace Takshak\Imager\Generators;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Storage;
use Takshak\Imager\Traits\GeneratorTrait;

class PicsumGenerator
{
	use GeneratorTrait;

	protected $width;
	protected $height;
	protected $bucket;
	protected $disk;
	protected $storage;
	protected $sourceDir;
	protected $img;
	protected $extension = 'jpg';

	protected $seed = false;
	protected $flush = false;
	protected $refresh = false;
	protected $blur;
	protected $greyscale;
	protected $flip;
	protected $rotate;

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
		$this->addGitignore();
		return $this;
	}

	public function seed($count=10)
	{	
		$this->seed = true;
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
		$this->flush = true;
		(new Filesystem)->cleanDirectory($this->storage->path($this->sourceDir));
		$this->addGitignore();
		return $this;
	}

	public function addGitignore()
	{
		$this->storage->put($this->sourceDir.'.gitignore', "*\n!.gitignore");
	}

	public function refresh($count=10)
	{
		$this->refresh = true;
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
		$this->width = $width ? $width : $this->width;
		$this->height = $height ? $height : $this->height;

		$files = $this->storage->files($this->sourceDir);
		shuffle($files);

		$this->img = \Image::make($this->storage->path(end($files)))->crop($this->width, $this->height);
		return $this;
	}

	public function url()
	{
		$params = [
			'w' => $this->width,
			'h' => $this->height,
			'ext' => $this->extension,
		];

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
		if ($this->seed) {
			$params['seed'] = $this->seed;
		}
		if ($this->flush) {
			$params['flush'] = $this->flush;
		}
		if ($this->refresh) {
			$params['refresh'] = $this->refresh;
		}

		return route('imgr.picsum', $params);
	}

}