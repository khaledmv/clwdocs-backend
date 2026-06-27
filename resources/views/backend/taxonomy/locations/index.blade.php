

@extends('backend.layout')

@section('title')
 Location Taxonomies | Clean Water Documents Library
@endsection

@section('content')

     <!-- Datatables  -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">

                                    <div class="card-header d-flex flex-wrap gap-4 align-items-center">
                                        <h5 class="card-title mb-0">Location Taxonomy</h5>
                                        <h5 class="card-title mb-0"><a href="{{ route('taxonomy.create', 'locations') }}" class="btn btn-outline-primary rounded-pill">Add New</a></h5>
                                        
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
                                             @foreach($items as $item)
                                                <tr>
                                                    <td># {{ $loop->iteration }}</td>
                                                    <td> {{ ucwords($item->name) }} </td>
                                                    <td>{{ $item->slug }}</td>
                                                    <td>
                                                        <div class="d-flex flex-wrap gap-2">
                                                            <a href="{{ route('taxonomy.edit', [
                                                                'type' => $type,
                                                                'id' => $item->id
                                                            ]) }}" class="btn btn-outline-primary rounded-pill">Edit</a>

                                                          
                                                             <form action="{{ route('taxonomy.destroy', [
                                                                'type' => $type,
                                                                'id' => $item->id
                                                                ]) }}" method="POST" class="d-inline delete-form">
                                                                @csrf
                                                                @method('DELETE')

                                                                <button class="btn btn-outline-danger rounded-pill ">
                                                                    Delete
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
@endsection

@push('scripts')


@endpush