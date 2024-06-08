<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{

    public function index()
    {
        $jobApplications = JobApplication::orderBy('created_at', 'desc')->with(['user', 'job', 'employer'])->paginate(10);

        return view('admin.job-applications.list', ['jobApplications' => $jobApplications]);
    }

    //delete job application
    public function delete($id)
    {
        $jobApplication = JobApplication::find($id);
        if ($jobApplication) {

            $jobApplication->delete();

            session()->flash('success', 'Your job deleted successfully!');
        } else {
            session()->flash('error', 'Job not found or already deleted.');
        }
        return redirect()->back();
    }
}
