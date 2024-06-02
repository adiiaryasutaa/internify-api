<?php

declare(strict_types=1);

use App\Models\Company;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('vacancies', function (Blueprint $table): void {
            $table->id();
            $table->string('slug');
            $table->string('code')->unique();
            $table->foreignIdFor(Company::class)
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('title');
            $table->longText('description');
            $table->string('location');
            $table->datetime('deadline');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }
};
