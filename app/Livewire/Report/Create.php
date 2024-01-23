<?php

namespace App\Livewire\Report;

use App\Jobs\GenerateReport;
use App\Livewire\Forms\Report\CreateForm;
use Domain\Reports\Actions\CreateReportAction;
use Domain\Reports\Data\CreateReportData;
use Domain\Reports\Enums\States;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application as ApplicationAlias;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Create extends Component
{
    use LivewireAlert;

    public CreateForm $form;

    public function render(): View|ApplicationAlias|Factory|Application
    {
        return view('livewire.report.create');
    }

    public function submit(CreateReportAction $createReportAction): void
    {
        $this->validate();

        $report = $createReportAction(new CreateReportData(
            requester_id: Auth::id(),
            type: $this->form->type,
            from_date: $this->form->from_date,
            from_time: $this->form->from_time,
            to_date: $this->form->to_date,
            to_time: $this->form->to_time,
            status: States::PENDING,
        ));

        GenerateReport::dispatch($report);

        $this->dispatch('report-created');

        $this->form->reset();

        $this->alert('success', 'New report generating');
    }
}
