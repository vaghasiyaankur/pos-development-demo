<template>

<div class="col-lg-4 col--md--lg px-0 tab-view-cart ">
  <div class="pos-left-main ">
    <div class="purchase--navtab">
      <ul class="nav nav-pills nav-justified fs-17 nav-success nav-responsive" role="tablist" style="flex-wrap:nowrap;">
        <li
          class="nav-item border-radius-10 me-2"
          data-bs-toggle="tooltip"
          data-bs-trigger="hover"
          data-bs-placement="top"
          title=""
          data-bs-original-title="Home"
        >
          <a
            class="nav-link active text-nowrap purchase_type btn"
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
          class="nav-item border-radius-10 me-2"
          data-bs-toggle="tooltip"
          data-bs-trigger="hover"
          data-bs-placement="top"
          title=""
          data-bs-original-title="Profile"
        >
          <a
            class="nav-link text-nowrap purchase_type btn"
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
          class="nav-item border-radius-10 "
          data-bs-toggle="tooltip"
          data-bs-trigger="hover"
          data-bs-placement="top"
          title=""
          data-bs-original-title="Messages"
        >
          <a
            class="nav-link text-nowrap purchase_type btn"
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
            <div class="card product mx-2 mb-2 position-relative overflow-hidden border-radius-10" :class="{ 'fade-in-bl' : addSwiper }" v-for="(data,key) in cart.data" :key="key">
              <div class="card-body position-relative p-2">
                <div class="price-tag">
                  <span class="badge bg-success position-absolute"> {{currencyCode}}:{{ (data.price).toFixed(2)}}</span>
                </div>
                <div class="row position-relative align-items-center">
                    <div class="col-2">
                      <div class="product-img">
                      <img
                      :src="'/storage/'+ data.product.image"
                      class="flex-shrink-0 me-3 avatar-sm rounded-circle" alt="cartImage"
                    />
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="order-details fw-medium fs-10 ps-lg-0 ps-2">
                        <h5 class="fs-12 text-truncate mb-1">
                          <a
                            href="javascript:;"
                            class="color-gray fw-bold"
                            >{{ data.product.name }}</a
                          >
                        </h5>
                        <ul class="list-inline mb-0">
                          <li class="list-item color-gray" v-if="data.ingredient">
                            Ingredients :
                            <span class="fw-medium line-clamp">{{ data.ingredient }} </span>
                          </li>
                          <li class="list-item color-gray" v-if="data.size">
                            Size :
                            <span class="fw-medium">{{ data.size }}</span>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-4 mt-auto ps-0 ps-lg-3">
                      <div class="input-step border-0 bg-transparent">
                        <button v-if="data.quantity > 1" type="button" class="minus" data-action="minus" :data-id="key" @click="changeCartQuantity(key, $event)">
                          <span >-</span>
                        </button>
                        <button v-else type="button" class="minus" data-action="minus" :data-id="key" @click="removeCart(key)">
                          <span><i class=" ri-delete-bin-7-line align-bottom me-1 text-danger" data-v-0349ff8e=""></i></span>
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
              </div>            
            </div>
        </div>
      </div>
    </div>
    <div class="bottom-bar px-3 py-2">
      <div class="comment-box">
        <div class="row">
          <div class="col-7">
            <p class="m-0 fw-bold fs-12 text-start text-nowrap">Total Amount</p>
          </div>
          <div class="col-5">
            <p class="m-0 fw-bold fs-12 text-end text-nowrap">{{currencyCode}} {{(cart.total).toFixed(2)}}</p>
          </div>
        </div>
        <!-- <div class="row">
          <div class="12">
            <textarea class="form-control border-radius-10" rows="2" v-model="desc" placeholder="comment" style="padding:0.5rem;"></textarea>
          </div>
        </div> -->
      </div>
      <div class="row">
        <div class="col-12">
          <div class="d-grid mt-2">
            <a href="javascript:;" class="position-relative">
              <button type="button" class="btn btn-success w-100 fs-16" style="line-height:16px;" data-bs-toggle="modal" data-bs-target="#orderPlaceModal" @click="placeOrder" :disabled="cart.data.length < 1">
                Order
              </button>
            <div class="spinner-border text-light position-absolute addtocart-btn-spinner d-none" id="loader_CartOrder" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            </a>
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
        },
        currencyCode: {
            type: String,
        },
        addSwiper : {
            type : Boolean,
        }
    },
    methods: {
      changeCartQuantity(key,event){
          this.$emit('changeCartQuantity',key, event);
      },
      removeCart(key){
          this.$emit('removeCart',key);
      },
      placeOrder(){
      const allEle = document.querySelectorAll('.purchase_type');
      var purchase = '';
      var description = this.desc;
      allEle.forEach(ele => {
        if (ele.classList.contains('active')) {
          purchase = ele.getAttribute('data-type');
        }
      });
        this.$emit('placeOrder', purchase ,description);
      },
      changeDeliveryType(type){
        this.$emit('changeDeliveryType', type);
      },

    },
};
</script>

<style scoped>

.addtocart-btn-spinner{
    right: 10%;
    top: 15%;
    width : 1.5rem;
    height : 1.5rem;
}
/* ---------------------POS MENU CARD START -----------------*/
.pos-left-main .purchase--navtab{
  background: #FFFFFF;
  box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.25);
  border-radius: 10px;
  padding:12px;
}
.pos-left-main .purchase--navtab .nav-item{
    background: #EFEEF3;
}
.main-content .pos-main .pos-inner .allorder .scrollbar {
  overflow-y: scroll;
  margin-bottom: 25px;
  overflow-x:hidden;
}

.main-content .pos-main .pos-inner .allorder .force-overflow {
  height: calc(100vh - 105px - 186px);
}
 .pos-main .tab-view-cart .pos-left-main{
    height: 100vh;
    max-height: calc(100vh - 109px);
    background: #FFFCFC;
    box-shadow: 0px 0px 4px 1px rgba(0, 0, 0, 0.25);
    border-radius: 10px;
  }
.main-content .pos-main .pos-inner .allorder .force-overflow .price-tag span{
  top: 0;
  right: 0;
  border-radius: 0 10px;
  padding:5px 8px !important;
}
.main-content .pos-main .pos-inner .allorder .force-overflow .card{
  max-height:96px;
  box-shadow: 0px 0px 3px 1px rgba(0, 0, 0, 0.1);
}
.main-content .pos-main .pos-inner .allorder .force-overflow .order-details{
    min-height:68px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.main-content .pos-main .pos-inner .allorder .force-overflow .line-clamp{
  display: -webkit-box;
  -webkit-line-clamp:2;
  -webkit-box-orient: vertical;
  overflow: hidden;
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
  background-color: #8B8A8A;
  border-radius:10px;
}
.main-content .pos-main .pos-inner .bottom-bar .comment-box{
    background: #FFFFFF;
    box-shadow: 0px 0px 3px 1px rgb(0 0 0 / 10%);
    padding: 6px 7px;
    border-radius: 10px;
}
.main-content .pos-main .pos-inner .allorder .force-overflow .card .input-step input{
  width:3em;
}
.fade-in-bl {
  -webkit-animation: fade-in-bl 0.6s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;
  animation: fade-in-bl 0.6s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;
}
@-webkit-keyframes fade-in-bl {
0% {
  -webkit-transform: translateX(-50px) translateY(50px);
          transform: translateX(-50px) translateY(50px);
  opacity: 0;
}
100% {
  -webkit-transform: translateX(0) translateY(0);
          transform: translateX(0) translateY(0);
  opacity: 1;
}
}
@keyframes fade-in-bl {
0% {
  -webkit-transform: translateX(-50px) translateY(50px);
          transform: translateX(-50px) translateY(50px);
  opacity: 0;
}
100% {
  -webkit-transform: translateX(0) translateY(0);
          transform: translateX(0) translateY(0);
  opacity: 1;
}
}

/* ---------------------POS MENU CARD END -----------------*/


/************ RESPONSIVE CSS *****************/

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
@media screen and (max-width:1180px){
  /*.main-content .pos-main .pos-inner .allorder .force-overflow{
    height: calc(100vh - 87px - 230px);
  }*/
  /*.pos-main .tab-view-cart .pos-left-main{
    max-height: calc(100vh - 136px);
  }*/

}
@media screen and (max-width:991px){
  .col--md--lg{
    width:100%;
    max-width:295px;
  }
}
 @media screen and (max-width:820px){
  .main-content .tab-view-cart-main .allorder .force-overflow{
    height:calc(100vh - 150px - 145px);
  }
  .main-content .pos-main .pos-inner .allorder .force-overflow .card .input-step input{
    width:2em;
  }
  .pos-main .tab-view-cart .pos-left-main{
    max-height: calc(100vh - 136px);
  }
  .main-content .pos-main .pos-inner .allorder .force-overflow{
    height: calc(100vh - 93px - 230px);
  }
 }
 @media screen and (max-width:768px){
    .col-md-lg{
      width: 100%;
      max-width: 495px;
    }
    .col--md--lg[data-v-017d4892] {
      width: 100%;
      max-width: 251px;
    }
    .purchase--navtab .nav {
      flex-wrap:wrap !important;
    }
    .main-content .pos-main .pos-inner .allorder .force-overflow{
      height: calc(100vh - 176px - 173px);
    }
 }

.btn-success.disabled, .btn-success:disabled{
      cursor: default;
      pointer-events: inherit;
}
</style>
