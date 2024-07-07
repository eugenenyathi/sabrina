<?php

use App\Constants\PortalStatusConstants;
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
        Schema::create('portal_status', function (Blueprint $table) {
            $table->id();
            $table->enum('status', PortalStatusConstants::PORTAL_STATE);
            $table->integer('active')->default(PortalStatusConstants::INACTIVE);
            $table->datetime('opening_date')->nullable();
            $table->datetime('closing_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portal_status');
    }
};
