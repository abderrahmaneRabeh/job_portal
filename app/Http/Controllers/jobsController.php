<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;

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
}
