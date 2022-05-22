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
                <a href="#" onclick="add()" data-bs-toggle="modal" data-bs-target="#modal-form" class="badge badge-sm bg-info">Add Navigation</a>
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
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Navigation</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Url</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                    <th class="text-secondary opacity-7"></th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($data as $item)
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div>
                            <i class="material-icons opacity-10">{{ $item->icon }}</i>
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm">{{ $item->name }}</h6>
                          <p>Label : {{ $item->label->label }}</p>
                        </div>
                      </div>
                    </td>
                    <td>
                        <p class="text-xs font-weight-bold mb-0">{{ $item->url }}</p>
                    </td>
                    <td class="align-middle text-center text-sm">
                      @if ($item->is_active == 1)
                        <span class="badge badge-sm bg-gradient-success">Active</span>
                      @else
                        <span class="badge badge-sm bg-gradient-secondary">Disable</span>
                      @endif
                    </td>
                    <td class="align-middle">
                        @if ($item->is_active == 0)
                          <a href="<?= url('dashboard/navigation/status?id='.$item->nav_id.'&status='.$item->is_active) ?>" class="text-secondary font-weight-bold text-xs" >
                            Active
                          </a> | 
                        @else
                          <a href="<?= url('dashboard/navigation/status?id='.$item->nav_id.'&status='.$item->is_active) ?>" class="text-secondary font-weight-bold text-xs" >
                            Disable
                          </a> | 
                        @endif
                       
                        <a href="#" onclick="edit({{ $item }})" class="text-secondary font-weight-bold text-xs" >
                            Edit
                        </a> | 
                        <a href="{{ url('/dashboard/navigation/delete/'.$item->nav_id) }}" onclick="return confirm('Are you Sure Delete this Navigation?')" class="text-secondary font-weight-bold text-xs" >
                            Delete
                        </a>
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
                      <h5 id="header-form">Add Navigation</h5>
                    </div>
                    <div class="card-body">
                      <form id="link" action="{{ url('/dashboard/navigation/add') }}" method="POST" role="form text-left">
                        @csrf
                        <span>icon can be seen in the following <a href="https://fonts.google.com/icons">Click Here</a>, copy the name of the icon in the field below</span>
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" value="{{ old('name') }}" required>
                        </div>
                        <div class="input-group input-group-outline my-3">
                          <select id="label" class="form-select p-3" name="label" aria-label="Default select example" required>
                            <option selected disabled>Select Label</option>
                            @foreach ($label as $r)
                              <option value="{{ $r->id_label }}">{{ $r->label }}</option>
                            @endforeach
                            
                          </select>
                        </div>
                        <div class="input-group input-group-outline my-3">
                          <label class="form-label">Url</label>
                          <input type="text" name="url" id="url" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" value="{{ old('url') }}" required>
                        </div>
                        <div class="input-group input-group-outline my-3">
                          <label class="form-label">Icon</label>
                          <input type="text" name="icon" id="icon" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" required>
                        </div>
                        <div class="text-center">
                          <button type="submit" id="btn_nav" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0">Save Navigation</button>
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
              $('#header-form').text('Add Navigation')
              $('#btn_user').text('Save Navigation')
             
              var link = $('#link').attr('action', `<?php echo url('/dashboard/navigation/add'); ?>`);
              $('#name').val('')
              $('#url').val('')
              $('#icon').val('')
              $('#label').val('Select Label')
           }

           function edit(data){
              $('#modal-form').modal('show');
              $('#header-form').text('Edit Navigation')
              $('#btn_user').text('Update Navigation')
             
              var link = $('#link').attr('action', `<?php echo url('/dashboard/navigation/edit/${data.nav_id}'); ?>`);
              $('#name').val(data.name)
              $('#url').val(data.url)
              $('#icon').val(data.icon)
              $('#label').val(data.label.id_label)
           }
         </script>
      
@endsection
