<!DOCTYPE html>
<html  lang="en" data-layout="horizontal" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">
   
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    
   <!-- Layout config Js -->
   <script src="{{ asset('assets/js/layout.js') }}"></script>
    <!-- !-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
   <!-- Bootstrap Css -->
   <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
   <!-- Icons Css -->
   <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
   <!-- App Css-->
   <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-------Fontawsome Cdn Link ------->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"  />

   <!-- custom Css-->
   <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

   <!-- Custom css -->
   <link src="{{ asset('assets/css/custom-front.css') }}" rel="stylesheet" type="text/css" />
</head>
<style>
    
    .invoice--details .border--bottom{
        border-bottom: 1px dashed #878A99;
    }
    .invoice--details{
        background: #fff;
        max-width: 500px;
        margin: 0 auto;
        padding: 12px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50% , -50%);
        width: 100%;
    }
    .invoice--details .invoice-card{
        background: transparent;
        box-shadow: none;
        border: 1px solid #878A99;
        border-radius: 0;
        padding: 12px;
    }
    .invoice--details .invoice-card .card-header .invioce-header p{
        font-size: 20px;
        line-height: 27px;
        color: #333;
        white-space: nowrap;
        font-weight: 500;
    }
    .invoice--details .invoice-card .card-body table tr th,
    .invoice--details .invoice-card .card-body table tr td{
        padding-left: 0;
        padding-right:0;
        font-size: 16px;
        color: #333;
        font-weight: 500;
    }
    .border--div{
        border: 2px dashed #878A99;
        padding: 1px;
    }
    .invoice--details .invoice-card .card-footer p,
    .invoice--details .invoice-card .card-footer span{
        font-size: 20px;
        line-height: 22px;
        color: #333;
        font-weight: 500;
    }
    .invoice--details .invoice-card .signature > .line {
        display: inline-block;
        border-bottom: 1px solid #333333;
        width: 164px; 
    }
    /* @media screen and (max-width:1024px){
        [data-layout=horizontal] .page-content{
            margin-top: 70px
        }
    } */
</style>
<body>
    <div class="main-content">
        <div class="page-content pt-0">
            <div class="invoice--details">
                <div class="card invoice-card mb-0">
                    <div class="card-header text-center border-0">
                        <img src="/assets/images/logo-dark.png" alt="" height="17" data-v-62bad5be="">
                    </div>
                    <div class="card-header px-0 border--bottom">
                        <div class="row">
                            <div class="col-6">                                  
                                <div class="invioce-header">
                                    <p class="mb-0">Date: 2-08-22</p> 
                                    <p class="mb-0">Server : Admin (T02/5)</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="invioce-header text-end">                                                                              
                                    <p class="mb-0">Time: 10 : 41</p> 
                                    <p class="mb-0">Type : Table  </p>
                                </div>                                    
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <thead >
                                    <tr> 
                                        <th class="fs-18">Item Description</th>
                                        <th class="text-end fs-18">Price</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">                            
                                    <tr>
                                        <td> X1 Olive oil</td>
                                        <td class="text-end" id="cart-subtotal">CHF 12:00</td>
                                    </tr>
                                    <tr>
                                        <td>X2 Mozzarella cheese  </td>
                                        <td class="text-end">CHF 15:00</td>
                                    </tr>
                                    <tr>
                                        <td>X1 Tomato sauce</td>
                                        <td class="text-end"> CHF 10:00</td>
                                    </tr>
                                    <tr class="border--bottom">
                                        <td>X1 gamberoni pasta</td>
                                        <td class="text-end" id="cart-tax"> CHF 15:00</td>
                                    </tr>
                                    <tr class="border--bottom">
                                        <td>Sub total :(8items)</td>
                                        <td class="text-end"> CHF 67:00</td>
                                    </tr>
                                    <tr class="border--bottom">
                                        <th>Total (USD) :</th>
                                        <td class="text-end">
                                            <span class="fw-semibold" id="cart-total">
                                                CHF 67:00
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- end table-responsive -->
                    </div>    
                    <div class="card-footer pb-1 px-0 text-center">
                        <div class="text-end pb-2">
                            <span class ="signature">Signature : <span class = "line">                                
                        </div>    
                        <div class="border--div mb-2"></div>  
                        <p>Closed Bill</p>   
                        <p class="mb-0">Thank You <br>
                            See you again!</p>            
                    </div> 
                </div>
            </div>
        </div>
        <!-- End Page-content -->
    </div>
     <!-- jquery Cdn Link -------->
     <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
     <!-- -----Owl js cdn Link ------>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
     <!----- Bootstrap cdn Link ------->
     <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
     <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
     <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
     <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
     <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
     <script src="{{ asset('assets/js/plugins.js') }}"></script>
</body>
</html>