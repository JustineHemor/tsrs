<?php

namespace Domain\Reports\Models;

use App\Models\User;
use Carbon\Carbon;
use Database\Factories\ReportFactory;
use Domain\Reports\Enums\States;
use Domain\Reports\Types\GeneratorAbstract;
use Domain\Reports\Types\SupplyRequestRawDataReport;
use Domain\Reports\Types\TripTicketRawDataReport;
use Domain\Reports\Types\UserTripHistory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $requester_id
 * @property string $filename
 * @property string $type
 * @property array $parameters
 * @property States $status
 * @property string $disk
 * @property string $error
 * @property Carbon $failed_at
 * @property Carbon $started_at
 * @property Carbon $finished_at
 * @property Carbon $created_at
 */
class Report extends Model
{
    use HasFactory;

    protected static function newFactory(): ReportFactory
    {
        return ReportFactory::new();
    }

    protected $casts = [
        'status' => States::class,
        'parameters' => 'array',
        'failed_at' => 'datetime',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public static function GET_REPORTS(): Collection
    {
        return Collection::make([
            'Trip Ticket Raw Data Report',
            'Supply Request Raw Data Report',
        ]);
    }

    public function getGenerator(): GeneratorAbstract
    {
        return match ($this->type) {
            'Trip Ticket Raw Data Report' => new TripTicketRawDataReport($this),
            'Supply Request Raw Data Report' => new SupplyRequestRawDataReport($this),
        };
    }

    public function getCoverageAttribute(): string
    {
        return Carbon::parse($this->parameters['from_date'])->format('F d, Y') . ' - ' .
            Carbon::parse($this->parameters['to_date'])->format('F d, Y');
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function markStatus(States $status): void
    {
        match ($status) {
            States::GENERATING => $this->started_at = Carbon::now(),
            States::FAILED => $this->failed_at = Carbon::now(),
            States::DONE => $this->finished_at = Carbon::now(),
            States::PENDING => '',
        };

        $this->status = $status;
        $this->save();
    }
}
