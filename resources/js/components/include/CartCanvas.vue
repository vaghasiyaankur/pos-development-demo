<template>

<div class="tab-view-cart-main">
      <div class="text-end pe-4 pt-2 tab-cart-offcanvas d-none">
        <a href="javascript:;" class="cart-icon-img" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" >
        <!-- <img src="assets/images/NavBar.png" alt="cartcanvas"> -->
        <i class=" ri-shopping-cart-2-line fs-1"></i></a>
      </div>
      <div class="offcanvas offcanvas-end tab-offcanvas" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header justify-content-end py-2 border-bottom border">
          <button type="button" class="btn-close text-reset fs-3" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0 mt-2">
          <div class="pos-left-main">
              <div class="card mb-2" style="box-shadow:none;">
                <ul class="nav nav-pills nav-justified fs-17 nav-success nav-responsive" role="tablist">
                  <li
                  class="nav-item"
                  data-bs-toggle="tooltip"
                  data-bs-trigger="hover"
                  data-bs-placement="top"
                  title=""
                  data-bs-original-title="Home"
                >
                  <a
                    class="nav-link active text-nowrap purchase_type"
                    data-bs-toggle="tab"
                    href="#bottomtabs-home"
                    role="tab"
                    aria-selected="true"
                    data-type="dinein"
                      @click="changeDeliveryType('dinein')"
                  >
                    Dine In
                  </a>
                  </li>
                  <li
                    class="nav-item"
                    data-bs-toggle="tooltip"
                    data-bs-trigger="hover"
                    data-bs-placement="top"
                    title=""
                    data-bs-original-title="Profile"
                  >
                    <a
                      class="nav-link text-nowrap purchase_type"
                      data-bs-toggle="tab"
                      href="#bottomtabs-profile"
                      role="tab"
                      aria-selected="false"
                      data-type="takeaway"
                      @click="changeDeliveryType('takeaway')"
                    >
                      Takeaway
                    </a>
                  </li>
                  <li
                    class="nav-item"
                    data-bs-toggle="tooltip"
                    data-bs-trigger="hover"
                    data-bs-placement="top"
                    title=""
                    data-bs-original-title="Messages"
                  >
                    <a
                      class="nav-link text-nowrap purchase_type"
                      data-bs-toggle="tab"
                      href="#bottomtabs-messages"
                      role="tab"
                      aria-selected="false"
                      data-type="delivery"
                      @click="changeDeliveryType('delivery')"
                    >
                      Delivery
                    </a>
                  </li>
                </ul>
              </div>
              <div class="allorder">
                <div class="scrollbar mb-2" id="style-3">
                  <div class="force-overflow mt-3">
                    <div class="card product mx-2 mb-2 position-relative" v-for="(data,key) in cart.data" :key="key">
                      <!-- card body -->
                      <div class="card-body py-0 pt-1">
                        <div class="row">
                          <div class="col-2 pt-1 p-2">
                            <div class="p-1">
                              <img
                                :src="'/storage/'+ data.product.image"
                                class="d-block rounded-circle cart-image"
                                style="width: 55px" alt="cartcanvas"
                              />
                            </div>
                          </div>
                          <div class="col-8 pt-1 cart-body-content">
                            <h5 class="fs-14 text-truncate mb-1">
                              <a
                                href="javascript:;"
                                class="text-dark fw-bold"
                                >{{ data.product.name }}</a
                              >
                            </h5>
                            <ul class="list-inline text-muted">
                              <li class="list-item text-dark fw-bold" v-if="data.ingredient !== false">
                                Ingredients :
                                <span class="fw-medium">{{ data.ingredient }}</span>
                              </li>
                              <li class="list-item text-dark fw-bold" v-if="data.size !== false">
                                Size :
                                <span class="fw-medium">{{ data.size }}</span>
                              </li>
                            </ul>
                          </div>
                          <div class="col-2 pt-1 pe-0">
                            <div
                              class="
                                card
                                ribbon-box
                                shadow-none
                                mb-lg-0
                                right
                              "
                            >
                              <div
                                class="ribbon ribbon-dark ribbon-shape"
                                style="box-shadow: none"
                              >
                                CHF:{{ (data.price).toFixed(2)}}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- card footer -->
                      <div class="card-footer border-0 pb-1 pt-0">
                        <div class="row align-items-center card-footer-row">
                          <div class="col-sm">
                            <div
                              class="
                                d-flex
                                align-items-center
                                gap-2
                                text-muted
                                justify-content-center
                                pe-xxl-5 pe-xl-3 pe-lg-0
                              "
                            >
                              <div class="input-step">
                                <button type="button" class="minus" data-action="minus" :data-id="key" @click="changeCartQuantity(key, $event)" :disabled="data.quantity < 2">
                                <span v-if="data.quantity > 1">-</span>
                                <span v-else><i class="ri-delete-bin-fill text-muted align-bottom me-1" data-v-0349ff8e=""></i></span>
                                <!-- {{data.quantity < 2 ? '–' :  }} -->
                                </button>
                                <input
                                  type="number"
                                  class="product-quantity"
                                  :value="data.quantity"
                                  min="1"
                                  max="100"
                                />
                                <button type="button" class="plus" data-action="plus" :data-id="key" @click="changeCartQuantity(key, $event)">+</button>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-auto">
                            <div class="d-flex flex-wrap my-n1">
                              <div>
                                <a
                                  href="javascript:;"
                                  class="d-block text-body p-1 px-2"
                                  @click="removeCart(key)"
                                  ><i
                                    class="
                                      ri-delete-bin-fill
                                      text-muted
                                      align-bottom
                                      me-1
                                    "
                                  ></i>
                                  Remove</a
                                >
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
                  <div class="col-7">
                    <p class="m-0 text-start text-danger text-nowrap">
                      minimum order value
                    </p>
                  </div>
                  <div class="col-5">
                    <p class="m-0 text-end text-danger text-nowrap">CHF 20.00</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-7">
                    <p class="m-0 fw-bold fs-5 text-start text-nowrap">total amount</p>
                  </div>
                  <div class="col-5">
                    <p class="m-0 fw-bold fs-5 text-end text-nowrap">CHF {{(cart.total).toFixed(2)}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <div class="d-grid mt-2">
                      <a href="javascript:;">
                        <button type="button" class="btn btn-success w-100" @click="saveOrder"  :disabled="cart.data.length < 1">
                          PlaceOrder
                        </button>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
import $ from "jquery";
export default {
    name: "Cart",
    data(){
        return {
            desc : ''
        }
    },
    props: {
        cart: {
            type: Array,
        },
        description: {
            type: String,
        }
    },
    methods: {
      changeCartQuantity(key,event){
          this.$emit('changeCartQuantity',key, event);
      },
      removeCart(key){
          this.$emit('removeCart',key);
      },
      saveOrder(){
        const allEle = document.querySelectorAll('.purchase_type');
        var description = this.desc;
        var purchase = '';
        allEle.forEach(ele => {
          if (ele.classList.contains('active')) {
            purchase = ele.getAttribute('data-type');
          }
        });

        this.$emit('saveOrder', purchase, description);
      },
      changeDeliveryType(type){
        this.$emit('changeDeliveryType', type);
      },
    }
};
</script>

<style scoped>

/* ---------------------POS MENU CARD START -----------------*/

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
.main-content .page-content .pos-left-main .allorder .card {
  position: absolute;
  top: -4px;
  right: -3px;
}

/* ---------------------POS MENU CARD END -----------------*/
  /*****RESPONSIVE CSS********/

  @media screen and (max-width:1024px){
  /*.main-content .page-content .tab-cart-offcanvas{
    display:block !important;
    }*/
  .main-content .tab-view-cart-main .allorder .force-overflow{
    height:calc(100vh - 129px - 98px);
  }
  .main-content .page-content .tab-view-cart-main .tab-offcanvas .allorder .scrollbar {
  background: #f5f5f5;
  overflow-y: scroll;
  margin-bottom: 25px;
  overflow-x:hidden;
  }
  .main-content .page-content .tab-view-cart-main .tab-offcanvas  #style-3::-webkit-scrollbar-track {
    -webkit-box-shadw: inset 0 0 6px #0ab39c33;
    background-color: transparent;
  }
  .main-content .page-content .tab-view-cart-main .tab-offcanvas #style-3::-webkit-scrollbar {
    width: 3px;
    background-color: transparent;
  }

  .main-content .page-content .tab-view-cart-main .tab-offcanvas #style-3::-webkit-scrollbar-thumb {
    background-color: #0ab39c;
  }
}
@media screen and (max-width:1099px){
  .main-content .page-content .pos-main .allorder .cart-image{
    width:40px !important;
  }
  .main-content .page-content .pos-main .allorder .card-footer-row{
    display:-webkit-inline-box;
  }
}

@media screen and (min-width:1025px) and (max-width:1230px){
  .pos-main .nav.nav-responsive .nav-item a.nav-link{
    padding:0.5rem 0.5rem;
    font-size:15px;
  }
}
@media screen and (max-width:1399px){
  .main-content .page-content .pos-main .allorder .cart-image{
    width:45px !important;
  }
  .main-content .page-content .pos-main .cart-body-content{
    font-size:12px;
  }
  .main-content .page-content .pos-main .pos-left-main .allorder .card .card-body{
    padding:0px 5px;
  }
  .main-content .page-content .pos-main .pos-left-main .allorder .ribbon-box.right .ribbon{
    right:11px !important;
  }
}
@media screen and (max-width:1440px){
.main-content .page-content .pos-main .pos-left-main .allorder .ribbon-box.right .ribbon{
      right: 0px;
}
.main-content .page-content .pos-main .pos-left-main .allorder .ribbon-box .ribbon {
    padding: 5px;
    font-size: 10px;
}
.ribbon-box.right .ribbon-dark.ribbon-shape::before {
    border-right-color: #212529;
    border-top-color: #212529;
}
.ribbon-box.right .ribbon.ribbon-shape::after, .ribbon-box.right .ribbon.ribbon-shape::before {
    border-left-color: transparent;
}
.ribbon-box .ribbon.ribbon-shape::before {
    border: 8px solid transparent;
}
.ribbon-box .ribbon.ribbon-shape::after {
    border: 9px solid transparent;
}
.ribbon-box.right .ribbon.ribbon-shape::after,
.ribbon-box.right .ribbon.ribbon-shape::before{
  right: auto;
  left: -13px;
}
.ribbon-box.right .ribbon-dark.ribbon-shape::after {
    border-right-color: #212529;
    border-bottom-color: #212529;
}
}
 @media screen and (max-width:820px){
    .main-content .tab-view-cart-main .allorder .force-overflow{
        height:calc(100vh - 150px - 145px);
    }
    .main-content .page-content .tab-offcanvas .pos-left-main .allorder .ribbon-box .ribbon {
    padding: 5px !important;
    font-size: 10px !important;
    }
 }
.btn-success.disabled, .btn-success:disabled{
      cursor: default;
      pointer-events: inherit;
}
</style>
