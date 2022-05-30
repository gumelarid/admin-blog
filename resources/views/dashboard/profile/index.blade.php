@extends('dashboard.template.index')

@section('content')
    @include('dashboard.template.content.header')

    <div class="card-body px-0 pb-2 mx-3 mx-md-4">
        @if ($errors->any())
            <div class="p-3">
                @foreach ($errors->all() as $error)
                    {{-- <div class="alert alert-danger" style="color: white">{{ $error }}</div> --}}
                    <div class="alert alert-primary alert-dismissible text-white" role="alert">
                        <span class="text-sm">{{ $error }}</span>
                        <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>
                @endforeach
            </div>
        @endif
            
        <div class="row gx-4 mb-2">
            <div class="col-auto d-flex flex-column">
              <div class="avatar avatar-xl position-relative">
                @if ($profile->profile !== 'default.png')
                  <img src="<?= url('/assets/profile/'.$profile->profile) ?>" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                @else
                    <img src="<?= url('/assets/profile/default.png') ?>" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                @endif
              </div>
              @if ($profile->profile !== 'default.png')
                <div class="text-center">
                  <a href="{{ url('/dashboard/profile/reset?id='.Auth::user()->user_id) }}">Reset</a>
                </div>
              @endif
            </div>
            <div class="col-auto my-auto">
              <div class="h-100">
                <h5 class="mb-1">
                  {{ $profile->user_name }}
                </h5>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="row">
              <div class="col-12 col-xl-8">
                <div class="card card-plain h-100">
                  <div class="card-header pb-0 p-3">
                    <div class="row">
                      <div class="col-md-8 d-flex align-items-center">
                        <h6 class="mb-0">Profile Information</h6>
                      </div>
                      <div class="col-md-4 text-end">
                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#modal-form">
                          <i class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Profile"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body p-3">
                    <p class="text-sm">
                      {{ $detail->detail }}
                    </p>
                    <hr class="horizontal gray-light my-4">
                    <ul class="list-group">
                      <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Full Name:</strong> &nbsp; {{ $profile->user_name }}</li>
                      <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Email:</strong> &nbsp; {{ $profile->email }}</li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-12 col-xl-4">
                <div class="card card-plain h-100">
                  <div class="card-body p-3">
                    <li class="list-group-item border-0 ps-0 pb-0">
                        <strong class="text-dark text-sm">Social:</strong> &nbsp;
                        <a class="btn btn-facebook btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                          <i class="fab fa-facebook fa-lg"></i>
                        </a>
                        <a class="btn btn-twitter btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                          <i class="fab fa-twitter fa-lg"></i>
                        </a>
                        <a class="btn btn-instagram btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                          <i class="fab fa-instagram fa-lg"></i>
                        </a>
                      </li>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>

    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
          <div class="modal-content">
            <div class="modal-body p-0">
              <div class="card card-plain">
                <div class="card-header pb-0 text-left">
                  <h5 id="header-form">Add Users</h5>
                </div>
                <div class="card-body">
                  <form id="link" action="{{ url('/dashboard/profile/update') }}" method="POST" role="form text-left" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $profile->user_id }}">
                    <div class="input-group input-group-static mb-4">
                        <label>Profile</label>
                        <input type="file" class="form-control" name="profile">
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" value="{{ $profile->user_name }}" required>
                    </div>
                    <div class="input-group input-group-outline my-3">
                      <input type="email" name="email" id="email" class="form-control" value="{{ $profile->email }}" placeholder="email" disabled>
                    </div>
                    <div class="input-group input-group-outline my-3">
                      <label id="lb-pass" class="form-label">New Password</label>
                      <input type="password" name="password" id="password" min="8" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>
                    <div class="input-group input-group-outline my-3">
                      <textarea name="detail" cols="30" rows="10" class="form-control">
                        {{ $detail->detail }}
                      </textarea>
                    </div>
                    <div class="text-center">
                      <button type="submit" id="btn_user" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0">Update User</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <script>
        @if(Session::has('message'))
         var type = "{{ Session::get('alert-type', 'info') }}";
         switch(type){
             case 'info':
                 toastr.info("{{ Session::get('message') }}");
                 break;
     
             case 'warning':
                 toastr.warning("{{ Session::get('message') }}");
                 break;
     
             case 'success':
                 toastr.success("{{ Session::get('message') }}");
                 break;
     
             case 'error':
                 toastr.error("{{ Session::get('message') }}");
                 break;
         }
       @endif
     </script>
    @include('dashboard.template.content.footer')
@endsection