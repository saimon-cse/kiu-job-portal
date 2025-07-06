<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PublicationType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PublicationTypeController extends Controller
{
    public function index()
    {
        $this->authorize('manage-publication-types');
        $publicationTypes = PublicationType::latest()->paginate(10);
        return view('admin.publication-types.index', compact('publicationTypes'));
    }

    public function create()
    {
        $this->authorize('manage-publication-types');
        return view('admin.publication-types.create');
    }

    public function store(Request $request)
    {
        $this->authorize('manage-publication-types');

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:publication_types,name',
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name']);
        PublicationType::create($validatedData);

        return redirect()->route('admin.publication-types.index')->with('success', 'Publication Type created successfully.');
    }

    public function edit(PublicationType $publicationType)
    {
        $this->authorize('manage-publication-types');
        return view('admin.publication-types.edit', compact('publicationType'));
    }

    public function update(Request $request, PublicationType $publicationType)
    {
        $this->authorize('manage-publication-types');

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('publication_types')->ignore($publicationType->id)],
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name']);
        $publicationType->update($validatedData);

        return redirect()->route('admin.publication-types.index')->with('success', 'Publication Type updated successfully.');
    }

    public function destroy(PublicationType $publicationType)
    {
        $this->authorize('manage-publication-types');

        if ($publicationType->userPublications()->count() > 0) {
            return back()->with('error', 'Cannot delete this type because it is assigned to existing publications.');
        }

        $publicationType->delete();
        return back()->with('success', 'Publication Type deleted successfully.');
    }
}
