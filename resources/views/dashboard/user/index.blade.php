@extends('dashboard.template.index')

<style>
    .datatables_length{
        padding-left:20px 
    }

    .datatables_filter{
        padding-right: 20px
    }

    .datatables_info{
        padding-left:20px 
    }

    .datatables_paginate{
        padding-right: 20px
    }

    .bg-info:hover{
        color: rgb(192, 183, 183)
    }
</style>

@section('content')
        @include('dashboard.template.content.header')
     
        <div class="card-body px-0 pb-2">
            <div class="p-3">
                <a href="#" onclick="add()" data-bs-toggle="modal" data-bs-target="#modal-form" class="badge badge-sm bg-info">Add Users</a>
            </div>


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
          <div class="table-responsive p-0">
            <table id="datatable" class="table align-items-center justify-content-center mb-0">
              <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Author</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Level</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Employed</th>
                    <th class="text-secondary opacity-7"></th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($data as $item)
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div>
                          <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm">{{ $item->name }}</h6>
                          <p class="text-xs text-secondary mb-0">{{ $item->email }}</p>
                        </div>
                      </div>
                    </td>
                    <td>
                        <p class="text-xs font-weight-bold mb-0">{{ $item->role->role }}</p>
                    </td>
                    <td class="align-middle text-center text-sm">
                      @if ($item->status == 1)
                        <span class="badge badge-sm bg-gradient-success">Active</span>
                      @else
                        <span class="badge badge-sm bg-gradient-secondary">Disable</span>
                      @endif
                    </td>
                    <td class="align-middle text-center">
                      <span class="text-secondary text-xs font-weight-bold">{{ $item->created_at }}</span>
                    </td>
                    <td class="align-middle">
                        @if (Auth::User()->user_id == $item->user_id)
                          <a href="#" onclick="edit({{ $item }})" class="text-secondary font-weight-bold text-xs" >
                            Edit
                          </a>
                        @else
                          @if ($item->status == 0)
                            <a href="<?= url('dashboard/user/status?user='.$item->user_id.'&status='.$item->status) ?>" class="text-secondary font-weight-bold text-xs" >
                              Active
                            </a> | 
                          @else
                            <a href="<?= url('dashboard/user/status?user='.$item->user_id.'&status='.$item->status) ?>" class="text-secondary font-weight-bold text-xs" >
                              Disable
                            </a> | 
                          @endif
                        
                          <a href="#" onclick="edit({{ $item }})" class="text-secondary font-weight-bold text-xs" >
                              Edit
                          </a> | 
                          <a href="{{ url('/dashboard/user/delete/'.$item->user_id) }}" onclick="return confirm('Are you Sure Delete this User?')" class="text-secondary font-weight-bold text-xs" >
                              Delete
                          </a>
                        @endif
                    </td>
                  </tr>
                @endforeach

              </tbody>
            </table>
          </div>
        </div>
        @include('dashboard.template.content.footer')


        <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
              <div class="modal-content">
                <div class="modal-body p-0">
                  <div class="card card-plain">
                    <div class="card-header pb-0 text-left">
                      <h5 id="header-form">Add Users</h5>
                    </div>
                    <div class="card-body">
                      <form id="link" action="{{ url('/dashboard/user/add') }}" method="POST" role="form text-left">
                        @csrf
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" value="{{ old('name') }}" required>
                        </div>
                        <div class="input-group input-group-outline my-3">
                          <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="email" required>
                        </div>
                        <div class="input-group input-group-outline my-3">
                          <label id="lb-pass" class="form-label">Password</label>
                          <input type="password" name="password" id="password" min="8" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" required>
                        </div>
                        <div class="input-group input-group-outline my-3">
                          <select id="role" class="form-select p-3" name="role" aria-label="Default select example" required>
                            <option selected disabled>Select Role</option>
                            @foreach ($role as $r)
                              <option value="{{ $r->role_id }}">{{ $r->role }}</option>
                            @endforeach
                            
                          </select>
                        </div>
                        <div class="text-center">
                          <button type="submit" id="btn_user" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0">Save User</button>
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


         <script>
           function add(){
              $('#modal-form').modal('show');
              $('#header-form').text('Add User')
              $('#btn_user').text('Save User')
              $('#lb-pass').text('Password')
             
              var link = $('#link').attr('action', `<?php echo url('/dashboard/user/add'); ?>`);
              $('#password').attr('required', '');
              $('#email').removeAttr('disabled')
              $('#name').val('')
              $('#email').val('')
              $('#name').val({{ old('name') }})
              $('#email').val({{ old('email') }})
              $('#password').val('')
              $('#role').val('Select Role')
           }

           function edit(data){
              $('#modal-form').modal('show');
              $('#header-form').text('Edit User')
              $('#btn_user').text('Update User')
              $('#lb-pass').text('New Password')
             
              var link = $('#link').attr('action', `<?php echo url('/dashboard/user/edit/${data.user_id}'); ?>`);

              $('#password').removeAttr('required')
              $('#email').attr('disabled', '');
              $('#password').val('')
              $('#name').val(data.user_name)
              $('#email').val(data.email)
              $('#role').val(data.role_id)
              
           }
         </script>
      
@endsection
