@extends('layouts.panel.master')
@push('css')
    <style>
        /* ------------------------SMALL IMG SLIDER START-------------*/
        .main-content .page-content .img-small-slider .restaurant_swiper .small-slider-card img {
            max-width: 100px;
            margin: 0 auto;
            max-height: 50px;
            border-radius: 100px !important;
        }
        /* .main-content .page-content .img-small-slider .restaurant_swiper .owl-stage-outer .owl-item{
         width: 177px !important;
        } */
        .main-content .page-content .img-small-slider .restaurant_swiper .small-slider-card {
            width: 177px;
            transition: all 1s ease;
        }

        .main-content .page-content .img-small-slider .restaurant_swiper .owl-next span,
        .main-content .page-content .img-small-slider .restaurant_swiper .owl-prev span {
            display: none;
        }

        .main-content .page-content .img-small-slider .restaurant_swiper .owl-prev {
            position: absolute;
            top: 7px;
            left: -15px;
        }

        .main-content .page-content .img-small-slider .restaurant_swiper .owl-next {
            right: -23px;
            position: absolute;
            top: 7px;
        }

        .main-content .page-content .img-small-slider .restaurant_swiper .owl-next::before {
            content: "\f105";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            font-size: 25px;
        }

        .main-content .page-content .img-small-slider .restaurant_swiper .owl-prev::before {
            content: "\f104";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            font-size: 25px;
        }

        .main-content .page-content .img-small-slider .owl-theme .owl-nav [class*=owl-]:hover {
            background-color: transparent;
            color: #a9aab4;
        }

        .pos-main .pos-inner .img-small-slider .owl-item {
            padding-left: 10px;
        }
        .main-content .pos-main .img-small-slider .item .small-slider-card:hover,
        .main-content .pos-main .img-small-slider .item .small-slider-card.active {
            background-color: #0ab39c !important;
        }
        .main-content .pos-main .img-small-slider .item .small-slider-card:hover .card-body-title a,
        .main-content .pos-main .img-small-slider .item .small-slider-card:hover p,
        .main-content .pos-main .img-small-slider .item .small-slider-card.active p,
        .main-content .pos-main .img-small-slider .item .small-slider-card.active a{
            color: #fff !important;
        }
        .main-content .pos-main .img-small-slider .item .small-slider-card .card-body-title a,
        .main-content .pos-main .img-small-slider .item .small-slider-card p{
            transition: all 1s ease;
        }

        /* ------------------------SMALL IMG SLIDER END-------------*/

        /* ---------------------POS MENU CARD START -----------------*/
        .main-content .pos-main .pos-inner .allorder .scrollbar {
            background: #F5F5F5;
            overflow-y: scroll;
            margin-bottom: 25px;
        }

        .main-content .pos-main .pos-inner .cart-offcanvas .scrollbar {
            background-color: #ffff;
            overflow-y: scroll;
            margin-bottom: 25px;
            overflow-x: hidden;
        }

        .main-content .pos-main .pos-inner .allorder .force-overflow {
            height: calc(100vh - 155px - 128px);
        }

        .main-content .pos-main .pos-inner .cart-offcanvas .force-overflow {
            height: 770px;
        }

        .main-content .pos-main .pos-inner #style-3::-webkit-scrollbar-track {
            -webkit-box-shadw: inset 0 0 6px #0ab39c33;
            background-color: transparent;
        }

        .main-content .pos-main .pos-inner #style-3::-webkit-scrollbar {
            width: 3px;
            background-color: transparent;
        }

        .main-content .pos-main .pos-inner #style-3::-webkit-scrollbar-thumb {
            background-color: #0ab39c;
        }


        .main-content .page-content .pos-main .pos-inner .pos-menu-card .card-content {
            min-height: 83px;
            height: 100%;
        }

        .main-content .page-content .pos-main .pos-inner .pos-menu-card .card .ribbon-three::after {
            right: 0;
        }

        .main-content .page-content .pos-main .pos-inner .pos-menu-card .card .ribbon-box.right .ribbon-three {
            right: -10px;
        }

        .main-content .page-content .pos-main .pos-inner .pos-menu-card .cart-offcanvas .items-cart-img img {
            width: 235px;
            height: 235px;
        }

        .main-content .page-content .pos-left-main .allorder .card {
            position: absolute;
            top: -4px;
            right: -3px;
        }

        /* ---------------------POS MENU CARD END -----------------*/
        /* --------------------- CART OFFCANVAS START ------------------*/
        .main-content .page-content .pos-main .cart-offcanvas .offcanvas-start {
            top: 118px;
            left: 0;
            width: 75%;
        }

        .main-content .pos-main .cart-offcanvas .menu-cart-option .diff-menucart .card {
            box-shadow: 0 0 10px -5px #333 !important;
            transition: all 0.5s ease;
        }

        .main-content .pos-main .cart-offcanvas .menu-cart-option .diff-menucart .card:hover {
            background-color: #0ab39c;
        }

        .main-content .pos-main .cart-offcanvas .menu-cart-option .diff-menucart .card:hover .card-title {
            color: #fff;
        }

        .main-content .pos-main .cart-offcanvas .menu-cart-option .diff-menucart .card:hover p {
            color: #ffff !important;
        }
        .main-content .pos-main .cart-offcanvas .addtocart-details .size-varient a.nav-link{
            font-size: 13px;
            white-space: nowrap;
            padding: 5px;
            border-radius: 5px;
        }
        .main-content .pos-main .cart-offcanvas .addtocart-details .size-varient li.nav-item{
            background-color: #fff;
            border-radius: 5px;
            margin-right: 5px;
        }
        /* --------------------- CART OFFCANVAS END ------------------*/
    </style>
@endpush


@section('content')
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content pb-0 ps-0" style="margin-top:49px;">
               <!-------POS SECTION START --------->
               <section class="pos-main">
                  <div class="pos-inner">
                     <div class="row">
                        <div class="col-lg-9 pt-3">
                           <div class="pos-right-main ps-2">
                              <!------------- IMG SLIDER  START-------->
                              <!-- SWIPER START --->
                              <section class="img-small-slider mb-3">
                                 <div class="owl-carousel owl-theme restaurant_swiper position-relative" style="width:97%; margin:0 auto;">
                                    <div class="item">
                                       <div
                                          class="small-slider-card d-flex align-items-center p-1 bg-white rounded">
                                          <div class="flex-shrink-0 ps-1">
                                             <img src="assets/images/card-img1.png" alt="" class="rounded">
                                          </div>
                                          <div class="flex-grow-1 ms-2 card-body-title">
                                             <a href="javascript:;"
                                                class="stretched-link fw-bold text-dark">
                                                Getränke</a>
                                            <p class="mb-0 text-muted">45 items</p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="item">
                                       <div
                                          class="small-slider-card d-flex align-items-center bg-white rounded p-1">
                                          <div class="flex-shrink-0 ps-1">
                                             <img src="assets/images/card-img10.png" alt="" class="rounded">
                                          </div>
                                          <div class="flex-grow-1 ms-2 card-body-title">
                                             <a href="javascript:;"
                                                class="stretched-link fw-bold text-dark">Getränke</a>
                                                <p class="mb-0 text-muted">46 items</p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="item">
                                       <div
                                          class="small-slider-card d-flex align-items-center bg-white rounded p-1">
                                          <div class="flex-shrink-0 ps-1">
                                             <img src="assets/images/card-img2.png" alt="" class="rounded">
                                          </div>
                                          <div class="flex-grow-1 ms-2 card-body-title">
                                             <a href="javascript:;"
                                                class="stretched-link fw-bold text-dark">Getränke</a>
                                                <p class="mb-0 text-muted">200 items</p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="item">
                                       <div
                                          class="small-slider-card active d-flex align-items-center bg-white rounded p-1">
                                          <div class="flex-shrink-0 ps-1">
                                             <img src="assets/images/card-img3.png" alt="" class="rounded">
                                          </div>
                                          <div class="flex-grow-1 ms-2 card-body-title">
                                             <a href="javascript:;"
                                                class="stretched-link fw-bold text-dark">Getränke</a>
                                                <p class="mb-0 text-muted">120 items</p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="item">
                                       <div
                                          class="small-slider-card d-flex align-items-center bg-white rounded p-1">
                                          <div class="flex-shrink-0 ps-1">
                                             <img src="assets/images/card-img4.png" alt="" class="rounded">
                                          </div>
                                          <div class="flex-grow-1 ms-2 card-body-title">
                                             <a href="javascript:;"
                                                class="stretched-link fw-bold text-dark">Getränke</a>
                                                <p class="mb-0 text-muted">50 items</p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="item">
                                       <div
                                          class="small-slider-card d-flex align-items-center bg-white rounded p-1">
                                          <div class="flex-shrink-0 ps-1">
                                             <img src="assets/images/card-img5.png" alt="" class="rounded">
                                          </div>
                                          <div class="flex-grow-1 ms-2 card-body-title">
                                             <a href="javascript:;"
                                                class="stretched-link fw-bold text-dark">Getränke</a>
                                                <p class="mb-0 text-muted">35 items</p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="item">
                                       <div
                                          class="small-slider-card d-flex align-items-center bg-white rounded p-1">
                                          <div class="flex-shrink-0 ps-1">
                                             <img src="assets/images/card-img6.png" alt="" class="rounded">
                                          </div>
                                          <div class="flex-grow-1 ms-2 card-body-title">
                                             <a href="javascript:;"
                                                class="stretched-link fw-bold text-dark">Getränke</a>
                                                <p class="mb-0 text-muted">40 items</p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="item">
                                       <div
                                          class="small-slider-card d-flex align-items-center bg-white rounded p-1">
                                          <div class="flex-shrink-0 ps-1">
                                             <img src="assets/images/card-img8.png" alt="" class="rounded">
                                          </div>
                                          <div class="flex-grow-1 ms-2 card-body-title">
                                             <a href="javascript:;"
                                                class="stretched-link fw-bold text-dark">Getränke</a>
                                                <p class="mb-0 text-muted">55 items</p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="item">
                                       <div
                                          class="small-slider-card d-flex align-items-center bg-white rounded p-1">
                                          <div class="flex-shrink-0 ps-1">
                                             <img src="assets/images/card-img7.png" alt="" class="rounded">
                                          </div>
                                          <div class="flex-grow-1 ms-2 card-body-title">
                                             <a href="javascript:;"
                                                class="stretched-link fw-bold text-dark">Getränke</a>
                                                <p class="mb-0 text-muted">69 items</p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="item">
                                       <div
                                          class="small-slider-card d-flex align-items-center bg-white rounded p-1">
                                          <div class="flex-shrink-0 ps-1">
                                             <img src="assets/images/card-img9.png" alt="" class="rounded">
                                          </div>
                                          <div class="flex-grow-1 ms-2 card-body-title">
                                             <a href="javascript:;"
                                                class="stretched-link fw-bold text-dark">Getränke</a>
                                                <p class="mb-0 text-muted">10 items</p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="item">
                                       <div
                                          class="small-slider-card d-flex align-items-center bg-white rounded p-1">
                                          <div class="flex-shrink-0 ps-1">
                                             <img src="assets/images/card-img10.png" alt="" class="rounded">
                                          </div>
                                          <div class="flex-grow-1 ms-2 card-body-title">
                                             <a href="javascript:;"
                                                class="stretched-link fw-bold text-dark">Getränke</a>
                                                <p class="mb-0 text-muted">5 items</p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="item">
                                       <div
                                          class="small-slider-card d-flex align-items-center bg-white rounded p-1">
                                          <div class="flex-shrink-0 ps-1">
                                             <img src="assets/images/card-img3.png" alt="" class="rounded">
                                          </div>
                                          <div class="flex-grow-1 ms-2 card-body-title">
                                             <a href="javascript:;"
                                                class="stretched-link fw-bold text-dark">Getränke</a>
                                                <p class="mb-0 text-muted">100 items</p>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </section>
                              <!-- SWIPER END -->
                              <!----------- IMG SLIDER END ---------->
                              <div class="row">
                                 <div
                                    class="col-12 bg-danger text-white notificationBar d-flex justify-content-center align-items-center py-1">
                                    <p class="m-0 fs-5"> ★
                                       Restaurants Open at 9:00 AM And Close 11:00 PM (Available Home
                                       Delivery)★
                                    </p>
                                 </div>
                              </div>
                              <div class="row bg-dark py-1">
                                 <div class="col-6 col-lg-3 d-flex align-items-center mb-0" role="alert">
                                    <div class="topInfoImage lh-1">
                                       <i class="ri-roadster-fill text-white fs-4"></i>
                                    </div>
                                    <div class="text-white ps-3 fs-5">Bestellart: Lieferung</div>
                                 </div>
                                 <div class="col-6 col-lg-3 d-flex align-items-center mb-0" role="alert">
                                    <div class="topInfoImage lh-1">
                                       <i class="ri-map-pin-fill text-white fs-4"></i>
                                    </div>
                                    <div class="text-white ps-3 fs-5">
                                       Liefergebiet: <span id="DeliveryPostCode">8400</span>
                                    </div>
                                 </div>
                                 <div class="col-6 col-lg-3 d-flex align-items-center mb-0" role="alert">
                                    <div class="topInfoImage lh-1">
                                       <i class="ri-time-fill text-white fs-4"></i>
                                    </div>
                                    <div class="text-white fs-5 ps-3">
                                       Lieferzeit: ca.
                                       <span id="deliveryTime">35</span> min
                                    </div>
                                 </div>
                                 <div class="col-6 col-lg-3 d-flex align-items-center mb-0" role="alert">
                                    <div class="topInfoImage lh-1">
                                       <i class=" ri-wallet-fill text-white fs-4"></i>
                                    </div>
                                    <div class="text-white fs-5 ps-3">Mindestwert: <span id="minval">CHF
                                       20.00</span>
                                    </div>
                                 </div>
                              </div>
                              <div class="pos-order-from">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between mt-0">
                                    <h4 class="mb-sm-0">Contact Details</h4>
                                </div>
                                <form action="" class="mt-3">
                                    <div class="mb-3">
                                        <h5 class="form-label">Table Number</h5>
                                        <input type="number" class="form-control" placeholder="Enter Table Number">
                                    </div>
                                    <div class="mb-3">
                                        <h5 class="form-label">Contact Number</h5>
                                        <input type="number" class="form-control"  placeholder="Enter Table Number">
                                    </div>
                                    <div class="mb-3">
                                        <h5 for="comment" class="form-label">
                                            Give Your Remark</h5>
                                        <textarea class="form-control" id="comment" rows="5" placeholder="Comment here"></textarea>
                                    </div>
                                </form>
                                <div class="payment-option">
                                    <h5 class="mb-1">Payment Selection</h5>
                                    <p class="text-muted mb-4">Please select and enter your billing
                                        information</p>
                                        <div class="row g-4">
                                            <div class="col-lg-4 col-sm-6">
                                                <div data-bs-toggle="collapse" data-bs-target="#paymentmethodCollapse" aria-expanded="false" aria-controls="paymentmethodCollapse" class="collapsed">
                                                    <div class="form-check card-radio">
                                                        <input id="paymentMethod02" name="paymentMethod" type="radio" class="form-check-input" checked="">
                                                        <label class="form-check-label" for="paymentMethod02">
                                                            <span class="fs-16 text-muted me-2"><i class="ri-bank-card-fill align-bottom"></i></span>
                                                            <span class="fs-14 text-wrap">Visa Card</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div data-bs-toggle="collapse" data-bs-target="#paymentmethodCollapse.show" aria-expanded="true" aria-controls="paymentmethodCollapse">
                                                    <div class="form-check card-radio">
                                                        <input id="paymentMethod03" name="paymentMethod" type="radio" class="form-check-input">
                                                        <label class="form-check-label" for="paymentMethod03">
                                                            <span class="fs-16 text-muted me-2"><i class="ri-money-dollar-box-fill align-bottom"></i></span>
                                                            <span class="fs-14 text-wrap">Cash on
                                                                Delivery</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div data-bs-toggle="collapse" data-bs-target="#paymentmethodCollapse.show" aria-expanded="true" aria-controls="paymentmethodCollapse">
                                                    <div class="form-check card-radio">
                                                        <input id="paymentMethod04" name="paymentMethod" type="radio" class="form-check-input">
                                                        <label class="form-check-label" for="paymentMethod04">
                                                            <span class="fs-16 text-muted me-2"><i class="ri-money-dollar-box-fill align-bottom"></i></span>
                                                            <span class="fs-14 text-wrap">Master card</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>                                
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-3 px-0">
                           <div class="pos-left-main position-sticky"
                              style="top:116.5px;box-shadow: 0px 0px 10px -5px #333333">
                              <div class="card mb-2">
                                 <ul class="nav nav-pills nav-justified fs-17  nav-success " role="tablist">
                                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                       data-bs-placement="top" title="" data-bs-original-title="Home">
                                       <a class="nav-link active" data-bs-toggle="tab" href="#bottomtabs-home"
                                          role="tab" aria-selected="true">
                                       Dine In
                                       </a>
                                    </li>
                                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                       data-bs-placement="top" title="" data-bs-original-title="Profile">
                                       <a class="nav-link" data-bs-toggle="tab" href="#bottomtabs-profile"
                                          role="tab" aria-selected="false">
                                       Takeaway
                                       </a>
                                    </li>
                                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                       data-bs-placement="top" title="" data-bs-original-title="Messages">
                                       <a class="nav-link" data-bs-toggle="tab" href="#bottomtabs-messages"
                                          role="tab" aria-selected="false">
                                       Delivery
                                       </a>
                                    </li>
                                 </ul>
                              </div>
                              <div class="allorder ">
                                 <div class="scrollbar mb-2" id="style-3">
                                    <div class="force-overflow">
                                       <div class="card product mx-2 mb-2 position-relative">
                                          <!-- card body -->
                                          <div class="card-body py-0 pt-1">
                                             <div class="row">
                                                <div class="col-2 pt-1">
                                                   <div class="p-1">
                                                      <img src="assets/images/slider-1.jpg"
                                                         class="d-block rounded-circle"
                                                         style="width:55px">
                                                   </div>
                                                </div>
                                                <div class="col-8 pt-1">
                                                   <h5 class="fs-14 text-truncate mb-1"><a
                                                      href="javascript:;"
                                                      class="text-dark fw-bold">Naples</a>
                                                   </h5>
                                                   <ul class="list-inline text-muted">
                                                      <li class="list-item text-dark fw-bold">
                                                         Ingredients :
                                                         <span class=" fw-medium ">tomato sauce
                                                         </span>
                                                      </li>
                                                      <li class="list-item text-dark fw-bold">
                                                         Variations :
                                                         <span class="fw-medium">Penne</span>
                                                      </li>
                                                   </ul>
                                                </div>
                                                <div class="col-2 pt-1 pe-0">
                                                   <div class="card ribbon-box shadow-none mb-lg-0 right">
                                                      <div class="ribbon ribbon-dark ribbon-shape"
                                                         style="box-shadow: none;">
                                                         CHF:119
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- card footer -->
                                          <div class="card-footer border-0 pb-1 pt-0">
                                             <div class="row align-items-center">
                                                <div class="col-sm">
                                                   <div class="d-flex align-items-center gap-2 text-muted justify-content-center pe-5">
                                                      <div class="input-step">
                                                         <button type="button" class="minus">–</button>
                                                         <input type="number" class="product-quantity"
                                                            value="2" min="0" max="100">
                                                         <button type="button" class="plus">+</button>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-auto">
                                                   <div class="d-flex flex-wrap my-n1">
                                                      <div>
                                                         <a href="#" class="d-block text-body p-1 px-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#removeItemModal"><i
                                                            class="ri-delete-bin-fill text-muted align-bottom me-1"></i>
                                                         Remove</a>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- end card footer -->
                                       </div>
                                       <div class="card product mx-2 mb-2 position-relative">
                                          <!-- card body -->
                                          <div class="card-body py-0 pt-1">
                                             <div class="row">
                                                <div class="col-2 pt-1">
                                                   <div class="p-1">
                                                      <img src="assets/images/slider-1.jpg"
                                                         class="d-block rounded-circle"
                                                         style="width:55px">
                                                   </div>
                                                </div>
                                                <div class="col-8 pt-1">
                                                   <h5 class="fs-14 text-truncate mb-1"><a
                                                      href="javascript:;"
                                                      class="text-dark fw-bold">Naples</a>
                                                   </h5>
                                                   <ul class="list-inline text-muted">
                                                      <li class="list-item text-dark fw-bold">
                                                         Ingredients :
                                                         <span class=" fw-medium ">tomato sauce
                                                         </span>
                                                      </li>
                                                      <li class="list-item text-dark fw-bold">
                                                         Variations :
                                                         <span class="fw-medium">Penne</span>
                                                      </li>
                                                   </ul>
                                                </div>
                                                <div class="col-2 pt-1 pe-0">
                                                   <div class="card ribbon-box shadow-none mb-lg-0 right">
                                                      <div class="ribbon ribbon-dark ribbon-shape"
                                                         style="box-shadow: none;">
                                                         CHF:119
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- card footer -->
                                          <div class="card-footer border-0 pb-1 pt-0">
                                             <div class="row align-items-center">
                                                <div class="col-sm">
                                                   <div class="d-flex align-items-center gap-2 text-muted justify-content-center pe-5">
                                                      <div class="input-step">
                                                         <button type="button" class="minus">–</button>
                                                         <input type="number" class="product-quantity"
                                                            value="2" min="0" max="100">
                                                         <button type="button" class="plus">+</button>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-auto">
                                                   <div class="d-flex flex-wrap my-n1">
                                                      <div>
                                                         <a href="#" class="d-block text-body p-1 px-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#removeItemModal"><i
                                                            class="ri-delete-bin-fill text-muted align-bottom me-1"></i>
                                                         Remove</a>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- end card footer -->
                                       </div>
                                       <div class="card product mx-2 mb-2 position-relative">
                                          <!-- card body -->
                                          <div class="card-body py-0 pt-1">
                                             <div class="row">
                                                <div class="col-2 pt-1">
                                                   <div class="p-1">
                                                      <img src="assets/images/slider-1.jpg"
                                                         class="d-block rounded-circle"
                                                         style="width:55px">
                                                   </div>
                                                </div>
                                                <div class="col-8 pt-1">
                                                   <h5 class="fs-14 text-truncate mb-1"><a
                                                      href="javascript:;"
                                                      class="text-dark fw-bold">Naples</a>
                                                   </h5>
                                                   <ul class="list-inline text-muted">
                                                      <li class="list-item text-dark fw-bold">
                                                         Ingredients :
                                                         <span class=" fw-medium ">tomato sauce
                                                         </span>
                                                      </li>
                                                      <li class="list-item text-dark fw-bold">
                                                         Variations :
                                                         <span class="fw-medium">Penne</span>
                                                      </li>
                                                   </ul>
                                                </div>
                                                <div class="col-2 pt-1 pe-0">
                                                   <div class="card ribbon-box shadow-none mb-lg-0 right">
                                                      <div class="ribbon ribbon-dark ribbon-shape"
                                                         style="box-shadow: none;">
                                                         CHF:119
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- card footer -->
                                          <div class="card-footer border-0 pb-1 pt-0">
                                             <div class="row align-items-center">
                                                <div class="col-sm">
                                                   <div class="d-flex align-items-center gap-2 text-muted justify-content-center pe-5">
                                                      <div class="input-step">
                                                         <button type="button" class="minus">–</button>
                                                         <input type="number" class="product-quantity"
                                                            value="2" min="0" max="100">
                                                         <button type="button" class="plus">+</button>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-auto">
                                                   <div class="d-flex flex-wrap my-n1">
                                                      <div>
                                                         <a href="#" class="d-block text-body p-1 px-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#removeItemModal"><i
                                                            class="ri-delete-bin-fill text-muted align-bottom me-1"></i>
                                                         Remove</a>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- end card footer -->
                                       </div>
                                       <div class="card product mx-2 mb-2 position-relative">
                                          <!-- card body -->
                                          <div class="card-body py-0 pt-1">
                                             <div class="row">
                                                <div class="col-2 pt-1">
                                                   <div class="p-1">
                                                      <img src="assets/images/slider-1.jpg"
                                                         class="d-block rounded-circle"
                                                         style="width:55px">
                                                   </div>
                                                </div>
                                                <div class="col-8 pt-1">
                                                   <h5 class="fs-14 text-truncate mb-1"><a
                                                      href="javascript:;"
                                                      class="text-dark fw-bold">Naples</a>
                                                   </h5>
                                                   <ul class="list-inline text-muted">
                                                      <li class="list-item text-dark fw-bold">
                                                         Ingredients :
                                                         <span class=" fw-medium ">tomato sauce
                                                         </span>
                                                      </li>
                                                      <li class="list-item text-dark fw-bold">
                                                         Variations :
                                                         <span class="fw-medium">Penne</span>
                                                      </li>
                                                   </ul>
                                                </div>
                                                <div class="col-2 pt-1 pe-0">
                                                   <div class="card ribbon-box shadow-none mb-lg-0 right">
                                                      <div class="ribbon ribbon-dark ribbon-shape"
                                                         style="box-shadow: none;">
                                                         CHF:119
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- card footer -->
                                          <div class="card-footer border-0 pb-1 pt-0">
                                             <div class="row align-items-center">
                                                <div class="col-sm">
                                                   <div class="d-flex align-items-center gap-2 text-muted justify-content-center pe-5">
                                                      <div class="input-step">
                                                         <button type="button" class="minus">–</button>
                                                         <input type="number" class="product-quantity"
                                                            value="2" min="0" max="100">
                                                         <button type="button" class="plus">+</button>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-auto">
                                                   <div class="d-flex flex-wrap my-n1">
                                                      <div>
                                                         <a href="#" class="d-block text-body p-1 px-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#removeItemModal"><i
                                                            class="ri-delete-bin-fill text-muted align-bottom me-1"></i>
                                                         Remove</a>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- end card footer -->
                                       </div>
                                       <div class="card product mx-2 mb-2 position-relative">
                                          <!-- card body -->
                                          <div class="card-body py-0 pt-1">
                                             <div class="row">
                                                <div class="col-2 pt-1">
                                                   <div class="p-1">
                                                      <img src="assets/images/slider-1.jpg"
                                                         class="d-block rounded-circle"
                                                         style="width:55px">
                                                   </div>
                                                </div>
                                                <div class="col-8 pt-1">
                                                   <h5 class="fs-14 text-truncate mb-1"><a
                                                      href="javascript:;"
                                                      class="text-dark fw-bold">Naples</a>
                                                   </h5>
                                                   <ul class="list-inline text-muted">
                                                      <li class="list-item text-dark fw-bold">
                                                         Ingredients :
                                                         <span class=" fw-medium ">tomato sauce
                                                         </span>
                                                      </li>
                                                      <li class="list-item text-dark fw-bold">
                                                         Variations :
                                                         <span class="fw-medium">Penne</span>
                                                      </li>
                                                   </ul>
                                                </div>
                                                <div class="col-2 pt-1 pe-0">
                                                   <div class="card ribbon-box shadow-none mb-lg-0 right">
                                                      <div class="ribbon ribbon-dark ribbon-shape"
                                                         style="box-shadow: none;">
                                                         CHF:119
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- card footer -->
                                          <div class="card-footer border-0 pb-1 pt-0">
                                             <div class="row align-items-center">
                                                <div class="col-sm">
                                                   <div class="d-flex align-items-center gap-2 text-muted justify-content-center pe-5">
                                                      <div class="input-step">
                                                         <button type="button" class="minus">–</button>
                                                         <input type="number" class="product-quantity"
                                                            value="2" min="0" max="100">
                                                         <button type="button" class="plus">+</button>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-auto">
                                                   <div class="d-flex flex-wrap my-n1">
                                                      <div>
                                                         <a href="#" class="d-block text-body p-1 px-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#removeItemModal"><i
                                                            class="ri-delete-bin-fill text-muted align-bottom me-1"></i>
                                                         Remove</a>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- end card footer -->
                                       </div>
                                       <div class="card product mx-2 mb-2 position-relative">
                                          <!-- card body -->
                                          <div class="card-body py-0 pt-1">
                                             <div class="row">
                                                <div class="col-2 pt-1">
                                                   <div class="p-1">
                                                      <img src="assets/images/slider-1.jpg"
                                                         class="d-block rounded-circle"
                                                         style="width:55px">
                                                   </div>
                                                </div>
                                                <div class="col-8 pt-1">
                                                   <h5 class="fs-14 text-truncate mb-1"><a
                                                      href="javascript:;"
                                                      class="text-dark fw-bold">Naples</a>
                                                   </h5>
                                                   <ul class="list-inline text-muted">
                                                      <li class="list-item text-dark fw-bold">
                                                         Ingredients :
                                                         <span class=" fw-medium ">tomato sauce
                                                         </span>
                                                      </li>
                                                      <li class="list-item text-dark fw-bold">
                                                         Variations :
                                                         <span class="fw-medium">Penne</span>
                                                      </li>
                                                   </ul>
                                                </div>
                                                <div class="col-2 pt-1 pe-0">
                                                   <div class="card ribbon-box shadow-none mb-lg-0 right">
                                                      <div class="ribbon ribbon-dark ribbon-shape"
                                                         style="box-shadow: none;">
                                                         CHF:119
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- card footer -->
                                          <div class="card-footer border-0 pb-1 pt-0">
                                             <div class="row align-items-center">
                                                <div class="col-sm">
                                                   <div class="d-flex align-items-center gap-2 text-muted justify-content-center pe-5">
                                                      <div class="input-step">
                                                         <button type="button" class="minus">–</button>
                                                         <input type="number" class="product-quantity"
                                                            value="2" min="0" max="100">
                                                         <button type="button" class="plus">+</button>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-sm-auto">
                                                   <div class="d-flex flex-wrap my-n1">
                                                      <div>
                                                         <a href="#" class="d-block text-body p-1 px-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#removeItemModal"><i
                                                            class="ri-delete-bin-fill text-muted align-bottom me-1"></i>
                                                         Remove</a>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- end card footer -->
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="bottom-bar px-3 py-2">
                                 <div class="row">
                                    <div class="col-6">
                                       <p class="m-0 text-start text-danger">minimum order
                                          value
                                       </p>
                                    </div>
                                    <div class="col-6">
                                       <p class="m-0 text-end text-danger">CHF 20.00</p>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-6">
                                       <p class="m-0 fw-bold fs-5 text-start">total amount</p>
                                    </div>
                                    <div class="col-6">
                                       <p class="m-0 fw-bold fs-5 text-end">CHF 20.00</p>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-12">
                                       <div class="d-grid mt-2">
                                          <button type="button" class="btn btn-success">
                                             Pre-order
                                         </button>                                          
                                       </div>
                                    </div>                                                                     
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </section>
               <!-------POS SECTION END ----------->
            </div>
            <!-- End Page-content -->
         </div>
        <!-- end main content-->
@endsection

@push('script')

    <!-- // RESTORANT SWIPER JS // -->
    <script>
        $(function () {
            // Owl Carousel
            var owl = $(".owl-carousel");
            owl.owlCarousel({
                items: 7,
                margin: 10,
                loop: true,
                nav: true,
                dots: false,
                responsiveClass: true,
                responsive: {
                    320:{
                        items: 1,
                    },
                    380: {
                        items: 2,
                    },
                    576: {
                        items: 3,
                    },
                    768: {
                        items: 4,
                    },                   
                    1026: {
                        items: 3,
                    },
                    1200: {
                        items: 4,
                    },
                    1400: {
                        items:5,
                    },
                    1550:{
                     items:6,
                    },
                    1700: {
                        items: 7,
                    }
                }

            });
        });
    </script>
@endpush    