<?php

namespace App\Http\Controllers;

use App\Application;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
        if(!$applications){
            return redirect('/home');
        }
        return view('applications.index', compact('applications'));
    }

    public function create()
    {
        // TODO: Send email to manager on application creation.
        return view('applications.create');
    }
    public function show(Application $application){
        $user = auth()->user();
        $messages = $application->messages()->get();
        if($application->user == $user){ //Make sure its our application
            return view('applications.show', compact('application', 'messages'));
        }
        return abort(403);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $file = $request->file('file');
        $fileName = time() . '.' . $file->getClientOriginalName();
        $file->storeAs('public/files', $fileName);
        $path = 'files/'.$fileName;

        $user->applications()->create([
            'subject' => $request['subject'],
            'content' => $request['content'],
            'file_url' => $path,
        ]);
        $applications = $user->applications;
        return view('applications.index', compact('applications'));
    }

    public function update(Application $application){
        // TODO: Send email to manager about new messages or status change.
        $application->update(['active'=>false]);
        return redirect('/applications');
    }
}
