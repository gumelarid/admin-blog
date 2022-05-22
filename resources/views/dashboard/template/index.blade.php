@include('dashboard.template.header')
@include('dashboard.template.sidebar')
@include('dashboard.template.nav')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-12 col-md-10 mx-auto">
            

                @yield('content')

        </div>
    </div>

@include('dashboard.template.footer')


