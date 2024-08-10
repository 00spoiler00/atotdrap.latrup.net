<?php

use App\Models\Car;
use App\Models\Driver;
use App\Models\Track;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hotlaps', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Driver::class)->constrained();
            $table->foreignIdFor(Track::class)->constrained();
            $table->foreignIdFor(Car::class)->constrained();
            $table->integer('laptime');
            $table->timestamp('measured_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotlaps');
    }
};
