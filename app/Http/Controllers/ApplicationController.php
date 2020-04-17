<?php

namespace App\Http\Controllers;

use App\Application;
use App\Mail\CreatedAppMail;
use App\Mail\UpdatedAppMail;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Grosv\LaravelPasswordlessLogin\LoginUrl;

class ApplicationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $applications = $user->applications;
        $dayPassed = $user->dayPassed();
        if(!$applications){
            return redirect('/home');
        }
        return view('applications.index', compact('applications', 'dayPassed'));
    }

    public function create()
    {
        //Check if 24 hours have passed before creating new application / Проверить прошли ли сутки
        if(auth()->user()->dayPassed()){
            return view('applications.create');
        }
        return redirect('/');
    }
    public function show(Application $application){
        $user = auth()->user();
        $messages = $application->messages()->get();
        if($application->user == $user){
            return view('applications.show', compact('application', 'messages'));
        }
        return abort(403);
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject'=>'required|string|',
            'content' => 'required|string',
            'file' => 'required|max:5000',
        ]);

        $user = auth()->user();

        $path = null;
        if($request['file']){
            $file = $request->file('file');
            $fileName = time() . '.' . $file->getClientOriginalName();
            $file->storeAs('public/files', $fileName);
            $path = 'files/'.$fileName;
        }

        $application = $user->applications()->create([
            'subject' => $request['subject'],
            'content' => $request['content'],
            'file_url' => $path,
        ]);
        $applications = $user->applications;

        //Mail
        $managerRole = Role::where('name', 'manager')->first();
        $managerId = DB::table('role_user')->where('role_id', $managerRole->id)->first()->user_id;
        $managerEmail = User::find($managerId)->email;

        $manager = User::find($managerId);
        $generator = new LoginUrl($manager);
        $generator->setRedirectUrl('/manager/applications/'.$application->id); // Override the default url to redirect to after login
        $url = $generator->generate();
        Mail::to($managerEmail)->send(new CreatedAppMail($application, $url));

        return redirect('/');
    }

    public function update(Application $application){
        if($application->manager){
            $manager = $application->manager;
            $generator = new LoginUrl($manager);
            $generator->setRedirectUrl('/manager/applications/'.$application->id); // Override the default url to redirect to after login
            $url = $generator->generate();
            Mail::to($application->manager->email)->send(new UpdatedAppMail($application, $url));
        }
        $application->update(['active'=>false]);
        return redirect('/applications');
    }
}
