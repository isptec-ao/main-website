<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarMensagem;
use App\Models\Post;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TopicController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\UploadsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\AcademicCategoryController;
use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Admin\RecruitmentCategoryController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\ConfirmPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sendmail', function () {

    // Eu vou inserir as variáveis manualmente mas na prática devem obté-los a partir do formulário
    // Algo como request()->contactform_name, request()->contactform_email, request()->contactform_subject, etc
    // Contudo vou ser breve

    Mail::to('veneravel.osvaldo@gmail.com')->send(new EnviarMensagem(
        'Osvaldo Manuel',
        'vmanuel@outlook.com',
        '949645105',
        'Novidades 2021',
        'Marketing',
        'Ola, gostaria de saber se iremos receber novos modelos do Mazda 6 em 2021.'
    ));
});

Route::get('lang/{lang}', function($lang) {
    //
    (in_array($lang, config('app.locales')) ? app()->setLocale($lang) : app()->setLocale('pt'));

    //
    session()->put('locale', $lang);

    //
    return back();
});
Route::middleware(['setLocale'])->group(function() {

    Route::group(['middleware' => 'website_guest'], function() {

        Route::get('/', [HomeController::class, 'index'])->name('home');

        // Website Authentication
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('canvas.login');
        Route::post('/login', [LoginController::class, 'login'])->name('canvas.login.attempt');
        Route::get('password/email', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('canvas.password.email');
        Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('canvas.password.email');
        Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('canvas.password.reset');
        Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('canvas.password.reset');    
    
    });
    
    Route::group(['middleware' => 'website_auth'], function() {

        Route::post('/logout', [LoginController::class, 'logout'])->name('canvas.logout');
        Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('canvas.password.confirm');
        Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm'])->name('canvas.password.confirm');
        
        Route::get('/canvas/dashboard',[StatsController::class, 'index'])->name('canvas.dashboard');

        Route::get('/canvas/tags',[TagController::class, 'index'])->name('canvas.tags.index');
        Route::get('/canvas/tags/create',[TagController::class, 'create'])->name('canvas.tags.create');
        Route::post('/canvas/tags',[TagController::class, 'store'])->name('canvas.tags.store');
        Route::get('/canvas/tags/{tag}/edit',[TagController::class, 'edit'])->name('canvas.tags.edit');
        Route::get('/canvas/tags/{tag}/show',[TagController::class, 'show'])->name('canvas.tags.show');
        Route::put('/canvas/tags/{tag}',[TagController::class, 'update'])->name('canvas.tags.update');
        Route::delete('/canvas/tags/{tag}',[TagController::class, 'destroy'])->name('canvas.tags.delete');
        Route::put('/canvas/tags/{tag}/restore',[TagController::class, 'restore'])->name('canvas.tags.restore');
        Route::get('/canvas/tags/{tag}/{lang}',[TagController::class, 'lang'])->name('canvas.tags.getlang');
        Route::put('/canvas/tags/{tag}/settranslation',[TagController::class, 'settranslation'])->name('canvas.tags.settranslation');

        Route::get('/canvas/topics',[TopicController::class, 'index'])->name('canvas.topics.index');
        Route::get('/canvas/topics/create',[TopicController::class, 'create'])->name('canvas.topics.create');
        Route::post('/canvas/topics',[TopicController::class, 'store'])->name('canvas.topics.store');
        Route::get('/canvas/topics/{topic}/edit',[TopicController::class, 'edit'])->name('canvas.topics.edit');
        Route::get('/canvas/topics/{topic}/show',[TopicController::class, 'show'])->name('canvas.topics.show');
        Route::put('/canvas/topics/{topic}',[TopicController::class, 'update'])->name('canvas.topics.update');
        Route::delete('/canvas/topics/{topic}',[TopicController::class, 'destroy'])->name('canvas.topics.delete');
        Route::put('/canvas/topics/{topic}/restore',[TopicController::class, 'restore'])->name('canvas.topics.restore');
        Route::get('/canvas/topics/{topic}/{lang}',[TopicController::class, 'lang'])->name('canvas.topics.getlang');
        Route::put('/canvas/topics/{topic}/settranslation',[TopicController::class, 'settranslation'])->name('canvas.topics.settranslation');

        Route::get('/canvas/posts',[PostController::class, 'index'])->name('canvas.posts.index');
        Route::get('/canvas/posts/create',[PostController::class, 'create'])->name('canvas.posts.create');
        Route::post('/canvas/posts',[PostController::class, 'store'])->name('canvas.posts.store');
        Route::get('/canvas/posts/{post}/edit',[PostController::class, 'edit'])->name('canvas.posts.edit');
        Route::get('/canvas/posts/{post}/show',[PostController::class, 'show'])->name('canvas.posts.show');
        Route::put('/canvas/posts/{post}',[PostController::class, 'update'])->name('canvas.posts.update');
        Route::delete('/canvas/posts/{post}',[PostController::class, 'destroy'])->name('canvas.posts.delete');
        Route::put('/canvas/posts/{post}/restore',[PostController::class, 'restore'])->name('canvas.posts.restore');
        Route::get('/canvas/posts/{post}/{lang}',[PostController::class, 'lang'])->name('canvas.posts.getlang');
        Route::put('/canvas/posts/{post}/settranslation',[PostController::class, 'settranslation'])->name('canvas.posts.settranslation');
        Route::get('/canvas/posts/downloadsingleattachment',[PostController::class, 'downloadsingleattachment'])->name('canvas.posts.downloadsingleattachment');
        Route::get('/canvas/posts/deletesingleattachment',[PostController::class, 'deletesingleattachment'])->name('canvas.posts.deletesingleattachment');
        Route::get('/canvas/posts/downloadallattachments',[PostController::class, 'downloadallattachments'])->name('canvas.posts.downloadallattachments');

        Route::get('/canvas/departments',[DepartmentController::class, 'index'])->name('canvas.departments.index');
        Route::get('/canvas/departments/create',[DepartmentController::class, 'create'])->name('canvas.departments.create');
        Route::post('/canvas/departments',[DepartmentController::class, 'store'])->name('canvas.departments.store');
        Route::get('/canvas/departments/{department}/edit',[DepartmentController::class, 'edit'])->name('canvas.departments.edit');
        Route::get('/canvas/departments/{department}/show',[DepartmentController::class, 'show'])->name('canvas.departments.show');
        Route::put('/canvas/departments/{department}',[DepartmentController::class, 'update'])->name('canvas.departments.update');
        Route::delete('/canvas/departments/{department}',[DepartmentController::class, 'destroy'])->name('canvas.departments.delete');
        Route::put('/canvas/departments/{department}/restore',[DepartmentController::class, 'restore'])->name('canvas.departments.restore');
        Route::get('/canvas/departments/{department}/{lang}',[DepartmentController::class, 'lang'])->name('canvas.departments.getlang');
        Route::put('/canvas/departments/{department}/settranslation',[DepartmentController::class, 'settranslation'])->name('canvas.departments.settranslation');

        Route::get('/canvas/academiccategories',[AcademicCategoryController::class, 'index'])->name('canvas.academiccategories.index');
        Route::get('/canvas/academiccategories/create',[AcademicCategoryController::class, 'create'])->name('canvas.academiccategories.create');
        Route::post('/canvas/academiccategories',[AcademicCategoryController::class, 'store'])->name('canvas.academiccategories.store');
        Route::get('/canvas/academiccategories/{academiccategory}/edit',[AcademicCategoryController::class, 'edit'])->name('canvas.academiccategories.edit');
        Route::get('/canvas/academiccategories/{academiccategory}/show',[AcademicCategoryController::class, 'show'])->name('canvas.academiccategories.show');
        Route::put('/canvas/academiccategories/{academiccategory}',[AcademicCategoryController::class, 'update'])->name('canvas.academiccategories.update');
        Route::delete('/canvas/academiccategories/{academiccategory}',[AcademicCategoryController::class, 'destroy'])->name('canvas.academiccategories.delete');
        Route::put('/canvas/academiccategories/{academiccategory}/restore',[AcademicCategoryController::class, 'restore'])->name('canvas.academiccategories.restore');
        Route::get('/canvas/academiccategories/{academiccategory}/{lang}',[AcademicCategoryController::class, 'lang'])->name('canvas.academiccategories.getlang');
        Route::put('/canvas/academiccategories/{academiccategory}/settranslation',[AcademicCategoryController::class, 'settranslation'])->name('canvas.academiccategories.settranslation');

        Route::get('/canvas/coursecategories',[CourseCategoryController::class, 'index'])->name('canvas.coursecategories.index');
        Route::get('/canvas/coursecategories/create',[CourseCategoryController::class, 'create'])->name('canvas.coursecategories.create');
        Route::post('/canvas/coursecategories',[CourseCategoryController::class, 'store'])->name('canvas.coursecategories.store');
        Route::get('/canvas/coursecategories/{coursecategory}/edit',[CourseCategoryController::class, 'edit'])->name('canvas.coursecategories.edit');
        Route::get('/canvas/coursecategories/{coursecategory}/show',[CourseCategoryController::class, 'show'])->name('canvas.coursecategories.show');
        Route::put('/canvas/coursecategories/{coursecategory}',[CourseCategoryController::class, 'update'])->name('canvas.coursecategories.update');
        Route::delete('/canvas/coursecategories/{coursecategory}',[CourseCategoryController::class, 'destroy'])->name('canvas.coursecategories.delete');
        Route::put('/canvas/coursecategories/{coursecategory}/restore',[CourseCategoryController::class, 'restore'])->name('canvas.coursecategories.restore');
        Route::get('/canvas/coursecategories/{coursecategory}/{lang}',[CourseCategoryController::class, 'lang'])->name('canvas.coursecategories.getlang');
        Route::put('/canvas/coursecategories/{coursecategory}/settranslation',[CourseCategoryController::class, 'settranslation'])->name('canvas.coursecategories.settranslation');

        Route::get('/canvas/recruitmentcategories',[RecruitmentCategoryController::class, 'index'])->name('canvas.recruitmentcategories.index');
        Route::get('/canvas/recruitmentcategories/create',[RecruitmentCategoryController::class, 'create'])->name('canvas.recruitmentcategories.create');
        Route::post('/canvas/recruitmentcategories',[RecruitmentCategoryController::class, 'store'])->name('canvas.recruitmentcategories.store');
        Route::get('/canvas/recruitmentcategories/{recruitmentcategory}/edit',[RecruitmentCategoryController::class, 'edit'])->name('canvas.recruitmentcategories.edit');
        Route::get('/canvas/recruitmentcategories/{recruitmentcategory}/show',[RecruitmentCategoryController::class, 'show'])->name('canvas.recruitmentcategories.show');
        Route::put('/canvas/recruitmentcategories/{recruitmentcategory}',[RecruitmentCategoryController::class, 'update'])->name('canvas.recruitmentcategories.update');
        Route::delete('/canvas/recruitmentcategories/{recruitmentcategory}',[RecruitmentCategoryController::class, 'destroy'])->name('canvas.recruitmentcategories.delete');
        Route::put('/canvas/recruitmentcategories/{recruitmentcategory}/restore',[RecruitmentCategoryController::class, 'restore'])->name('canvas.recruitmentcategories.restore');
        Route::get('/canvas/recruitmentcategories/{recruitmentcategory}/{lang}',[RecruitmentCategoryController::class, 'lang'])->name('canvas.recruitmentcategories.getlang');
        Route::put('/canvas/recruitmentcategories/{recruitmentcategory}/settranslation',[RecruitmentCategoryController::class, 'settranslation'])->name('canvas.recruitmentcategories.settranslation');

        Route::get('/canvas/servicecategories',[ServiceCategoryController::class, 'index'])->name('canvas.servicecategories.index');
        Route::get('/canvas/servicecategories/create',[ServiceCategoryController::class, 'create'])->name('canvas.servicecategories.create');
        Route::post('/canvas/servicecategories',[ServiceCategoryController::class, 'store'])->name('canvas.servicecategories.store');
        Route::get('/canvas/servicecategories/{servicecategory}/edit',[ServiceCategoryController::class, 'edit'])->name('canvas.servicecategories.edit');
        Route::get('/canvas/servicecategories/{servicecategory}/show',[ServiceCategoryController::class, 'show'])->name('canvas.servicecategories.show');
        Route::put('/canvas/servicecategories/{servicecategory}',[ServiceCategoryController::class, 'update'])->name('canvas.servicecategories.update');
        Route::delete('/canvas/servicecategories/{servicecategory}',[ServiceCategoryController::class, 'destroy'])->name('canvas.servicecategories.delete');
        Route::put('/canvas/servicecategories/{servicecategory}/restore',[ServiceCategoryController::class, 'restore'])->name('canvas.servicecategories.restore');
        Route::get('/canvas/servicecategories/{servicecategory}/{lang}',[ServiceCategoryController::class, 'lang'])->name('canvas.servicecategories.getlang');
        Route::put('/canvas/servicecategories/{servicecategory}/settranslation',[ServiceCategoryController::class, 'settranslation'])->name('canvas.servicecategories.settranslation');

        Route::get('/canvas/pages',[PageController::class, 'index'])->name('canvas.pages.index');
        Route::get('/canvas/pages/create',[PageController::class, 'create'])->name('canvas.pages.create');
        Route::post('/canvas/pages',[PageController::class, 'store'])->name('canvas.pages.store');
        Route::get('/canvas/pages/{page}/edit',[PageController::class, 'edit'])->name('canvas.pages.edit');
        Route::get('/canvas/pages/{page}/show',[PageController::class, 'show'])->name('canvas.pages.show');
        Route::put('/canvas/pages/{page}',[PageController::class, 'update'])->name('canvas.pages.update');
        Route::delete('/canvas/pages/{page}',[PageController::class, 'destroy'])->name('canvas.pages.delete');
        Route::put('/canvas/pages/{page}/restore',[PageController::class, 'restore'])->name('canvas.pages.restore');
        Route::get('/canvas/pages/{page}/{lang}',[PageController::class, 'lang'])->name('canvas.pages.getlang');
        Route::put('/canvas/pages/{page}/settranslation',[PageController::class, 'settranslation'])->name('canvas.pages.settranslation');

        Route::get('/canvas/sections',[SectionController::class, 'index'])->name('canvas.sections.index');
        Route::get('/canvas/sections/create',[SectionController::class, 'create'])->name('canvas.sections.create');
        Route::post('/canvas/sections',[SectionController::class, 'store'])->name('canvas.sections.store');
        Route::get('/canvas/sections/{section}/edit',[SectionController::class, 'edit'])->name('canvas.sections.edit');
        Route::get('/canvas/sections/{section}/show',[SectionController::class, 'show'])->name('canvas.sections.show');
        Route::put('/canvas/sections/{section}',[SectionController::class, 'update'])->name('canvas.sections.update');
        Route::delete('/canvas/sections/{section}',[SectionController::class, 'destroy'])->name('canvas.sections.delete');
        Route::put('/canvas/sections/{section}/restore',[SectionController::class, 'restore'])->name('canvas.sections.restore');
        Route::get('/canvas/sections/{section}/{lang}',[SectionController::class, 'lang'])->name('canvas.sections.getlang');
        Route::put('/canvas/sections/{section}/settranslation',[SectionController::class, 'settranslation'])->name('canvas.sections.settranslation');

        Route::get('/canvas/sliders',[SliderController::class, 'index'])->name('canvas.sliders.index');
        Route::get('/canvas/sliders/create',[SliderController::class, 'create'])->name('canvas.sliders.create');
        Route::post('/canvas/sliders',[SliderController::class, 'store'])->name('canvas.sliders.store');
        Route::get('/canvas/sliders/{slider}/edit',[SliderController::class, 'edit'])->name('canvas.sliders.edit');
        Route::get('/canvas/sliders/{slider}/show',[SliderController::class, 'show'])->name('canvas.sliders.show');
        Route::put('/canvas/sliders/{slider}',[SliderController::class, 'update'])->name('canvas.sliders.update');
        Route::delete('/canvas/sliders/{slider}',[SliderController::class, 'destroy'])->name('canvas.sliders.delete');
        Route::put('/canvas/sliders/{slider}/restore',[SliderController::class, 'restore'])->name('canvas.sliders.restore');
        Route::get('/canvas/sliders/{slider}/{lang}',[SliderController::class, 'lang'])->name('canvas.sliders.getlang');
        Route::put('/canvas/sliders/{slider}/settranslation',[SliderController::class, 'settranslation'])->name('canvas.sliders.settranslation');

    });

});

// Route::get('lang/{lang}', [LocalizationController::class, 'index']);
