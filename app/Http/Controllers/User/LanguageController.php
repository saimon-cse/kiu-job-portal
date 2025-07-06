<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LanguageProficiency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'efficiency' => 'required|string',
        ]);
        auth()->user()->languageProficiencies()->create($validated);
        return redirect()->route('language.index')->with('success', 'Language added successfully.');
    }

        /**
     * Reorder the language proficiency records based on a new order of IDs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reorder(Request $request)
    {
        $this->authorize('create', LanguageProficiency::class);

        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer',
        ]);

        $user = Auth::user();

        foreach ($request->order as $index => $languageId) {
            $user->languageProficiencies()
                 ->where('id', $languageId)
                 ->update(['rank' => $index]);
        }

        return response()->json(['status' => 'success', 'message' => 'Language order updated successfully.']);
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
            'efficiency' => 'required|string',
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
