<?php

namespace App\Http\Controllers;

use App\Application;
use App\Mail\CreatedAppMail;
use App\Mail\ManagerReplyAppMail;
use App\Mail\UpdatedAppMail;
use App\User;
use Grosv\LaravelPasswordlessLogin\LoginUrl;
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
            $manager = $application->manager;
            $generator = new LoginUrl($manager);
            $generator->setRedirectUrl('/manager/applications/'.$application->id); // Override the default url to redirect to after login
            $url = $generator->generate();
            Mail::to($application->manager->email)->send(new UpdatedAppMail($application, $url));
        }
        return redirect('/');
    }
}
