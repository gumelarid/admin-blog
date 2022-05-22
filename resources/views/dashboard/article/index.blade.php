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
                <a href="{{ url('/dashboard/article/add') }}"  class="badge badge-sm bg-info">Add Article</a>
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
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Title</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">View</th>
                    <th class="text-secondary opacity-7"></th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($data as $item)
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div>
                          <img src="../assets/profile/{{ $item->user->profile }}" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm">{{ $item->user->user_name }}</h6>
                          <p>{{ $item->created_at }}</p>
                        </div>
                      </div>
                    </td>
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm">{{ $item->title_article }}</h6>
                              <p>{{ $item->category->category }}</p>
                            </div>
                          </div>
                    </td>
                    <td class="align-middle text-center text-sm">
                      @if ($item->status == 1)
                        <span class="badge badge-sm bg-gradient-success">Publish</span>
                      @else
                        <span class="badge badge-sm bg-gradient-secondary">Unpublish</span>
                      @endif
                    </td>
                    <td class="align-middle text-center">
                      <span class="text-secondary text-xs font-weight-bold">{{ $item->views }}</span>
                    </td>
                    <td class="align-middle">
                       
                        
                          <a href="{{ url('/dashboard/article/edit/'.$item->article_id) }}" class="text-secondary font-weight-bold text-xs" >
                              Edit
                          </a> | 
                          <a href="{{ url('/dashboard/article/delete/'.$item->article_id) }}" onclick="return confirm('Are you Sure Delete this Article?')" class="text-secondary font-weight-bold text-xs" >
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
