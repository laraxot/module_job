<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

class CreateTasksTable extends XotBaseMigration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('description');
                $table->string('command');
                $table->string('parameters')->nullable();
                $table->string('expression')->nullable();
                $table->string('timezone')->default('UTC');
                $table->boolean('is_active')->default(true);
                $table->boolean('dont_overlap')->default(false);
                $table->boolean('run_in_maintenance')->default(false);
                $table->string('notification_email_address')->nullable();
                $table->string('notification_phone_number')->nullable();
                $table->string('notification_slack_webhook');
                $table->integer('auto_cleanup_num')->default(0);
                $table->string('auto_cleanup_type', 20)->nullable();
                $table->boolean('run_on_one_server')->default(false);

                $table->index('is_active', 'tasks_is_active_idx');
                $table->index('dont_overlap', 'tasks_dont_overlap_idx');
                $table->index('run_in_maintenance', 'tasks_run_in_maintenance_idx');
                $table->index('run_on_one_server', 'tasks_run_on_one_server_idx');
                $table->index('auto_cleanup_num', 'tasks_auto_cleanup_num_idx');
                $table->index('auto_cleanup_type', 'tasks_auto_cleanup_type_idx');
                $table->boolean('run_in_background')->default(false);
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->timestamps();
            }
        );
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table) {
                // if (! $this->hasColumn('created_by')) {
                //     $table->string('created_by')->nullable();
                //     $table->string('updated_by')->nullable();
                // }

            }
        );
    }
}
