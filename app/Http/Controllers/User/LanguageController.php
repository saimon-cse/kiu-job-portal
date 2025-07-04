<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LanguageProficiency;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', LanguageProficiency::class);
        $languages = auth()->user()->languageProficiencies()->orderBy('rank')->get();
        return view('user.language.index', compact('languages'));
    }

    public function create()
    {
        $this->authorize('create', LanguageProficiency::class);
        return view('user.language.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', LanguageProficiency::class);
        $validated = $request->validate([
            'language' => 'required|string|max:255',
            'efficiency' => 'required|string|in:good,excellent,poor',
        ]);
        auth()->user()->languageProficiencies()->create($validated);
        return redirect()->route('language.index')->with('success', 'Language added successfully.');
    }

    public function edit(LanguageProficiency $language)
    {
        $this->authorize('update', $language);
        return view('user.language.edit', compact('language'));
    }

    public function update(Request $request, LanguageProficiency $language)
    {
        $this->authorize('update', $language);
        $validated = $request->validate([
            'language' => 'required|string|max:255',
            'efficiency' => 'required|string|in:good,excellent,poor',
        ]);
        $language->update($validated);
        return redirect()->route('language.index')->with('success', 'Language updated successfully.');
    }

    public function destroy(LanguageProficiency $language)
    {
        $this->authorize('delete', $language);
        $language->delete();
        return redirect()->route('language.index')->with('success', 'Language deleted successfully.');
    }
}
