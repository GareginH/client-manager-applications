<?php

namespace App\Http\Controllers;

use App\Application;
use App\Mail\ManagerReplyAppMail;
use App\Mail\UpdatedAppMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function store(Application $application, Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'file' => 'max:5000|nullable',
        ]);

        $user = auth()->user();
        $path = null;
        if($request['file']){
            $file = $request->file('file');
            $fileName = time() . '.' . $file->getClientOriginalName();
            $file->storeAs('public/files', $fileName);
            $path = 'files/'.$fileName;
        }

        $message = $user->messages()->create([
            'content' => $request['content'],
            'file_url' => $path,
        ]);
        $application->messages()->attach($message);
        if($user->isManager()){
            Mail::to($application->user->email)->send(new ManagerReplyAppMail($application));
            return redirect('/');
        }
        if($application->manager){
            Mail::to($application->manager->email)->send(new UpdatedAppMail($application));
        }
        return redirect('/');
    }
}
