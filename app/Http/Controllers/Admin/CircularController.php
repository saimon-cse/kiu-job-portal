<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Circular;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CircularController extends Controller
{
    public function index()
    {
        $this->authorize('manage-circulars');
         $circulars = Circular::withCount(['jobs', 'jobApplications'])
            ->with('creator')
            ->latest('post_date')
            ->paginate(10);
        return view('admin.circulars.index', compact('circulars'));
    }

    public function create()
    {
        $this->authorize('manage-circulars');
        return view('admin.circulars.create');
    }

    public function store(Request $request)
    {
        $this->authorize('manage-circulars');

        $validated = $request->validate([
            'circular_no' => 'required|string|max:255|unique:circulars,circular_no',
            'post_date' => 'required|date',
            'last_date_of_submission' => 'required|date|after_or_equal:post_date',
            'description' => 'nullable|string',
            'document_path' => 'nullable|file|mimes:pdf,doc,docx|max:5120', // Max 5MB
            'status' => 'required|in:open,closed,archived',
            'jobs' => 'required|array|min:1',
            'jobs.*.post_name' => 'required|string|max:5000',
            'jobs.*.department_office' => 'nullable|string|max:5000',
            'jobs.*.application_fee' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $circularData = $request->only(['circular_no', 'post_date', 'last_date_of_submission', 'description', 'status']);
            $circularData['created_by'] = auth()->id();

            if ($request->hasFile('document_path')) {
                $circularData['document_path'] = $request->file('document_path')->store('circular_documents', 'public');
            }

            $circular = Circular::create($circularData);

            foreach ($validated['jobs'] as $jobData) {
                $circular->jobs()->create($jobData);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating circular: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('admin.circulars.index')->with('success', 'Circular and job posts created successfully.');
    }

    public function edit(Circular $circular)
    {
        $this->authorize('manage-circulars');
        $circular->load('jobs'); // Eager load the jobs
        return view('admin.circulars.edit', compact('circular'));
    }

    public function update(Request $request, Circular $circular)
    {
        $this->authorize('manage-circulars');

        $validated = $request->validate([
            'circular_no' => 'required|string|max:255|unique:circulars,circular_no,' . $circular->id,
            'post_date' => 'required|date',
            'last_date_of_submission' => 'required|date|after_or_equal:post_date',
            'description' => 'nullable|string',
            'document_path' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'status' => 'required|in:open,closed,archived',
            'jobs' => 'required|array|min:1',
            'jobs.*.id' => 'nullable|integer|exists:jobs,id', // For existing jobs
            'jobs.*.post_name' => 'required|string|max:5000',
            'jobs.*.department_office' => 'nullable|string|max:5000',
            'jobs.*.application_fee' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $circularData = $request->only(['circular_no', 'post_date', 'last_date_of_submission', 'description', 'status']);

            if ($request->hasFile('document_path')) {
                if ($circular->document_path) {
                    Storage::disk('public')->delete($circular->document_path);
                }
                $circularData['document_path'] = $request->file('document_path')->store('circular_documents', 'public');
            }

            $circular->update($circularData);

            $existingJobIds = $circular->jobs->pluck('id')->toArray();
            $submittedJobIds = collect($validated['jobs'])->pluck('id')->filter()->toArray();
            $jobsToDelete = array_diff($existingJobIds, $submittedJobIds);

            Job::destroy($jobsToDelete);

            foreach ($validated['jobs'] as $jobData) {
                if (isset($jobData['id'])) {
                    // Update existing job
                    $job = Job::find($jobData['id']);
                    if ($job) {
                        $job->update($jobData);
                    }
                } else {
                    // Create new job
                    $circular->jobs()->create($jobData);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating circular: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('admin.circulars.index')->with('success', 'Circular and job posts updated successfully.');
    }

    public function destroy(Circular $circular)
    {
        $this->authorize('manage-circulars');

        if ($circular->document_path) {
            Storage::disk('public')->delete($circular->document_path);
        }
        $circular->delete(); // onDelete('cascade') will delete related jobs

        return back()->with('success', 'Circular deleted successfully.');
    }
}
