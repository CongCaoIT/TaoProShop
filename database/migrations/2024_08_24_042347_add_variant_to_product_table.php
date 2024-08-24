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
        Schema::table('products', function (Blueprint $table) {
            $table->text('attributeCatalogue')->nullable();
            $table->string('code')->default(0);
            $table->string('made_in')->nullable();
            $table->float('price')->default(0);
            $table->text('attribute')->nullable();
            $table->text('variant')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('attributeCatalogue');
            $table->dropColumn('code');
            $table->dropColumn('made_in');
            $table->dropColumn('price');
            $table->dropColumn('attribute');
            $table->dropColumn('variant');
        });
    }
};
