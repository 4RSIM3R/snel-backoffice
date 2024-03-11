<?php

use App\Models\Customer;
use App\Models\Site;
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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Site::class)->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('information');
            $table->enum('status', ['NEED_REVIEW', 'APPROVED', 'DISMISS']);
            $table->softDeletes();
            $table->timestamps();
            $table->index(['id', 'customer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
