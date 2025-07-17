<x-app-layout>
    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Admin Dashboard</h1>
        <p class="text-gray-500">Welcome back, {{ Auth::user()->name }}. Here's an overview of the portal activity.</p>
    </div>

    {{-- 1. Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Circulars -->
        <div class="bg-white p-6 rounded-xl shadow-soft border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase">Total Circulars</p>
                    <p class="text-3xl font-bold mt-1 text-gray-800">{{ $stats['total_circulars'] }}</p>
                </div>
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 text-xl">
                    <i class="fas fa-file-alt"></i>
                </div>
            </div>
        </div>
        <!-- Open Circulars -->
        <div class="bg-white p-6 rounded-xl shadow-soft border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase">Open Circulars</p>
                    <p class="text-3xl font-bold mt-1 text-gray-800">{{ $stats['open_circulars'] }}</p>
                </div>
                <div class="p-3 rounded-full bg-green-100 text-green-600 text-xl">
                    <i class="fas fa-folder-open"></i>
                </div>
            </div>
        </div>
        <!-- Total Applications -->
        <div class="bg-white p-6 rounded-xl shadow-soft border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase">Total Applications</p>
                    <p class="text-3xl font-bold mt-1 text-gray-800">{{ $stats['total_applications'] }}</p>
                </div>
                <div class="p-3 rounded-full bg-purple-100 text-purple-600 text-xl">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <!-- Total Users -->
        <div class="bg-white p-6 rounded-xl shadow-soft border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase">Registered Users</p>
                    <p class="text-3xl font-bold mt-1 text-gray-800">{{ $stats['total_users'] }}</p>
                </div>
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 text-xl">
                    <i class="fas fa-user-plus"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 mb-8">
        <!-- Line Chart -->
        <div class="lg:col-span-3 bg-white p-6 rounded-xl shadow-soft">
            <h3 class="font-semibold text-gray-800 mb-4">Applications Trend (Last 14 Days)</h3>
            <canvas id="applicationsTimelineChart"></canvas>
        </div>
        <!-- Doughnut Chart -->
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-soft">
            <h3 class="font-semibold text-gray-800 mb-4">Applications by Status</h3>
            <canvas id="applicationStatusChart"></canvas>
        </div>
    </div>

    {{-- 3. Recent Applications Table --}}
    <div class="bg-white p-6 rounded-xl shadow-soft">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-gray-800">Recent Submitted Applications</h3>
            <a href="{{ route('admin.circulars.index') }}" class="text-sm font-medium text-primary-600 hover:underline">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Applicant</th>
                        <th class="px-6 py-3">Applied For</th>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentApplications as $application)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium">{{ $application->user->name }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $application->job->post_name }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $application->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.applications.show', $application) }}" class="font-medium text-primary-600 hover:text-primary-800">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center py-6 text-gray-500">No recent applications found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pushing the Chart.js logic to the layout's script stack --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Data passed from the controller
            const chartData = @json($chartData);

            // Applications by Status Doughnut Chart
            const statusCtx = document.getElementById('applicationStatusChart');
            if (statusCtx) {
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: chartData.status_labels,
                        datasets: [{
                            label: 'Applications',
                            data: chartData.status_counts,
                            backgroundColor: ['#10B981', '#3B82F6', '#EF4444', '#8B5CF6'],
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                        }
                    }
                });
            }

            // Applications Over Time Line Chart
            const timelineCtx = document.getElementById('applicationsTimelineChart');
            if (timelineCtx) {
                new Chart(timelineCtx, {
                    type: 'line',
                    data: {
                        labels: chartData.timeline_labels,
                        datasets: [{
                            label: 'New Applications',
                            data: chartData.timeline_counts,
                            borderColor: '#0284c7', // primary-600
                            backgroundColor: 'rgba(2, 132, 199, 0.1)',
                            fill: true,
                            tension: 0.3
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: { beginAtZero: true }
                        },
                        plugins: {
                            legend: { display: false },
                        }
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
