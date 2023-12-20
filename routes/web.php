<?php

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

\URL::forceScheme('http');

Route::get('/sendremindermail', 'HomeController@sendremindermail')->name('sendremindermail');
Route::get('/sendhourmail', 'HomeController@sendhourmail')->name('sendhourmail');
Route::get('/', 'HomeController@index')->name('home');
Auth::routes(['verify' => true]);
Route::get('logout', 'Auth\LoginController@logout')->name('logOut');

Route::get('/login/{social}','Auth\LoginController@socialLogin')->where('social','twitter|facebook|linkedin|google|github|bitbucket');

Route::get('/login/{social}/callback','Auth\LoginController@handleProviderCallback')->where('social','twitter|facebook|linkedin|google|github|bitbucket');

Route::get('/locale/{locale}', 'HomeController@locale')->name('locale');

Route::get('about', 'HomeController@pageAbout')->name('page.about');
Route::get('contact', 'HomeController@pageContact')->name('page.contact');
Route::get('instructor/{instructor_slug}', 'InstructorController@instructorView')->name('instructor.view');

Route::get('getCheckTime', 'HomeController@getCheckTime');

Route::get('checkUserEmailExists', 'HomeController@checkUserEmailExists');

Route::get('checkUserEmailExists', 'HomeController@checkUserEmailExists');

Route::get('course-view/{course_slug}', 'CourseController@courseView')->name('course.view');
Route::get('courses', 'CourseController@courseList')->name('course.list');
Route::get('checkout/{course_slug}/{p_id}/{instructor_id}/{time}', 'CourseController@checkout')->name('course.checkout');
Route::get('course-breadcrumb', 'CourseController@saveBreadcrumb')->name('course.breadcurmb');

Route::post('become-instructor', 'InstructorController@becomeInstructor')->name('become.instructor');

Route::get('teachers', 'InstructorController@instructorList')->name('instructor.list');
Route::post('contact-instructor', 'InstructorController@contactInstructor')->name('contact.instructor');

Route::post('contact-admin', 'HomeController@contactAdmin')->name('contact.admin');

Route::get('blogs', 'HomeController@blogList')->name('blogs');
Route::get('blog/{blog_slug}', 'HomeController@blogView')->name('blog.view');

Route::get('register-teacher', 'HomeController@registerTeacher')->name('register.teacher');

Route::get('clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});


Route::get('schedule-run', function() {
    Artisan::call('schedule:run');
    return "schedule run";
});


Route::get('/terms-conditions', function () {
    return view('site.terms');
});
Route::get('/ourplatform', function () {
    return view('site.ourplatform');
});
Route::get('/ourmethod', function () {
    return view('site.ourmethod');
});
Route::get('/ourteachers', function () {
    return view('site.ourteacher');
});
Route::get('/ourcertificates', function () {
    return view('site.ourcertificates');
});
Route::get('/schoolchildrenandstudent', function () {
    return view('site.schoolchildren');
});
Route::get('/privatecitizen', function () {
    return view('site.privatecitizen');
});
Route::get('/forcompanies', function () {
    return view('site.forcompanies');
});
Route::get('/prices', function () {
    return view('site.prices');
});
Route::get('/english', function () {
    return view('site.english');
});
Route::get('/spanish', function () {
    return view('site.spanish');
});
Route::get('/german', function () {
    return view('site.dutch');
});
Route::get('/italian', function () {
    return view('site.italian');
});

Route::get('/imprint', function () {
    return view('site.imprint');
});
Route::get('/agreement', function () {
    return view('site.agreement');
});
Route::get('/condition', function () {
    return view('site.condition');
});

Route::post('saveloginsession', 'HomeController@saveLoginSessionData')->name('saveloginsession');
Route::get('verify/{email}', 'HomeController@verify')->name('verify');

Route::post('email/resend','Auth\VerificationController@resend')->name('verification.resend');

//Functions accessed by only authenticated users
Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('/messages', 'MessageController@index')->name('message.home');

    //credits//
    Route::get('/credits', 'CreditController@index')->name('credits.home');
    Route::get('/credits/create', 'CreditController@view')->name('credits.view');
    Route::post('/credits/add', 'CreditController@create')->name('admin.credits.create');
    Route::get('/credits/edit/{id}', 'CreditController@edit')->name('admin.credits.edit');
    Route::post('/credits/update/{id}', 'CreditController@update')->name('admin.credits.update');
    Route::get('/credits/delete/{id}', 'CreditController@delete')->name('admin.credits.delete');
    
    
    Route::get('/message/{id}', 'MessageController@getMessage')->name('message.message');
    Route::post('message', 'MessageController@sendMessage');

    Route::post('applycoupon', 'HomeController@applycoupon')->name('applycoupon');

    Route::any('choose-plan/{course_id}/{instructor_id}/{type}', 'HomeController@subscriptionplans')->name('choose.plan');
    Route::get('choose-package/{course_id}/{p_id}', 'HomeController@coursePackage')->name('choose.package');
    Route::get('subscribe/{id}/{course_id}/{instructor_id}/{time}', 'HomeController@subscribe')->name('subscribe');
    Route::get('processpayment/{id}', 'HomeController@processpayment')->name('processpayment');
    Route::get('cancelpayment/{id}', 'HomeController@cancelpayment')->name('cancelpayment');
    Route::any('joinmeeting/{api_id?}/{name?}', 'HomeController@joinmeeting')->name('joinmeeting');
    Route::post('meetdata', 'HomeController@meetdata')->name('meetdata');
    Route::get('checkmeeting', 'HomeController@checkmeeting')->name('checkmeeting');
    Route::get('checkunread', 'HomeController@unreadMessages')->name('checkunread');

    Route::post('delete-photo', 'CourseController@deletePhoto');
    Route::post('payment-form', 'PaymentController@paymentForm')->name('payment.form');

    Route::get('payment/success', 'PaymentController@getSuccess')->name('payment.success');
    Route::get('payment/failure', 'PaymentController@getFailure')->name('payment.failure');

    Route::get('users/profile', 'HomeController@profile')->name('users.profile');

    Route::get('canceltransaction/{t_id}/{id}', 'CourseController@canceltransaction')->name('canceltransaction');

    //Functions accessed by only students
    Route::group(['middleware' => 'role:student'], function () {
        Route::get('my-appointments', 'CourseController@myAppointments')->name('my.appointments');
        Route::get('listing', 'CourseController@myListing')->name('listing');
        Route::post('addappointment', 'CourseController@addAppointment')->name('add.appointment');
        Route::post('adminaddappointment', 'CourseController@adminaddAppointment')->name('admin.add.appointment');
        Route::get('cancelappointment/{id}', 'CourseController@cancelAppointment')->name('cancel.appointment');
        Route::get('mytransactions', 'CourseController@mytransactions')->name('mytransactions');
        ////credits
        Route::get('mycredits', 'CourseController@mycredits')->name('mycredits');
        Route::get('cancelcredits/{id}', 'CourseController@cancelcredits')->name('cancelcredits');

        Route::get('course-enroll-api/{course_slug}/{lecture_slug}/{is_sidebar}', 'CourseController@courseEnrollAPI');
        Route::get('readPDF/{file_id}', 'CourseController@readPDF');
        Route::get('update-lecture-status/{course_id}/{lecture_id}/{status}', 'CourseController@updateLectureStatus');

        Route::get('download-resource/{resource_id}/{course_slug}', 'CourseController@getDownloadResource');

        Route::get('my-courses', 'CourseController@myCourses')->name('my.courses');
        Route::get('course-learn/{course_slug}', 'CourseController@courseLearn')->name('course.learn');

        Route::post('course-rate', 'CourseController@courseRate')->name('course.rate');
        Route::get('delete-rating/{raing_id}', 'CourseController@deleteRating')->name('delete.rating');

        Route::get('course-enroll-api/{course_slug}/{lecture_slug}/{is_sidebar}', 'CourseController@courseEnrollAPI');
        Route::get('readPDF/{file_id}', 'CourseController@readPDF');

    });

    //Functions accessed by both student and instructor
    // Route::group(['middleware' => 'role:student,instructor'], function () {
    Route::group(['middleware' => 'role:instructor'], function () {
        Route::get('instructor-dashboard', 'InstructorController@dashboard')->name('instructor.dashboard');
        Route::get('instructor-schedule', 'InstructorController@schedule')->name('instructor.schedule');
        Route::post('addschedule', 'InstructorController@addschedule')->name('instructor.addschedule');

        Route::get('instructor-profile', 'InstructorController@getProfile')->name('instructor.profile.get');
        Route::post('instructor-profile', 'InstructorController@saveProfile')->name('instructor.profile.save');
		
		Route::get('instructor-edu/{instructor_id}', 'InstructorController@getEdu')->name('instructor.edu.get.edit');
		Route::post('instructor-edu', 'InstructorController@saveedu')->name('instructor.edu.save');
		
		Route::get('instructor-job/{instructor_id}', 'InstructorController@getJob')->name('instructor.job.get.edit');
		Route::post('instructor-job', 'InstructorController@saveJob')->name('instructor.job.save');
		
        Route::get('course-create', 'CourseController@createInfo')->name('instructor.course.create');
        Route::get('instructor-course-list', 'CourseController@instructorCourseList')->name('instructor.course.list');
        Route::get('instructor-course-info', 'CourseController@instructorCourseInfo')->name('instructor.course.info');
        Route::get('instructor-course-info/{course_id}', 'CourseController@instructorCourseInfo')->name('instructor.course.info.edit');
        Route::post('instructor-course-info-save', 'CourseController@instructorCourseInfoSave')->name('instructor.course.info.save');

        Route::get('instructor-course-image', 'CourseController@instructorCourseImage')->name('instructor.course.image');
        Route::get('instructor-course-image/{course_id}', 'CourseController@instructorCourseImage')->name('instructor.course.image.edit');
        Route::post('instructor-course-image-save', 'CourseController@instructorCourseImageSave')->name('instructor.course.image.save');

        Route::get('instructor-course-video/{course_id}', 'CourseController@instructorCourseVideo')->name('instructor.course.video.edit');
        Route::post('instructor-course-video-save', 'CourseController@instructorCourseVideoSave')->name('instructor.course.video.save');

        Route::get('instructor-course-curriculum/{course_id}', 'CourseController@instructorCourseCurriculum')->name('instructor.course.curriculum.edit');
        Route::post('instructor-course-curriculum-save', 'CourseController@instructorCourseCurriculumSave')->name('instructor.course.curriculum.save');


        Route::get('instructor-transactions', 'InstructorController@transactions')->name('instructor.transactions');

        Route::get('instructor-credits', 'InstructorController@credits')->name('instructor.credits');

        Route::post('instructor-withdraw-request', 'InstructorController@withdrawRequest')->name('instructor.withdraw.request');

        Route::get('instructor-withdraw-requests', 'InstructorController@listWithdrawRequests')->name('instructor.list.withdraw');
		
		// Save InstructorJOb
		Route::post('instructor/job/save', 'InstructorController@postInstructorJobSave');
        Route::post('instructor/job/delete', 'InstructorController@postInstructorJObDelete');
		
		// Save InstructorWork
		Route::post('instructor/edu/save', 'InstructorController@postInstructorEduSave');
		Route::post('instructor/edudoc/save/{lid}', 'InstructorController@postInstructorEduDocSave');
        Route::post('instructor/edu/delete', 'InstructorController@postInstructorEduDelete');
		
        // Save Curriculum
        Route::post('courses/section/save', 'CourseController@postSectionSave');
        Route::post('courses/section/delete', 'CourseController@postSectionDelete');
        Route::post('courses/lecture/save', 'CourseController@postLectureSave');
        Route::post('courses/video', 'CourseController@postVideo');
        
        Route::post('courses/lecturequiz/delete', 'CourseController@postLectureQuizDelete');
        Route::post('courses/lecturedesc/save', 'CourseController@postLectureDescSave');
        Route::post('courses/lecturepublish/save', 'CourseController@postLecturePublishSave');
        Route::post('courses/lecturevideo/save/{lid}', 'CourseController@postLectureVideoSave');
        Route::post('courses/lectureaudio/save/{lid}', 'CourseController@postLectureAudioSave');
        Route::post('courses/lecturepre/save/{lid}', 'CourseController@postLecturePresentationSave');
        Route::post('courses/lecturedoc/save/{lid}', 'CourseController@postLectureDocumentSave');
        Route::post('courses/lectureres/save/{lid}', 'CourseController@postLectureResourceSave');
        Route::post('courses/lecturetext/save', 'CourseController@postLectureTextSave');
        Route::post('courses/lectureres/delete', 'CourseController@postLectureResourceDelete');
        Route::post('courses/lecturelib/save', 'CourseController@postLectureLibrarySave');
        Route::post('courses/lecturelibres/save', 'CourseController@postLectureLibraryResourceSave');
        Route::post('courses/lectureexres/save', 'CourseController@postLectureExternalResourceSave');
        
        // Sorting Curriculum
        Route::post('courses/curriculum/sort', 'CourseController@postCurriculumSort');
        //Appointments
        Route::get('appointments','AppointmentController@index')->name('appointments');
        Route::get('appointment/listing','AppointmentController@listings')->name('appointment.listings');
        Route::get('appointment/create','AppointmentController@create')->name('appointment.create');
        Route::get('appointment/edit/{appointment_id}','AppointmentController@edit')->name('appointment.edit');
        Route::post('appointment/getcourse','AppointmentController@getcourse');
        Route::post('appointment/getlecture','AppointmentController@getlecture');
        Route::post('appointment/update','AppointmentController@update')->name('appointment.update');
        Route::get('appointment/delete/{id}','AppointmentController@destroy')->name('appointment.destroy');
        
    });

    
    //Functions accessed by only admin users
    Route::group(['middleware' => 'role:admin'], function () {
        Route::get('admin/dashboard', 'Admin\DashboardController')->name('admin.dashboard');
        
        Route::get('admin/users', 'Admin\UserController@index')->name('admin.users');
        Route::get('admin/user-form', 'Admin\UserController@getForm')->name('admin.getForm');
        Route::get('admin/user-form/{user_id}', 'Admin\UserController@getForm');
        Route::post('admin/save-user', 'Admin\UserController@saveUser')->name('admin.saveUser');
        Route::get('admin/users/getData', 'Admin\UserController@getData')->name('admin.users.getData');
        Route::get('admin/users/export', 'Admin\UserController@exportData')->name('admin.exportData');

        Route::get('admin/member_subscriptions', 'Admin\UserController@subscriptions')->name('admin.member.subscriptions');
        Route::get('admin/cancel/{t_id}/{id}/{type}', 'CourseController@canceltransaction')->name('admin.member.cancel');

        Route::get('admin/categories', 'Admin\CategoryController@index')->name('admin.categories');
        Route::get('admin/category-form', 'Admin\CategoryController@getForm')->name('admin.categoryForm');
        Route::get('admin/category-form/{Category_id}', 'Admin\CategoryController@getForm');
        Route::post('admin/save-category', 'Admin\CategoryController@saveCategory')->name('admin.saveCategory');
        Route::get('admin/delete-category/{Category_id}', 'Admin\CategoryController@deleteCategory');

		Route::get('admin/languages', 'Admin\LanguageController@index')->name('admin.languages');
        Route::get('admin/language-form', 'Admin\LanguageController@getForm')->name('admin.LanguageForm');
        Route::get('admin/language-form/{language_id}', 'Admin\LanguageController@getForm');
        Route::post('admin/save-language', 'Admin\LanguageController@saveLanguage')->name('admin.saveLanguage');
        Route::get('admin/delete-language/{language_id}', 'Admin\LanguageController@deleteLanguage');

        Route::get('admin/blogs', 'Admin\BlogController@index')->name('admin.blogs');
        Route::get('admin/blog-form', 'Admin\BlogController@getForm')->name('admin.blogForm');
        Route::get('admin/blog-form/{blog_id}', 'Admin\BlogController@getForm');
        Route::post('admin/save-blog', 'Admin\BlogController@saveBlog')->name('admin.saveBlog');
        Route::get('admin/delete-blog/{blog_id}', 'Admin\BlogController@deleteBlog');

        Route::get('admin/withdraw-requests', 'Admin\DashboardController@withdrawRequests')->name('admin.withdraw.requests');
        Route::get('admin/approve-withdraw-request/{request_id}', 'Admin\DashboardController@approveWithdrawRequest')->name('admin.approve.withdraw.request');

        Route::post('admin/config/save-config', 'Admin\ConfigController@saveConfig')->name('admin.saveConfig');

        ///new
        Route::post('admin/config/email-config', 'Admin\ConfigController@saveEmailLang')->name('admin.saveEmailLang');
        Route::get('admin/config/page-reset', 'Admin\ConfigController@pageReset')->name('admin.pageReset');


        Route::get('admin/config/page-home', 'Admin\ConfigController@pageHome')->name('admin.pageHome');
        Route::get('admin/config/page-about', 'Admin\ConfigController@pageAbout')->name('admin.pageAbout');
        Route::get('admin/config/page-login', 'Admin\ConfigController@pageLogin')->name('admin.pageLogin');
        Route::get('admin/config/page-student-register', 'Admin\ConfigController@pageStudent')->name('admin.pageStudent');

        Route::get('admin/config/page-email', 'Admin\ConfigController@pageEmail')->name('admin.pageEmail');
        Route::get('admin/config/page-email-cancel', 'Admin\ConfigController@pageEmailCancel')->name('admin.pageEmailCancel');
        
        Route::get('admin/config/page-teacher-register', 'Admin\ConfigController@pageTeacher')->name('admin.pageTeacher');
        Route::get('admin/config/page-contact', 'Admin\ConfigController@pageContact')->name('admin.pageContact');
        Route::get('admin/config/page-terms-conditions', 'Admin\ConfigController@pageTerm')->name('admin.pageTerm');
        Route::get('admin/config/page-platform', 'Admin\ConfigController@pagePlatform')->name('admin.pagePlatform');
        Route::get('admin/config/page-method', 'Admin\ConfigController@pageMethod')->name('admin.pageMethod');
        Route::get('admin/config/page-ourteachers', 'Admin\ConfigController@pageOurInstructors')->name('admin.pageOurInstructors');
        Route::get('admin/config/page-schoolstudent', 'Admin\ConfigController@pageChildrens')->name('admin.pageChildrens');
        Route::get('admin/config/page-citizen', 'Admin\ConfigController@pageCitizen')->name('admin.pageCitizen');
        Route::get('admin/config/page-company', 'Admin\ConfigController@pageCompany')->name('admin.pageCompany');
        Route::get('admin/config/page-price', 'Admin\ConfigController@pagePrice')->name('admin.pagePrice');
        Route::get('admin/config/page-certificate', 'Admin\ConfigController@pageCertificate')->name('admin.pageCertificate');
        Route::get('admin/config/page-english', 'Admin\ConfigController@pageEnglish')->name('admin.pageEnglish');
        Route::get('admin/config/page-dutch', 'Admin\ConfigController@pageDutch')->name('admin.pageDutch');
        Route::get('admin/config/page-spanish', 'Admin\ConfigController@pageSpanish')->name('admin.pageSpanish');
        Route::get('admin/config/page-italian', 'Admin\ConfigController@pageItalian')->name('admin.pageItalian');
        Route::get('admin/config/page-hourly', 'Admin\ConfigController@pageHourly')->name('admin.pageHourly');
        Route::get('admin/config/page-monthly', 'Admin\ConfigController@pageMonthly')->name('admin.pageMonthly');

        Route::get('admin/config/page-imprint', 'Admin\ConfigController@pageImprint')->name('admin.pageImprint');
        Route::get('admin/config/page-agreement', 'Admin\ConfigController@pageAgreement')->name('admin.pageAgreement');
        Route::get('admin/config/page-condition', 'Admin\ConfigController@pageCondition')->name('admin.pageCondition');

        Route::get('admin/config/setting-general', 'Admin\ConfigController@settingGeneral')->name('admin.settingGeneral');
        Route::get('admin/config/setting-payment', 'Admin\ConfigController@settingPayment')->name('admin.settingPayment');
        Route::get('admin/config/setting-email', 'Admin\ConfigController@settingEmail')->name('admin.settingEmail');

        Route::get('admin/course/create', 'Admin\CourseController@createInfo')->name('admin.course.create');
        Route::get('admin/courses', 'Admin\CourseController@instructorCourseList')->name('admin.course.list');
        Route::get('admin/course/info', 'Admin\CourseController@instructorCourseInfo')->name('admin.course.info');
        Route::get('admin/course/info/{course_id}', 'Admin\CourseController@instructorCourseInfo')->name('admin.course.info.edit');
        Route::get('admin/course/delete/{course_id}', 'Admin\CourseController@instructorCourseDelete')->name('admin.course.delete');
        Route::post('admin/course/info/save', 'Admin\CourseController@instructorCourseInfoSave')->name('admin.course.info.save');

        Route::get('admin/course/image', 'Admin\CourseController@instructorCourseImage')->name('admin.course.image');
        Route::get('admin/course/image/{course_id}', 'Admin\CourseController@instructorCourseImage')->name('admin.course.image.edit');
        Route::post('admin/course/image/save', 'Admin\CourseController@instructorCourseImageSave')->name('admin.course.image.save');

        Route::get('admin/course/video/{course_id}', 'Admin\CourseController@instructorCourseVideo')->name('admin.course.video.edit');
        Route::post('admin/course/video/save', 'Admin\CourseController@instructorCourseVideoSave')->name('admin.course.video.save');

        Route::get('admin/course/prices/{course_id}', 'Admin\CourseController@coursePrices')->name('admin.course.prices.edit');
        Route::post('admin/course/prices/save', 'Admin\CourseController@coursePricesSave')->name('admin.course.prices.save');

        Route::get('admin/course/curriculum/{course_id}', 'Admin\CourseController@instructorCourseCurriculum')->name('admin.course.curriculum.edit');
        Route::post('admin/course/curriculum/save', 'Admin\CourseController@instructorCourseCurriculumSave')->name('admin.course.curriculum.save');

        
        // Save Curriculum
        Route::post('admin/courses/section/save', 'Admin\CourseController@postSectionSave');
        Route::post('admin/courses/section/delete', 'Admin\CourseController@postSectionDelete');
        Route::post('admin/courses/lecture/save', 'Admin\CourseController@postLectureSave');
        Route::post('admin/courses/video', 'Admin\CourseController@postVideo');
        
        Route::post('admin/courses/lecturequiz/delete', 'Admin\CourseController@postLectureQuizDelete');
        Route::post('admin/courses/lecturedesc/save', 'Admin\CourseController@postLectureDescSave');
        Route::post('admin/courses/lecturepublish/save', 'Admin\CourseController@postLecturePublishSave');
        Route::post('admin/courses/lecturevideo/save/{lid}', 'Admin\CourseController@postLectureVideoSave');
        Route::post('admin/courses/lectureaudio/save/{lid}', 'Admin\CourseController@postLectureAudioSave');
        Route::post('admin/courses/lecturepre/save/{lid}', 'Admin\CourseController@postLecturePresentationSave');
        Route::post('admin/courses/lecturedoc/save/{lid}', 'Admin\CourseController@postLectureDocumentSave');
        Route::post('admin/courses/lectureres/save/{lid}', 'Admin\CourseController@postLectureResourceSave');
        Route::post('admin/courses/lecturetext/save', 'Admin\CourseController@postLectureTextSave');
        Route::post('admin/courses/lectureres/delete', 'Admin\CourseController@postLectureResourceDelete');
        Route::post('admin/courses/lecturelib/save', 'Admin\CourseController@postLectureLibrarySave');
        Route::post('admin/courses/lecturelibres/save', 'Admin\CourseController@postLectureLibraryResourceSave');
        Route::post('admin/courses/lectureexres/save', 'Admin\CourseController@postLectureExternalResourceSave');

        //Appointments
        Route::get('admin/appointments','Admin\AppointmentController@index')->name('admin.appointments');
        Route::get('admin/appointment/listing','Admin\AppointmentController@listings')->name('admin.appointment.listings');
        Route::get('admin/appointment/create','Admin\AppointmentController@create')->name('admin.appointment.create');
        Route::get('admin/appointment/edit/{appointment_id}','Admin\AppointmentController@edit')->name('admin.appointment.edit');
        Route::post('admin/appointment/getcourse','Admin\AppointmentController@getcourse');
        Route::post('admin/appointment/getlecture','Admin\AppointmentController@getlecture');
        Route::post('admin/appointment/update','Admin\AppointmentController@update')->name('admin.appointment.update');
        Route::get('admin/appointment/delete/{id}','Admin\AppointmentController@destroy')->name('admin.appointment.destroy');
        Route::get('admin/appointment/export', 'Admin\AppointmentController@exportData')->name('adminappoint.exportData');
        // Route::post('admin/appointments/search', 'Admin\AppointmentController@searchtData')->name('appoint.searchtData');

        //Coupons
        Route::get('admin/coupons','Admin\CouponController@index')->name('admin.coupons');
        Route::get('admin/coupon/create','Admin\CouponController@create')->name('admin.coupon.create');
        Route::get('admin/coupon/edit/{coupon_id}','Admin\CouponController@edit')->name('admin.coupon.edit');
        Route::post('admin/coupon/update','Admin\CouponController@update')->name('admin.coupon.update');
        Route::get('admin/coupon/delete/{id}','Admin\CouponController@destroy')->name('admin.coupon.destroy');

        //Testimonials
        Route::get('admin/testimonials','Admin\ReviewController@index')->name('admin.testimonials');
        Route::get('admin/testimonial/create','Admin\ReviewController@create')->name('admin.testimonial.create');
        Route::get('admin/testimonial/edit/{testimonial_id}','Admin\ReviewController@edit')->name('admin.testimonial.edit');
        Route::post('admin/testimonial/update','Admin\ReviewController@update')->name('admin.testimonial.update');
        Route::get('admin/testimonial/delete/{id}','Admin\ReviewController@destroy')->name('admin.testimonial.destroy');

        //Subscriptions
        Route::get('admin/subscriptions','Admin\SubscriptionController@index')->name('admin.subscriptions');
        Route::get('admin/subscription/create','Admin\SubscriptionController@create')->name('admin.subscription.create');
        Route::get('admin/subscription/edit/{subscription_id}','Admin\SubscriptionController@edit')->name('admin.subscription.edit');
        Route::post('admin/subscription/update','Admin\SubscriptionController@update')->name('admin.subscription.update');
        Route::get('admin/subscription/delete/{id}','Admin\SubscriptionController@destroy')->name('admin.subscription.destroy');
        
        Route::post('admin/uploadstatic', 'Admin\DashboardController@saveLoginSessionData')->name('admin.saveloginsession');
        Route::get('admin/teacherpayment','Admin\SubscriptionController@teacherweek')->name('admin.teacherpayment');
    });

    Route::group(['middleware' => 'subscribed'], function () {
        //Route for react js
        Route::get('course-enroll/{course_slug}/{lecture_slug}', function () {
            return view('site/course/course_enroll');
        });
        Route::get('course-learn/{course_slug}', 'CourseController@courseLearn')->name('course.learn');
    });
    
});

