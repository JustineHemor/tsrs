<?php

use App\Models\User;
use Domain\TripTickets\Models\Driver;
use Domain\TripTickets\Models\Vehicle;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trip_tickets', function (Blueprint $table) {
            $table->id();

            $table->string('status');

            $table->foreignIdFor(User::class, 'requester_id')->index();

            $table->integer('passenger_count');
            $table->string('contact_person');
            $table->string('contact_number');

            $table->string('origin');
            $table->string('drop_off');
            $table->string('pick_up')->nullable();

            $table->dateTime('origin_datetime');
            $table->dateTime('drop_off_datetime');
            $table->dateTime('pick_up_datetime')->nullable();

            $table->foreignIdFor(Vehicle::class)->nullable();
            $table->foreignIdFor(Driver::class)->nullable();

            $table->text('purpose')->nullable();
            $table->text('remarks')->nullable();

            $table->dateTime('approved_at')->nullable();
            $table->dateTime('denied_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();

            $table->foreignIdFor(User::class, 'approver_id')->nullable()->index();
            $table->foreignIdFor(User::class, 'denier_id')->nullable()->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_tickets');
    }
};
