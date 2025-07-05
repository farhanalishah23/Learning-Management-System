<?php

namespace App\Http\Controllers;
use App\Category;
use App\Contact;
use App\Course;
use App\CourseAttachment;
use App\CourseTeacher;
use App\CourseStudent;
use App\Feature;
use App\SocialMedia;
use App\Task;
use App\TaskAnswer;
use App\TaskScore;
use App\Testmonial;
use App\User;
use Illuminate\Support\Facades\Storage;
use Auth;
use Validator;
use Mail;
use Illuminate\Http\Request;

class BackendController extends Controller
{
     public function dashboard() {
         $id = Auth::id();
         $teacherCourses = CourseTeacher::where('status', 'active')->where('teacher_id', $id)->get();
         $TopMarks = TaskScore::where('teacher_id',$id)->orderBy('score','desc')->take(3)->get();
         $AllTopMarks = TaskScore::with('student')->orderBy('score', 'desc')->take(3)->get();
         $myHighestMarks = TaskScore::with('course')->where('student_id', $id)->orderBy('score', 'desc')->take(1)->get();
         $studentCourse = CourseStudent::where('status','active')->where('student_id', $id)->get();
         $allCourse = Course::where('status','active')->latest()->limit(5)->get();
         return view('backend.dashboard', compact('teacherCourses' ,'studentCourse','allCourse','TopMarks','myHighestMarks','AllTopMarks'));

    }
    public function categories(){
        $categories = Category::get();
        return view('backend.categories' , compact('categories'));
    }
    public function addCategory(Request $request){
        extract($request->all());
        $request->validate([
            'name' => 'required',
        ]);
        $categories = Category::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);
        if($categories){
            return redirect()->back()->with(['type'=>'success','title'=>'Done!','message'=>'Category created successfully']);
        }else{
            return redirect()->back()->with(['type'=>'success','title'=>'Fail!','message'=>'Unable to create category']);
        }
    }
    public function updateCategoryStatus($category_id,$status){
        if (Category::where('id',$category_id)->update(['status'=>$status])){
            return redirect()->back()->with(['type'=>'success','title'=>'Done!','message'=>'Status updated successfully']);
        }else{
            return redirect()->back()->with(['type'=>'success','title'=>'Fail!','message'=>'Unable to update status']);
        }
    }
    public function updateCategory(Request $request ){
        extract($request->all());
        $request->validate([
            'name' => 'required|max:25',
        ]);
        $category = Category::where('id',$request->edit_category_id)->update([
            'name' => $request->name,
        ]);
        if($category){
            return redirect()->back()->with(['type'=>'success','title'=>'Done!','message'=>'Category updated successfully']);
        }else{
            return redirect()->back()->with(['type'=>'success','title'=>'Fail!','message'=>'Unable to update category']);
        }
    }
    public function destroyCategory(Request $request){
        extract($request->all());
        $categories = Category::findorfail($id);
        $categories->delete();
        if($categories){
            return redirect()->back()->with(['type'=>'success' , 'title'=>'Deleted!' , 'message' => 'Category deleted succesfully']);
        }else {
            return redirect()->back()->with(['type'=>'error' , 'title'=>'fail' , 'message' => 'Unable to delete succesfully']);
        }
    }
    public function courses(){
       $courses =  Course::latest()->paginate(6);
        return view('backend.courses',compact('courses'));
    }
    public function addCourse(){
        $categories = Category::where('status','active')->get();
        return view('backend.add_course' , compact('categories'));
    }
    public function storeCourse(Request $request){
        extract($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'category_id' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            $courseAttachments=CourseAttachment::where('unique_number',$request->unique_number)->get();
            $categories = Category::where('status','active')->get();
            return view('backend.add_course',compact('courseAttachments','categories'))->withErrors($errors);
        }
        $course = Course::create([
            'category_id' => $category_id,
            'title' => $title,
            'description' => $description,
            'status' => $status,
        ]);
        CourseAttachment::where('unique_number',$unique_number)->update(['course_id'=>$course->id]);
        if($course){
            return redirect(url('courses'))->with(['type'=>'success','title'=>'Done!','message'=>'Course created successfully']);
        }else{
            return redirect()->back()->with(['type'=>'success','title'=>'Fail!','message'=>'Unable to create course']);
        }
    }
    public function showCourse($id){
        $courses = Course::findOrFail($id);
        $categories = Category::where('status','active')->get();
        $courseAttachments = $courses->attachments;
        return view('backend.show_course', compact('courses', 'categories', 'courseAttachments'));
    }

    public function updateCourse(Request $request , $id){
        extract($request->all());
        $course = Course::findorfail($id);
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        $courseUpdate = $course->update([
            'category_id' => $category_id,
            'title' => $title,
            'description' => $description,
            'status' => $status,
        ]);
        CourseAttachment::where('unique_number',$unique_number)->update(['course_id'=>$course->id]);
        if($courseUpdate) {
            return redirect(url('courses'))->with(['type'=>'success','title'=>'Done!','message'=>'Course updated successfully']);
        }else{
            return redirect()->back()->with(['type'=>'success','title'=>'Fail!','message'=>'Unable to update course']);
        }
    }
    public function uploadCourseAttachment(Request  $request){
        $extension= $request->file->getClientOriginalExtension();
        $path = Storage::disk('website')->putFile('CourseAttachments', $request->file('file'));
        $courseAttachment = CourseAttachment::create(['file'=>$path,'extension'=>$extension,'unique_number'=>$request->unique_number]);
        if ($courseAttachment!=null){
            return true;
        }else{
            return false;
        }//end if
    }//end uploadPostAttachment
    public function fetchFiles(Request $request){
        try {
           $attachments = Attachment::where('unique_number', $request->unique_number)->get();
            $filesData = [];
            foreach ($attachments as $attachment) {
                $fileUrl = Storage::disk('website')->url($attachment->file);
                $filesData[] = [
                    'name' => basename($fileUrl),
                    'size' => Storage::disk('website')->size($attachment->file),
                    'path' => $fileUrl
                ];
            }
            return response()->json($filesData);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
      public function teachers(){
       $teachers = User::where('role','teacher')->get();
      return view('backend.teachers',compact('teachers') );
    }
      public function addTeacher(){
        return view ('backend.add_teacher');
    }
    public function storeTeacher(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' =>'required',
        ]);
        $path = null;
        if ($request->hasFile('image')) {
            $path = Storage::disk('website')->putFile('Users', $request->file('image'));
        }
        $teacher = User::create([
            'role' => 'teacher',
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'image' => $path,
            'status' => $request->input('status'),
        ]);
        if($teacher) {
            return redirect(url('teachers'))->with(['type' => 'success', 'title' => 'Done!', 'message' => 'Teacher has been created successfully']);
        } else {
            return redirect()->back()->with(['type' => 'error', 'title' => 'Fail!', 'message' => 'Unable to create teacher']);
        }
    }
    public function checkEmailAvailability(Request $request){
        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        if ($user) {
            return response()->json(['available' => false]);
        }
        return response()->json(['available' => true]);
    }

    public function updateTeacherStatus($teacher_id,$status){
        if (User::where('id',$teacher_id)->update(['status'=>$status])){
            return redirect()->back()->with(['type'=>'success','title'=>'Done!','message'=>'Status updated successfully']);
        }else{
            return redirect()->back()->with(['type'=>'success','title'=>'Fail!','message'=>'Unable to update status']);
        }
    }
    public function showTeacher($id){
        $teachers = User::where('role', 'teacher')->findOrFail($id);
        return view('backend.show_teacher',compact('teachers') );
    }
    public function updateTeacher(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
        ]);
        $user = User::where('role','teacher')->find($id);
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        if ($request->hasFile('image')) {
            $path = Storage::disk('website')->putFile('Users', request()->file('image'));
        } else {
            $path = Auth::user()->image;
        }
        $user->update(['name' => $request->name,'email' => $request->email,'image' => $path]);
        if ($user) {
            return redirect(url('teachers'))->with(['type' => 'success', 'title' => 'Success', 'message' => 'Teacher updated successfully']);
        }else{
            return redirect()->back()->with(['type' => 'error', 'title' => 'Error', 'message' => 'Unable to update teacher']);
        }
    }
    public function destroyTeacher(Request $request){
        extract($request->all());
        $teachers = User::where('role','teacher')->findorfail($id);
        $teachers->delete();
        if ($teachers){
            return redirect(url('teachers'))->with(['type'=>'success','title'=>'Deleted!','message'=>'Teacher deleted successfully']);
        }
        else {
            return redirect()->back()->with(['type'=>'success','title'=>'Deleted!','message'=>'Unable to delete teacher']);
        }
    }
    public function students(){
        $students = User::where('role','student')->get();
        return view('backend.students',compact('students') );
    }
    public function addStudent(){
        return view ('backend.add_student');
    }
    public function storeStudent(Request $request){
        $request->validate([
            'name'=> 'required',
            'email' => 'required|email|unique:users,email',
            'password' =>'required',
        ]);
        $path = null;
        if ($request->hasFile('image')) {
            $path = Storage::disk('website')->putFile('Users', $request->file('image'));
        }
        $student = User::create([
            'role' => 'student',
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'image' => $path,
            'status' => $request->input('status'),
        ]);
        if($student){
            return redirect(url('students'))->with(['type'=>'success','title'=>'Done!','message'=>'Student has been created successfully']);
        }else{
            return redirect()->back()->with(['type'=>'error','title'=>'Fail!','message'=>'Unable to create student']);
        }
    }
    public function updateStudentStatus($student_id,$status){
        if (User::where('id', $student_id)->update(['status' => $status])) {
            return redirect()->back()->with(['type' => 'success', 'title' => 'Done!', 'message' => 'Status updated successfully']);
        } else {
            return redirect()->back()->with(['type' => 'success', 'title' => 'Fail!', 'message' => 'Unable to update status']);
        }
    }
    public function showStudent($id){
        $students = User::where('role', 'student')->findOrFail($id);
        return view('backend.show_student', compact('students'));
    }
    public function updateStudent(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
        ]);
        $user = User::where('role','student')->find($id);
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        if ($request->hasFile('image')) {
            $path = Storage::disk('website')->putFile('Users', request()->file('image'));
        } else {
            $path = Auth::user()->image;
        }
        $user->update(['name' => $request->name,'email' => $request->email,'image' => $path]);
        if ($user) {
            return redirect(url('students'))->with(['type' => 'success', 'title' => 'Success', 'message' => 'Student updated successfully']);
        }else{
            return redirect()->back()->with(['type' => 'error', 'title' => 'Error', 'message' => 'Unable to update student']);
        }
    }
    public function destroyStudent(Request $request){
        extract($request->all());
        $students = User::where('role','student')->findorfail($id);
        $students->delete();
        if ($students){
            return redirect(url('students'))->with(['type'=>'success','title'=>'Deleted!','message'=>'Student deleted successfully']);
        }
        else {
            return redirect()->back()->with(['type'=>'success','title'=>'Deleted!','message'=>'Unable to delete student']);
        }
    }
    public function features(){
         $features = Feature::get();
         return view('backend.features',compact('features'));
    }
    public function addFeature(Request $request){
         extract($request->all());
         $request->validate([
             'title' => 'required',
             'description' => 'required',
         ]);
         $features = Feature::create([
          'title'=> $title ?? null,
          'description'=>$description ?? null,
          'color'=>$color ?? null,
          'icon'=>$icon ?? null,
          'status'=>$status ?? null,
         ]);
        if($features){
            return redirect()->back()->with(['type'=>'success','title'=>'Done!','message'=>'Feature created successfully']);
        }else{
            return redirect()->back()->with(['type'=>'error','title'=>'Fail!','message'=>'Unable to create feature']);
        }
    }
    public function updateFeature(Request $request){
//         return $request->all();
        extract($request->all());
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
       $features = Feature::where('id',$edit_feature_id)->update([
            'title'=> $title,
            'description'=>$description,
            'icon'=> $edit_feature_icon ?? null,
            'color'=> $edit_feature_color ?? null,
            'status'=>$status,
        ]);
        if($features){
            return redirect()->back()->with(['type'=>'success','title'=>'Done!','message'=>'Feature updated successfully']);
        }else{
            return redirect()->back()->with(['type'=>'error','title'=>'Fail!','message'=>'Unable to update feature']);
        }
    }
    public function testimonials(){
        $testimonials = Testmonial::get();
        return view('backend.testimonials',compact('testimonials'));
    }
    public function addTestimonial(Request $request){
        extract($request->all());
         $request->validate([
           'name' => 'required',
           'description' => 'required',
        ]);
        $path =null;
        if($request->hasFile('image')){
            $path = Storage::disk('website')->putFile('Testmonials', $request->file('image'));
        }
        $testimonials = Testmonial::create([
            'name'=> $name,
            'email'=> $email,
            'description'=>$description,
            'image'=>$path,
            'status'=>$status,
        ]);
        if($testimonials){
            return redirect()->back()->with(['type'=>'success','title'=>'Done!','message'=>'Testimonial created successfully']);
        }else{
            return redirect()->back()->with(['type'=>'error','title'=>'Fail!','message'=>'Unable to create testimonial']);
        }
    }

    public function updateTestimonial(Request $request){
//         return $request->all();
        extract($request->all());
        $request->validate([
            'edit_testimonial_name' => 'required',
            'edit_testimonial_description' => 'required',
        ]);
       $testimonials = Testmonial::find($request->edit_testimonial_id);
        if ($request->hasFile('image')) {
            $path = Storage::disk('website')->putFile('Testmonials', $request->file('image'));
        }else{
            $path = $testimonials->image;
        }
        if($testimonials){
            $testimonials->update([
                'name'=> $edit_testimonial_name,
                'email'=> $edit_testimonial_email,
                'description'=>$edit_testimonial_description,
                'image'=>$path,
                'status'=>$status,
            ]);
            return redirect()->back()->with(['type'=>'success','title'=>'Done!','message'=>'Testimonial updated successfully']);
        }else{
            return redirect()->back()->with(['type'=>'error','title'=>'Fail!','message'=>'Unable to updated testimonial']);
        }
    }
    public function socialMedias(){
         $socialMedias = SocialMedia::get();
         return view ('backend.socialmedias',compact('socialMedias'));
    }
    public function addSocialMedia(Request $request){
        extract($request->all());
        $socialMedias = SocialMedia::create([
            'icon_class'=> $icon ?? null,
            'color'=> $color ?? null,
            'url'=> $url ?? null,
            'status'=>$status ?? null,
        ]);
        if($socialMedias){
            return redirect()->back()->with(['type'=>'success','title'=>'Done!','message'=>'Social media icon created successfully']);
        }else{
            return redirect()->back()->with(['type'=>'error','title'=>'Fail!','message'=>'Unable to create social media icon']);
        }
    }
    public function contacts(){
        $contacts = Contact::get();
        return view('backend.contacts',compact('contacts'));
    }
    public function showContact($id){
       $contacts = Contact::find($id);
        return view('backend.contacts' , compact('contacts'));
    }
    public function assignTeacher(){
        $courses = Course::get();
        $teachers = User::where('role','teacher')->where('status', 'active')->get();
        $courseTeachers = CourseTeacher::get();
        return view('backend.assign_teacher' , compact('teachers','courses','courseTeachers'));
    }
    public function assignTeacherToCourse(Request $request){
        extract($request->all());
        $request->validate([
            'status' => 'required',
        ]);
        $alreadyExistCourse = CourseTeacher::where('course_id', $request->course_id)->first();
        if ($alreadyExistCourse) {
            return redirect()->back()->with(['type' => 'warning', 'title' => 'Already Assigned!', 'message' => 'Teacher is already assigned to this course']);
        }
        $courseTeacher = CourseTeacher::create([
            'course_id' => $request->course_id,
            'teacher_id' => $request->teacher_id,
            'status' => $request->status,
        ]);
        $teachers = CourseTeacher::where('teacher_id', $request->teacher_id)->where('status', 'active')->with('course')->get();
        foreach ($teachers as $teacher) {
            $suggestionString = "Course '{$teacher->course->title}' is assigned to you by admin";
            Mail::raw($suggestionString, function ($message) use ($teacher) {
                $message->to($teacher->teacher->email)->subject('Email Testing');
            });
        }
        if ($courseTeacher) {
            return redirect()->back()->with(['type'=>'success', 'title'=>'Done!', 'message'=>'Teacher assigned successfully']);
        } else {
            return redirect()->back()->with(['type'=>'error', 'title'=>'Fail!', 'message'=>'Unable to assign teacher']);
        }
    }
    public function updateTeacherCourseStatus($teacher_id,$status){
        if (CourseTeacher::where('id',$teacher_id)->update(['status'=>$status])){
            return redirect()->back()->with(['type'=>'success','title'=>'Done!','message'=>'Status updated successfully']);
        }else{
            return redirect()->back()->with(['type'=>'success','title'=>'Fail!','message'=>'Unable to update status']);
        }
    }
    public function assignStudent(){
        $courses = Course::get();
        $students = User::where('role','student')->where('status', 'active')->get();
        $studentCourses = CourseStudent::get();
        return view('backend.assign_student' , compact('students','courses','studentCourses'));
    }
    public function assignStudentToCourse(Request $request){
        $request->validate([
            'status' => 'required',
        ]);
        $studentCourse = CourseStudent::where('student_id', $request->student_id)->where('course_id', $request->course_id)->first();
        if ($studentCourse) {
            return redirect()->back()->with(['type'=>'warning', 'title'=>'Already Assigned!', 'message'=>'Course is already assigned to this student']);
        }
        $studentCourse = CourseStudent::create([
            'student_id' => $request->student_id,
            'course_id' => $request->course_id,
            'status' => $request->status,
        ]);
        $students = CourseStudent::where('student_id', $request->student_id)->where('status', 'active')->with('course')->get();
        foreach ($students as $student) {
            $suggestionString = "Course '{$student->course->title}' is assigned to you by admin";
            Mail::raw($suggestionString, function ($message) use ($student) {
                $message->to($student->student->email)->subject('Email Testing');
            });
        }
        if ($studentCourse){
            return redirect()->back()->with(['type'=>'success', 'title'=>'Done!', 'message'=>'Course assigned successfully']);
        } else {
            return redirect()->back()->with(['type'=>'error', 'title'=>'Fail!', 'message'=>'Unable to assign course']);
        }
    }
    public function updateCourseStudentStatus($student_id,$status){
        if (CourseStudent::where('id',$student_id)->update(['status'=>$status])){
            return redirect()->back()->with(['type'=>'success','title'=>'Done!','message'=>'Status updated successfully']);
        }else{
            return redirect()->back()->with(['type'=>'success','title'=>'Fail!','message'=>'Unable to update status']);
        }
    }
    public function manageCourses(){
         $teacherId = Auth::id();
         $manageCourses = CourseTeacher::with('task')->where('teacher_id', $teacherId)->where('status','active')->get();
         $createTasks = Task::get();
        return view('backend.manage_courses',compact('manageCourses','createTasks'));
    }
    public function createTask(Request $request){
        extract($request->all());
        $request->validate([
            'task'=>'required',
        ]);
        $createTask = Task::create([
            'teacher_id'=>Auth::id(),
            'course_id'=>$course_id,
            'task' => $task,
        ]);
        if($createTask){
            return redirect()->back()->with(['type'=>'success','title'=>'Done!','message'=>'Task created successfully']);
        }else{
            return redirect()->back()->with(['type'=>'success','title'=>'Fail!','message'=>'Unable to create task']);
        }
    }
    public function viewCreatedTaskModal(Request $request){
        $studentTasks = Task::where('course_id', $request->course_id)->first();
        return view('backend.view_created_task_modal', compact('studentTasks'));
    }
    public function storeScore(Request $request){
        extract($request->all());
        $request->validate([
            'task'=>'required',
        ]);
        $createTask = TaskScore::create([
            'teacher_id'=>Auth::id(),
            'student_id' => $student_id,
            'course_id'=>$course_id,
            'score' => $score,
            'remarks' => $remarks,
        ]);
        if($createTask){
            return redirect()->back()->with(['type'=>'success','title'=>'Done!','message'=>'Score assigned successfully']);
        }else{
            return redirect()->back()->with(['type'=>'success','title'=>'Fail!','message'=>'Unable to assign score']);
        }
    }
    public function viewStudents(){
        $teacherId = Auth::id();
        $teacherCourses = CourseTeacher::with('taskAnswer')->where('teacher_id',$teacherId)->where('status','active')->get();
        $tasks = Task::get();
        $taskAnswers = TaskAnswer::get();
        $studentScore = TaskScore::get();
        return view('backend.view_students',compact('teacherCourses','tasks','taskAnswers','studentScore'));
    }
    public function viewTaskModal(Request $request){
        $studentCourses = TaskAnswer::where('course_id', $request->course_id)->where('student_id', $request->student_id)->first();
        $studentTasks = Task::where('course_id', $request->course_id)->first();
        $studentScore = TaskScore::where('course_id', $request->course_id)->where('student_id',$request->student_id)->first();
        return view('backend.view_task_modal', compact('studentCourses','studentTasks','studentScore'));
    }
    public function viewTeacherTaskModal(Request $request){
        $studentTasks = Task::where('course_id', $request->course_id)->first();
        return view('backend.view_teacher_task_modal', compact('studentTasks'));
    }
    public function myCourses() {
        $studentId = Auth::id();
        $studentCourses = CourseStudent::with('teacher')->where('status','active')->where('student_id', $studentId)->get();
        $viewTaskAnswers = TaskAnswer::get();
        $studentScores = TaskScore::get();
        $tasks = Task::get();
        return view('backend.my_courses', compact('studentCourses', 'tasks','viewTaskAnswers','studentScores'));
    }
    public function viewCourseModal(Request $request){
       $studentId = Auth::id();
        $studentCourses = CourseStudent::with('student')->where('course_id',$request->course_id)->where('student_id', $studentId)->where('status','active')->first();
        $studentTasks = Task::where('course_id', $request->course_id )->first();
        $courseTasks = TaskAnswer::where('course_id', $request->course_id)->where('student_id', $studentId)->first();
       return view('backend.view_course_modal', compact('studentTasks','courseTasks','studentCourses'));
    }
    public function storeAnswer(Request $request){
        extract($request->all());
        $request->validate([
            'answer' => 'required',
        ]);
        $taskAnswers = TaskAnswer::create([
            'student_id'=> Auth::id(),
            'course_id' => $course_id,
            'answer' => $answer,
        ]);
        if($taskAnswers){
            return redirect()->back()->with(['type'=>'success','title'=>'Done!','message'=>'Answer submitted successfully']);
        }else{
            return redirect()->back()->with(['type'=>'success','title'=>'Fail!','message'=>'Unable to submit answer']);
        }
    }
    public function viewScoreModal(Request $request){
       $studentScore = TaskScore::where('course_id', $request->course_id)->where('student_id',$request->student_id)->first();
        return view('backend.view_score_modal', compact('studentScore'));
    }
    public function manageProfile(){
        return view('backend.manage_profile');
    }
    public function updateProfile(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
        ]);
        $user = User::find($id);
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        if ($request->hasFile('image')) {
            $path = Storage::disk('website')->putFile('Users', request()->file('image'));
        } else {
            $path = Auth::user()->image;
        }
        $user->update(['name' => $request->name,'email' => $request->email,'image' => $path]);
        if ($user) {
            return redirect(url('manage_profile'))->with(['type' => 'success', 'title' => 'Success', 'message' => 'User updated successfully']);
        }else{
            return redirect()->back()->with(['type' => 'error', 'title' => 'Error', 'message' => 'User not found']);
        }
    }
    public function logout(){
        Auth::logout();
        return redirect(url('/'));
    }
}
