<?php

use App\Models\User;
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
        Schema::create('supply_requests', function (Blueprint $table) {
            $table->id();

            $table->string('status'); //pending, approved, denied, fulfilled

            $table->foreignIdFor(User::class, 'requester_id')->index();

            $table->string('remarks')->nullable();

            $table->string('note')->nullable();

            $table->dateTime('approved_at')->nullable();
            $table->dateTime('denied_at')->nullable();
            $table->dateTime('fulfilled_at')->nullable();

            $table->foreignIdFor(User::class, 'approver_id')->nullable()->index();
            $table->foreignIdFor(User::class, 'denier_id')->nullable()->index();
            $table->foreignIdFor(User::class, 'fulfiller_id')->nullable()->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supply_requests');
    }
};
