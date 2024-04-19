<?php

use App\Models\DelayedOrder;
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
        Schema::create('delayed_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->nullable()->constrained();
            $table->foreignId('order_id')->constrained();
            $table->string('reason')->nullable();
            $table->string('status')->default(DelayedOrder::STATUS['WITHOUT_OWNER']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delayed_orders');
    }
};
