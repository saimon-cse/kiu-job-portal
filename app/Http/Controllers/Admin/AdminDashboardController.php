<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicationHistory;
use App\Models\Circular;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // --- Key Metrics (Cards) ---
        $stats = [
            'total_circulars' => Circular::count(),
            'open_circulars' => Circular::where('status', 'open')->count(),
            'total_applications' => ApplicationHistory::where('status', '!=', 'pending')->count(),
            'total_users' => User::whereHas('roles', function ($query) {
                $query->where('name', 'user');
            })->count(),
        ];

        // --- Recent Applications (Table) ---
        $recentApplications = ApplicationHistory::with(['user', 'job'])
            ->where('status', 'submitted')
            ->latest()
            ->limit(5)
            ->get();

        // --- Chart Data ---
        // Prepare data for the Applications by Status chart
        $applicationStatusData = ApplicationHistory::select('status', \DB::raw('count(*) as count'))
            ->where('status', '!=', 'pending')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->all();

        // Prepare data for the Applications Over Time chart
        $applicationsOverTime = ApplicationHistory::select(
                \DB::raw('DATE(created_at) as date'),
                \DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(14)) // Last 14 days
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Format data for Chart.js
        $chartData = [
            'status_labels' => array_map('ucfirst', array_keys($applicationStatusData)),
            'status_counts' => array_values($applicationStatusData),
            'timeline_labels' => $applicationsOverTime->pluck('date')->map(function ($date) {
                return \Carbon\Carbon::parse($date)->format('M d');
            }),
            'timeline_counts' => $applicationsOverTime->pluck('count'),
        ];

        return view('admin.dashboard', compact('stats', 'recentApplications', 'chartData'));
    }
}
