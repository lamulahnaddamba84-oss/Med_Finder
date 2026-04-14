<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pharmacies', function (Blueprint $table) {
            if (! Schema::hasColumn('pharmacies', 'subscription_amount')) {
                $table->decimal('subscription_amount', 10, 2)->nullable()->after('subscription_plan');
            }

            if (! Schema::hasColumn('pharmacies', 'subscription_paid_at')) {
                $table->timestamp('subscription_paid_at')->nullable()->after('subscription_amount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pharmacies', function (Blueprint $table) {
            if (Schema::hasColumn('pharmacies', 'subscription_paid_at')) {
                $table->dropColumn('subscription_paid_at');
            }

            if (Schema::hasColumn('pharmacies', 'subscription_amount')) {
                $table->dropColumn('subscription_amount');
            }
        });
    }
};
