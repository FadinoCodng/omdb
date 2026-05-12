<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>MOVIES DASHBOARD &mdash; Stisla</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{  asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{  asset('assets/modules/fontawesome/css/all.min.css') }}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{  asset('assets/modules/jqvmap/dist/jqvmap.min.css') }}">
  <link rel="stylesheet" href="{{  asset('assets/modules/summernote/summernote-bs4.css') }}">
  <link rel="stylesheet" href="{{  asset('assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="{{  asset('assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{  asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{  asset('assets/css/components.css') }}">
<!-- Start GA -->

<!-- /END GA --></head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>

  @include('layouts.header')
  @include('layouts.menu')
  <!-- Main Content -->
<div class="main-content">
    <section class="section">

        <div class="section-header">
            <h1>{{ __('Movies') }}</h1>

            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="#">{{ __('Dashboard') }}</a>
                </div>

                <div class="breadcrumb-item">
                    <a href="#">{{ __('Movies') }}</a>
                </div>

                <div class="breadcrumb-item active">
                    {{ __('All Movies') }}
                </div>
            </div>
        </div>

        <div class="section-body">

            <div class="card">

                <div class="card-header">
                    <h4>{{ __('All Movies') }}</h4>

                    <div class="card-header-form">
                        <form>

                            <div class="input-group">

                                <input 
                                    type="text"
                                    class="form-control"
                                    placeholder="{{ __('Search movies') }}"
                                >

                                <div class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-striped">

                            <thead>
                                <tr>
                                    <th>{{ __('Poster') }}</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Year') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">

                                        <i class="fas fa-search fa-2x mb-2"></i>

                                        <br>

                                        {{ __('Enter keyword') }}

                                    </td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </section>
</div>
  @include('layouts.footer')
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="{{  asset('assets/modules/jquery.min.js') }}"></script>
  <script src="{{  asset('assets/modules/popper.js') }}"></script>
  <script src="{{  asset('assets/modules/tooltip.js') }}"></script>
  <script src="{{  asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{  asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{  asset('assets/modules/moment.min.js') }}"></script>
  <script src="{{  asset('assets/js/stisla.js') }}"></script>
  
  <!-- JS Libraies -->
  <script src="{{  asset('assets/modules/jquery.sparkline.min.js') }}"></script>
  <script src="{{  asset('assets/modules/chart.min.js') }}"></script>
  <script src="{{  asset('assets/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
  <script src="{{  asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
  <script src="{{  asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

  <!-- Page Specific JS File -->
  <script src="{{  asset('assets/js/page/index.js') }}"></script>
  
  <!-- Template JS File -->
  <script src="{{  asset('assets/js/scripts.js') }}"></script>
  <script src="{{  asset('assets/js/custom.js') }}"></script>
</body>
</html>