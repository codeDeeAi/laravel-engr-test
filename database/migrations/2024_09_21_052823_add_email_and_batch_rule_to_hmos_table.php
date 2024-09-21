<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\BatchRuleEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hmos', function (Blueprint $table) {
            $table->string('email')->unique();
            $table->string('batch_rule')->default(BatchRuleEnum::ENCOUNTER_DATE->value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hmos', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('batch_rule');
        });
    }
};
