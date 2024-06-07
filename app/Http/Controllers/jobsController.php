<?php

namespace App\Http\Controllers;

use App\Mail\JobNotificationMail;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobType;
use App\Models\SavedJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Support\Facades\Mail;

class jobsController extends Controller
{
    //show jobs
    public function index(Request $request)
    {
        $categories = Category::where('status', 1)->get();
        $jobtype = JobType::where('status', 1)->get();

        $jobs = Job::where('status', 1);

        // search using keyword by title or keyword

        if (!empty($request->keyword)) {
            $jobs = $jobs->where(function ($query) use ($request) {
                $query->orWhere('title', 'like', '%' . $request->keyword . '%');
                $query->orWhere('keywords', 'like', '%' . $request->keyword . '%');
            });
        }


        // search using location

        if (!empty($request->location)) {
            $jobs = $jobs->where('location', 'like', '%' . $request->location . '%');
        }

        // search using location

        if (!empty($request->category)) {
            $jobs = $jobs->where('category_id', $request->category);
        }

        // search using jobType
        $jobTypeArray = [];
        if (!empty($request->jobType)) {
            // split a string into an array. The string being split is $request->jobtype
            $jobTypeArray = explode(',', $request->jobType);

            $jobs = $jobs->whereIn('job_type_id', $jobTypeArray);

        }

        // search using experience

        if (!empty($request->experience)) {
            $jobs = $jobs->where('experience', $request->experience);

        }

        $jobs = $jobs->with(['jobType', 'category']);

        // oldest and latest

        if ($request->sort == 0) {

            $jobs = $jobs->orderBy('created_at', 'ASC');

        } else {

            $jobs = $jobs->orderBy('created_at', 'DESC');

        }

        $jobs = $jobs->paginate(9);

        return view('front.jobs', [
            'categories' => $categories,
            'jobtype' => $jobtype,
            'jobs' => $jobs,
            'jobTypeArray' => $jobTypeArray
        ]);
    }


    // ------------ job details --------------

    public function details($id)
    {

        $jobs = Job::where(['id' => $id, 'status' => 1])->with(['jobType', 'category'])->first();
        //where job is active status = 1

        if (empty($jobs)) {
            abort(404);
        }

        $count = 0;
        $msg = false;

        if (Auth::check()) {
            $count = SavedJob::where([
                'user_id' => Auth::user()->id,
                'job_id' => $id
            ])->count();
            $msg = true;
        } else {
            $msg = false;
        }



        return view('front.jobDetail', ['job' => $jobs, 'count' => $count, 'msg' => $msg]);
    }

    // ----------- Apply for job ------------

    public function applyJob(Request $request)
    {
        $id = $request->id;

        $job = Job::where('id', $id)->first();

        // if job not found in database
        if (empty($job)) {
            session()->flash('error', 'Job not found');
            return response()->json([
                'status' => false,
                'message' => 'Job not found',
            ]);
        }

        // you can't apply on you own job
        if ($job->user_id == Auth::user()->id) {
            session()->flash('error', 'You can not apply on your own job');
            return response()->json([
                'status' => false,
                'message' => 'You can not apply on your own job',
            ]);
        }

        // you can't apply on job that is already applied

        $jobApplied = JobApplication::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->count();

        if ($jobApplied > 0) {
            session()->flash('error', 'You have already applied on this job');
            return response()->json([
                'status' => false,
                'message' => 'You have already applied on this job',
            ]);
        }

        $appllication = new JobApplication();
        $appllication->job_id = $id;
        $appllication->user_id = Auth::user()->id;
        $appllication->employer_id = $job->user_id;
        $appllication->applied_date = now();
        $appllication->save();


        // send email to employer

        // $employer = User::where('id', $job->user_id)->first();

        // if ($employer == null) {
        //     return response()->json(['error' => 'Employer not found']);
        // }
        // $mailData = [
        //     'employer' => $employer,
        //     'job' => $job,
        //     'user' => Auth::user()
        // ];


        session()->flash('success', 'Job applied successfully');

        // Mail::to($employer->email)->send(new JobNotificationMail($mailData));


        return response()->json([
            'status' => true,
            'message' => 'Job applied successfully',
        ]);
    }

    // --------------------------- Saving a job ------------------------------


    public function saveJob(Request $request)
    {
        $id = $request->id;

        $job = Job::find($id);

        if ($job == null) {
            session()->flash('error', 'Job not found');
            return response()->json([
                'status' => false,
                'message' => 'Job not found',
            ]);
        }

        //check if already saved
        $isSaved = SavedJob::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->count();

        if ($isSaved > 0) {
            session()->flash('error', 'Already saved');
            return response()->json([
                'status' => false,
                'message' => 'Already saved',
            ]);
        }


        $save = new SavedJob();
        $save->job_id = $id;
        $save->user_id = Auth::user()->id;
        $save->save();


        session()->flash('success', 'Job saved successfully');
        return response()->json([
            'status' => true,
            'message' => 'Job saved successfully',
        ]);
    }
}
