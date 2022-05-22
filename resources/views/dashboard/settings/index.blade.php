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
          
            <form action="{{ url('/dashboard/setting/save') }}" method="POST" class="p-3" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_setting" value="{{ $setting[0]->id_setting }}">
                <div class="row">
                  <div class="col-md-6">
                    <div class="input-group input-group-outline my-3">
                      <label class="form-label">Title</label>
                      <input type="text" name="title" value="{{ $setting[0]->webname }}" class="form-control">
                    </div>

                    <div class="input-group input-group-dynamic">
                        <textarea name="description" class="form-control" rows="5" placeholder="Description" spellcheck="false">{{ $setting[0]->description }}</textarea>
                    </div>
                   
                  </div>
                  <div class="col-md-6">
                    <span class="mb-1" style="color: red; font-size: 12px;">*if enabled, you can change access menu and manag navigation</span>
                    <div class="form-check form-switch">
                        <input name="is_developer" class="form-check-input" type="checkbox" {{ $setting[0]->is_developer == 1 ? 'checked' : '' }} >
                        <label class="form-check-label" for="flexSwitchCheckDefault">Developer Mode</label>
                        
                    </div>

                    <span class="mb-1" style="color: red; font-size: 12px;">*if enabled, logo not show in header</span>
                    <div class="form-check form-switch">
                        <input name="is_logo" class="form-check-input" type="checkbox"   {{ $setting[0]->is_logo == 1 ? 'checked' : '' }} >
                        <label class="form-check-label" for="flexSwitchCheckDefault">Activate Logo</label>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="example-color-input" class="form-control-label">Logo</label>
                        <input name="logo" class="form-control" type="file" id="example-color-input">
                    </div>

                    <hr>
                    <div class="input-group input-group-dynamic">
                        <textarea name="meta" class="form-control" rows="5" placeholder="Meta Description" spellcheck="false">{{ $setting[0]->meta_description }}</textarea>
                    </div>
                  </div>
                </div>

                <div>
                    <button class="btn btn-primary" type="submit">Save Setting</button>
                </div>

            </form>
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
