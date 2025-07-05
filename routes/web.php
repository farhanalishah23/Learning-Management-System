<?php

use Illuminate\Support\Facades\Route;
use app\Http\Controllers\BackendController;
use app\Http\Controllers\WebsiteController;

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

Route::get('/', 'WebsiteController@index')->name('/');
Route::get('contactus','WebsiteController@contactUs')->name('contactus');
Route::post('contact_store','WebsiteController@contactStore')->name('contact_store');

Route::get('login' , 'WebsiteController@login')->name('login');

Route::get('manage_profile', 'BackendController@manageProfile')->name('manage_profile');

Route::get('testing' , 'WebsiteController@testing')->name('testing');

Route::get('dashboard', 'BackendController@dashboard')->name('dashboard');

Route::group(['middleware' => 'role:admin'], function () {

    //Admin Dashboard Routes
    Route::get('categories' , 'BackendController@categories')->name('categories');
    Route::post('add_category' , 'BackendController@addCategory')->name('add_category');
    Route::get('update_category_status/{category_id?}/{status?}', 'BackendController@updateCategoryStatus')->name('update_category_status');
    Route::put('update_category' , 'BackendController@updateCategory')->name('update_category');
    Route::delete('destroy_category', 'BackendController@destroyCategory')->name('destroy_category');
    Route::get('courses' , 'BackendController@courses')->name('courses');
    Route::get('add_course' , 'BackendController@addCourse')->name('add_course');
    Route::post('store_course' , 'BackendController@storeCourse')->name('store_course');
    Route::get('show_course/{id}' , 'BackendController@showCourse')->name('show_course');
    Route::get('update_course/{id}' , 'BackendController@updateCourse')->name('update_course');
    Route::post('upload_post_attachment' , 'BackendController@uploadCourseAttachment')->name('upload_post_attachment');
    Route::get('edit_course/{id}' , 'BackendController@editCourse')->name('edit_course');
    Route::put('update_course/{id}' , 'BackendController@updateCourse')->name('upload_course');

    Route::get('teachers' , 'BackendController@teachers')->name('teachers');
    Route::get('add_teacher' , 'BackendController@addTeacher')->name('add_teacher');
    Route::post('store_teacher' , 'BackendController@storeTeacher')->name('store_teacher');
    Route::post('check_email', 'BackendController@checkEmailAvailability')->name('check_email');
    Route::get('show_teacher/{id}' , 'BackendController@showTeacher')->name('show_teacher');
    Route::put('update_teacher/{id}' , 'BackendController@updateTeacher')->name('update_teacher');
    Route::delete('destroy_teacher' , 'BackendController@destroyTeacher')->name('destroy_teacher');
    Route::get('update_teacher_status/{id?}/{status?}', 'BackendController@updateTeacherStatus')->name('update_teacher_status');


    Route::get('students' , 'BackendController@students')->name('students');
    Route::get('add_student' , 'BackendController@addStudent')->name('add_student');
    Route::post('store_student' , 'BackendController@storeStudent')->name('store_student');
    Route::get('update_student_status/{id?}/{status?}', 'BackendController@updateStudentStatus')->name('update_student_status');
    Route::get('show_student/{id}' , 'BackendController@showStudent')->name('show_student');
    Route::put('update_student/{id}' , 'BackendController@updateStudent')->name('update_student');
    Route::delete('destroy_student' , 'BackendController@destroyStudent')->name('destroy_student');

    Route::get('features', 'BackendController@features')->name('features');
    Route::post('add_feature', 'BackendController@addFeature')->name('add_feature');
    Route::put('update_feature', 'BackendController@updateFeature')->name('update_feature');

    Route::get('testimonials', 'BackendController@testimonials')->name('testimonials');
    Route::post('add_testimonial', 'BackendController@addTestimonial')->name('add_testimonial');
    Route::post('update_testimonial', 'BackendController@updateTestimonial')->name('update_testimonial');

    Route::get('socialmedias', 'BackendController@socialMedias')->name('socialmedias');
    Route::post('add_social_media', 'BackendController@addSocialMedia')->name('add_social_media');
    Route::put('update_social_media', 'BackendController@updateSocialMedia')->name('update_social_media');

    Route::get('contacts', 'BackendController@contacts')->name('contacts');
    Route::get('show_contact/{contact_id}', 'BackendController@showContact')->name('show_contact');

    Route::get('assign_teacher' , 'BackendController@assignTeacher')->name('assign_teacher');
    Route::post('assign_teacher_course' , 'BackendController@assignTeacherToCourse')->name('assign_teacher_course');
    Route::get('update_teacher_course/{id?}/{status?}', 'BackendController@updateTeacherCourseStatus')->name('update_teacher_course');

    Route::get('assign_student' , 'BackendController@assignStudent')->name('assign_student');
    Route::post('assign_student_course' , 'BackendController@assignStudentToCourse')->name('assign_student_course');
    Route::get('update_student_course/{id?}/{status?}', 'BackendController@updateCourseStudentStatus')->name('update_student_course');
});
Route::group(['middleware' => 'role:teacher'], function () {

    //teacher Dashboard Routes
    Route::get('view_students' , 'BackendController@viewStudents')->name('view_students');
    Route::get('manage_courses' , 'BackendController@manageCourses')->name('manage_courses');
    Route::get('view_created_task_modal' , 'BackendController@viewCreatedTaskModal')->name('view_created_task_modal');
    Route::post('create_task' , 'BackendController@createTask')->name('create_task');
    Route::get('view_task_modal' , 'BackendController@viewTaskModal')->name('view_task_modal');
    Route::get('view_teacher_task_modal' , 'BackendController@viewTeacherTaskModal')->name('view_teacher_task_modal');
    Route::post('store_score' , 'BackendController@storeScore')->name('store_score');
});
Route::group(['middleware' => 'role:student'], function () {

    //Student Dashboard Routes
    Route::get('my_courses' , 'BackendController@myCourses')->name('my_courses');
    Route::get('view_course_modal' , 'BackendController@viewCourseModal')->name('view_course_modal');
    Route::post('store_answer' , 'BackendController@storeAnswer')->name('store_answer');
    Route::get('view_score_modal' , 'BackendController@viewScoreModal')->name('view_score_modal');
});

Route::put('update_profile/{id?}', 'BackendController@updateProfile')->name('update_profile');

Route::get('/unauthorized', function () {
    return response('Unauthorized', 403);
})->name('unauthorized');



Route::get('logout' , 'BackendController@logout')->name('logout');

Auth::routes();



