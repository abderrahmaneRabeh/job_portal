<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AccountController extends Controller
{
    public function registration()
    { // use registration page
        return view('front.account.registration');
    }

    public function saveRegestration(Request $request)
    {
        // save user
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5|same:confirm_password',
            'confirm_password' => 'required'
        ]);

        if ($validator->passes()) {

            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            // $user->confirm_password = $request->confirm_password;

            $user->save();

            session()->flash('success', 'Your registered successfully!');


            return response()->json([
                'status' => true,
                'errors' => [

                ]
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function login()
    { // use login page
        return view('front.account.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);

        if ($validator->passes()) {

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

                return redirect()->route('account.profile');
            } else {
                return redirect()->route('account.login')
                    ->with('error', 'Invalid email or password');
            }

        } else {
            return redirect()->route('account.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

    }

    public function profile()
    {
        // dd(Auth::user()->id);

        $user = User::find(Auth::user()->id);

        return view('front.account.profile', ['user' => $user]);
    }

    public function updateProfile(Request $request)
    {
        // save user
        $id = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->passes()) {

            $user = User::find($id);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->designation = $request->designation;
            $user->mobile = $request->mobile;
            $user->save();

            session()->flash('success', 'Your profile updated successfully!');
            //  is a method of the session instance that stores data in the session for the next request. This data will only be available during the next HTTP request and will be deleted afterward.

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

    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }

    public function updateProfilePicture(Request $request)
    {

        $id = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'image' => 'required|image'
        ]);

        if ($validator->passes()) {

            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $image_name = $id . '-' . time() . '.' . $ext;
            $image->move(public_path('/profile_pic/'), $image_name);


            // create new image instance (800 x 600)
            $sourcePath = public_path('/profile_pic/' . $image_name);
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($sourcePath);
            $image->cover(150, 150);
            $image->toPng()->save(public_path('/profile_pic/thumb/' . $image_name));

            // delete old image

            File::delete(public_path('/profile_pic/thumb/' . Auth::user()->image));
            File::delete(public_path('/profile_pic/' . Auth::user()->image));

            User::where('id', $id)->update(['image' => $image_name]);

            session()->flash('success', 'Your profile updated successfully!');

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

    public function createJob()
    {
        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $jobtype = JobType::orderBy('name', 'ASC')->where('status', 1)->get();
        return view('front.account.job.create', [
            'categories' => $categories,
            'jobType' => $jobtype
        ]);
    }

    public function saveJob(Request $request)
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

            $job = new Job();

            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;
            $job->user_id = Auth::user()->id;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->description;
            $job->description = $request->location;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->experience;
            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;
            $job->save();

            session()->flash('success', 'Your job created successfully!');

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

    public function MyJobs()
    {
        $jobs = Job::where('user_id', Auth::user()->id)->with('jobType')->orderBy('created_at', 'DESC')->paginate(6);
        return view('front.account.job.my-job', [
            'jobs' => $jobs
        ]);
    }

    public function editJob(Request $request, $id)
    {

        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $jobtype = JobType::orderBy('name', 'ASC')->where('status', 1)->get();

        $job = Job::where([
            'id' => $id,
            'user_id' => Auth::user()->id
        ])->first();

        if ($job == null) {
            abort(404);
        }

        // dd($job);
        return view('front.account.job.edit', [
            'categories' => $categories,
            'jobType' => $jobtype,
            'job' => $job
        ]);
    }

    public function UpdateJob(Request $request, $id)
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
            $job->user_id = Auth::user()->id;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->description;
            $job->description = $request->location;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->experience;
            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
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

    public function deleteJob(Request $request, $id)
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
