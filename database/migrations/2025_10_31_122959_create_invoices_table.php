<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Relation;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('type'); //inbound or outbound
            $table->foreignIdFor(Relation::class)->constrained();
            $table->string('date');
            $table->string('description');
            $table->string('number');
            $table->string('term');
            $table->decimal('amount', 10, 2);
            $table->integer('vat_percentage');
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
