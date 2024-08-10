<?php

use App\Models\Car;
use App\Models\Driver;
use App\Models\Race;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Driver::class)->constrained();
            $table->foreignIdFor(Race::class)->constrained();
            $table->foreignIdFor(Car::class)->constrained();
            $table->string('server_name');
            $table->float('sof', 5, 1);
            $table->integer('split');
            $table->boolean('is_notified')->default(false);
            $table->timestamps();

            $table->unique(['driver_id', 'race_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
