<?php

namespace Domain\Reports\Types;

use Domain\Reports\Enums\States;
use Domain\Reports\Models\Report;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use SplFileObject;

abstract class GeneratorAbstract
{
    public ?Filesystem $disk = null;
    public SplFileObject $file;

    public function __construct(public Report $report)
    {
    }

    public function getDisk(): Filesystem
    {
        if ($this->disk === null) {
            $this->disk = Storage::disk('local');
        }
        return $this->disk;
    }

    public function createTempFile(): string
    {
        $this->disk  = $this->getDisk();

        $target_folder  = 'reports_temp';

        if (!$this->disk->exists($target_folder)) {
            $this->disk->makeDirectory($target_folder);
        }

        $filename = tempnam($this->disk->path($target_folder), $this->report->id);
        $this->file = new SplFileObject($filename, 'w');

        return $filename;
    }

    public function setRealFile(SplFileObject $file, $filename): void
    {
        unset($file);

        $new_filename = Storage::disk('local')->putFileAs('reports', new File($filename), $this->report->id . '.csv');

        unlink($filename);

        $this->report->disk = 'local';
        $this->report->filename = $new_filename;

        $this->report->save();

        $this->report->markStatus(States::DONE);
    }

    abstract function getParameters();

    abstract function build();
}
