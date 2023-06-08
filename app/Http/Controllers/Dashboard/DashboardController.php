<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Candidate;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function viewDashboard(){
        $total_services = Service::where('status', 1)->count();
        $total_blogs = Blog::where('status', 1)->count();
        $total_candidates = Candidate::where('status', 1)->count();
        $total_products = Product::where('status', 1)->count();

        return view('content.dashboard.dashboard')->with(['total_services' => $total_services, 'total_blogs' => $total_blogs, 'total_candidates' => $total_candidates, 'total_products' => $total_products  ]);
    }
}
