<?php

namespace App\Http\Controllers;





use App\Mail\ContactMe;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;


class ContactController extends Controller
{


      public function store(){
          request()->validate([
              'message' => 'required|string',
              'name' => 'required|string',
              'mail' => 'required|email',
              'subject' => 'required|string'
          ]);


        //   Mail::to('admin@example.com')
        //       ->send(new ContactMe(request('message'),request('name'), request('mail'), request('subject')));

          $message = __("მეილი წარმატებით გაიგზავნა");
          return redirect('/contact')->with('message', $message);
      }
}
