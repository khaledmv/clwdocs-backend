<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
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
use App\Services\PdfExtractorService;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    
    public function index()
    {
        $relations = [
            'applications',
            'documentTypes',
            'brands',
            'locations',
            'productCategories',
            'solutions',
        ];

        // All documents including drafts and published
        $documents = Document::with($relations)
            ->latest()
            ->get();
            
        // Draft documents
        $draftDocuments = Document::with($relations)
        ->whereNull('published_at')
        ->latest()
        ->get();

        // Published documents
        $publishedDocuments = Document::with($relations)
        ->whereNotNull('published_at')
        ->latest()
        ->get();

        // Documents in trash
        $documentsWithTrash = Document::onlyTrashed()
            ->with($relations)
            ->latest()
            ->get();

        return view('backend.documents.index', compact('documents', 'publishedDocuments','documentsWithTrash', 'draftDocuments'));
    }



    public function create()
    {
        return view('backend.documents.create', $this->formData());
    }


   public function store(StoreDocumentRequest $request, PdfExtractorService $extractor)
{
    DB::transaction(function () use ($request, $extractor) {

        $fileData = $this->storeDocumentFile($request->file('file'), $extractor);

        $document = Document::create([
            ...$request->safe()->except([
                'file',
                'thumbnail',
                'document_type_ids',
                'brand_ids',
                'application_ids',
                'solution_ids',
                'product_category_ids',
                'location_ids',
            ]),

            ...$fileData,

            'thumbnail_path' => $this->storeThumbnail($request),

            'uploaded_by' => auth()->id(),

            'is_published' => $request->boolean('is_published', true),

            'published_at' => $request->boolean('is_published', true)
                ? now()
                : null,
        ]);

        $this->syncRelations($document, $request);
    });

    return redirect()
        ->route('documents.index')
        ->with([
            'message' => 'Document uploaded successfully.',
            'alert-type' => 'success',
        ]);
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

  public function update( UpdateDocumentRequest $request, Document $document, PdfExtractorService $extractor)
    {
    DB::transaction(function () use ($request, $document, $extractor) {

        $data = $request->safe()->except([
            'file',
            'thumbnail',
            'document_type_ids',
            'brand_ids',
            'application_ids',
            'solution_ids',
            'product_category_ids',
            'location_ids',
        ]);

        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('file')) {

            $newFile = $this->storeDocumentFile(
                $request->file('file'),
                $extractor
            );

            Storage::disk('public')->delete($document->file_path);

            $data = array_merge($data, $newFile);
        }

        if ($request->hasFile('thumbnail')) {

                $thumbnailPath = $this->storeThumbnail($request);

                if ($document->thumbnail_path) {
                    Storage::disk('public')->delete($document->thumbnail_path);
                }

                $data['thumbnail_path'] = $thumbnailPath;
            }


       $data['published_at'] = $data['is_published']
        ? ($document->published_at ?? now())
        : null;

        $document->update($data);

        $this->syncRelations($document, $request);
    });

    return redirect()
        ->route('documents.index')
        ->with([
            'message' => 'Document updated successfully.',
            'alert-type' => 'success',
        ]);
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

    private function storeDocumentFile( UploadedFile $file, PdfExtractorService $extractor ): array
    {
        $path = $file->store('documents', 'public');

        try {
            return [
                'file_path'   => $path,
                'file_name'   => $file->getClientOriginalName(),
                'file_size'   => $file->getSize(),
                'mime_type'   => $file->getMimeType(),
                'pdf_content' => $extractor->extract(
                    storage_path("app/public/{$path}")
                ),
            ];
        } catch (\Throwable $e) {
            Storage::disk('public')->delete($path);

            throw $e;
        }
    }

    private function storeThumbnail(Request $request): ?string
    {
        if (! $request->hasFile('thumbnail')) {
            return null;
        }

        return $request->file('thumbnail')
            ->store('thumbnails', 'public');
    }

    private function syncRelations(Document $document, Request $request): void
    {
        $document->documentTypes()->sync($request->input('document_type_ids', []));
        $document->brands()->sync($request->input('brand_ids', []));
        $document->applications()->sync($request->input('application_ids', []));
        $document->solutions()->sync($request->input('solution_ids', []));
        $document->productCategories()->sync($request->input('product_category_ids', []));
        $document->locations()->sync($request->input('location_ids', []));
    }


}
