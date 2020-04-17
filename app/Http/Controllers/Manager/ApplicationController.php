<?php

namespace App\Http\Controllers\Manager;

use App\Application;
use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
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

    public function index(Request $request)
    {
        if(empty($value = $request->get('seen')) && empty($value = $request->get('reply')) && empty($value = $request->get('active'))){
            $applications = Application::all();
            return view('applications.manager.index', compact('applications'));
        }
        $query = Application::orderByDesc('updated_at');
        if (!empty($value = $request->get('active'))) {
            $query->where('active', $value);
        }
        else if(empty($value = $request->get('active'))){
            $query->where('active', $value);
        }
        if (!empty($value = $request->get('seen'))) {
            $query->where('seen_by', auth()->user()->id)->get();
        }
        else if(empty($value = $request->get('seen'))){
            $query->whereNull('seen_by');
        }
        if (!empty($value = $request->get('reply'))) {
            $messageIds = auth()->user()->messages->pluck("id");
            $applications = DB::table('application_message')->whereIn('message_id', $messageIds)->pluck('application_id');
            $query->whereIn('id', $applications)->get();
        }
        $applications = $query->get();
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
