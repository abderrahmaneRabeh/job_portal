<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{

    public function index()
    {
        $jobs = Job::orderBy('created_at', 'desc')->with('user', 'applications')->paginate(4);

        return view('admin.jobs.list', ['jobs' => $jobs]);
    }

    //show edited job data in admin panel form
    public function edit($id)
    {

        return view('admin.jobs.edit', );
    }
}
