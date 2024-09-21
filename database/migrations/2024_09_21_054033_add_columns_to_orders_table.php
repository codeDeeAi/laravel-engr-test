<?php

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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('provider');
            $table->string('hmo_code')->constrained('hmos', 'code');
            $table->decimal('total_items_cost', 10, 2)->default(0);
            $table->dateTime('encounter_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('hmo_code');
            $table->dropColumn('provider');
            $table->dropColumn('total_items_cost');
            $table->dropColumn('encounter_date');
            $table->dropForeign(['hmo_code']);
        });
    }
};
