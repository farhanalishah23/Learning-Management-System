<?php

namespace App\Http\Controllers;
use App\Contact;
use App\Course;
use App\Testmonial;
use App\Feature;
use Auth;
use Mail;

use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index(){
        $courses=Course::get();
        $features = Feature::where('status','active')->paginate(6);
        $testmonials = Testmonial::where('status','active')->paginate(3);
      return view('website.index',compact('courses','testmonials','features'));
    }
    public function contactUs(){
        return view('website.contact');
    }
    public function contactStore(Request $request){
        $request->validate([
            'name'=>"required|max:50",
            'email'=>"required|email",
            'subject'=>"required|max:50",
            'message'=>"required:max:200",
        ]);
        $contacts =Contact::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'subject'=> $request->subject,
            'phone' =>$request->phone,
            'message'=> $request->message,
        ]);
        $email = $request->email;
        $name = $request->name ?? 'Customer';
        $suggestionString = "Dear $name,\n\nThanks for contacting us! We will reply to you soon. \n\nRegards,\nLMS Platform";
        Mail::raw($suggestionString, function($message) use ($email) {
            $message->to($email)->subject('LMS Support');
        });
        if ($contacts!=null) {
            return redirect(url('contactus'))->with(['type'=>'success','title'=>'Done','message'=>'Your message has been send']);
        }else {
            return redirect()->back()->with(['type'=>'error','title'=>'Fail','message'=>'Unable to send message']);
        }
    }
    public function login(){
        Auth::login();
        return redirect(url('login'));
    }
    public function testing(){
        $suggestionString = "In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before the final copy is available";
        Mail::raw($suggestionString, function($message)
        {
            $message->to('farhan@yopmail.com')->subject('Email Testing');
        });
    }
}
