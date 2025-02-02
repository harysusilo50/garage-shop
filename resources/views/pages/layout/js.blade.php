<script src="{{ asset('pages/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('pages/jquery/jquery.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('vendor/splide/dist/js/splide.min.js') }}"></script>
<script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
@include('sweetalert::alert')
<script>
    
  /**
   * Init swiper sliders
   */
  function initSwiper() {
    document.querySelectorAll(".init-swiper").forEach(function(swiperElement) {
      let config = JSON.parse(
        swiperElement.querySelector(".swiper-config").innerHTML.trim()
      );

      if (swiperElement.classList.contains("swiper-tab")) {
        initSwiperWithCustomPagination(swiperElement, config);
      } else {
        new Swiper(swiperElement, config);
      }
    });
  }

  window.addEventListener("load", initSwiper);
    $(document).ready(function() {
        if ($("#search_bar").val() != "") {
            $("#clear_search").show();
        } else {
            $("#clear_search").hide();
        }

        $("#search_bar").keyup(function(e) {
            e.preventDefault();
            if (e.keyCode == 13) {
                $('#search_form').submit();
            } else {
                if ($("#search_bar").val() != "") {
                    $("#clear_search").show();
                } else {
                    $("#clear_search").hide();
                }
            }
        });
        $("#clear_search").click(function(e) {
            e.preventDefault();
            $("#search_bar").val("");
            $("#clear_search").hide();
        });
    });
</script>
@yield('js')
