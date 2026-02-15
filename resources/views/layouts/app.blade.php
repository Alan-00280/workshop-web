<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Purple Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href={{ asset("/assets/vendors/mdi/css/materialdesignicons.min.css") }}>
  <link rel="stylesheet" href={{ asset("/assets/vendors/ti-icons/css/themify-icons.css") }}>
  <link rel="stylesheet" href={{ asset("/assets/vendors/css/vendor.bundle.base.css") }}>
  <link rel="stylesheet" href={{ asset("/assets/vendors/font-awesome/css/font-awesome.min.css") }}>
  <!-- endinject -->

  <!-- Plugin css for this page -->
  <link rel="stylesheet" href={{ asset("/assets/vendors/font-awesome/css/font-awesome.min.css") }} />
  <link rel="stylesheet" href={{ asset("/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css") }}>
  <!-- End plugin css for this page -->

  <!-- inject:css -->
  <!-- endinject -->

  <!-- Layout styles -->
  <link rel="stylesheet" href={{ asset("/assets/css/style.css") }}>
  <!-- End layout styles -->

  <link rel="shortcut icon" href={{ asset("/assets/images/favicon.png") }} />

  @vite([])
  <script src="https://kit.fontawesome.com/f714303560.js" crossorigin="anonymous"></script>

</head>

<body>
  <div class="container-scroller">

    @yield('modal')

    <!-- partial:partials/_navbar.html -->
    <x-nav />

    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <x-sidebar />

      <!-- partial -->
      <div class="main-panel">
        
        {{-- Content Wrapper Start --}}
        <div class="content-wrapper">

          {{-- Alert Message --}}
          <x-successAlert :message="session('success')" />

          @if(session('error'))
              <x-error-alert :errors="session('error')" type="global" />
          @endif

          <x-error-alert :errors="$errors" />

          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white me-2">
                @yield('icon-page')
              </span> @yield('db-page-title')
            </h3>

            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>

                @yield('breadcrumb')

                <li class="breadcrumb-item active" aria-current="page">
                  @yield('bcrumb-title')
                </li>
              </ol>
            </nav>
          </div>

          @yield('content')

        </div>
        <!-- content-wrapper ends -->

        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2026 <a
                href="https://github.com/Alan-00280" target="_blank">xyzeerg</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">"Partially" <i
                class="fa-solid fa-face-grin-squint-tears" style="color: rgba(255, 212, 59, 1);"></i> Hand-crafted &
              made with <i class="mdi mdi-heart text-danger"></i> by Alan</span>
          </div>
        </footer>
        <!-- partial -->

        <div class="modal fade" id="specialFace" tabindex="-1"
          aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
            <img src="{{ asset('/Blue_Lobster_Meme_Banner_image.jpg') }}" alt="Special Face" width="700px">
            </div>
          </div>
        </div>

      </div>
      <!-- main-panel ends -->

    </div>

    <!-- page-body-wrapper ends -->
  </div>

  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src={{ asset("/assets/vendors/js/vendor.bundle.base.js") }}></script>
  <!-- endinject -->

  <!-- Plugin js for this page -->
  @yield('script')
  {{--
  <script src="/assets/vendors/chart.js/chart.umd.js"></script>
  <script src="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script> --}}
  <!-- End plugin js for this page -->

  <!-- inject:js -->
  <script src={{ asset('/assets/js/off-canvas.js') }}></script>
  <script src={{ asset("/assets/js/misc.js") }}></script>
  {{--
  <script src="/assets/js/settings.js"></script>
  <script src="/assets/js/todolist.js"></script>
  <script src="/assets/js/jquery.cookie.js"></script> --}}
  <!-- endinject -->

  <!-- Custom js for this page -->
  <script src="/assets/js/dashboard.js"></script>
  <script>
    const powerBtn = document.querySelector('a#power-btn')
    const lob_aud = new Audio('/blue-lobster-jumpscare-made-with-Voicemod.mp3')
    powerBtn.addEventListener('click', () => {
      lob_aud.play()
    })
    
    const lobModal = document.querySelector('div#specialFace')
    lobModal.addEventListener('hidden.bs.modal', () => {
      lob_aud.pause()
      lob_aud.currentTime = 0
    })

    lob_aud.addEventListener('ended', () => {
      const modalLob_bs = bootstrap.Modal.getInstance(lobModal)
      modalLob_bs.hide()
    })

  </script>
  <!-- End custom js for this page -->
</body>

</html>