<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('oil_tonnages', function (Blueprint $table) {
        $table->id();
        $table->float('volume');
        $table->float('density');
        $table->float('temperature');
        $table->float('vcf');
        $table->float('tonnage');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oil_tonnages');
    }
};
