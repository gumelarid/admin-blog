@extends('dashboard.template.index')

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
          
            <form action="{{ url('/dashboard/article/save') }}" method="POST" class="p-3" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="col-md-8">
                    <div class="input-group input-group-outline my-3">
                      <label class="form-label">Title</label>
                      <input type="text" name="title" value="{{ old('title') }}"  class="form-control">
                    </div>

                    <div class="input-group input-group-dynamic">
                        <textarea id="description" name="description" class="form-control" rows="5" placeholder="Description" spellcheck="false">{{ old('description') }}</textarea>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                        <label for="example-color-input" class="form-control-label">Thumbnail</label>
                        <input name="thumb" class="form-control" type="file" id="example-color-input">
                    </div>
                    <hr>
                  
                    <div class="input-group input-group-static mb-4">
                        <label for="exampleFormControlSelect1" class="ms-0">Category</label>
                        <select style="padding: 10px" name="category" class="form-control" id="exampleFormControlSelect1" value="{{ old('category') }}">
                          <option selected disabled>Select Category</option>
                          @foreach ($category as $ca)
                            <option value="{{ $ca->category_id }}">{{ $ca->category }}</option>
                          @endforeach
                        </select>
                      </div>
                    <div class="form-check form-switch">
                        <input name="is_publish" class="form-check-input" type="checkbox" >
                        <label class="form-check-label" for="flexSwitchCheckDefault">Publish</label>
                    </div>
                    <hr>

                    <div class="input-group input-group-dynamic">
                        <textarea name="meta" class="form-control" rows="5" placeholder="Meta Description" spellcheck="false"></textarea>
                    </div>
                    
                    <br>
                    <button class="btn btn-primary" type="submit">Save Article</button>
                  </div>
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

    
<script>
  const table = '<p>This table uses features of the non-editable plugin to make the text in the<br><strong>top row</strong> and <strong>left column</strong> uneditable.</p>' +
'    <table style="width: 60%; border-collapse: collapse;" border="1"> ' +
'        <caption class="mceNonEditable">Ephox Sales Analysis</caption> ' +
'       <tbody> ' +
'          <tr class="mceNonEditable"> ' +
'                <th style="width: 40%;">&nbsp;</th><th style="width: 15%;">Q1</th> ' +
'                <th style="width: 15%;">Q2</th><th style="width: 15%;">Q3</th> ' +
'                <th style="width: 15%;">Q4</th> ' +
'            </tr> ' +
'            <tr> ' +
'                <td class="mceNonEditable">East Region</td> ' +
'                <td>100</td> <td>110</td> <td>115</td> <td>130</td> ' +
'            </tr> ' +
'            <tr> ' +
'                <td class="mceNonEditable">Central Region</td> ' +
'                <td>100</td> <td>110</td> <td>115</td> <td>130</td> ' +
'            </tr> ' +
'            <tr> ' +
'                <td class="mceNonEditable">West Region</td> ' +
'                <td>100</td> <td>110</td> <td>115</td> <td>130</td> ' +
'            </tr> ' +
'        </tbody> ' +
'    </table>';
const table2 = '<div> ' +
'        <p>' +
'            Templates are a great way to help content authors get started creating content.  You can define the HTML for the template and ' +
'            then when the author inserts the template they have a great start towards creating content! ' +
'        </p> ' +
'        <p> ' +
'            In this example we create a simple table for providing product details for a product page on your web site.  The headings are ' +
'            made non-editable by loading the non-editable plugin and placing the correct class on the appropriate table cells. ' +
'        </p> ' +
'        <table style="width:90%; border-collapse: collapse;" border="1"> ' +
'        <tbody> ' +
'        <tr style="height: 30px;"> ' +
'            <th class="mceNonEditable" style="width:40%; text-align: left;">Product Name:</td><td style="width:60%;">{insert name here}</td> ' +
'        </tr> ' +
'        <tr style="height: 30px;"> ' +
'            <th class="mceNonEditable" style="width:40%; text-align: left;">Product Description:</td><td style="width:60%;">{insert description here}</td> ' +
'        </tr> ' +
'        <tr style="height: 30px;"> ' +
'            <th class="mceNonEditable" style="width:40%; text-align: left;">Product Price:</td><td style="width:60%;">{insert price here}</td> ' +
'        </tr> ' +
'        </tbody> ' +
'        </table> ' +
'    </div> ';
const demoBaseConfig = {
selector: 'textarea#description',
resize: false,
autosave_ask_before_unload: false,
powerpaste_allow_local_images: true,
plugins: [
  'a11ychecker', 'advcode', 'advlist', 'anchor', 'autolink', 'codesample', 'fullscreen', 'help',
  'image', 'editimage', 'tinydrive', 'lists', 'link', 'media', 'powerpaste', 'preview',
  'searchreplace', 'table', 'template', 'tinymcespellchecker', 'visualblocks', 'wordcount'
],
templates: [
  {
    title: 'Non-editable Example',
    description: 'Non-editable example.',
    content: table
  },
  {
    title: 'Simple Table Example',
    description: 'Simple Table example.',
    content: table2
  }
],
toolbar: 'insertfile a11ycheck undo redo | bold italic | forecolor backcolor | template codesample | alignleft aligncenter alignright alignjustify | bullist numlist | link image',
spellchecker_dialog: true,
spellchecker_ignore_list: ['Ephox', 'Moxiecode'],
tinydrive_demo_files_url: '../_images/tiny-drive-demo/demo_files.json',
tinydrive_token_provider: (success, failure) => {
  success({ token: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJqb2huZG9lIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.Ks_BdfH4CWilyzLNk8S2gDARFhuxIauLa8PwhdEQhEo' });
},
content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
};
tinymce.init(demoBaseConfig);
</script>
@endsection
