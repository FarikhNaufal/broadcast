<?php

use App\Models\Group;
use App\Models\Media;
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
        Schema::create('group_media', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Group::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Media::class)->constrained()->onDelete('cascade');
            $table->integer('duration');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_media');
    }
};
