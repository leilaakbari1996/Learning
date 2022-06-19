<?php

use App\Models\CoursesCategory;
use App\Models\VideosTitle;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Panel\CourseController as CoursePanel;
use \App\Http\Controllers\Panel\CategoryCourseController as CategoryCoursePanel;
use \App\Http\Controllers\Panel\BannerController as BannerPanel;
use \App\Http\Controllers\Panel\CategoryBlogController as CategoryBlogPanel;
use \App\Http\Controllers\Panel\BlogController as BlogPanel;
use \App\Http\Controllers\Panel\TagController as TagPanel;
use \App\Http\Controllers\Panel\PodcastController as PodcastPanel;
use \App\Http\Controllers\Panel\GuidanceController as GuidancePanel;
use \App\Http\Controllers\Panel\CommentController as CommentPanel;
use \App\Http\Controllers\Panel\UserController as UsePanel;
use \App\Http\Controllers\Panel\CouponController as CouponPanel;
use \App\Http\Controllers\Panel\VideoTitleController as VideoTitlePanel;
use App\Http\Controllers\Panel\VideoController as VideoPanel;
use \App\Http\Controllers\Panel\SettingController as SettingPanel;
use \App\Http\Controllers\Panel\ContactController as ContactPanel;
use \App\Http\Controllers\Panel\HomeController as HomePanel;

use \App\Http\Controllers\Main\UserController as UserMain;
use \App\Http\Controllers\Main\HomeController as HomeMain;
use \App\Http\Controllers\Auth\RegisterController as RegisterMain;
use \App\Http\Controllers\Main\CartController as CartMain;
use \App\Http\Controllers\Main\OrderController as OrderMain;
use \App\Http\Controllers\Main\CourseController as CourseMain;
use \App\Http\Controllers\Main\CourseCategoryController as CourseCategoryMain;
use \App\Http\Controllers\Main\GuidanceController as GuidanceMain;
use \App\Http\Controllers\Main\BlogController as BlogMain;
use \App\Http\Controllers\Main\PodcastController as PodcastMain;
use \App\Http\Controllers\Main\ContactUsController as ContactMain;
use \App\Http\Controllers\Main\VideoTitleController as VideoTitleMain;
use \App\Http\Controllers\Main\BlogCategoryController as BlogCategoryMain;
use \App\Http\Controllers\Main\BannerController as BannerMain;

use \App\Http\Controllers\Api\UserController as UserApi;
use \App\Http\Controllers\Api\CouponController as CouponApi;
use \App\Http\Controllers\Api\OrderController as OrderApi;
use \App\Http\Controllers\Api\CartController as CartApi;
use \App\Http\Controllers\Api\ContactUsController as ContactApi;

use \App\Http\Controllers\Auth\LoginController as LoginAuth;

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


Route::prefix('')->name('client.')->group(function () {

    Route::resource('banner',BannerMain::class);

    Route::get('/', [HomeMain::class, 'index']);

    Route::prefix('/api')->name('api.')->group(function (){
        Route::put('/user/{user}',[UserApi::class,'update']);
        Route::delete('/user/{user}',[UserApi::class,'destroy']);

        Route::post('/coupon', [CouponApi::class, 'coupon']);

        Route::put('/order', [OrderApi::class, 'store']);
        Route::delete('/', [OrderApi::class, 'destroy']);

        Route::post('/cart', [CartApi::class, 'store']);
        Route::put('/cart', [CartApi::class, 'update']);
        Route::delete('/cart', [CartApi::class, 'destroy']);
        Route::delete('/cart/all', [CartApi::class, 'destroyAll']);

        Route::post('/contact', [ContactApi::class, 'store']);

    });

    Route::resource('user',UserMain::class);

    Route::middleware('notAuth')->group(function () {
        Route::get('/login', [LoginAuth::class, 'index'])->name('login');
        Route::post('/login', [LoginAuth::class, 'store']);

        Route::prefix('/register')->name('register.')->group(function () {
            Route::get('/', [RegisterMain::class, 'index'])->name('index');
            Route::post('/', [RegisterMain::class, 'store']);
        });
    });

    Route::middleware('auth')->group(function () {

        Route::delete('/logout', [LoginAuth::class, 'destroy']);

        Route::prefix('cart')->name('cart.')->group(function () {
            Route::get('/', [CartMain::class, 'index'])->name('index');
        });

        Route::prefix('/order')->middleware('isEmptyCart')->name('order.')->group(function () {
            Route::get('/', [OrderMain::class, 'index'])->name('index');
        });


    });

    Route::get('/course/offline', [CourseMain::class, 'offline'])->name('course.offline');

    Route::prefix('/course')->name('course')->group(function () {
        Route::get('/{slug}', [CourseMain::class, 'show'])->name('.show');
    });

    Route::prefix('/categoey')->name('category')->group(function () {
        Route::get('/', [CourseCategoryMain::class, 'index'])->name('.index');
        Route::get('/{slug?}', [CourseCategoryMain::class, 'show'])->name('.show');
    });

    Route::prefix('/blogCategory')->name('blogCategory')->group(function () {
        Route::get('/', [BlogCategoryMain::class, 'index'])->name('.index');
        Route::get('/{slug?}', [BlogCategoryMain::class, 'show'])->name('.show');
    });

    Route::prefix('/guidance')->name('guidance')->group(function () {
        Route::get('/', [GuidanceMain::class, 'index'])->name('.index');
        Route::get('/{slug?}', [GuidanceMain::class, 'show'])->name('.show');
    });

    Route::prefix('/blog')->name('blog')->group(function () {
        Route::get('/', [BlogMain::class, 'index'])->name('.index');
        Route::get('/{slug?}', [BlogMain::class, 'show'])->name('.show');
    });

    Route::get('/video/{slug?}', [\App\Http\Controllers\Main\VideoController::class, 'index']);

    Route::get('/category/{slug?}', [\App\Http\Controllers\Main\CourseCategoryController::class, 'index']);

    Route::prefix('/podcast')->name('podcast')->group(function () {
        Route::get('/', [PodcastMain::class, 'index'])->name('.index');
        Route::get('//{slug?}', [PodcastMain::class, 'show'])->name('.show');
    });

//Route::get('/videoTitle/{slug?}',[\App\Http\Controllers\Main\VideoTitleController::class,'index']);
    Route::get('/course/{course}/videoTitle/{slug?}', [VideoTitleMain::class, 'index']);

    Route::get('/contact', [ContactMain::class, 'index'])->name('contact');

    Route::get('/master', [UserMain::class, 'index']);




});

Route::prefix('/panel')->middleware('isAdmin')->name("panel.")->group(function (){
    Route::get('/',[HomePanel::class,'index'])->name("index");

    Route::resource('course',CoursePanel::class);
    Route::prefix('/course')->name('course.')->group(function (){
        Route::get('/{course}/related',[CoursePanel::class,'related'])->name('related');
        Route::delete('/{course}/related',[CoursePanel::class,'deleteRelated'])->name('relatedDelete');
        Route::get('/{course}/categories',[CoursePanel::class,'categories'])->name('categories');
        Route::delete('/{course}/category',[CoursePanel::class,'categoryDelete'])->name('categoryDelete');
        Route::get('/{course}/images',[CoursePanel::class,'images'])->name('image');
        Route::delete('/{course}/images',[CoursePanel::class,'imagesDelete'])->name('imageDelete');
        Route::get('/{course}/videos',[CoursePanel::class,'videos'])->name('video');
        Route::delete('/{course}/videos',[CoursePanel::class,'videosDelete'])->name('videoDelete');

        Route::prefix('/{course}/')->group(function (){
            Route::resource('videosTitle',VideoTitlePanel::class);
            /*Route::get('/',[VideoTitlePanel::class,'index']);
            Route::get('/{videosTitle}',[VideoTitlePanel::class,'show']);
            Route::put('/{videosTitle}',[VideoTitlePanel::class,'update']);*/
        });


        //Route::get('{course}/videoTitle/{videoTitle}',[VideoTitlePanel::class,'show']);

        Route::prefix('/{course}/videoTitle/{videosTitle}/')->group(function (){
            Route::resource('video',VideoPanel::class);
        });

    });

    Route::resource('coursesCategory',CategoryCoursePanel::class);

    Route::resource('banner',BannerPanel::class);

    Route::resource('blogCategory',CategoryBlogPanel::class);

    Route::prefix('/categoryBlog')->name('blogCategory')->group(function (){
        Route::get('/{blogCategory}/blogs',[CategoryBlogPanel::class,'blogs'])->name('.blogs');
        Route::delete('/blog',[CategoryBlogPanel::class,'blogDestroy'])->name('.blogDestroy');
    });

    Route::resource('blog',BlogPanel::class);
    Route::prefix('/blog')->name('blog')->group(function (){
        Route::get('/{blog}/categories',[BlogPanel::class,'categories'])->name('.categories');
        Route::delete('/{blog}/category',[BlogPanel::class,'categoryDelete'])->name('.categoryDelete');
        Route::get('{blog}/related',[BlogPanel::class,'related'])->name('.related');
        Route::delete('{blog}/related',[BlogPanel::class,'deleteRelated'])->name('.deleteRelated');
    });

    Route::resource('tag',TagPanel::class);

    Route::resource('podcast',PodcastPanel::class);
    Route::prefix('/podcast')->name('podcast')->group(function (){
        Route::get('/{podcast}/related',[PodcastPanel::class,'related'])->name('.related');
        Route::delete('/{podcast}/related',[PodcastPanel::class,'deleteRelated'])->name('deleteRelated');
    });

    Route::resource('guidance',GuidancePanel::class);
    Route::prefix('/guidance')->name('guidance')->group(function (){
        Route::get('/{guidance}/courses',[GuidancePanel::class,'courses'])->name('.courses');
        Route::delete('{guidance}/course',[GuidancePanel::class,'coursesDelete'])->name('.courseDelete');
        Route::get('/{guidance}/related',[GuidancePanel::class,'related'])->name('.related');
        Route::delete('/{guidance}/related',[GuidancePanel::class,'deleteRelated'])->name('deleteRelated');
    });


    Route::get('/comment/filter/{filter}',[CommentPanel::class,'filter'])->name('comment.filter');
    Route::resource('comment',CommentPanel::class);

    Route::resource('user',UsePanel::class);
    Route::put('/user/admin/{user}',[UsePanel::class,'admin']);
    Route::put('/user/master/{user}',[UsePanel::class,'master']);

    Route::get('/admin',[UsePanel::class,'adminIndex'])->name('admin.index');
    Route::delete('/admin/{user}',[UsePanel::class,'adminDelete']);

    Route::get('/master',[UsePanel::class,'masterIndex'])->name('master.index');
    Route::delete('/master/{user}',[UsePanel::class,'masterDelete']);

    Route::resource('coupon',CouponPanel::class);

    Route::prefix('/setting')->name('setting')->group(function (){

        Route::get('/',[SettingPanel::class,'index'])->name('.index');
        Route::get('/edit',[SettingPanel::class,'edit'])->name('.edit');
        Route::put('/',[SettingPanel::class,'update']);
        Route::delete('/',[SettingPanel::class,'destroy']);
        Route::delete('/delete',[SettingPanel::class,'destroySetting']);
    });

    Route::resource('contact',ContactPanel::class);
    Route::prefix('/contact')->name('contact')->group(function (){
        Route::get('/filter/{filter}',[ContactPanel::class,'filter'])->name('.filter');
    });



});
