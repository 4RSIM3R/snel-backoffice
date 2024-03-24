<?php

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Site;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Site::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Employee::class)->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->string('number');
            $table->string('title');
            $table->string('information');
            $table->enum('type', ['RECORDING', 'REGULAR', 'PRIORITY'])->default('REGULAR');
            $table->enum('status', ['ADMIN_APPROVED', 'CUSTOMER_APPROVED', 'WORKING', 'NEED_ADMIN_REVIEW', 'DONE', 'CANCEL'])->default('ADMIN_APPROVED');
            $table->softDeletes();
            $table->timestamps();
            $table->index(['id', 'customer_id', 'site_id', 'employee_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
