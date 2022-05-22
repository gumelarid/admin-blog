<?php 
  $role = Auth::User()->role_id;
  $nav  = \App\Models\UserAccessModel::where('role_id',$role)->get();
  $label = \App\Models\LabelModel::all();
  $setting  = \App\Models\SettingModel::first();
?>
<body class="g-sidenav-show  bg-gray-200">
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
      <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">

          @if ($setting->is_logo == 1)
            @if ($setting->logo == 'logo_default.png')
              <img src="<?= url('/assets/logo/logo_default.png') ?>" class="navbar-brand-img h-100" alt="main_logo">
            @else
              <img src="<?= url('/assets/logo/'.$setting->logo) ?>" class="navbar-brand-img h-100" alt="main_logo">
            @endif
          @endif
          
          <span class="ms-1 font-weight-bold text-white">{{ $setting->webname }}</span>
        </a>
      </div>
      <hr class="horizontal light mt-0 mb-2">
      <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">

          @foreach ($label as $lb)
            <li class="nav-item mt-3">
              <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">{{ $lb->label }}</h6>
            </li>
            @foreach ($nav as $item)
              @if ($lb->id_label == $item->navigation->id_label)
                  @if ($setting->is_developer == 0)
                    @if ($item->navigation->nav_id !== 'efdd4ce7-8b53-4b88-a282-5fde11e82acf')
                      <li class="nav-item">
                        <a class="nav-link text-white " href="<?= url($item->navigation->url) ?>">
                          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">{{ $item->navigation->icon }}</i>
                          </div>
                          <span class="nav-link-text ms-1">{{ $item->navigation->name }}</span>
                        </a>
                      </li>
                    @endif
                  @else
                    <li class="nav-item">
                      <a class="nav-link text-white " href="<?= url($item->navigation->url) ?>">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                          <i class="material-icons opacity-10">{{ $item->navigation->icon }}</i>
                        </div>
                        <span class="nav-link-text ms-1">{{ $item->navigation->name }}</span>
                      </a>
                    </li>
                  @endif
              @endif
            @endforeach
          @endforeach
          
        </ul>
      </div>
      <div class="sidenav-footer position-absolute w-100 bottom-0 ">
        <div class="mx-3">
          <a class="btn bg-gradient-primary mt-4 w-100" href="{{ url('logout') }}" onclick="confirm('log out now !')" type="button">Log Out</a>
        </div>
      </div>
    </aside>