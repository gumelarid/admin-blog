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

            <div class="d-flex">
                <button class="btn btn-sm btn-primary mx-3" onclick="reload()">Reload Page</button>
                <small class="py-1">* Please reload to implement change</small>
            </div>
          <div class="table-responsive p-0">
            <table id="datatable" class="table align-items-center justify-content-center mb-0">
              <thead>
                <tr>
                    <th class="align-middle text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Navigation</th>
                    <th class="align-middle text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Access</th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($nav as $item)
                    <tr>
                        <td>
                            <div class="d-flex px-2 py-1">
                                <div>
                                    <i class="material-icons opacity-10">{{ $item->icon }}</i>
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">{{ $item->name }}</h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="align-middle text-center text-sm">
                                <div class="form-check form-switch">
                                    <input onclick="access({{ $item }})" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" 
                                    {{ \App\Models\UserAccessModel::where('nav_id', $item->nav_id)->where('role_id', $role->role_id)->first() ? 'checked' : '' }}>
                                </div>
                            </div>
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


         <script>
            function reload(){
                location.reload();  
            }
           function access(data){
                $.ajax({
                        url:"/dashboard/role/access/checked",
                        type:"POST",

                        data:{
                            _token: '{{ csrf_token() }}',
                            role: <?= $role->role_id ?>,
                            nav: data.nav_id,
                            name: data.name
                        },
                        success:function(response) {
                            if (response.alert == 'success') {
                                toastr.success(response.message);
                            }else{
                                toastr.warning(response.message);
                            }
                            
                        },
                        error:function(){
                            alert("error");
                        }

                });
           }
         </script>
      
@endsection
