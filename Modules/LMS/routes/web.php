<?php


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Modules\LMS\Http\Controllers\InstallerController;
use Modules\LMS\Http\Controllers\Auth\LoginController;
use Modules\LMS\Http\Controllers\Admin\ThemeController;
use Modules\LMS\Http\Controllers\LocalizationController;
use Modules\LMS\Http\Controllers\Auth\RegisterController;
use Modules\LMS\Http\Controllers\Frontend\BlogController;
use Modules\LMS\Http\Controllers\Frontend\CartController;
use Modules\LMS\Http\Controllers\Frontend\ExamController;
use Modules\LMS\Http\Controllers\Frontend\HomeController;
use Modules\LMS\Http\Controllers\Frontend\ForumController;
use Modules\LMS\Http\Controllers\Frontend\BundleController;
use Modules\LMS\Http\Controllers\Frontend\CourseController;
use Modules\LMS\Http\Controllers\Frontend\ContactController;
use Modules\LMS\Http\Controllers\Frontend\VideoStreamController;
use Modules\LMS\Http\Controllers\Frontend\PaymentController;
use Modules\LMS\Http\Controllers\Frontend\CheckoutController;
use Modules\LMS\Http\Controllers\Auth\ForgotPasswordController;
use Modules\LMS\Http\Controllers\Frontend\InstructorController;
use Modules\LMS\Http\Controllers\Frontend\OrganizationController;
use Modules\LMS\Http\Controllers\Admin\Courses\Quizzes\QuizController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/

/* ==================== */
/* Storage link (run via URL for hosting without terminal). Add ?token=your_secret to .env STORAGE_LINK_TOKEN */
Route::get('storage-link', function () {

    try {
        Artisan::call('storage:link');
        $output = Artisan::output();
        return response()->json([
            'success' => true,
            'message' => 'Storage link created successfully.',
            'output'  => trim($output),
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
})->name('storage.link');

/* ==================== */
/* Run AceAcademicsSeeder via URL (for hosting without terminal) */
/* Usage: yourdomain.com/run-seed?token=AceAcademics2024 */
Route::get('run-seed', function () {
    $token = request()->query('token');
    if ($token !== 'AceAcademics2024') {
        abort(403, 'Invalid token.');
    }
    try {
        Artisan::call('db:seed', [
            '--class' => 'Modules\\LMS\\Database\\Seeders\\AceAcademicsSeeder',
            '--force' => true,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'AceAcademicsSeeder ran successfully. Caches cleared.',
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ], 500);
    }
});

/* ==================== */
/* Git Pull via URL (for cPanel hosting without terminal) */
/* Usage: yourdomain.com/git-pull?token=AceAcademics2024 */
Route::get('git-pull', function () {
    $token = request()->query('token');
    if ($token !== 'AceAcademics2024') {
        abort(403, 'Invalid token.');
    }
    try {
        $output = [];
        $returnCode = 0;
        $basePath = base_path();

        // Git pull
        exec("cd {$basePath} && git pull 2>&1", $output, $returnCode);
        $pullOutput = implode("\n", $output);

        return response()->json([
            'success' => $returnCode === 0,
            'git_pull' => $pullOutput,
            'caches' => 'All caches cleared.',
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
});

/* ==================== */

Route::group(['middleware' => ['checkInstaller']], function () {
    // Home
    Route::group(['controller' => HomeController::class], function () {
        Route::get('/about-us',  'aboutUs')->name('about.us');
        Route::get('/workshop',  'workshop')->name('workshop.page');
        Route::get('/category-course/{slug}',  'categoryCourse')->name('category.course');
        Route::get('success',  'success')->name('success');
        Route::get('verify-mail/{id}/{hash}',  'verificationMail')->name('mail.verify');
        Route::post('subscribe',  'newsletterSubscribe')->name('newsletter.subscribe');
        Route::get('privacy-policy',  'policyContent')->name('privacy.policy');
        Route::get('terms-conditions',  'termsCondition')->name('terms.condition');
        Route::get('categories',  'categoryList')->name('category.list');
    });

    Route::get('blogs', [BlogController::class, 'blogs'])->name('blog.list');
    Route::get('blogs/{slug}', [BlogController::class, 'blogDetail'])->name('blog.detail');

    Route::get('instructors', [InstructorController::class, 'index'])->name('instructor.list');
    Route::get('users/{id}/profile', [HomeController::class, 'userDetail'])->name('users.detail');
    Route::get('courses', [CourseController::class, 'courseList'])->name('course.list');
    Route::get('courses/{slug}', [CourseController::class, 'courseDetail'])->name('course.detail');
    Route::get('bundles/{slug}', [BundleController::class, 'bundleDetail'])->name('bundle.detail');
    Route::get('bundles', [BundleController::class, 'bundleList'])->name('bundle.list');

    Route::get('forums', [ForumController::class, 'forumsList']);

    Route::group(['controller' => LoginController::class], function () {
        Route::get('login', 'showForm')->name('login');
        Route::post('login',  'login')->name('auth.login');
    });

    // Register
    Route::group(['controller' => RegisterController::class], function () {

        Route::get('register',  'registerForm')->name('register.page');
        Route::post('register',  'register')->name('auth.register');
    });

    //============== Forgot Password

    Route::group(['controller' => ForgotPasswordController::class], function () {
        Route::get('forgot-password', 'showForm')->name('password.request');
        Route::post('forgot-password', 'forgotPassword')->name('forgot.password');
        Route::get('reset-password/{token}', 'passwordReset')->name('password.reset');
        Route::post('reset-password', 'passwordUpdate')->name('password.update');
    });

    //========= Cart

    Route::group(['controller' => CartController::class], function () {
        Route::get('add-to-cart',  'addToCart')->name('add.to.cart');
        Route::get('remove-cart',  'removeCart')->name('remove.cart');
        Route::get('cart',  'cartCourseList')->name('cart.page');
        Route::get('apply-coupon', 'applyCoupon')->name('apply.coupon');
    });

    Route::group(['controller' => ContactController::class], function () {
        Route::get('contact', 'index')->name('contact.page');
        Route::post('contact', 'store')->name('contact.store');
    });

    Route::get('page/{url}', [HomeController::class, 'dynamicPage'])->name('page.show');
    Route::get('organizations', [OrganizationController::class, 'index'])->name('organization.list');
    Route::get('checkout', [CheckoutController::class, 'checkoutPage'])->name('checkout.page');
    Route::group(['middleware' => ['auth', 'device.limit']], function () {
        Route::post('forum-post', [ForumController::class, 'forumPost']);
        Route::post('blog/store', [BlogController::class, 'store'])->name('blog.comment');

        Route::group(['controller' => CheckoutController::class], function () {
            Route::post('checkout', 'checkout')->name('checkout');
            Route::get('success', 'transactionSuccess')->name('transaction.success');
            Route::get('payment-form', 'paymentFormRender')->name('payment.form');
            Route::post('enrolled',  'courseEnrolled')->name('course.enrolled');
            Route::post('subscription/payment', 'subscriptionPayment')->name('subscription.payment');
        });
        Route::group(['controller' => PaymentController::class], function () {
            Route::get('payment/success/{method}', 'success')->name('payment.success');
            Route::get('cancel', 'cancel')->name('payment.cancel');
        });

        Route::get('learn/course/{slug}', [CourseController::class, 'courseVideoPlayer'])->name('play.course');
        Route::get('learn/course-topic', [CourseController::class, 'leanCourseTopic'])->name('learn.course.topic');
        Route::get('stream/course-video/{topicId}', [VideoStreamController::class, 'stream'])->name('stream.course.video')->whereNumber('topicId');
        Route::post('course-review', [CourseController::class, 'review'])->name('review');
        Route::post('quiz/{id}/store', [QuizController::class, 'quizStoreResult'])->name('quiz.store.result');
        Route::post('user/submit-quiz-answer/{quiz_id}/{type}', [QuizController::class, 'submitQuizAnswer'])->name('user.submit.quiz.answer');
        Route::get('exam/{type}/{exam_type_id}/{course_id}', [ExamController::class, 'examStart'])->name('exam.start');
        Route::post('exam-store', [ExamController::class, 'store'])->name('exam.store');
        Route::get('add-wishlist', [HomeController::class, 'addWishlist'])->name('add.wishlist');
    });
    Route::get('language', [LocalizationController::class, 'setLanguage'])->name('language.set');
    Route::get('theme/activation/{slug}/{uuid}', [ThemeController::class, 'activationByUrl'])->name('theme.activation_by_uuid');
});

// install.
Route::controller(InstallerController::class)->group(
    function () {
        Route::get('install', 'installContent')->name('install');
        Route::get('install/requirements', 'requirement')->name('install.requirement');
        Route::get('install/permission', 'permission')->name('install.permission');
        Route::get('install/environment', 'environmentForm')->name('install.environment.form');
        Route::post('install/environment', 'environment')->name('install.environment');
        Route::get('install/database', 'databaseForm')->name('install.database.form');

        Route::post('install/database', 'database')->name('install.database');
        Route::get('install/import-demo', 'importDemo')->name('install.import-demo');
        Route::get('install/license', 'licenseForm')->name('license.form');
        Route::post('install/purchase-code', 'purchaseCode')->name('purchase.code');
        Route::get('install/demo', 'imported')->name('install.demo');
        Route::get('install/final', 'finish')->name('install.final');
        Route::get('license', 'licenseVerifyForm')->name('license.verify.form');
        Route::post('license', 'licenseVerify')->name('license.verify');
    }
);
