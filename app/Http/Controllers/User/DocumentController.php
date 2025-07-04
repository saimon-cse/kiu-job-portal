<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', UserDocument::class);
        $documents = auth()->user()->documents()->latest()->get();
        return view('user.document.index', compact('documents'));
    }

    // Note: We don't have create/edit views, just store and destroy.
    // The form is typically on the index page.

    public function store(Request $request)
    {
        $this->authorize('create', UserDocument::class);
        $request->validate([
            'document_type' => 'required|string|max:255',
            'document_file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // 5MB max
        ]);

        $file = $request->file('document_file');
        $path = $file->store('user_documents/' . auth()->id(), 'public');

        auth()->user()->documents()->create([
            'document_type' => $request->document_type,
            'file_path' => $path,
            'mime_type' => $file->getMimeType(),
        ]);

        return redirect()->route('document.index')->with('success', 'Document uploaded successfully.');
    }

    public function destroy(UserDocument $document)
    {
        $this->authorize('delete', $document);

        // Delete the file from storage
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        // Delete the record from the database
        $document->delete();

        return redirect()->route('document.index')->with('success', 'Document deleted successfully.');
    }
}
