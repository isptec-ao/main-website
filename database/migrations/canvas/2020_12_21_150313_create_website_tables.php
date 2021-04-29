<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsiteTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->unique()->nullable();
            $table->string('password');
            $table->text('summary')->nullable();
            $table->string('avatar')->nullable();
            $table->tinyInteger('dark_mode')->nullable();
            $table->tinyInteger('digest')->nullable();
            $table->string('locale')->nullable();
            $table->tinyInteger('role')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_posts', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('title');
            $table->text('summary')->nullable();
            $table->text('body')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('featured_image_caption')->nullable();
            $table->unsignedBigInteger('user_id')->index();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['slug', 'user_id']);
        });

        Schema::create('website_tags', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->unsignedBigInteger('user_id')->index();
            $table->timestamps();
            $table->softDeletes();
            $table->index('created_at');
            $table->unique(['slug', 'user_id']);
        });

        Schema::create('website_topics', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->unsignedBigInteger('user_id')->index();
            $table->timestamps();
            $table->softDeletes();
            $table->index('created_at');
            $table->unique(['slug', 'user_id']);
        });

        Schema::create('website_posts_tags', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('tag_id');
            $table->unique(['post_id', 'tag_id']);
        });

        Schema::create('website_posts_topics', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('topic_id');
            $table->unique(['post_id', 'topic_id']);
        });

        Schema::create('website_views', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id')->index();
            $table->string('ip')->nullable();
            $table->text('agent')->nullable();
            $table->string('referer')->nullable();
            $table->timestamps();
            $table->index('created_at');
        });

        Schema::create('website_visits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->string('ip')->nullable();
            $table->text('agent')->nullable();
            $table->string('referer')->nullable();
            $table->timestamps();
        });

        Schema::create('website_menus', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('slug');
            $table->string('link')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('sort_id')->nullable();
            $table->unsignedBigInteger('user_id')->index();

            $table->timestamps();
        });

        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();
            $table->string('option');
            $table->longText('value')->nullable();
            $table->unsignedBigInteger('user_id')->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('category')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('contact')->nullable();
            $table->longText('description_pt')->nullable();
            $table->longText('description_en')->nullable();
            $table->longText('obs')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('email')->nullable();
            $table->string('tel_no')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('show_on_contact_page')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('website_service_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id', 'dep_id')->references('id')->on('website_departments')->onDelete('cascade');
            $table->string('email')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('website_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id', 'service_cat')->references('id')->on('website_service_categories')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->longText('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('website_events', function (Blueprint $table) {
            $table->id();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->string('color')->nullable();
            $table->longText('description')->nullable();
            $table->string('venue')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('user_id')->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_rec_cats', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('user_id')->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_rec_pubs', function (Blueprint $table) {
            $table->id();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->longText('description')->nullable();
            $table->longText('requirements')->nullable();
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id', 'rec_cat')->references('id')->on('website_rec_cats')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_acad_cats', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_rec_subs', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('naturality')->nullable();
            $table->string('id_no')->nullable();
            $table->string('email')->nullable();
            $table->string('tel_no')->nullable();
            $table->string('country')->nullable();
            $table->date('dob')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('address')->nullable();
            $table->string('suburb')->nullable();
            $table->string('postal_code')->nullable();
            $table->longText('work_experience')->nullable();
            $table->longText('other_info')->nullable();
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('pub_id')->nullable();
            $table->foreign('pub_id')->references('id')->on('website_rec_pubs')->onDelete('cascade');
            $table->unsignedBigInteger('acad_id')->nullable();
            $table->foreign('acad_id')->references('id')->on('website_acad_cats')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_employees', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->boolean('receive_bday_notification')->default(1);
            $table->boolean('is_national')->default(1);
            $table->boolean('is_lecturer')->default(1);
            $table->string('tel_no')->nullable();
            $table->string('orchid_id')->nullable();
            $table->longText('description')->nullable();
            $table->string('extension')->nullable();
            $table->date('dob')->nullable();
            $table->char('birthday', 5)->virtualAs('date_format(dob, "%m-%d")')->index();
            $table->enum('gender', ['M', 'F']);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('website_messages', function (Blueprint $table) {
            $table->id();
            $table->longText('description');
            $table->enum('gender', ['A', 'M', 'F']);
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();
        });

        Schema::create('website_journal_cats', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_pub_journals', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug');
            $table->longText('summary')->nullable();
            $table->longText('extra_data')->nullable();
            $table->date('published_at')->nullable();
            $table->string('external_url')->nullable();
            $table->string('journal_name')->nullable();
            $table->string('authors')->nullable();
            $table->string('reference')->nullable();
            $table->string('lecturers')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('website_journal_cats')->onDelete('cascade');
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();
        });

        Schema::create('website_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('code')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('status')->default(1);
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();
        });

        Schema::create('website_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('page_id')->nullable();
            $table->foreign('page_id')->references('id')->on('website_pages')->onDelete('cascade');
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();
        });

        Schema::create('website_sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('height')->nullable();
            $table->string('width')->nullable();
            $table->string('interval')->nullable();
            $table->unsignedBigInteger('page_id')->nullable();
            $table->foreign('page_id')->references('id')->on('website_pages')->onDelete('cascade');
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();
        });

        Schema::create('website_course_cats', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('user_id')->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_courses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug');
            $table->longText('description')->nullable();
            $table->string('duration')->nullable();
            $table->boolean('status')->default(1);
            $table->date('start_date')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('website_course_cats')->onDelete('cascade');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('website_departments')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_alumni', function (Blueprint $table) {
            $table->id();
            $table->string('student_full_name')->nullable();
            $table->string('slug');
            $table->string('year')->nullable();
            $table->longText('summary')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')->references('id')->on('website_courses')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_semesters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->longText('year')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_css', function (Blueprint $table) {
            $table->id();
            $table->string('theoretical')->nullable();
            $table->string('practical')->nullable();
            $table->string('theoretical_practical')->nullable();
            $table->string('weekly_hours')->nullable();
            $table->string('semester_hours')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')->references('id')->on('website_courses')->onDelete('cascade');
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->foreign('subject_id')->references('id')->on('website_subjects')->onDelete('cascade');
            $table->unsignedBigInteger('semester_id')->nullable();
            $table->foreign('semester_id')->references('id')->on('website_semesters')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_simages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('link')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('slider_id')->nullable();
            $table->foreign('slider_id')->references('id')->on('website_sliders')->onDelete('cascade');
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();
        });

        Schema::create('website_partnership_cats', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug');
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_partnerships', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug');
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('website_partnership_cats')->onDelete('cascade');
            $table->string('link')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_nl_cats', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug');
            $table->longText('description')->nullable();
            $table->integer('period')->default(15);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_nl_subs', function (Blueprint $table) {
            $table->id();
            $table->string('fullname')->nullable();
            $table->string('email')->unique();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('website_nl_cats')->onDelete('cascade');
            $table->boolean('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_scourses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug');
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('website_departments')->onDelete('cascade');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('website_employees')->onDelete('cascade');
            $table->string('external_employee')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_scourse_class', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug');
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')->references('id')->on('website_scourses')->onDelete('cascade');
            $table->integer('total_hours')->default(20);
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('price', 8, 2)->default(0);
            $table->decimal('registration_fee', 8, 2)->default(0);
            $table->longText('extra_data')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_scourse_enrolments', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('class_id')->nullable();
            $table->foreign('class_id')->references('id')->on('website_scourse_class')->onDelete('cascade');
            $table->date('dob')->nullable();
            $table->string('id_no')->nullable();
            $table->string('institution')->nullable();
            $table->boolean('paid')->default(0);
            $table->boolean('registration_active')->default(0);
            $table->boolean('is_student')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_file_cats', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_files', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug');
            $table->longText('description')->nullable();
            $table->string('link')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('website_file_cats')->onDelete('cascade');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('website_departments')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_cel_cats', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug');
            $table->string('responsible_name')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('website_employees')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_cel_members', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug');
            $table->string('surname')->nullable();
            $table->string('email')->nullable();
            $table->enum('member_type', ['E', 'S', 'O']); // Employee, Student, Other
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('website_cel_cats')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_cel_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('topic')->nullable();
            $table->string('slug');
            $table->longText('description')->nullable();
            $table->date('date')->nullable();
            $table->string('venue')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('website_cel_cats')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_msg_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->longText('tel_no')->nullable();
            $table->string('email')->nullable();
            $table->longText('message')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('website_media_cats', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_isptec_media', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('title');
            $table->text('summary')->nullable();
            $table->text('body')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('featured_image_caption')->nullable();
            $table->unsignedBigInteger('user_id')->index();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['slug', 'user_id']);
        });

        Schema::create('website_isptec_media_cats', function (Blueprint $table) {
            $table->unsignedBigInteger('media_id');
            $table->unsignedBigInteger('category_id');
            $table->unique(['media_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_users');
        Schema::dropIfExists('website_posts');
        Schema::dropIfExists('website_tags');
        Schema::dropIfExists('website_topics');
        Schema::dropIfExists('website_posts_tags');
        Schema::dropIfExists('website_posts_topics');
        Schema::dropIfExists('website_views');
        Schema::dropIfExists('website_visits');
        Schema::dropIfExists('website_menus');
        Schema::dropIfExists('website_settings');
        Schema::dropIfExists('website_submissions');
        Schema::dropIfExists('website_departments');
        Schema::dropIfExists('website_service_categories');
        Schema::dropIfExists('website_services');
        Schema::dropIfExists('website_events');
        Schema::dropIfExists('website_rec_cats');
        Schema::dropIfExists('website_acad_cats');
        Schema::dropIfExists('website_rec_pubs');
        Schema::dropIfExists('website_employees');
        Schema::dropIfExists('website_messages');
        Schema::dropIfExists('website_journal_cats');
        Schema::dropIfExists('website_pub_journals');
        Schema::dropIfExists('website_pages');
        Schema::dropIfExists('website_sections');
        Schema::dropIfExists('website_sliders');
        Schema::dropIfExists('website_course_cats');
        Schema::dropIfExists('website_courses');
        Schema::dropIfExists('website_alumni');
        Schema::dropIfExists('website_subjects');
        Schema::dropIfExists('website_semesters');
        Schema::dropIfExists('website_css');
        Schema::dropIfExists('website_simages');
        Schema::dropIfExists('website_partnership_cats');
        Schema::dropIfExists('website_partnerships');
        Schema::dropIfExists('website_nl_cats');
        Schema::dropIfExists('website_nl_subs');
        Schema::dropIfExists('website_scourses');
        Schema::dropIfExists('website_scourse_class');
        Schema::dropIfExists('website_scourse_enrolments');
        Schema::dropIfExists('website_file_cats');
        Schema::dropIfExists('website_files');
        Schema::dropIfExists('website_cel_cats');
        Schema::dropIfExists('website_cel_members');
        Schema::dropIfExists('website_cel_sessions');
        Schema::dropIfExists('website_msg_submissions');
        Schema::dropIfExists('website_media_cats');
        Schema::dropIfExists('website_isptec_media');
        Schema::dropIfExists('website_isptec_media_cats');
    }
}
