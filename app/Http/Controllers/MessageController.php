<?php

namespace App\Http\Controllers;

use App\Application;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Application $application, Request $request)
    {
        $user = auth()->user();

        $file = $request->file('file');
        $fileName = time() . '.' . $file->getClientOriginalName();
        $file->storeAs('public/files', $fileName);
        $path = 'files/'.$fileName;

        $message = $user->messages()->create([
            'content' => $request['content'],
            'file_url' => $path,
        ]);
        $application->messages()->attach($message);
        return view('applications.index', $application);
    }
}
