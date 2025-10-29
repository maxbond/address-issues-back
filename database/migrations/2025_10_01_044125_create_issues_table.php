<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\IssuePriority;
use App\Enums\IssueStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('address_id');
            $table->enum('status', array_column(IssueStatus::cases(), 'value'))->default(IssueStatus::Open);
            $table->enum('priority', array_column(IssuePriority::cases(), 'value'))->default(IssuePriority::Default);
            $table->string('title', 200);
            $table->mediumText('description')->nullable();
            $table->dateTimeTz('time_period_from')->nullable();
            $table->dateTimeTz('time_period_to')->nullable();
            $table->dateTimeTz('tracking_start')->nullable();
            $table->dateTimeTz('tracking_finish')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('restrict');
            $table->index('address_id');
            $table->index(['time_period_from', 'time_period_to']);
        });

        Schema::create('issue_tags', function (Blueprint $table) {
            $table->unsignedBigInteger('issue_id');
            $table->unsignedBigInteger('tag_id');
            $table->foreign('issue_id')->references('id')->on('issues')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issue_tags');
        Schema::dropIfExists('issues');
    }
};
