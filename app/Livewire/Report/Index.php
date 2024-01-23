<?php

namespace App\Livewire\Report;

use Domain\Reports\Actions\DownloadReportAction;
use Domain\Reports\Data\DownloadReportData;
use Domain\Reports\Models\Report;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application as ApplicationAlias;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Index extends Component
{
    use WithPagination;

    public function render(): View|ApplicationAlias|Factory|Application
    {
        return view('livewire.report.index', [
            'reports' => Report::query()
                            ->with('requester')
                            ->latest()
                            ->paginate(10),
        ]);
    }

    #[On('report-created')]
    public function refreshComponent(): void
    {
        $this->js('$wire.$refresh()');
    }

    public function download(
        Report $report,
        DownloadReportAction $downloadReportAction
    ): StreamedResponse
    {
        return $downloadReportAction(new DownloadReportData(
            user_id: Auth::id(),
            report: $report,
        ));
    }
}
