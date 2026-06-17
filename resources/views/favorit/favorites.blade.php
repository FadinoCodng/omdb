<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ __('My Favorites') }} &mdash; Stisla</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('assets/modules/jqvmap/dist/jqvmap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

  <style>
    .movie-poster { width: 60px; height: 85px; object-fit: cover; border-radius: 4px; }
    .badge-movie { background-color: #6777ef; }
    .badge-series { background-color: #fc544b; }
    .badge-episode { background-color: #ffa426; }
    .toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; }
    .toast-msg {
      padding: 12px 20px; border-radius: 6px; color: #fff; font-size: 14px;
      box-shadow: 0 4px 12px rgba(0,0,0,.15); animation: slideIn .3s ease;
    }
    .toast-success { background: #47c363; }
    .toast-error { background: #fc544b; }
    @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

    .detail-poster { width: 200px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,.2); }
    .detail-meta span { margin-right: 15px; }
    .fav-count { font-size: 14px; color: #6c757d; }
  </style>
</head>

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
            <h1>{{ __('My Favorites') }}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
              <div class="breadcrumb-item active">{{ __('Favorites') }}</div>
            </div>
          </div>

          <div class="section-body">
            <div class="card">

              <div class="card-header">
                <h4>{{ __('Favorite Movies') }}</h4>
                @if($favorites->count() > 0)
                  <div class="card-header-action">
                    <span class="fav-count">
                      <i class="fas fa-heart text-danger"></i>
                      {{ $favorites->count() }} {{ __('movies') }}
                    </span>
                  </div>
                @endif
              </div>

              <div class="card-body p-0">
                @if($favorites->count() > 0)
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
                        @foreach($favorites as $fav)
                          <tr id="fav-row-{{ $fav->imdb_id }}">
                            <td>
                              @if($fav->poster && $fav->poster !== 'N/A')
                                <img src="{{ $fav->poster }}" alt="{{ $fav->title }}" class="movie-poster">
                              @else
                                <div class="movie-poster bg-light d-flex align-items-center justify-content-center">
                                  <i class="fas fa-film text-muted"></i>
                                </div>
                              @endif
                            </td>
                            <td><strong>{{ $fav->title }}</strong></td>
                            <td>{{ $fav->year }}</td>
                            <td>
                              <span class="badge badge-{{ $fav->type }}">
                                {{ ucfirst($fav->type) }}
                              </span>
                            </td>
                            <td>
                              <button class="btn btn-sm btn-info btn-detail" data-imdb="{{ $fav->imdb_id }}">
                                <i class="fas fa-eye"></i> {{ __('Detail') }}
                              </button>
                              <button class="btn btn-sm btn-danger btn-remove-fav"
                                data-imdb="{{ $fav->imdb_id }}"
                                data-title="{{ $fav->title }}"
                                data-year="{{ $fav->year }}"
                                data-type="{{ $fav->type }}"
                                data-poster="{{ $fav->poster }}">
                                <i class="fas fa-trash"></i> {{ __('Remove') }}
                              </button>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @else
                  <div class="text-center py-5">
                    <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">{{ __('No favorites yet') }}</h5>
                    <p>{{ __('Start adding movies to your favorites list!') }}</p>
                    <a href="{{ route('search') }}" class="btn btn-primary">
                      <i class="fas fa-search"></i> {{ __('Search Movies') }}
                    </a>
                  </div>
                @endif
              </div>

            </div>
          </div>

        </section>
      </div>

      @include('layouts.footer')
    </div>
  </div>

  <!-- Detail Modal -->
  <div class="modal fade" id="detailModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('Movie Details') }}</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body" id="detailContent">
          <div class="text-center py-5">
            <div class="spinner-border text-primary"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Toast Container -->
  <div class="toast-container" id="toastContainer"></div>

  <!-- General JS Scripts -->
  <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/modules/popper.js') }}"></script>
  <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
  <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
  <script src="{{ asset('assets/js/stisla.js') }}"></script>

  <!-- JS Libraries -->
  <script src="{{ asset('assets/modules/jquery.sparkline.min.js') }}"></script>
  <script src="{{ asset('assets/modules/chart.min.js') }}"></script>
  <script src="{{ asset('assets/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
  <script src="{{ asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>

  <script>
    $.ajaxSetup({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    function showToast(message, type) {
      var toast = $('<div class="toast-msg toast-' + type + '">' + message + '</div>');
      $('#toastContainer').append(toast);
      setTimeout(function() { toast.fadeOut(300, function() { $(this).remove(); }); }, 3000);
    }

    // Detail button
    $(document).on('click', '.btn-detail', function() {
      var imdbId = $(this).data('imdb');
      $('#detailContent').html('<div class="text-center py-5"><div class="spinner-border text-primary"></div></div>');
      $('#detailModal').modal('show');

      $.get('/api/movies/' + imdbId, function(res) {
        if (res.success) {
          var m = res.movie;
          var poster = (m.Poster && m.Poster !== 'N/A')
            ? '<img src="' + m.Poster + '" class="detail-poster" alt="' + m.Title + '">'
            : '<div class="detail-poster bg-light d-flex align-items-center justify-content-center" style="width:200px;height:300px"><i class="fas fa-film fa-3x text-muted"></i></div>';

          var html = '<div class="row">' +
            '<div class="col-md-4 text-center">' + poster + '</div>' +
            '<div class="col-md-8">' +
              '<h4>' + m.Title + ' <small class="text-muted">(' + m.Year + ')</small></h4>' +
              '<div class="detail-meta mb-3">' +
                '<span><i class="fas fa-star text-warning"></i> ' + m.imdbRating + '/10</span>' +
                '<span><i class="fas fa-clock"></i> ' + m.Runtime + '</span>' +
                '<span class="badge badge-' + m.Type + '">' + m.Type + '</span>' +
              '</div>' +
              '<p><strong>{{ __("Genre") }}:</strong> ' + m.Genre + '</p>' +
              '<p><strong>{{ __("Director") }}:</strong> ' + m.Director + '</p>' +
              '<p><strong>{{ __("Actors") }}:</strong> ' + m.Actors + '</p>' +
              '<p><strong>{{ __("Plot") }}:</strong> ' + m.Plot + '</p>' +
            '</div></div>';
          $('#detailContent').html(html);
        } else {
          $('#detailContent').html('<p class="text-danger">' + res.message + '</p>');
        }
      }).fail(function() {
        $('#detailContent').html('<p class="text-danger">{{ __("Failed to load details") }}</p>');
      });
    });

    // Remove from favorites
    $(document).on('click', '.btn-remove-fav', function() {
      var btn = $(this);
      var imdbId = btn.data('imdb');

      if (!confirm('{{ __("Are you sure you want to remove this from favorites?") }}')) return;

      $.post('/favorites/toggle', {
        imdb_id: imdbId,
        title: btn.data('title'),
        year: btn.data('year'),
        type: btn.data('type'),
        poster: btn.data('poster')
      }, function(res) {
        if (res.success && res.action === 'removed') {
          $('#fav-row-' + imdbId).fadeOut(300, function() {
            $(this).remove();
            // Check if table is empty
            if ($('tbody tr').length === 0) {
              location.reload();
            }
          });
          showToast(res.message, 'success');
        }
      }).fail(function() {
        showToast('{{ __("An error occurred") }}', 'error');
      });
    });
  </script>
</body>
</html>