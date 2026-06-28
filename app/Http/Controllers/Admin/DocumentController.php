<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\StoreDocumentRequest;
use App\Http\Requests\Admin\UpdateDocumentRequest;
use App\Models\Document;
use App\Models\Application;
use App\Models\Brand;
use App\Models\DocumentType;
use App\Models\Location;
use App\Models\ProductCategory;
use App\Models\Solution;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    
    public function index()
    {
        $documents = Document::with([
            'application', 'documentType', 'brand', 'location','productCategory','solution'
            ])
            ->latest()
            ->paginate(20);

        $documentsWithTrash = Document::onlyTrashed()
            ->with(['application', 'documentType', 'brand', 'location','productCategory','solution'])
            ->latest()
            ->paginate(20);

        return view('backend.documents.index', compact('documents', 'documentsWithTrash'));
    }



    public function create()
    {
        return view('backend.documents.create', $this->formData());
    }


    public function store(StoreDocumentRequest $request)
    {
        $file = $request->file('file');

        $filePath = $file->store('documents', 'public');

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Document::create([
            ...$request->safe()->except(['file', 'thumbnail']),
            'file_path'    => $filePath,
            'file_name'    => $file->getClientOriginalName(),
            'file_size'    => $file->getSize(),
            'mime_type'    => $file->getMimeType(),
            'thumbnail_path' => $thumbnailPath,
            'uploaded_by'  => auth()->id(),
            'is_published' => $request->boolean('is_published', true),
            'published_at' => $request->boolean('is_published', true) ? now() : null,
        ]);

            $notification = array(
            "message" => "Document uploaded successfully.",
            "alert-type" => "success"
            );

        return redirect()->route('documents.index')->with($notification);
    }

    // Edit documets 

    public function edit(Document $document)
    {
        return view('backend.documents.edit', array_merge(
            ['document' => $document],
            $this->formData()
        ));
    }

    // Update documents

        public function update(UpdateDocumentRequest $request, Document $document)
    {
        $data = $request->safe()->except(['file', 'thumbnail']);
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($document->file_path);
            $file = $request->file('file');
            $data['file_path'] = $file->store('documents', 'public');
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
            $data['mime_type'] = $file->getMimeType();
        }

        if ($request->hasFile('thumbnail')) {
            if ($document->thumbnail_path) {
                Storage::disk('public')->delete($document->thumbnail_path);
            }
            $data['thumbnail_path'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        if (isset($data['is_published'])) {
            $data['published_at'] = $data['is_published'] && ! $document->published_at ? now() : $document->published_at;
        }

        $document->update($data);

        $notification = array(
                "message" => "Document updated successfully.",
                "alert-type" => "success"
        );

        return redirect()->route('documents.index')->with($notification);
    }


    // Moved to trash
    public function destroy(Document $document)
    {
        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', 'Document moved to trash.');
    }


    // Restore
    public function restore(int $id)
    {
        $document = Document::withTrashed()->findOrFail($id);
        $document->restore();

        return redirect()->route('documents.index')
            ->with('success', 'Document restored.');
    }


    // Delete permanently 
    public function forceDelete(int $id)
    {
        $document = Document::withTrashed()->findOrFail($id);

        Storage::disk('public')->delete($document->file_path);

        if ($document->thumbnail_path) {
            Storage::disk('public')->delete($document->thumbnail_path);
        }

        $document->forceDelete();

        return redirect()->route('documents.index')
            ->with('success', 'Document permanently deleted.');
    }




    // Helper function
    private function formData(): array
    {
        return [
            'documentTypes'     => DocumentType::orderBy('name')->get(),
            'brands'            => Brand::orderBy('name')->get(),
            'applications'      => Application::orderBy('name')->get(),
            'solutions'         => Solution::orderBy('name')->get(),
            'productCategories' => ProductCategory::orderBy('name')->get(),
            'locations'         => Location::orderBy('name')->get(),
        ];
    }


}
