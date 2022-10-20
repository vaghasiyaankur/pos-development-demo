<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">

<head>

    <meta charset="utf-8" />
    <title>Pos Development</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Pos , Single page" name="keywords" >
    <meta content="Pos Development" name="description" />
    <meta content="Pos" name="author" />
    <!-- !-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
      <!-- Sweet Alert css-->
      <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
     <!-------Fontawsome Cdn Link ------->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"  />
    <!------- Owl Slider CSS Link------>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

    <!-- custom Css-->
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Custom css -->
    <link href="{{ asset('assets/css/custom-front.css') }}" rel="stylesheet" type="text/css" />
     <!-- dropzone css -->
     <link rel="stylesheet" href="{{('assets/libs/dropzone/dropzone.css')}}" type="text/css" />
     <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css"
  />

    <style>
        button.carousel__prev,
        button.carousel__next {
          box-sizing: content-box;
          background-color:transparent;
          color: #212529;
          font-size: 30px;
        }
    </style>
</head>

<body>
    <div id="layout-wrapper">
        <div id="app">
            <Layout></Layout>
        </div>
    </div>

    <script src="{{mix('js/app.js')}}"></script>



  <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/custom-front.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    
     <script src="{{ asset('assets/libs/dropzone/dropzone-min.js')}}"></script>
    <script>
        $(".collapse--class").click(function(){
            $(this).siblings('.menu-dropdown').toggleClass('show');
        });

        $(document).on("click",".small--size--navlink",function(){
            $("#topnav-hamburger-icon").trigger('click');
            $("#menumanagement--div").css('display', 'none');
        })

        $(document).on("click",".menu--management--toggle",function(){
            if($("#menumanagement--div").css("display") == "none"){
                $("#menumanagement--div").css('display', 'block');
            }else{
                $("#menumanagement--div").css('display', 'none');
            }
        });

        $(document).on('click', function (e) {
            if ($(e.target).closest(".menu--management--toggle").length === 0) {
                $("#menumanagement--div").css('display', 'none');
            }
        });
        
    </script>
</body>

</html>
