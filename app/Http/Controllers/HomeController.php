<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->take(8)->get();

        $newCategories = Category::where('status', 1)->orderBy('name', 'ASC')->get();

        $Futurejob = Job::where('status', 1)
            ->where('isFeatured', 1)
            ->with('jobType')
            ->orderBy('created_at', 'DESC')
            ->take(6)->get();

        $Latestjob = Job::where('status', 1)
            ->with('jobType')
            ->orderBy('created_at', 'DESC')
            ->take(6)->get();

        return view('front.home', [
            'categories' => $categories,
            'Futurejob' => $Futurejob,
            'Latestjob' => $Latestjob,
            'newCategories' => $newCategories
        ]);
    }
}
