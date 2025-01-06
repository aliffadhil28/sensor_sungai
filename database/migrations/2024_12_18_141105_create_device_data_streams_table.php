<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Device;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('device_data_streams', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Device::class,'device_id');
            $table->float('debit_air');
            $table->string('debit_air_status');
            $table->float('tinggi_air');
            $table->string('tinggi_air_status');
            $table->float('curah_hujan');
            $table->string('curah_hujan_status');
            $table->float('battery');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_data_streams');
    }
};
