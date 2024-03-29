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
                <a href="#" onclick="add()" data-bs-toggle="modal" data-bs-target="#modal-form" class="badge badge-sm bg-info">Add Category</a>
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
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                    <th class="text-secondary opacity-7"></th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($data as $item)
                  <tr>
                    <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ $item->category }}</span>
                    </td>
                   
                    <td class="align-middle">
                       
                        <a href="#" onclick="edit({{ $item }})" class="text-secondary font-weight-bold text-xs" >
                            Edit
                        </a> | 
                        <a href="{{ url('/dashboard/category/delete/'.$item->category_id) }}" onclick="return confirm('Are you Sure Delete this Category?')" class="text-secondary font-weight-bold text-xs" >
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
                      <h5 id="header-form">Add Category</h5>
                    </div>
                    <div class="card-body">
                      <form id="link" action="{{ url('/dashboard/category/add') }}" method="POST" role="form text-left">
                        @csrf
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Name Category</label>
                            <input type="text" name="category" id="category" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" value="{{ old('category') }}" required>
                        </div>
                       
                        <div class="text-center">
                          <button type="submit" id="btn_nav" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0">Save Category</button>
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
              $('#header-form').text('Add Category')
              $('#btn_user').text('Save Category')
             
              var link = $('#link').attr('action', `<?php echo url('/dashboard/category/add'); ?>`);
              $('#category').val('')
           }

           function edit(data){
              $('#modal-form').modal('show');
              $('#header-form').text('Edit Category')
              $('#btn_user').text('Update Category')
             
              var link = $('#link').attr('action', `<?php echo url('/dashboard/category/edit/${data.category_id}'); ?>`);
              $('#category').val(data.category)
           }
         </script>
      
@endsection
