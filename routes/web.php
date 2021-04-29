<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarMensagem;
use App\Models\Canvas\Post;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ISPTECMediaController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TopicController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\UploadsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\AcademicCategoryController;
use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Admin\MediaCategoryController;
use App\Http\Controllers\Admin\RecruitmentCategoryController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Admin\RecruitmentPublicationController;
use App\Http\Controllers\Admin\RecruitmentSubmissionController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\JournalCategoryController;
use App\Http\Controllers\Admin\JournalPublicationController;
use App\Http\Controllers\Admin\AlumniController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CoursePlanController;
use App\Http\Controllers\Admin\CelCategoryController;
use App\Http\Controllers\Admin\FileCategoryController;
use App\Http\Controllers\Admin\PartnerCategoryController;
use App\Http\Controllers\Admin\NewsletterCategoryController;
use App\Http\Controllers\Admin\PartnershipController;
use App\Http\Controllers\Admin\ClubMembershipController;
use App\Http\Controllers\Admin\ClubSessionController;
use App\Http\Controllers\Admin\NewsletterSubscriptionController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\ShortCourseController;
use App\Http\Controllers\Admin\ShortCourseClassController;
use App\Http\Controllers\Admin\ShortCourseRegistrationController;
use App\Http\Controllers\Admin\ContentSubmissionController;


use App\Http\Controllers\NewsController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\JournalPubsController;
use App\Http\Controllers\AlumnisController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\RecruitmentsController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\ACIController;
use App\Http\Controllers\CCDController;
use App\Http\Controllers\PagesController;
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

Route::get('/storage/{extra}', function ($extra) {
    return redirect('/public/storage/$extra');
})->where('extra', '.*');

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
    return redirect('/');
});
Route::middleware(['setLocale'])->group(function() {

    Route::group(['middleware' => 'website_guest'], function() {

        Route::get('/', [PagesController::class, 'home'])->name('pages.home');

        // Noticias
        Route::get('/noticias',[NewsController::class, 'index'])->name('news');
        Route::get('/noticias/{slug}',[NewsController::class, 'show'])
                ->name('news.show')
                ->missing(function (Request $request) {
                    return Redirect::route('home');
                });

        // Eventos
        Route::get('/eventos',[EventsController::class, 'index'])->name('events');
        Route::get('/eventos/{slug}',[EventsController::class, 'show'])
                ->name('events.show')
                ->missing(function (Request $request) {
                    return Redirect::route('home');
                });
       
        // Publicações
        Route::get('/publicacao-com-impacto',[JournalPubsController::class, 'index'])->name('impactjpublications');        
        Route::get('/publicacao-sem-impacto',[JournalPubsController::class, 'index'])->name('jpublications');
        
        // Alumni
        Route::get('/alumni',[AlumnisController::class, 'index'])->name('alumni');
        Route::get('/alumni/{slug}',[AlumnisController::class, 'show'])
                ->name('alumni.show')
                ->missing(function (Request $request) {
                    return Redirect::route('home');
                });

        // Ficheiros
        Route::get('/ficheiros',[FilesController::class, 'index'])->name('files');
        Route::get('/ficheiros/downloadsingleattachment',[FilesController::class, 'downloadsingleattachment'])->name('files.downloadsingleattachment');
        
        // Recrutamento
        Route::get('/recrutamento',[RecruitmentsController::class, 'index'])->name('recruitments');
        Route::post('/recrutamento',[RecruitmentsController::class, 'store'])->name('recruitments.store');
        Route::get('/recrutamento/{slug}',[RecruitmentsController::class, 'show'])
                ->name('recruitments.show')
                ->missing(function (Request $request) {
                    return Redirect::route('home');
                });        
        
                
        // Contactos
        Route::get('/contacto',[ContactsController::class, 'index'])->name('contacts');
        Route::post('/contacto',[ContactsController::class, 'storecontactrequest'])->name('contacts.storecontactrequest');
        Route::post('/servico',[ContactsController::class, 'storeservicerequest'])->name('contacts.storeservicerequest');

        // Submeter Conteudo
        Route::get('/submeter-conteudo',[ACIController::class, 'submitcontent'])->name('aci.contentsubmission');
        Route::post('/submeter-conteudo',[ACIController::class, 'storesubmitedcontent'])->name('aci.storecontentsubmission');
        Route::get('/isptec-na-midia',[ACIController::class, 'isptecmedia'])->name('aci.isptecmedia');
        Route::get('/isptec-na-midia/{slug}',[ACIController::class, 'showisptecmedia'])
                ->name('aci.showisptecmedia')
                ->missing(function (Request $request) {
                    return Redirect::route('home');
                });
        
                
        // CCD
        Route::get('/ccd',[CCDController::class, 'index'])->name('ccd');
        Route::post('/ccd',[CCDController::class, 'store'])->name('ccd.store');
        Route::get('/ccd-inscricao',[CCDController::class, 'registration'])->name('ccd.registration');
        Route::get('/ccd/{slug}',[CCDController::class, 'show'])
                ->name('ccd.show')
                ->missing(function (Request $request) {
                    return Redirect::route('home');
                });
                
        // Páginas Estáticas
        Route::get('/mensagem-direcao',[PagesController::class, 'msg_from_dg'])->name('pages.msg_from_dg');
        Route::get('/apresentacao-institucional',[PagesController::class, 'institutional_presentation'])->name('pages.institutional_presentation');
        Route::get('/organigrama',[PagesController::class, 'org_chart'])->name('pages.org_chart');
        Route::get('/missao',[PagesController::class, 'mission_vision_values'])->name('pages.mission_vision_values');
        Route::get('/historico',[PagesController::class, 'history'])->name('pages.history');
        Route::get('/infraestruturas',[PagesController::class, 'infrastructure'])->name('pages.infrastructure');
        Route::get('/legislacao',[PagesController::class, 'legislation'])->name('pages.legislation');
        Route::get('/convenios',[PagesController::class, 'aggr_protocols'])->name('pages.aggr_protocols');
        Route::get('/accao-social',[PagesController::class, 'social_wellfare'])->name('pages.social_wellfare');
        Route::get('/apoio-social',[PagesController::class, 'social_support'])->name('pages.social_support');
        Route::get('/actividade-extracurriculares',[PagesController::class, 'extracurricular_activities'])->name('pages.extracurricular_activities');
        Route::get('/saude',[PagesController::class, 'health'])->name('pages.health');

        Route::get('/calendario-academico',[PagesController::class, 'acad_calendar'])->name('pages.acad_calendar');
        Route::get('/regulamentos',[PagesController::class, 'regulations'])->name('pages.regulations');
        Route::get('/editais',[PagesController::class, 'edicts'])->name('pages.edicts');
        Route::get('/mobilidadeestudantil',[PagesController::class, 'student_mobility'])->name('pages.student_mobility');

        Route::get('/departamento-de-engenharias-e-tecnologias',[PagesController::class, 'education_det'])->name('pages.education_det');
        Route::get('/departamento-de-geociencias',[PagesController::class, 'education_dgc'])->name('pages.education_dgc');
        Route::get('/departamento-de-ciencias-sociais-aplicadas',[PagesController::class, 'education_dcsa'])->name('pages.education_dcsa');
        Route::get('/docentes',[PagesController::class, 'education_teachers'])->name('pages.education_teachers');
        Route::get('/biblioteca',[PagesController::class, 'education_library_presentation'])->name('pages.education_library_presentation');
        Route::get('/regulamentoestudantil',[PagesController::class, 'education_library_rules'])->name('pages.education_library_rules');

        Route::get('/politicai',[PagesController::class, 'scientific_research_policy'])->name('pages.scientific_research_policy');
        Route::get('/guiaelaboracao',[PagesController::class, 'scientific_research_project_guide'])->name('pages.scientific_research_project_guide');
        Route::get('/jornadas',[PagesController::class, 'scientific_research_events'])->name('pages.scientific_research_events');
        Route::get('/premio-inovacao',[PagesController::class, 'scientific_research_innovation_award'])->name('pages.scientific_research_innovation_award');
        Route::get('/ciclo-de-palestras',[PagesController::class, 'scientific_research_lec_cycles'])->name('pages.scientific_research_lec_cycles');
        Route::get('/centro-investigacoes-dsa',[PagesController::class, 'scientific_research_aasr_center'])->name('pages.scientific_research_aasr_center');

        Route::get('/politica-de-extensao',[PagesController::class, 'extension_services_policy'])->name('pages.extension_services_policy');
        Route::get('/projecto-transferencia-de-conhecimento',[PagesController::class, 'extension_services_trans_knowledge'])->name('pages.extension_services_trans_knowledge');
        Route::get('/estagio-nao-supervisionado',[PagesController::class, 'extension_services_non_curricular_internships'])->name('pages.extension_services_non_curricular_internships');
        Route::get('/promocao-ao-empreendedorismo',[PagesController::class, 'extension_services_entrepreneurship_program'])->name('pages.extension_services_entrepreneurship_program');
        Route::get('/olimpiadas-cientificas',[PagesController::class, 'extension_services_olympiads'])->name('pages.extension_services_olympiads');
        Route::get('/servico-carreira-empregabilidade',[PagesController::class, 'extension_services_employment_careers'])->name('pages.extension_services_employment_careers');
        Route::get('/cel',[PagesController::class, 'extension_services_ltc'])->name('pages.extension_services_ltc');
        Route::get('/program-empresa',[PagesController::class, 'extension_services_cu_program'])->name('pages.extension_services_cu_program');

        // Route::get('/cel', function() {
        //     return view('cel');
        // })->name('cel');

        // Route::get('/cel-registration', function() {
        //     return view('cel_registration');
        // })->name('cel_registration');

        // Route::get('/extensao', function() {
        //     return view('extension_services');
        // })->name('extension_services');

        // Route::get('/investigacao-cientifica', function() {
        //     return view('scientific_research');
        // })->name('scientific_research');

        // Route::get('/recrutamento2', function() {
        //     return view('recruitment');
        // })->name('recruitment');

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

        Route::get('/canvas/contentsubmissions',[ContentSubmissionController::class, 'index'])->name('canvas.contentsubmissions.index');
        Route::get('/canvas/contentsubmissions/create',[ContentSubmissionController::class, 'create'])->name('canvas.contentsubmissions.create');
        Route::post('/canvas/contentsubmissions',[ContentSubmissionController::class, 'store'])->name('canvas.contentsubmissions.store');
        Route::get('/canvas/contentsubmissions/{contentsubmission}/edit',[ContentSubmissionController::class, 'edit'])->name('canvas.contentsubmissions.edit');
        Route::get('/canvas/contentsubmissions/{contentsubmission}/show',[ContentSubmissionController::class, 'show'])->name('canvas.contentsubmissions.show');
        Route::put('/canvas/contentsubmissions/{contentsubmission}',[ContentSubmissionController::class, 'update'])->name('canvas.contentsubmissions.update');
        Route::delete('/canvas/contentsubmissions/{contentsubmission}',[ContentSubmissionController::class, 'destroy'])->name('canvas.contentsubmissions.delete');
        Route::put('/canvas/contentsubmissions/{contentsubmission}/restore',[ContentSubmissionController::class, 'restore'])->name('canvas.contentsubmissions.restore');
        Route::get('/canvas/contentsubmissions/{contentsubmission}/{lang}',[ContentSubmissionController::class, 'lang'])->name('canvas.contentsubmissions.getlang');
        Route::put('/canvas/contentsubmissions/{contentsubmission}/settranslation',[ContentSubmissionController::class, 'settranslation'])->name('canvas.contentsubmissions.settranslation');

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

        Route::get('/canvas/isptecmedia',[ISPTECMediaController::class, 'index'])->name('canvas.isptecmedia.index');
        Route::get('/canvas/isptecmedia/create',[ISPTECMediaController::class, 'create'])->name('canvas.isptecmedia.create');
        Route::post('/canvas/isptecmedia',[ISPTECMediaController::class, 'store'])->name('canvas.isptecmedia.store');
        Route::get('/canvas/isptecmedia/{isptecmedia}/edit',[ISPTECMediaController::class, 'edit'])->name('canvas.isptecmedia.edit');
        Route::get('/canvas/isptecmedia/{isptecmedia}/show',[ISPTECMediaController::class, 'show'])->name('canvas.isptecmedia.show');
        Route::put('/canvas/isptecmedia/{isptecmedia}',[ISPTECMediaController::class, 'update'])->name('canvas.isptecmedia.update');
        Route::delete('/canvas/isptecmedia/{isptecmedia}',[ISPTECMediaController::class, 'destroy'])->name('canvas.isptecmedia.delete');
        Route::put('/canvas/isptecmedia/{isptecmedia}/restore',[ISPTECMediaController::class, 'restore'])->name('canvas.isptecmedia.restore');
        Route::get('/canvas/isptecmedia/{isptecmedia}/{lang}',[ISPTECMediaController::class, 'lang'])->name('canvas.isptecmedia.getlang');
        Route::put('/canvas/isptecmedia/{isptecmedia}/settranslation',[ISPTECMediaController::class, 'settranslation'])->name('canvas.isptecmedia.settranslation');
        Route::get('/canvas/isptecmedia/downloadsingleattachment',[ISPTECMediaController::class, 'downloadsingleattachment'])->name('canvas.isptecmedia.downloadsingleattachment');
        Route::get('/canvas/isptecmedia/deletesingleattachment',[ISPTECMediaController::class, 'deletesingleattachment'])->name('canvas.isptecmedia.deletesingleattachment');
        Route::get('/canvas/isptecmedia/downloadallattachments',[ISPTECMediaController::class, 'downloadallattachments'])->name('canvas.posts.downloadallattachments');

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

        Route::get('/canvas/mediacategories',[MediaCategoryController::class, 'index'])->name('canvas.mediacategories.index');
        Route::get('/canvas/mediacategories/create',[MediaCategoryController::class, 'create'])->name('canvas.mediacategories.create');
        Route::post('/canvas/mediacategories',[MediaCategoryController::class, 'store'])->name('canvas.mediacategories.store');
        Route::get('/canvas/mediacategories/{mediacategory}/edit',[MediaCategoryController::class, 'edit'])->name('canvas.mediacategories.edit');
        Route::get('/canvas/mediacategories/{mediacategory}/show',[MediaCategoryController::class, 'show'])->name('canvas.mediacategories.show');
        Route::put('/canvas/mediacategories/{mediacategory}',[MediaCategoryController::class, 'update'])->name('canvas.mediacategories.update');
        Route::delete('/canvas/mediacategories/{mediacategory}',[MediaCategoryController::class, 'destroy'])->name('canvas.mediacategories.delete');
        Route::put('/canvas/mediacategories/{mediacategory}/restore',[MediaCategoryController::class, 'restore'])->name('canvas.mediacategories.restore');
        Route::get('/canvas/mediacategories/{mediacategory}/{lang}',[MediaCategoryController::class, 'lang'])->name('canvas.mediacategories.getlang');
        Route::put('/canvas/mediacategories/{mediacategory}/settranslation',[MediaCategoryController::class, 'settranslation'])->name('canvas.mediacategories.settranslation');

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
        Route::get('/canvas/sliders/downloadsingleattachment',[SliderController::class, 'downloadsingleattachment'])->name('canvas.sliders.downloadsingleattachment');
        Route::get('/canvas/sliders/deletesingleattachment',[SliderController::class, 'deletesingleattachment'])->name('canvas.sliders.deletesingleattachment');

        Route::get('/canvas/subjects',[SubjectController::class, 'index'])->name('canvas.subjects.index');
        Route::get('/canvas/subjects/create',[SubjectController::class, 'create'])->name('canvas.subjects.create');
        Route::post('/canvas/subjects',[SubjectController::class, 'store'])->name('canvas.subjects.store');
        Route::get('/canvas/subjects/{subject}/edit',[SubjectController::class, 'edit'])->name('canvas.subjects.edit');
        Route::get('/canvas/subjects/{subject}/show',[SubjectController::class, 'show'])->name('canvas.subjects.show');
        Route::put('/canvas/subjects/{subject}',[SubjectController::class, 'update'])->name('canvas.subjects.update');
        Route::delete('/canvas/subjects/{subject}',[SubjectController::class, 'destroy'])->name('canvas.subjects.delete');
        Route::put('/canvas/subjects/{subject}/restore',[SubjectController::class, 'restore'])->name('canvas.subjects.restore');
        Route::get('/canvas/subjects/{subject}/{lang}',[SubjectController::class, 'lang'])->name('canvas.subjects.getlang');
        Route::put('/canvas/subjects/{subject}/settranslation',[SubjectController::class, 'settranslation'])->name('canvas.subjects.settranslation');

        Route::get('/canvas/services',[ServiceController::class, 'index'])->name('canvas.services.index');
        Route::get('/canvas/services/create',[ServiceController::class, 'create'])->name('canvas.services.create');
        Route::post('/canvas/services',[ServiceController::class, 'store'])->name('canvas.services.store');
        Route::get('/canvas/services/{service}/edit',[ServiceController::class, 'edit'])->name('canvas.services.edit');
        Route::get('/canvas/services/{service}/show',[ServiceController::class, 'show'])->name('canvas.services.show');
        Route::put('/canvas/services/{service}',[ServiceController::class, 'update'])->name('canvas.services.update');
        Route::delete('/canvas/services/{service}',[ServiceController::class, 'destroy'])->name('canvas.services.delete');
        Route::put('/canvas/services/{service}/restore',[ServiceController::class, 'restore'])->name('canvas.services.restore');
        Route::get('/canvas/services/{service}/{lang}',[ServiceController::class, 'lang'])->name('canvas.services.getlang');
        Route::put('/canvas/services/{service}/settranslation',[ServiceController::class, 'settranslation'])->name('canvas.services.settranslation');

        Route::get('/canvas/semesters',[SemesterController::class, 'index'])->name('canvas.semesters.index');
        Route::get('/canvas/semesters/create',[SemesterController::class, 'create'])->name('canvas.semesters.create');
        Route::post('/canvas/semesters',[SemesterController::class, 'store'])->name('canvas.semesters.store');
        Route::get('/canvas/semesters/{semester}/edit',[SemesterController::class, 'edit'])->name('canvas.semesters.edit');
        Route::get('/canvas/semesters/{semester}/show',[SemesterController::class, 'show'])->name('canvas.semesters.show');
        Route::put('/canvas/semesters/{semester}',[SemesterController::class, 'update'])->name('canvas.semesters.update');
        Route::delete('/canvas/semesters/{semester}',[SemesterController::class, 'destroy'])->name('canvas.semesters.delete');
        Route::put('/canvas/semesters/{semester}/restore',[SemesterController::class, 'restore'])->name('canvas.semesters.restore');
        Route::get('/canvas/semesters/{semester}/{lang}',[SemesterController::class, 'lang'])->name('canvas.semesters.getlang');
        Route::put('/canvas/semesters/{semester}/settranslation',[SemesterController::class, 'settranslation'])->name('canvas.semesters.settranslation');

        Route::get('/canvas/recruitmentpublications',[RecruitmentPublicationController::class, 'index'])->name('canvas.recruitmentpublications.index');
        Route::get('/canvas/recruitmentpublications/create',[RecruitmentPublicationController::class, 'create'])->name('canvas.recruitmentpublications.create');
        Route::post('/canvas/recruitmentpublications',[RecruitmentPublicationController::class, 'store'])->name('canvas.recruitmentpublications.store');
        Route::get('/canvas/recruitmentpublications/{recruitmentpublication}/edit',[RecruitmentPublicationController::class, 'edit'])->name('canvas.recruitmentpublications.edit');
        Route::get('/canvas/recruitmentpublications/{recruitmentpublication}/show',[RecruitmentPublicationController::class, 'show'])->name('canvas.recruitmentpublications.show');
        Route::put('/canvas/recruitmentpublications/{recruitmentpublication}',[RecruitmentPublicationController::class, 'update'])->name('canvas.recruitmentpublications.update');
        Route::delete('/canvas/recruitmentpublications/{recruitmentpublication}',[RecruitmentPublicationController::class, 'destroy'])->name('canvas.recruitmentpublications.delete');
        Route::put('/canvas/recruitmentpublications/{recruitmentpublication}/restore',[RecruitmentPublicationController::class, 'restore'])->name('canvas.recruitmentpublications.restore');
        Route::get('/canvas/recruitmentpublications/{recruitmentpublication}/{lang}',[RecruitmentPublicationController::class, 'lang'])->name('canvas.recruitmentpublications.getlang');
        Route::put('/canvas/recruitmentpublications/{recruitmentpublication}/settranslation',[RecruitmentPublicationController::class, 'settranslation'])->name('canvas.recruitmentpublications.settranslation');
        Route::get('/canvas/recruitmentpublications/downloadsingleattachment',[RecruitmentPublicationController::class, 'downloadsingleattachment'])->name('canvas.recruitmentpublications.downloadsingleattachment');
        Route::get('/canvas/recruitmentpublications/deletesingleattachment',[RecruitmentPublicationController::class, 'deletesingleattachment'])->name('canvas.recruitmentpublications.deletesingleattachment');
        Route::get('/canvas/recruitmentpublications/downloadallattachments',[RecruitmentPublicationController::class, 'downloadallattachments'])->name('canvas.recruitmentpublications.downloadallattachments');

        Route::get('/canvas/recruitmentsubmissions',[RecruitmentSubmissionController::class, 'index'])->name('canvas.recruitmentsubmissions.index');
        Route::get('/canvas/recruitmentsubmissions/create',[RecruitmentSubmissionController::class, 'create'])->name('canvas.recruitmentsubmissions.create');
        Route::post('/canvas/recruitmentsubmissions',[RecruitmentSubmissionController::class, 'store'])->name('canvas.recruitmentsubmissions.store');
        Route::get('/canvas/recruitmentsubmissions/{recruitmentsubmission}/edit',[RecruitmentSubmissionController::class, 'edit'])->name('canvas.recruitmentsubmissions.edit');
        Route::get('/canvas/recruitmentsubmissions/{recruitmentsubmission}/show',[RecruitmentSubmissionController::class, 'show'])->name('canvas.recruitmentsubmissions.show');
        Route::put('/canvas/recruitmentsubmissions/{recruitmentsubmission}',[RecruitmentSubmissionController::class, 'update'])->name('canvas.recruitmentsubmissions.update');
        Route::delete('/canvas/recruitmentsubmissions/{recruitmentsubmission}',[RecruitmentSubmissionController::class, 'destroy'])->name('canvas.recruitmentsubmissions.delete');
        Route::put('/canvas/recruitmentsubmissions/{recruitmentsubmission}/restore',[RecruitmentSubmissionController::class, 'restore'])->name('canvas.recruitmentsubmissions.restore');
        Route::get('/canvas/recruitmentsubmissions/{recruitmentsubmission}/{lang}',[RecruitmentSubmissionController::class, 'lang'])->name('canvas.recruitmentsubmissions.getlang');
        Route::put('/canvas/recruitmentsubmissions/{recruitmentsubmission}/settranslation',[RecruitmentSubmissionController::class, 'settranslation'])->name('canvas.recruitmentsubmissions.settranslation');
        Route::get('/canvas/recruitmentsubmissions/downloadsingleattachment',[RecruitmentSubmissionController::class, 'downloadsingleattachment'])->name('canvas.recruitmentsubmissions.downloadsingleattachment');
        Route::get('/canvas/recruitmentsubmissions/deletesingleattachment',[RecruitmentSubmissionController::class, 'deletesingleattachment'])->name('canvas.recruitmentsubmissions.deletesingleattachment');
        Route::get('/canvas/recruitmentsubmissions/downloadallattachments',[RecruitmentSubmissionController::class, 'downloadallattachments'])->name('canvas.recruitmentsubmissions.downloadallattachments');

        Route::get('/canvas/events',[EventController::class, 'index'])->name('canvas.events.index');
        Route::get('/canvas/events/create',[EventController::class, 'create'])->name('canvas.events.create');
        Route::post('/canvas/events',[EventController::class, 'store'])->name('canvas.events.store');
        Route::get('/canvas/events/{event}/edit',[EventController::class, 'edit'])->name('canvas.events.edit');
        Route::get('/canvas/events/{event}/show',[EventController::class, 'show'])->name('canvas.events.show');
        Route::put('/canvas/events/{event}',[EventController::class, 'update'])->name('canvas.events.update');
        Route::delete('/canvas/events/{event}',[EventController::class, 'destroy'])->name('canvas.events.delete');
        Route::put('/canvas/events/{event}/restore',[EventController::class, 'restore'])->name('canvas.events.restore');
        Route::get('/canvas/events/{event}/{lang}',[EventController::class, 'lang'])->name('canvas.events.getlang');
        Route::put('/canvas/events/{event}/settranslation',[EventController::class, 'settranslation'])->name('canvas.events.settranslation');
        Route::get('/canvas/events/downloadsingleattachment',[EventController::class, 'downloadsingleattachment'])->name('canvas.events.downloadsingleattachment');
        Route::get('/canvas/events/deletesingleattachment',[EventController::class, 'deletesingleattachment'])->name('canvas.events.deletesingleattachment');
        Route::get('/canvas/events/downloadallattachments',[EventController::class, 'downloadallattachments'])->name('canvas.events.downloadallattachments');

        Route::get('/canvas/employees',[EmployeeController::class, 'index'])->name('canvas.employees.index');
        Route::get('/canvas/employees/create',[EmployeeController::class, 'create'])->name('canvas.employees.create');
        Route::post('/canvas/employees',[EmployeeController::class, 'store'])->name('canvas.employees.store');
        Route::get('/canvas/employees/{employee}/edit',[EmployeeController::class, 'edit'])->name('canvas.employees.edit');
        Route::get('/canvas/employees/{employee}/show',[EmployeeController::class, 'show'])->name('canvas.employees.show');
        Route::put('/canvas/employees/{employee}',[EmployeeController::class, 'update'])->name('canvas.employees.update');
        Route::delete('/canvas/employees/{employee}',[EmployeeController::class, 'destroy'])->name('canvas.employees.delete');
        Route::put('/canvas/employees/{employee}/restore',[EmployeeController::class, 'restore'])->name('canvas.employees.restore');
        Route::get('/canvas/employees/{employee}/{lang}',[EmployeeController::class, 'lang'])->name('canvas.employees.getlang');
        Route::put('/canvas/employees/{employee}/settranslation',[EmployeeController::class, 'settranslation'])->name('canvas.employees.settranslation');
        Route::get('/canvas/employees/downloadsingleattachment',[EmployeeController::class, 'downloadsingleattachment'])->name('canvas.employees.downloadsingleattachment');
        Route::get('/canvas/employees/deletesingleattachment',[EmployeeController::class, 'deletesingleattachment'])->name('canvas.employees.deletesingleattachment');
        Route::get('/canvas/employees/downloadallattachments',[EmployeeController::class, 'downloadallattachments'])->name('canvas.employees.downloadallattachments');
        Route::post('/canvas/employees/togglenotification', [EmployeeController::class, 'togglenotification'])->name('employees.togglenotification');

        Route::get('/canvas/messages',[MessageController::class, 'index'])->name('canvas.messages.index');
        Route::get('/canvas/messages/create',[MessageController::class, 'create'])->name('canvas.messages.create');
        Route::post('/canvas/messages',[MessageController::class, 'store'])->name('canvas.messages.store');
        Route::get('/canvas/messages/{message}/edit',[MessageController::class, 'edit'])->name('canvas.messages.edit');
        Route::get('/canvas/messages/{message}/show',[MessageController::class, 'show'])->name('canvas.messages.show');
        Route::put('/canvas/messages/{message}',[MessageController::class, 'update'])->name('canvas.messages.update');
        Route::delete('/canvas/messages/{message}',[MessageController::class, 'destroy'])->name('canvas.messages.delete');
        Route::put('/canvas/messages/{message}/restore',[MessageController::class, 'restore'])->name('canvas.messages.restore');
        Route::get('/canvas/messages/{message}/{lang}',[MessageController::class, 'lang'])->name('canvas.messages.getlang');
        Route::put('/canvas/messages/{message}/settranslation',[MessageController::class, 'settranslation'])->name('canvas.messages.settranslation');

        Route::get('/canvas/journalcategories',[JournalCategoryController::class, 'index'])->name('canvas.journalcategories.index');
        Route::get('/canvas/journalcategories/create',[JournalCategoryController::class, 'create'])->name('canvas.journalcategories.create');
        Route::post('/canvas/journalcategories',[JournalCategoryController::class, 'store'])->name('canvas.journalcategories.store');
        Route::get('/canvas/journalcategories/{journalcategory}/edit',[JournalCategoryController::class, 'edit'])->name('canvas.journalcategories.edit');
        Route::get('/canvas/journalcategories/{journalcategory}/show',[JournalCategoryController::class, 'show'])->name('canvas.journalcategories.show');
        Route::put('/canvas/journalcategories/{journalcategory}',[JournalCategoryController::class, 'update'])->name('canvas.journalcategories.update');
        Route::delete('/canvas/journalcategories/{journalcategory}',[JournalCategoryController::class, 'destroy'])->name('canvas.journalcategories.delete');
        Route::put('/canvas/journalcategories/{journalcategory}/restore',[JournalCategoryController::class, 'restore'])->name('canvas.journalcategories.restore');
        Route::get('/canvas/journalcategories/{journalcategory}/{lang}',[JournalCategoryController::class, 'lang'])->name('canvas.journalcategories.getlang');
        Route::put('/canvas/journalcategories/{journalcategory}/settranslation',[JournalCategoryController::class, 'settranslation'])->name('canvas.journalcategories.settranslation');

        Route::get('/canvas/journalpublications',[JournalPublicationController::class, 'index'])->name('canvas.journalpublications.index');
        Route::get('/canvas/journalpublications/create',[JournalPublicationController::class, 'create'])->name('canvas.journalpublications.create');
        Route::post('/canvas/journalpublications',[JournalPublicationController::class, 'store'])->name('canvas.journalpublications.store');
        Route::get('/canvas/journalpublications/{journalpublication}/edit',[JournalPublicationController::class, 'edit'])->name('canvas.journalpublications.edit');
        Route::get('/canvas/journalpublications/{journalpublication}/show',[JournalPublicationController::class, 'show'])->name('canvas.journalpublications.show');
        Route::put('/canvas/journalpublications/{journalpublication}',[JournalPublicationController::class, 'update'])->name('canvas.journalpublications.update');
        Route::delete('/canvas/journalpublications/{journalpublication}',[JournalPublicationController::class, 'destroy'])->name('canvas.journalpublications.delete');
        Route::put('/canvas/journalpublications/{journalpublication}/restore',[JournalPublicationController::class, 'restore'])->name('canvas.journalpublications.restore');
        Route::get('/canvas/journalpublications/{journalpublication}/{lang}',[JournalPublicationController::class, 'lang'])->name('canvas.journalpublications.getlang');
        Route::put('/canvas/journalpublications/{journalpublication}/settranslation',[JournalPublicationController::class, 'settranslation'])->name('canvas.journalpublications.settranslation');
        Route::get('/canvas/journalpublications/downloadsingleattachment',[JournalPublicationController::class, 'downloadsingleattachment'])->name('canvas.journalpublications.downloadsingleattachment');
        Route::get('/canvas/journalpublications/deletesingleattachment',[JournalPublicationController::class, 'deletesingleattachment'])->name('canvas.journalpublications.deletesingleattachment');
        Route::get('/canvas/journalpublications/downloadallattachments',[JournalPublicationController::class, 'downloadallattachments'])->name('canvas.journalpublications.downloadallattachments');

        Route::get('/canvas/alumnis',[AlumniController::class, 'index'])->name('canvas.alumnis.index');
        Route::get('/canvas/alumnis/create',[AlumniController::class, 'create'])->name('canvas.alumnis.create');
        Route::post('/canvas/alumnis',[AlumniController::class, 'store'])->name('canvas.alumnis.store');
        Route::get('/canvas/alumnis/{alumni}/edit',[AlumniController::class, 'edit'])->name('canvas.alumnis.edit');
        Route::get('/canvas/alumnis/{alumni}/show',[AlumniController::class, 'show'])->name('canvas.alumnis.show');
        Route::put('/canvas/alumnis/{alumni}',[AlumniController::class, 'update'])->name('canvas.alumnis.update');
        Route::delete('/canvas/alumnis/{alumni}',[AlumniController::class, 'destroy'])->name('canvas.alumnis.delete');
        Route::put('/canvas/alumnis/{alumni}/restore',[AlumniController::class, 'restore'])->name('canvas.alumnis.restore');
        Route::get('/canvas/alumnis/{alumni}/{lang}',[AlumniController::class, 'lang'])->name('canvas.alumnis.getlang');
        Route::put('/canvas/alumnis/{alumni}/settranslation',[AlumniController::class, 'settranslation'])->name('canvas.alumnis.settranslation');
        Route::get('/canvas/alumnis/downloadsingleattachment',[AlumniController::class, 'downloadsingleattachment'])->name('canvas.alumnis.downloadsingleattachment');
        Route::get('/canvas/alumnis/deletesingleattachment',[AlumniController::class, 'deletesingleattachment'])->name('canvas.alumnis.deletesingleattachment');
        Route::get('/canvas/alumnis/downloadallattachments',[AlumniController::class, 'downloadallattachments'])->name('canvas.alumnis.downloadallattachments');

        Route::get('/canvas/courses',[CourseController::class, 'index'])->name('canvas.courses.index');
        Route::get('/canvas/courses/create',[CourseController::class, 'create'])->name('canvas.courses.create');
        Route::post('/canvas/courses',[CourseController::class, 'store'])->name('canvas.courses.store');
        Route::get('/canvas/courses/{course}/edit',[CourseController::class, 'edit'])->name('canvas.courses.edit');
        Route::get('/canvas/courses/{course}/show',[CourseController::class, 'show'])->name('canvas.courses.show');
        Route::put('/canvas/courses/{course}',[CourseController::class, 'update'])->name('canvas.courses.update');
        Route::delete('/canvas/courses/{course}',[CourseController::class, 'destroy'])->name('canvas.courses.delete');
        Route::put('/canvas/courses/{course}/restore',[CourseController::class, 'restore'])->name('canvas.courses.restore');
        Route::get('/canvas/courses/{course}/{lang}',[CourseController::class, 'lang'])->name('canvas.courses.getlang');
        Route::put('/canvas/courses/{course}/settranslation',[CourseController::class, 'settranslation'])->name('canvas.courses.settranslation');
        Route::get('/canvas/courses/downloadsingleattachment',[CourseController::class, 'downloadsingleattachment'])->name('canvas.courses.downloadsingleattachment');
        Route::get('/canvas/courses/deletesingleattachment',[CourseController::class, 'deletesingleattachment'])->name('canvas.courses.deletesingleattachment');
        Route::get('/canvas/courses/downloadallattachments',[CourseController::class, 'downloadallattachments'])->name('canvas.courses.downloadallattachments');

        Route::get('/canvas/settings',[SettingController::class, 'index'])->name('canvas.settings.index');
        Route::get('/canvas/settings/create',[SettingController::class, 'create'])->name('canvas.settings.create');
        Route::post('/canvas/settings',[SettingController::class, 'store'])->name('canvas.settings.store');
        Route::get('/canvas/settings/{setting}/edit',[SettingController::class, 'edit'])->name('canvas.settings.edit');
        Route::get('/canvas/settings/{setting}/show',[SettingController::class, 'show'])->name('canvas.settings.show');
        Route::put('/canvas/settings/{setting}',[SettingController::class, 'update'])->name('canvas.settings.update');
        Route::delete('/canvas/settings/{setting}',[SettingController::class, 'destroy'])->name('canvas.settings.delete');
        Route::put('/canvas/settings/{setting}/restore',[SettingController::class, 'restore'])->name('canvas.settings.restore');
        Route::get('/canvas/settings/{setting}/{lang}',[SettingController::class, 'lang'])->name('canvas.settings.getlang');
        Route::put('/canvas/settings/{setting}/settranslation',[SettingController::class, 'settranslation'])->name('canvas.settings.settranslation');
        Route::get('/canvas/settings/downloadsingleattachment',[SettingController::class, 'downloadsingleattachment'])->name('canvas.settings.downloadsingleattachment');
        Route::get('/canvas/settings/deletesingleattachment',[SettingController::class, 'deletesingleattachment'])->name('canvas.settings.deletesingleattachment');
        Route::get('/canvas/settings/downloadallattachments',[SettingController::class, 'downloadallattachments'])->name('canvas.settings.downloadallattachments');

        Route::get('/canvas/courseplans',[CoursePlanController::class, 'index'])->name('canvas.courseplans.index');
        Route::get('/canvas/courseplans/create',[CoursePlanController::class, 'create'])->name('canvas.courseplans.create');
        Route::post('/canvas/courseplans',[CoursePlanController::class, 'store'])->name('canvas.courseplans.store');
        Route::get('/canvas/courseplans/{courseplan}/edit',[CoursePlanController::class, 'edit'])->name('canvas.courseplans.edit');
        Route::get('/canvas/courseplans/{courseplan}/show',[CoursePlanController::class, 'show'])->name('canvas.courseplans.show');
        Route::put('/canvas/courseplans/{courseplan}',[CoursePlanController::class, 'update'])->name('canvas.courseplans.update');
        Route::delete('/canvas/courseplans/{courseplan}',[CoursePlanController::class, 'destroy'])->name('canvas.courseplans.delete');
        Route::put('/canvas/courseplans/{courseplan}/restore',[CoursePlanController::class, 'restore'])->name('canvas.courseplans.restore');
        Route::get('/canvas/courseplans/{courseplan}/{lang}',[CoursePlanController::class, 'lang'])->name('canvas.courseplans.getlang');
        Route::put('/canvas/courseplans/{courseplan}/settranslation',[CoursePlanController::class, 'settranslation'])->name('canvas.courseplans.settranslation');
        Route::get('/canvas/courseplans/downloadsingleattachment',[CoursePlanController::class, 'downloadsingleattachment'])->name('canvas.courseplans.downloadsingleattachment');
        Route::get('/canvas/courseplans/deletesingleattachment',[CoursePlanController::class, 'deletesingleattachment'])->name('canvas.courseplans.deletesingleattachment');
        Route::get('/canvas/courseplans/downloadallattachments',[CoursePlanController::class, 'downloadallattachments'])->name('canvas.courseplans.downloadallattachments');

        Route::get('/canvas/celcategories',[CelCategoryController::class, 'index'])->name('canvas.celcategories.index');
        Route::get('/canvas/celcategories/create',[CelCategoryController::class, 'create'])->name('canvas.celcategories.create');
        Route::post('/canvas/celcategories',[CelCategoryController::class, 'store'])->name('canvas.celcategories.store');
        Route::get('/canvas/celcategories/{celcategory}/edit',[CelCategoryController::class, 'edit'])->name('canvas.celcategories.edit');
        Route::get('/canvas/celcategories/{celcategory}/show',[CelCategoryController::class, 'show'])->name('canvas.celcategories.show');
        Route::put('/canvas/celcategories/{celcategory}',[CelCategoryController::class, 'update'])->name('canvas.celcategories.update');
        Route::delete('/canvas/celcategories/{celcategory}',[CelCategoryController::class, 'destroy'])->name('canvas.celcategories.delete');
        Route::put('/canvas/celcategories/{celcategory}/restore',[CelCategoryController::class, 'restore'])->name('canvas.celcategories.restore');
        Route::get('/canvas/celcategories/{celcategory}/{lang}',[CelCategoryController::class, 'lang'])->name('canvas.celcategories.getlang');
        Route::put('/canvas/celcategories/{celcategory}/settranslation',[CelCategoryController::class, 'settranslation'])->name('canvas.celcategories.settranslation');

        Route::get('/canvas/filecategories',[FileCategoryController::class, 'index'])->name('canvas.filecategories.index');
        Route::get('/canvas/filecategories/create',[FileCategoryController::class, 'create'])->name('canvas.filecategories.create');
        Route::post('/canvas/filecategories',[FileCategoryController::class, 'store'])->name('canvas.filecategories.store');
        Route::get('/canvas/filecategories/{filecategory}/edit',[FileCategoryController::class, 'edit'])->name('canvas.filecategories.edit');
        Route::get('/canvas/filecategories/{filecategory}/show',[FileCategoryController::class, 'show'])->name('canvas.filecategories.show');
        Route::put('/canvas/filecategories/{filecategory}',[FileCategoryController::class, 'update'])->name('canvas.filecategories.update');
        Route::delete('/canvas/filecategories/{filecategory}',[FileCategoryController::class, 'destroy'])->name('canvas.filecategories.delete');
        Route::put('/canvas/filecategories/{filecategory}/restore',[FileCategoryController::class, 'restore'])->name('canvas.filecategories.restore');
        Route::get('/canvas/filecategories/{filecategory}/{lang}',[FileCategoryController::class, 'lang'])->name('canvas.filecategories.getlang');
        Route::put('/canvas/filecategories/{filecategory}/settranslation',[FileCategoryController::class, 'settranslation'])->name('canvas.filecategories.settranslation');

        Route::get('/canvas/partnercategories',[PartnerCategoryController::class, 'index'])->name('canvas.partnercategories.index');
        Route::get('/canvas/partnercategories/create',[PartnerCategoryController::class, 'create'])->name('canvas.partnercategories.create');
        Route::post('/canvas/partnercategories',[PartnerCategoryController::class, 'store'])->name('canvas.partnercategories.store');
        Route::get('/canvas/partnercategories/{partnercategory}/edit',[PartnerCategoryController::class, 'edit'])->name('canvas.partnercategories.edit');
        Route::get('/canvas/partnercategories/{partnercategory}/show',[PartnerCategoryController::class, 'show'])->name('canvas.partnercategories.show');
        Route::put('/canvas/partnercategories/{partnercategory}',[PartnerCategoryController::class, 'update'])->name('canvas.partnercategories.update');
        Route::delete('/canvas/partnercategories/{partnercategory}',[PartnerCategoryController::class, 'destroy'])->name('canvas.partnercategories.delete');
        Route::put('/canvas/partnercategories/{partnercategory}/restore',[PartnerCategoryController::class, 'restore'])->name('canvas.partnercategories.restore');
        Route::get('/canvas/partnercategories/{partnercategory}/{lang}',[PartnerCategoryController::class, 'lang'])->name('canvas.partnercategories.getlang');
        Route::put('/canvas/partnercategories/{partnercategory}/settranslation',[PartnerCategoryController::class, 'settranslation'])->name('canvas.partnercategories.settranslation');

        Route::get('/canvas/newslettercategories',[NewsletterCategoryController::class, 'index'])->name('canvas.newslettercategories.index');
        Route::get('/canvas/newslettercategories/create',[NewsletterCategoryController::class, 'create'])->name('canvas.newslettercategories.create');
        Route::post('/canvas/newslettercategories',[NewsletterCategoryController::class, 'store'])->name('canvas.newslettercategories.store');
        Route::get('/canvas/newslettercategories/{newslettercategory}/edit',[NewsletterCategoryController::class, 'edit'])->name('canvas.newslettercategories.edit');
        Route::get('/canvas/newslettercategories/{newslettercategory}/show',[NewsletterCategoryController::class, 'show'])->name('canvas.newslettercategories.show');
        Route::put('/canvas/newslettercategories/{newslettercategory}',[NewsletterCategoryController::class, 'update'])->name('canvas.newslettercategories.update');
        Route::delete('/canvas/newslettercategories/{newslettercategory}',[NewsletterCategoryController::class, 'destroy'])->name('canvas.newslettercategories.delete');
        Route::put('/canvas/newslettercategories/{newslettercategory}/restore',[NewsletterCategoryController::class, 'restore'])->name('canvas.newslettercategories.restore');
        Route::get('/canvas/newslettercategories/{newslettercategory}/{lang}',[NewsletterCategoryController::class, 'lang'])->name('canvas.newslettercategories.getlang');
        Route::put('/canvas/newslettercategories/{newslettercategory}/settranslation',[NewsletterCategoryController::class, 'settranslation'])->name('canvas.newslettercategories.settranslation');

        Route::get('/canvas/partnerships',[PartnershipController::class, 'index'])->name('canvas.partnerships.index');
        Route::get('/canvas/partnerships/create',[PartnershipController::class, 'create'])->name('canvas.partnerships.create');
        Route::post('/canvas/partnerships',[PartnershipController::class, 'store'])->name('canvas.partnerships.store');
        Route::get('/canvas/partnerships/{partnership}/edit',[PartnershipController::class, 'edit'])->name('canvas.partnerships.edit');
        Route::get('/canvas/partnerships/{partnership}/show',[PartnershipController::class, 'show'])->name('canvas.partnerships.show');
        Route::put('/canvas/partnerships/{partnership}',[PartnershipController::class, 'update'])->name('canvas.partnerships.update');
        Route::delete('/canvas/partnerships/{partnership}',[PartnershipController::class, 'destroy'])->name('canvas.partnerships.delete');
        Route::put('/canvas/partnerships/{partnership}/restore',[PartnershipController::class, 'restore'])->name('canvas.partnerships.restore');
        Route::get('/canvas/partnerships/{partnership}/{lang}',[PartnershipController::class, 'lang'])->name('canvas.partnerships.getlang');
        Route::put('/canvas/partnerships/{partnership}/settranslation',[PartnershipController::class, 'settranslation'])->name('canvas.partnerships.settranslation');
        Route::get('/canvas/partnerships/downloadsingleattachment',[PartnershipController::class, 'downloadsingleattachment'])->name('canvas.partnerships.downloadsingleattachment');
        Route::get('/canvas/partnerships/deletesingleattachment',[PartnershipController::class, 'deletesingleattachment'])->name('canvas.partnerships.deletesingleattachment');
        Route::get('/canvas/partnerships/downloadallattachments',[PartnershipController::class, 'downloadallattachments'])->name('canvas.posts.downloadallattachments');

        Route::get('/canvas/newslettersubscriptions',[NewsletterSubscriptionController::class, 'index'])->name('canvas.newslettersubscriptions.index');
        Route::get('/canvas/newslettersubscriptions/create',[NewsletterSubscriptionController::class, 'create'])->name('canvas.newslettersubscriptions.create');
        Route::post('/canvas/newslettersubscriptions',[NewsletterSubscriptionController::class, 'store'])->name('canvas.newslettersubscriptions.store');
        Route::get('/canvas/newslettersubscriptions/{newslettersubscription}/edit',[NewsletterSubscriptionController::class, 'edit'])->name('canvas.newslettersubscriptions.edit');
        Route::get('/canvas/newslettersubscriptions/{newslettersubscription}/show',[NewsletterSubscriptionController::class, 'show'])->name('canvas.newslettersubscriptions.show');
        Route::put('/canvas/newslettersubscriptions/{newslettersubscription}',[NewsletterSubscriptionController::class, 'update'])->name('canvas.newslettersubscriptions.update');
        Route::delete('/canvas/newslettersubscriptions/{newslettersubscription}',[NewsletterSubscriptionController::class, 'destroy'])->name('canvas.newslettersubscriptions.delete');
        Route::put('/canvas/newslettersubscriptions/{newslettersubscription}/restore',[NewsletterSubscriptionController::class, 'restore'])->name('canvas.newslettersubscriptions.restore');
        Route::get('/canvas/newslettersubscriptions/{newslettersubscription}/{lang}',[NewsletterSubscriptionController::class, 'lang'])->name('canvas.newslettersubscriptions.getlang');
        Route::put('/canvas/newslettersubscriptions/{newslettersubscription}/settranslation',[NewsletterSubscriptionController::class, 'settranslation'])->name('canvas.newslettersubscriptions.settranslation');

        Route::get('/canvas/clubmemberships',[ClubMembershipController::class, 'index'])->name('canvas.clubmemberships.index');
        Route::get('/canvas/clubmemberships/create',[ClubMembershipController::class, 'create'])->name('canvas.clubmemberships.create');
        Route::post('/canvas/clubmemberships',[ClubMembershipController::class, 'store'])->name('canvas.clubmemberships.store');
        Route::get('/canvas/clubmemberships/{clubmembership}/edit',[ClubMembershipController::class, 'edit'])->name('canvas.clubmemberships.edit');
        Route::get('/canvas/clubmemberships/{clubmembership}/show',[ClubMembershipController::class, 'show'])->name('canvas.clubmemberships.show');
        Route::put('/canvas/clubmemberships/{clubmembership}',[ClubMembershipController::class, 'update'])->name('canvas.clubmemberships.update');
        Route::delete('/canvas/clubmemberships/{clubmembership}',[ClubMembershipController::class, 'destroy'])->name('canvas.clubmemberships.delete');
        Route::put('/canvas/clubmemberships/{clubmembership}/restore',[ClubMembershipController::class, 'restore'])->name('canvas.clubmemberships.restore');
        Route::get('/canvas/clubmemberships/{clubmembership}/{lang}',[ClubMembershipController::class, 'lang'])->name('canvas.clubmemberships.getlang');
        Route::put('/canvas/clubmemberships/{clubmembership}/settranslation',[ClubMembershipController::class, 'settranslation'])->name('canvas.clubmemberships.settranslation');

        Route::get('/canvas/clubsessions',[ClubSessionController::class, 'index'])->name('canvas.clubsessions.index');
        Route::get('/canvas/clubsessions/create',[ClubSessionController::class, 'create'])->name('canvas.clubsessions.create');
        Route::post('/canvas/clubsessions',[ClubSessionController::class, 'store'])->name('canvas.clubsessions.store');
        Route::get('/canvas/clubsessions/{clubsession}/edit',[ClubSessionController::class, 'edit'])->name('canvas.clubsessions.edit');
        Route::get('/canvas/clubsessions/{clubsession}/show',[ClubSessionController::class, 'show'])->name('canvas.clubsessions.show');
        Route::put('/canvas/clubsessions/{clubsession}',[ClubSessionController::class, 'update'])->name('canvas.clubsessions.update');
        Route::delete('/canvas/clubsessions/{clubsession}',[ClubSessionController::class, 'destroy'])->name('canvas.clubsessions.delete');
        Route::put('/canvas/clubsessions/{clubsession}/restore',[ClubSessionController::class, 'restore'])->name('canvas.clubsessions.restore');
        Route::get('/canvas/clubsessions/{clubsession}/{lang}',[ClubSessionController::class, 'lang'])->name('canvas.clubsessions.getlang');
        Route::put('/canvas/clubsessions/{clubsession}/settranslation',[ClubSessionController::class, 'settranslation'])->name('canvas.clubsessions.settranslation');

        Route::get('/canvas/files',[FileController::class, 'index'])->name('canvas.files.index');
        Route::get('/canvas/files/create',[FileController::class, 'create'])->name('canvas.files.create');
        Route::post('/canvas/files',[FileController::class, 'store'])->name('canvas.files.store');
        Route::get('/canvas/files/{file}/edit',[FileController::class, 'edit'])->name('canvas.files.edit');
        Route::get('/canvas/files/{file}/show',[FileController::class, 'show'])->name('canvas.files.show');
        Route::put('/canvas/files/{file}',[FileController::class, 'update'])->name('canvas.files.update');
        Route::delete('/canvas/files/{file}',[FileController::class, 'destroy'])->name('canvas.files.delete');
        Route::put('/canvas/files/{file}/restore',[FileController::class, 'restore'])->name('canvas.files.restore');
        Route::get('/canvas/files/{file}/{lang}',[FileController::class, 'lang'])->name('canvas.files.getlang');
        Route::put('/canvas/files/{file}/settranslation',[FileController::class, 'settranslation'])->name('canvas.files.settranslation');
        Route::get('/canvas/files/downloadsingleattachment',[FileController::class, 'downloadsingleattachment'])->name('canvas.files.downloadsingleattachment');
        Route::get('/canvas/files/deletesingleattachment',[FileController::class, 'deletesingleattachment'])->name('canvas.files.deletesingleattachment');

        Route::get('/canvas/shortcourses',[ShortCourseController::class, 'index'])->name('canvas.shortcourses.index');
        Route::get('/canvas/shortcourses/create',[ShortCourseController::class, 'create'])->name('canvas.shortcourses.create');
        Route::post('/canvas/shortcourses',[ShortCourseController::class, 'store'])->name('canvas.shortcourses.store');
        Route::get('/canvas/shortcourses/{shortcourse}/edit',[ShortCourseController::class, 'edit'])->name('canvas.shortcourses.edit');
        Route::get('/canvas/shortcourses/{shortcourse}/show',[ShortCourseController::class, 'show'])->name('canvas.shortcourses.show');
        Route::put('/canvas/shortcourses/{shortcourse}',[ShortCourseController::class, 'update'])->name('canvas.shortcourses.update');
        Route::delete('/canvas/shortcourses/{shortcourse}',[ShortCourseController::class, 'destroy'])->name('canvas.shortcourses.delete');
        Route::put('/canvas/shortcourses/{shortcourse}/restore',[ShortCourseController::class, 'restore'])->name('canvas.shortcourses.restore');
        Route::get('/canvas/shortcourses/{shortcourse}/{lang}',[ShortCourseController::class, 'lang'])->name('canvas.shortcourses.getlang');
        Route::put('/canvas/shortcourses/{shortcourse}/settranslation',[ShortCourseController::class, 'settranslation'])->name('canvas.shortcourses.settranslation');
        Route::get('/canvas/shortcourses/downloadsingleattachment',[ShortCourseController::class, 'downloadsingleattachment'])->name('canvas.shortcourses.downloadsingleattachment');
        Route::get('/canvas/shortcourses/deletesingleattachment',[ShortCourseController::class, 'deletesingleattachment'])->name('canvas.shortcourses.deletesingleattachment');

        Route::get('/canvas/shortcourseclasses',[ShortCourseClassController::class, 'index'])->name('canvas.shortcourseclasses.index');
        Route::get('/canvas/shortcourseclasses/create',[ShortCourseClassController::class, 'create'])->name('canvas.shortcourseclasses.create');
        Route::post('/canvas/shortcourseclasses',[ShortCourseClassController::class, 'store'])->name('canvas.shortcourseclasses.store');
        Route::get('/canvas/shortcourseclasses/{shortcourseclass}/edit',[ShortCourseClassController::class, 'edit'])->name('canvas.shortcourseclasses.edit');
        Route::get('/canvas/shortcourseclasses/{shortcourseclass}/show',[ShortCourseClassController::class, 'show'])->name('canvas.shortcourseclasses.show');
        Route::put('/canvas/shortcourseclasses/{shortcourseclass}',[ShortCourseClassController::class, 'update'])->name('canvas.shortcourseclasses.update');
        Route::delete('/canvas/shortcourseclasses/{shortcourseclass}',[ShortCourseClassController::class, 'destroy'])->name('canvas.shortcourseclasses.delete');
        Route::put('/canvas/shortcourseclasses/{shortcourseclass}/restore',[ShortCourseClassController::class, 'restore'])->name('canvas.shortcourseclasses.restore');
        Route::get('/canvas/shortcourseclasses/{shortcourseclass}/{lang}',[ShortCourseClassController::class, 'lang'])->name('canvas.shortcourseclasses.getlang');
        Route::put('/canvas/shortcourseclasses/{shortcourseclass}/settranslation',[ShortCourseClassController::class, 'settranslation'])->name('canvas.shortcourseclasses.settranslation');
        Route::get('/canvas/shortcourseclasses/downloadsingleattachment',[ShortCourseClassController::class, 'downloadsingleattachment'])->name('canvas.shortcourseclasses.downloadsingleattachment');
        Route::get('/canvas/shortcourseclasses/deletesingleattachment',[ShortCourseClassController::class, 'deletesingleattachment'])->name('canvas.shortcourseclasses.deletesingleattachment');

        Route::get('/canvas/shortcourseregistrations',[ShortCourseRegistrationController::class, 'index'])->name('canvas.shortcourseregistrations.index');
        Route::get('/canvas/shortcourseregistrations/create',[ShortCourseRegistrationController::class, 'create'])->name('canvas.shortcourseregistrations.create');
        Route::post('/canvas/shortcourseregistrations',[ShortCourseRegistrationController::class, 'store'])->name('canvas.shortcourseregistrations.store');
        Route::get('/canvas/shortcourseregistrations/{shortcourseregistration}/edit',[ShortCourseRegistrationController::class, 'edit'])->name('canvas.shortcourseregistrations.edit');
        Route::get('/canvas/shortcourseregistrations/{shortcourseregistration}/show',[ShortCourseRegistrationController::class, 'show'])->name('canvas.shortcourseregistrations.show');
        Route::put('/canvas/shortcourseregistrations/{shortcourseregistration}',[ShortCourseRegistrationController::class, 'update'])->name('canvas.shortcourseregistrations.update');
        Route::delete('/canvas/shortcourseregistrations/{shortcourseregistration}',[ShortCourseRegistrationController::class, 'destroy'])->name('canvas.shortcourseregistrations.delete');
        Route::put('/canvas/shortcourseregistrations/{shortcourseregistration}/restore',[ShortCourseRegistrationController::class, 'restore'])->name('canvas.shortcourseregistrations.restore');
        Route::get('/canvas/shortcourseregistrations/{shortcourseregistration}/{lang}',[ShortCourseRegistrationController::class, 'lang'])->name('canvas.shortcourseregistrations.getlang');
        Route::put('/canvas/shortcourseregistrations/{shortcourseregistration}/settranslation',[ShortCourseRegistrationController::class, 'settranslation'])->name('canvas.shortcourseregistrations.settranslation');
        Route::get('/canvas/shortcourseregistrations/downloadsingleattachment',[ShortCourseRegistrationController::class, 'downloadsingleattachment'])->name('canvas.shortcourseregistrations.downloadsingleattachment');
        Route::get('/canvas/shortcourseregistrations/deletesingleattachment',[ShortCourseRegistrationController::class, 'deletesingleattachment'])->name('canvas.shortcourseregistrations.deletesingleattachment');

    });

});

// Route::get('lang/{lang}', [LocalizationController::class, 'index']);
