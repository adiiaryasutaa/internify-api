<?php

declare(strict_types=1);

use App\Models\Apprentice;
use App\Models\Vacancy;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table): void {
            $table->id();
            $table->string('slug');
            $table->foreignIdFor(Vacancy::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignIdFor(Apprentice::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->longText('resume');
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });
    }
};
