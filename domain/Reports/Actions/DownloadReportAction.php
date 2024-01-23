<?php

namespace Domain\Reports\Actions;

use App\Models\User;
use Domain\Reports\Data\DownloadReportData;
use Domain\Reports\Models\Report;
use Domain\TripTickets\Exceptions\UserNotPermittedException;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadReportAction
{
    public function __invoke(DownloadReportData $data): StreamedResponse
    {
        $this->checkUserPermission($data);

        return Storage::disk($data->report->disk)->download($data->report->filename, $data->report->type . '.csv');
    }

    private function checkUserPermission(DownloadReportData $data): void
    {
        /** @var User $user */
        $user = User::query()->findOrFail($data->user_id);

        if ($user->cannot('generate-report')) {
            throw new UserNotPermittedException();
        }
    }
}
