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
        schema::table('pharmacies', function (Blueprint $table) {
            if(!Schema::hasColumn('pharmacies', 'is_subscribed')) {
                $table->boolean('is_subscribed')->default(false);
            }
        });
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::table('pharmacies', function (Blueprint $table) {
            if(Schema::hasColumn('pharmacies', 'is_subscribed')) {
                $table->dropColumn('is_subscribed');
            }
        });
        //
    }
};
