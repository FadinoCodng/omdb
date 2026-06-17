<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ __('Search Movie') }} &mdash; Stisla</title>

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
    .btn-fav { cursor: pointer; }
    .btn-fav.active i { color: #fff; }
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
    .search-info { font-size: 14px; color: #6c757d; }
    .pagination-wrapper { padding: 15px; }
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
            <h1>{{ __('Search Movie') }}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
              <div class="breadcrumb-item active">{{ __('Search Movie') }}</div>
            </div>
          </div>

          <div class="section-body">
            <div class="card">

              <div class="card-header">
                <h4>{{ __('Search Movie') }}</h4>
                <div class="card-header-form">
                  <form id="searchForm">
                    <div class="input-group">
                      <select class="form-control" id="typeFilter" style="max-width: 130px;">
                        <option value="">{{ __('All Types') }}</option>
                        <option value="movie">Movie</option>
                        <option value="series">Series</option>
                        <option value="episode">Episode</option>
                      </select>
                      <input type="text" class="form-control" id="searchInput" placeholder="{{ __('Search movies') }}" autofocus>
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

                <!-- Loading Spinner -->
                <div id="loading" class="text-center py-5" style="display:none;">
                  <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">{{ __('Loading...') }}</span>
                  </div>
                  <p class="mt-2 text-muted">{{ __('Searching movies...') }}</p>
                </div>

                <!-- Search Info -->
                <div id="searchInfo" class="px-4 pt-3" style="display:none;">
                  <span class="search-info"></span>
                </div>

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
                    <tbody id="movieResults">
                      <tr id="emptyState">
                        <td colspan="5" class="text-center text-muted py-5">
                          <i class="fas fa-search fa-2x mb-2"></i><br>
                          {{ __('Enter keyword') }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <!-- Pagination -->
                <div id="pagination" class="pagination-wrapper text-center" style="display:none;">
                  <button class="btn btn-sm btn-outline-primary" id="prevPage" disabled>
                    <i class="fas fa-chevron-left"></i> {{ __('Previous') }}
                  </button>
                  <span class="mx-3" id="pageInfo"></span>
                  <button class="btn btn-sm btn-outline-primary" id="nextPage" disabled>
                    {{ __('Next') }} <i class="fas fa-chevron-right"></i>
                  </button>
                </div>

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

    var currentPage = 1;
    var currentQuery = '';
    var totalResults = 0;
    var userFavorites = @json($userFavorites);

    function showToast(message, type) {
      var toast = $('<div class="toast-msg toast-' + type + '">' + message + '</div>');
      $('#toastContainer').append(toast);
      setTimeout(function() { toast.fadeOut(300, function() { $(this).remove(); }); }, 3000);
    }

    function searchMovies(query, page) {
      if (!query || query.length < 2) return;

      currentQuery = query;
      currentPage = page;
      var type = $('#typeFilter').val();

      $('#loading').show();
      $('#emptyState').hide();
      $('#movieResults').find('tr:not(#emptyState)').remove();
      $('#searchInfo').hide();
      $('#pagination').hide();

      $.get('/api/movies/search', { q: query, page: page, type: type }, function(res) {
        $('#loading').hide();

        if (res.success && res.results.length > 0) {
          totalResults = res.totalResults;
          var totalPages = Math.ceil(totalResults / 10);

          // Search info
          $('#searchInfo').show().find('.search-info').text(
            '{{ __("Search Results") }}: ' + totalResults + ' {{ __("movies found for") }} "' + query + '"'
          );

          // Render results
          res.results.forEach(function(movie) {
            var isFav = userFavorites.indexOf(movie.imdbID) !== -1 || movie.isFavorite;
            var favClass = isFav ? 'btn-danger active' : 'btn-outline-danger';
            var poster = (movie.Poster && movie.Poster !== 'N/A')
              ? '<img src="' + movie.Poster + '" alt="' + movie.Title + '" class="movie-poster">'
              : '<div class="movie-poster bg-light d-flex align-items-center justify-content-center"><i class="fas fa-film text-muted"></i></div>';

            var row = '<tr>' +
              '<td>' + poster + '</td>' +
              '<td><strong>' + movie.Title + '</strong></td>' +
              '<td>' + movie.Year + '</td>' +
              '<td><span class="badge badge-' + movie.Type + '">' + movie.Type.charAt(0).toUpperCase() + movie.Type.slice(1) + '</span></td>' +
              '<td>' +
                '<button class="btn btn-sm btn-info btn-detail" data-imdb="' + movie.imdbID + '"><i class="fas fa-eye"></i> {{ __("Detail") }}</button> ' +
                '<button class="btn btn-sm btn-fav ' + favClass + '" data-imdb="' + movie.imdbID + '" data-title="' + movie.Title.replace(/"/g, '&quot;') + '" data-year="' + movie.Year + '" data-type="' + movie.Type + '" data-poster="' + movie.Poster + '">' +
                  '<i class="fas fa-heart"></i>' +
                '</button>' +
              '</td>' +
            '</tr>';
            $('#movieResults').append(row);
          });

          // Pagination
          if (totalPages > 1) {
            $('#pagination').show();
            $('#pageInfo').text('{{ __("Page") }} ' + page + ' / ' + totalPages);
            $('#prevPage').prop('disabled', page <= 1);
            $('#nextPage').prop('disabled', page >= totalPages);
          }

        } else {
          $('#emptyState').show().find('td').html(
            '<i class="fas fa-search fa-2x mb-2"></i><br>{{ __("No results found") }}'
          );
        }
      }).fail(function() {
        $('#loading').hide();
        $('#emptyState').show().find('td').html(
          '<i class="fas fa-exclamation-triangle fa-2x mb-2 text-danger"></i><br>{{ __("An error occurred") }}'
        );
      });
    }

    // Search form submit
    $('#searchForm').on('submit', function(e) {
      e.preventDefault();
      var query = $('#searchInput').val().trim();
      if (query.length >= 2) {
        // Update URL without reloading page
        var newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?q=' + encodeURIComponent(query);
        window.history.pushState({path:newUrl},'',newUrl);
        searchMovies(query, 1);
      }
    });

    // Auto-search on page load if query param exists
    $(document).ready(function() {
      var urlParams = new URLSearchParams(window.location.search);
      var initialQuery = urlParams.get('q');
      if (initialQuery && initialQuery.trim().length >= 2) {
        $('#searchInput').val(initialQuery);
        searchMovies(initialQuery, 1);
      }
    });

    // Pagination
    $('#prevPage').on('click', function() { searchMovies(currentQuery, currentPage - 1); });
    $('#nextPage').on('click', function() { searchMovies(currentQuery, currentPage + 1); });

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

    // Favorite toggle
    $(document).on('click', '.btn-fav', function() {
      var btn = $(this);
      $.post('/favorites/toggle', {
        imdb_id: btn.data('imdb'),
        title: btn.data('title'),
        year: btn.data('year'),
        type: btn.data('type'),
        poster: btn.data('poster')
      }, function(res) {
        if (res.success) {
          if (res.action === 'added') {
            btn.removeClass('btn-outline-danger').addClass('btn-danger active');
            userFavorites.push(btn.data('imdb'));
          } else {
            btn.removeClass('btn-danger active').addClass('btn-outline-danger');
            userFavorites = userFavorites.filter(function(id) { return id !== btn.data('imdb'); });
          }
          showToast(res.message, 'success');
        }
      }).fail(function() {
        showToast('{{ __("An error occurred") }}', 'error');
      });
    });
  </script>
</body>
</html>