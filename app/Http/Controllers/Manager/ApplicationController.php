<?php

namespace App\Http\Controllers\Manager;

use App\Application;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ManagerApplicationController extends Controller
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
        $applications = Application::all();
        return view('applications.manager.index', compact('applications'));
    }

    public function show(Application $application){
        $user = auth()->user();
        $messages = $application->messages()->get();
        $application->update(['seen_by'=>null]);
        if(!$application->seenBy){
            $application->update(['seen_by'=>$user->id]); //Make post 'seen' by manager
        }
        return view('applications.manager.show', compact('application', 'messages'));
    }


    public function update(Application $application){
        $user = auth()->user();
        $application->manager()->associate($user->id)->save(); // Add manager to application
        return redirect('/manager/applications');
    }
}
