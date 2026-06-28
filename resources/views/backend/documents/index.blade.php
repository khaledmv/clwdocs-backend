

@extends('backend.layout')

@section('title')
 Documents | Clean Water Documents Library
@endsection

@section('content')




<div class="content">

                    <!-- Start Content-->
                  
                        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-18 fw-semibold m-0">Documents</h4>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">

                                    <div class="card-body">


                                        <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active p-2" id="profile_about_tab" data-bs-toggle="tab" href="#profile_about" role="tab" aria-selected="true">
                                                    <span class="d-block d-sm-none"><i class="mdi mdi-information"></i></span>
                                                    <span class="d-none d-sm-block">Published</span>
                                                </a>
                                            </li>

                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link p-2" id="portfolio_education_tab" data-bs-toggle="tab" href="#profile_education" role="tab" aria-selected="false" tabindex="-1">
                                                    <span class="d-block d-sm-none"><i class="mdi mdi-school"></i></span>
                                                    <span class="d-none d-sm-block">Trash</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content text-muted bg-white">
                                            <div class="tab-pane active show pt-4" id="profile_about" role="tabpanel" aria-labelledby="profile_about_tab">
                                                   <!-- Datatables  -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card">

                                                        <div class="card-header d-flex flex-wrap gap-4 align-items-center">
                                                            <h5 class="card-title mb-0">Documents</h5>
                                                            <h5 class="card-title mb-0"><a href="{{ route('documents.create') }}" class="btn btn-outline-primary rounded-pill">Add New</a></h5>
                                                            
                                                        </div><!-- end card header -->

                                                        <div class="card-body">
                                                            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                                                                <thead>
                                                                <tr>
                                                                    <th>SL.</th>
                                                                    <th>Title</th>
                                                                    <th>Slug</th>
                                                                    <th>Action</th>
                                                                
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($documents as $item)
                                                                    <tr>
                                                                        <td># {{ $loop->iteration }}</td>
                                                                        <td> {{ ucwords($item->title) }} </td>
                                                                        <td>{{ $item->slug }}</td>
                                                                        <td>
                                                                            <div class="d-flex flex-wrap gap-2">
                                                                                <a href="{{ route('documents.edit', $item->id ) }}" class="btn btn-outline-primary rounded-pill">Edit</a>

                                                                            
                                                                                <form action="{{ route('documents.destroy', $item->id ) }}" method="POST" class="d-inline trash-form">
                                                                                    @csrf
                                                                                    @method('DELETE')

                                                                                    <button class="btn btn-outline-danger rounded-pill ">
                                                                                        Moved to trash
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                              

                                            </div><!-- Published -->
                                            
                                            <!-- Trashed -->
                                            <div class="tab-pane pt-4" id="profile_education" role="tabpanel" aria-labelledby="portfolio_education_tab">
                                             <div class="row">
                                                <div class="col-12">
                                                    <div class="card">

                                                        <div class="card-body">
                                                            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                                                                <thead>
                                                                <tr>
                                                                    <th>SL.</th>
                                                                    <th>Title</th>
                                                                    <th>Slug</th>
                                                                    <th>Action</th>
                                                                
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($documentsWithTrash as $itemWithTrash)
                                                                    <tr>
                                                                        <td># {{ $loop->iteration }}</td>
                                                                        <td> {{ ucwords($itemWithTrash->title) }} </td>
                                                                        <td>{{ $itemWithTrash->slug }}</td>
                                                                        <td>
                                                                            <div class="d-flex flex-wrap gap-2">
                                                                                {{-- <a href="{{ route('documents.restore', $itemWithTrash->id ) }}" class="btn btn-outline-primary rounded-pill">Restore</a> --}}

                                                                            
                                                                                <form action="{{ route('documents.restore', $itemWithTrash->id ) }}" method="POST" class="d-inline restore-form">
                                                                                    @csrf
                                                                                   
                                                                                    <button class="btn btn-outline-primary rounded-pill">
                                                                                        Restore
                                                                                    </button>
                                                                                </form>

                                                                                <form action="{{ route('documents.force-delete', $itemWithTrash->id ) }}" method="POST" class="d-inline delete-form">
                                                                                    @csrf
                                                                                    @method('DELETE')

                                                                                    <button class="btn btn-outline-danger rounded-pill ">
                                                                                        Delete permanently
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            </div> <!-- end education -->

                                   

                                        </div> <!-- Tab panes -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> 





















@endsection

@push('scripts')


@endpush