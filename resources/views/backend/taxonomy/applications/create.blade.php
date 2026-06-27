

@extends('backend.layout')

@section('title')
 Application Taxonomies | Clean Water Documents Library
@endsection


@section('content')

                                 <div class="card">

                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Application</h5>
                                    </div><!-- end card header -->

                                    <div class="card-body">
                                        <form  action="{{ route('taxonomy.store', 'applications') }}" method="post">
                                           @csrf
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Application Title</label>
                                                <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter application name">
                                                
                                            </div>
                                           
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                    </div>
                                </div>

@endsection



@push('scripts')


@endpush