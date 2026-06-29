

@extends('backend.layout')

@section('title')
 Documents | Clean Water Documents Library
@endsection

@push('styles')
    <link href="{{ asset('backend/assets/libs/quill/quill.core.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/libs/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/libs/quill/quill.bubble.css') }}" rel="stylesheet">
@endpush


@section('content')

      <div class="card">

        <div class="card-header">
            <h5 class="card-title mb-0">Documents</h5>
        </div><!-- end card header -->

            <div class="card-body">
                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                   <div class="card">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="simpleinput" class="form-label">Title</label>
                                            <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="{{ old('title') }}">
                                             @error('title')
                                                        <span class="text-danger">{{ $message }}</span>
                                             @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-email" class="form-label">URL Slug</label>
                                                <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="slug"
                                                    name="slug"
                                                    placeholder="auto-generated-url-slug"
                                                    value="{{ old('slug') }}"
                                                    >
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="simpleinput" class="form-label">Meta Title</label>
                                            <input type="text" name="meta_title" id="metaTitle" class="form-control" placeholder="Title" value="{{ old('meta_title') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="example-textarea" class="form-label">Meta Description</label>
                                            <textarea class="form-control" name="meta_description" id="example-textarea" rows="3" spellcheck="false">{{ old('meta_description')}}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="example-textarea" class="form-label">Dcoments Description</label>
                                                <textarea name="description"  id="description" style="display: none;"></textarea>
                                                 @error('description')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                <div id="quill-editor" style="height: 400px;">
                                            
                                            </div>
                                        </div> 
                                </div>

                                <div class="col-lg-12">
                                   <div class="row">
                                         <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="simpleinput" class="form-label">Applicaiton</label>
                                            <select id="simpleinput" name="application_id" class="form-select" aria-label="Default select example">
                                               
                                                <option value="">— None —</option>
                                                @foreach ($applications as $item)
                                                    <option value="{{ $item->id }}" data-name="{{ $item->name }}"
                                                        {{ old('application_id', $document->application_id ?? '') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                          <div class="mb-3">
                                            <label for="simpleinput" class="form-label">Brands</label>
                                            <select id="simpleinput" name="brand_id" class="form-select" aria-label="Default select example">
                                               <option value="">— None —</option>
                                                    @foreach ($brands as $item)
                                                        <option value="{{ $item->id }}" data-name="{{ $item->name }}"
                                                            {{ old('brand_id', $document->brand_id ?? '') == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                   </div>
                                </div>
                                <div class="col-lg-12">
                                   <div class="row">
                                         <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="simpleinput" class="form-label">Document Type</label>
                                            <select id="simpleinput" name="document_type_id" class="form-select" aria-label="Default select example">
                                               
                                                <option value="">— None —</option>
                                                @foreach ($documentTypes as $item)
                                                    <option value="{{ $item->id }}" data-name="{{ $item->name }}"
                                                        {{ old('document_type_id', $document->document_type_id ?? '') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                          <div class="mb-3">
                                            <label for="simpleinput" class="form-label">Location</label>
                                            <select id="simpleinput" name="location_id" class="form-select" aria-label="Default select example">
                                                   <option value="">— None —</option>
                                                    @foreach ($locations as $item)
                                                        <option value="{{ $item->id }}" data-name="{{ $item->name }}"
                                                            {{ old('location_id', $document->location_id ?? '') == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                   </div>
                                </div>
                                <div class="col-lg-12">
                                   <div class="row">
                                         <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="simpleinput" class="form-label">Product Category</label>
                                            <select id="simpleinput" name="product_category_id" class="form-select" aria-label="Default select example">
                                               
                                               <option value="">— None —</option>
                                                @foreach ($productCategories as $item)
                                                    <option value="{{ $item->id }}" data-name="{{ $item->name }}"
                                                        {{ old('product_category_id', $document->product_category_id ?? '') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                          <div class="mb-3">
                                            <label for="simpleinput" class="form-label">Solution</label>
                                            <select id="simpleinput" name="solution_id" class="form-select" aria-label="Default select example">
                                                   <option value="">— None —</option>
                                                    @foreach ($solutions as $item)
                                                        <option value="{{ $item->id }}" data-name="{{ $item->name }}"
                                                            {{ old('solution_id', $document->solution_id ?? '') == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                   </div>
                                </div>
                                <div class="col-lg-12">
                                   <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3 row">
                                                <label class="form-label">Thumbnail</label>
                                                <div class="col-lg-12 col-xl-12">
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="mdi mdi-face-man"></i></span>
                                                        <input class="form-control" id="imageInput" type="file" name="thumbnail" aria-describedby="basic-addon1" >
                                                    </div>
                                                    @error('thumbnail')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <img class="rounded-circle avatar-xxl img-thumbnail float-start" alt="image profile" id="preview" style="display:none; max-width: 400px; margin-top: 10px;" alt="Preview">
                
                                                </div>
                                            </div>
                                        </div>
                                    <div class="col-lg-6">
                                             <div class="form-group mb-3 row">
                                                <label class="form-label">Upload pdf </label>
                                                <div class="col-lg-12 col-xl-12">
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="mdi mdi-file"></i></span>
                                                        <input class="form-control" id="imageInput" type="file" name="file" aria-describedby="basic-addon1" >
                                                    </div>
                                                    @error('file')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                    </div>
                                   </div>
                                </div>
                                <!-- Published row--> 
                                <div class="col-lg-12">
                                   <div class="row">
                                        <fieldset class="row mb-3">
                                            <legend class="col-form-label pt-0">Status</legend>

                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    name="is_published"
                                                    id="status_draft"
                                                    value="0"
                                                    @checked(old('is_published', '0') == '0')
                                                >

                                                <label class="form-check-label" for="status_draft">
                                                    Draft
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    name="is_published"
                                                    id="status_published"
                                                    value="1"
                                                    @checked(old('is_published') == '1')
                                                >

                                                <label class="form-check-label" for="status_published">
                                                    Published
                                                </label>
                                            </div>
                                        </fieldset>
                                   </div>
                                </div>
                                <!-- Published row--> 
                            </div>
                        </div>

                    </div>
                                           
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

@endsection



@push('scripts')

        <!-- Quill Editor Js -->
        <script src="{{ asset('backend/assets/libs/quill/quill.min.js')}}"></script>

        <!-- Quill Demo Js -->
        <script src="{{ asset('backend/assets/js/pages/quilljs.init.js')}}"></script>

        <script>

            const title = document.getElementById('title');
            const slug = document.getElementById('slug');

            // Has the user manually edited the slug?
            let slugEdited = slug.value !== '';

            function slugify(text) {
                return text
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
            }

            // Auto-generate slug from title
            title.addEventListener('input', function () {
                if (!slugEdited) {
                    slug.value = slugify(this.value);
                }
            });

            // If the user edits the slug manually, stop auto-generation
            slug.addEventListener('input', function () {
                slugEdited = true;
                slug.value = slugify(this.value);
            });

            // QuilEditor 

           document.querySelector('form').addEventListener('submit', function () {
                document.getElementById('description').value = quill.root.innerHTML;
            });
          quill.root.innerHTML = @json(old('description', $document->description ?? ''));

            //image preview 

                const imageInput = document.getElementById('imageInput');
                const preview = document.getElementById('preview');

                imageInput.addEventListener('change', function() {
                const file = this.files[0];
                
                if (file) {
                    // Enforce basic client-side image validation
                    if (!file.type.startsWith('image/')) {
                        alert('Please select a valid image file.');
                        return;
                    }

                    // Create an optimized local object URL to display the preview instantly
                    preview.src = URL.createObjectURL(file);
                    preview.style.display = 'block';
                }
            });

        </script>

@endpush