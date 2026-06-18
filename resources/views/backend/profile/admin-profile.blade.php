
@extends('backend.layout')

@section('title')
 Profile| Clean Water Documents Library
@endsection

@section('content')

                <div class="content">

                    <!-- Start Content-->
                    <div class="container-xxl">

                        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-18 fw-semibold m-0">Profile</h4>
                            </div>
                        </div>
                       @if(session('success'))
                            <div class="alert alert-success" id="success-alert">
                                {{ session('success') }}
                            </div>

                        @endif

                        <!-- start row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">

                                    <div class="card-body">

                                        <div class="align-items-center">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ (!empty($profileData->photo)) ? asset('upload/user_images/' . $profileData->photo ) : asset('/upload/user_images/user-avater.png') }}" class="rounded-circle avatar-xxl img-thumbnail float-start" alt="image profile">
            
                                                <div class="overflow-hidden ms-4">
                                                    <h4 class="m-0 text-dark fs-20">{{ ucwords($profileData->name); }}</h4>
                                                    <p class="my-1 text-muted fs-16">{{ ucfirst($profileData->role); }}</p>
                                                    <span class="fs-15"><i class="mdi mdi-message me-2 align-middle"></i>Speaks: <span>English <span class="badge bg-primary-subtle text-primary px-2 py-1 fs-13 fw-normal">Email</span>{{ ucfirst($profileData->email); }} </span></span>
                                                </div>
                                            </div>
                                        </div>

                                        <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                                      
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link p-2 active" id="setting_tab" data-bs-toggle="tab" href="#profile_setting" role="tab" aria-selected="true">
                                                    <span class="d-block d-sm-none"><i class="mdi mdi-school"></i></span>
                                                    <span class="d-none d-sm-block">Setting</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content text-muted bg-white">
                                           

                                            <div class="tab-pane pt-4 active show" id="profile_setting" role="tabpanel" aria-labelledby="setting_tab">
                                                <div class="row">

                                                    <div class="row">
                                                        <div class="col-lg-6 col-xl-6">
                                                            <div class="card border mb-0">

                                                                <div class="card-header">
                                                                    <div class="row align-items-center">
                                                                        <div class="col">                      
                                                                            <h4 class="card-title mb-0">Personal Information</h4>                      
                                                                        </div><!--end col-->                                                       
                                                                    </div>
                                                                </div>
                                                            <form  action=" {{ route('profile.store') }} " method="post" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="card-body">
                                                                    <div class="form-group mb-3 row">
                                                                        <label class="form-label">Name</label>
                                                                        <div class="col-lg-12 col-xl-12">
                                                                            <input class="form-control" type="text" name="name" value="{{$profileData->name}}">
                                                                            @error('name')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group mb-3 row">
                                                                        <label class="form-label">Email Address</label>
                                                                        <div class="col-lg-12 col-xl-12">
                                                                            <div class="input-group">
                                                                                <span class="input-group-text"><i class="mdi mdi-email"></i></span>
                                                                                <input type="text" class="form-control" value="{{$profileData->email}}"  name="email" placeholder="Email" aria-describedby="basic-addon1">
                                                                                
                                                                            </div>
                                                                            @error('email')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                            

                                                                    <div class="form-group mb-3 row">
                                                                        <label class="form-label">Contact Phone</label>
                                                                        <div class="col-lg-12 col-xl-12">
                                                                            <div class="input-group">
                                                                                <span class="input-group-text"><i class="mdi mdi-phone-outline"></i></span>
                                                                                <input class="form-control" type="text" placeholder="Phone" name="phone" aria-describedby="basic-addon1" value="{{$profileData->phone}}">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group mb-3 row">
                                                                        <label class="form-label">Address</label>
                                                                        <div class="col-lg-12 col-xl-12">
                                                                            <div class="input-group">    
                                                                           <textarea class="form-control" name="address" rows="2">
                                                                             {{ $profileData->address }}
                                                                           </textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                     <div class="form-group mb-3 row">
                                                                        <label class="form-label">Profile photo</label>
                                                                        <div class="col-lg-12 col-xl-12">
                                                                            <div class="input-group">
                                                                                <span class="input-group-text"><i class="mdi mdi-face-man"></i></span>
                                                                                <input class="form-control" id="imageInput" type="file" name="photo" aria-describedby="basic-addon1" >
                                                                            </div>
                                                                            @error('photo')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    
                                                                    <div class="align-items-center">
                                                                        <div class="d-flex align-items-center">
                                                                            <img class="rounded-circle avatar-xxl img-thumbnail float-start" alt="image profile" id="preview" style="display:none; max-width: 300px; margin-top: 10px;" alt="Preview">
                                        
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row" style="margin-top:30px;">
                                                                        <div class="col-lg-12 col-xl-12">
                                                                            <button type="submit" class="btn btn-primary">Saved Changes</button>
                                                                        </div>
                                                                    </div>

                                                                </div><!--end card-body-->
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 col-xl-6">
                                                            <div class="card border mb-0">

                                                                <div class="card-header">
                                                                    <div class="row align-items-center">
                                                                        <div class="col">                      
                                                                            <h4 class="card-title mb-0">Change Password</h4>                      
                                                                        </div><!--end col-->                                                       
                                                                    </div>
                                                                </div>

                                                                <div class="card-body mb-0">
                                                                    <div class="form-group mb-3 row">
                                                                        <label class="form-label">Old Password</label>
                                                                        <div class="col-lg-12 col-xl-12">
                                                                            <input class="form-control" type="password" placeholder="Old Password">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group mb-3 row">
                                                                        <label class="form-label">New Password</label>
                                                                        <div class="col-lg-12 col-xl-12">
                                                                            <input class="form-control" type="password" placeholder="New Password">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group mb-3 row">
                                                                        <label class="form-label">Confirm Password</label>
                                                                        <div class="col-lg-12 col-xl-12">
                                                                            <input class="form-control" type="password" placeholder="Confirm Password">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <div class="col-lg-12 col-xl-12">
                                                                            <button type="submit" class="btn btn-primary">Change Password</button>
                                                                            <button type="button" class="btn btn-danger">Cancel</button>
                                                                        </div>
                                                                    </div>

                                                                </div><!--end card-body-->
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div> <!-- end settings -->

                                        </div> <!-- Tab panes -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->


                    </div> <!-- container-fluid -->
                </div> 

@endsection

@push('scripts')
<script>

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

    // Session alert auto hidden
      setTimeout(() => {
          document.getElementById('success-alert').style.display = 'none';
       }, 3000);


</script>

@endpush