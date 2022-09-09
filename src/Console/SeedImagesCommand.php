<?php

namespace Takshak\Imager\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SeedImagesCommand extends Command
{
    /**
     * >>> arguments
     * count: number of images to be seeded
     *
     * >>> options:
     * --disk: storage disk type
     * --bucket: this is the folder name where the images will be kept
     * --action: action of the command. possible values are, seed, refresh, flush
     * --width: width of the images to be seeded
     * --height: height of the images to be seeded
     */
    protected $signature = 'imager:seed {count=50} {--disk=local} {--bucket=imgr-bucket/} {--action=seed} {--width=2000} {--height=1500}';

    protected $description = 'Generate some images to use for picsum generator or may be for any other use.';

    public function handle()
    {
        $storage = Storage::disk($this->option('disk'));

        $bucket = $this->option('bucket');
        if (!Str::endsWith($bucket, '/')) {
            $bucket .= '/';
        }

        if (in_array($this->option('action'), ['flush', 'refresh'])) {
            $storage->deleteDirectory($bucket);
            $this->info('Image bucket has been successfully removed.');

            if ($this->option('action') == 'flush') {
                exit; # stop execution if only want to flush images, don't want to seed.
            }
        }

        (new Filesystem())
            ->ensureDirectoryExists(
                $storage->path($bucket)
            );

        if ($storage->missing($bucket . '.gitignore')) {
            $storage->put($bucket . '.gitignore', "*\n!.gitignore");
        }

        $writtenImagesCount = 0;
        for ($i = 0; $i < $this->argument('count'); $i++) {
            $fileName = Str::of(microtime())->slug('-')
                ->prepend($bucket)
                ->append('.jpg');

            try {
                \Image::make('https://picsum.photos/' . $this->option('width') . '/' . $this->option('height'))->save($storage->path($fileName));

                $this->line('Image written: '.$fileName);
                $writtenImagesCount++;
            } catch (\Exception $e) {
                logger($e->getMessage());
                $this->error('Image failed: '.$fileName);
                $this->error($e->getMessage());
            }
        }

        $this->newLine();
        $this->info('Total '.$writtenImagesCount.' images are successfully seeded.');
    }
}
