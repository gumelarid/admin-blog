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
                <a href="{{ url('/dashboard/page/add') }}"  class="badge badge-sm bg-info">Add Page</a>
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
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Title</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created</th>
                    <th class="text-secondary opacity-7"></th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($data as $item)
                  <tr>
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm">{{ $item->title_page }}</h6>
                            </div>
                          </div>
                    </td>
                    <td class="align-middle text-center">
                      <span class="text-secondary text-xs font-weight-bold">{{ $item->created_at }}</span>
                    </td>
                    <td class="align-middle">
                       
                        
                          <a href="{{ url('/dashboard/page/edit/'.$item->page_id) }}" class="text-secondary font-weight-bold text-xs" >
                              Edit
                          </a> | 
                          <a href="{{ url('/dashboard/page/delete/'.$item->page_id) }}" onclick="return confirm('Are you Sure Delete this Page?')" class="text-secondary font-weight-bold text-xs" >
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
      
@endsection
