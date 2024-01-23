<?php

namespace App\Jobs;

use Carbon\Carbon;
use Domain\Reports\Enums\States;
use Domain\Reports\Models\Report;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public readonly Report $report)
    {
        //
    }

    /**
     * Execute the job.
     * @throws Exception
     */
    public function handle(): void
    {
        try {
            $generator = $this->report->getGenerator();

            $generator->build();
        } catch (Exception $e) {
            $this->report->failed_at = Carbon::now();
            $this->report->error = $e->getMessage();
            $this->report->markStatus(States::FAILED);

            Log::error($e);
        }
    }
}
