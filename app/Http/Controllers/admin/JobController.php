<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $job = Job::findOrFail($id);

        $categories = Category::orderBy('name', 'ASC')->get();
        $jobtype = JobType::orderBy('name', 'ASC')->get();


        return view('admin.jobs.edit', ['job' => $job, 'categories' => $categories, 'jobType' => $jobtype]);
    }

    public function Update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'vacancy' => 'required|integer',
            'company_name' => 'required',
            'responsibility' => 'required',
            'category' => 'required',
            'description' => 'required',
            'location' => 'required',
            'jobType' => 'required',
            'experience' => 'required',

        ]);

        if ($validator->passes()) {

            $job = Job::find($id);

            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->status = $request->status;
            $job->isFeatured = (!empty($request->isFeatured) ? $request->isFeatured : 0);

            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;
            $job->save();

            session()->flash('success', 'Your job Updated successfully!');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);



        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

    }

    public function delete($id)
    {
        $job = Job::find($id);

        if ($job) {
            $job->delete();
            session()->flash('success', 'Your job deleted successfully!');
        } else {
            session()->flash('error', 'Job not found or already deleted.');
        }
        return redirect()->back();

    }
}
