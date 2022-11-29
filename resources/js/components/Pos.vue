<template>

  <div class="main-content">
    <div class="page-content pb-0 ps-0 pt-4" style="margin-top: 49px">
        <!---------TAB VIEW START -------->


        <CartCanvas :cart="cart" :description="description" @changeCartQuantity="changeCartQuantity" @removeCart="removeCart" @saveOrder="saveOrder" @changeDeliveryType="changeDeliveryType"/>
        <!---------TAB VIEW END -------->

        <!---POS SECTION START -->

      <section class="pos-main position-relative">
        <div class="pos-inner pt-3">
          <div class="row">
            <div class="col-lg-8 col-md-lg tab-view-menu">
              <div class="pos-right-main ps-2">

                <section class="img-small-slider mb-3 mx-2">
                  <carousel
                    :items-to-show="7"
                    :wrap-around="true"
                    :mouseDrag="false"
                    :touchDrag="false"
                    :breakpoints="breakpoints"
                  >
                    <slide v-for="featurecategory in featuredcategories" :key="featurecategory.id">
                      <div class="">
                        <div class="item">
                          <div
                            class="
                              small-slider-card
                              d-flex
                              align-items-center
                              p-1
                              bg-white border-radius-10     
                              equal-height-pos
                              product--list
                            " :data-id="featurecategory.id" v-bind:class="(featurecategory.name === 'All')?'active':''">
                                                    <div class="flex-shrink-0 ps-0" v-if="featurecategory.image_show">
                                                        <img :src="'/storage/'+ featurecategory.image" alt="pos" class="rounded" />
                                                    </div>
                                                    <div class="flex-grow-1 ms-1 card-body-title">
                                                        <a class="stretched-link fs-10 fw-bold text-dark text-start" style="line-height: 10px;" href="javascript:;" @click="sliderChangeSelection()">{{ featurecategory.name }}</a>
                                                        <p class="mb-0 fs-10 text-muted text-start">{{featurecategory.activeproducts_count}} items</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </slide>

                                    <template #addons>
                                        <navigation />
                                        <pagination />
                                    </template>
                                </carousel>
                            </section>

                            <div class="pos-menu-card">
                                <div class="menu-card-header px-3 pt-3">
                                    <div class="form-check form-switch form-switch-success form-check-inline">
                                        <input class="form-check-input" type="checkbox" role="switch" id="vegOnlySelect" @click="vegOnlySelect = !vegOnlySelect; getproductslist('vegOnly')" :checked="vegOnlySelect">
                                        <label class="form-check-label text-uppercase fs-15 color-gray" for="vegOnlySelect">veg only</label>
                                    </div>
                                    <div class="form-check form-switch form-switch-success form-check-inline">
                                        <input class="form-check-input" type="checkbox" role="switch" id="comboSelect" @click="comboSelect = !comboSelect; getproductslist('combo')" :checked="comboSelect">
                                        <label class="form-check-label text-uppercase" for="comboSelect">combo</label>

                            </div>
                            <div class="form-check form-switch form-switch-success form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" id="ingredientSelect" @click="ingredientSelect = !ingredientSelect; getproductslist('ingredient')" :checked="ingredientSelect">
                                <label class="form-check-label text-uppercase fs-15 color-gray" for="ingredientSelect">ingredient</label>
                            </div>
                        </div>
                        <div class="menu-card-inner px-3">
                            <div class="loading" :class="{ 'd-none' : !addLoader}"></div>
                                <div class="row" :class="{ 'd-none' : addLoader}">
                                    <div class="col-lg-3 col-md-4 col-12 mb-3 px-lg-2 px-1" v-for="product in products" :key="product.id">
                                        <div class="card pos-single-card text-center pt-0 mb-0 mt-3 h-100 px-2">
                                            <div class="right ribbon-box shadow-none mb-lg-0">
                                                <div class="card-body text-muted">
                                                    <span class="ribbon-three ribbon-three-success"><span class="fs-10">{{currencyCode}} {{ formatPrice(product.price) }}</span></span>
                                                </div>
                                            </div>
                                            <div class="mx-auto avatar pos-card-img">
                                                <img :src="'/storage/'+ product.image" alt="Image Not Found" class="rounded-circle avatar-md" />
                                            </div>
                                            <div class="card-content mt-auto">
                                                <h4 class="card-title fs-10 fw-bold mb-0 color-gray">
                                                    {{ product.name }}
                                                </h4>
                                                <p class="card-text mb-0 fs-10">Baked with cheese</p>
                                            </div>
                                            <a v-if="(!comboSelect && !ingredientSelect) && (product.product_ingredients_count || (product.product_size_count > 1))" href="javascript:;" class="btn btn-success my-2 fs-10" aria-controls="openDetails" @click="openDetailpopup(product.id)">Select your Choose</a>
                                            <a v-else-if="(!comboSelect && !ingredientSelect) && (!product.product_ingredients_count || (product.product_size_count < 2))" href="javascript:;" class="btn btn-success my-2 fs-10" aria-controls="openDetails" @click="openDetailpopup(product.id)">Add To Cart
                                                <div class="spinner-border text-light position-absolute addtocart-btn-spinner product--loader d-none" :id="'loader_'+product.id" role="status">
                                                    <span class="sr-only">Loading...</span>
                                            </div>
                                            </a>
                                            <div class="position-relative" v-else>
                                                <a href="javascript:;" class="btn btn-success my-2 fs-10 w-100" :id="'addtocart_'+product.id" @click="addcombocart(product.id);">Add To Cart</a>
                                                <div class="spinner-border text-light position-absolute addtocart-btn-spinner d-none" :id="'loader_'+product.id" role="status">
                                                    <span class="sr-only">Loading...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <!--- CART OFFCANVAS START -->

                        <AddToCart :product="product" :sizes="sizes" :selectSizes="selectSizes" :selectIngredient="selectIngredient" :ingredientCategories="ingredientCategories" :popUpprice="popUpprice" :popupQuantityValue="popupQuantityValue" @changePopupQuantity="changePopupQuantity" @AddToCart="AddToCart" @ingredientSelection="ingredientSelection" :currencyCode="currencyCode" :addToCartLoader="addToCartLoader" :addCartLoader="addCartLoader" @selectSize="selectSize" />

                        <!-- CART OFFCANVS END -->
                            </div>
                        </div>
                        <Cart :cart="cart" :description="description" :currencyCode="currencyCode" @changeCartQuantity="changeCartQuantity" :addSwiper="addSwiper" @removeCart="removeCart" @placeOrder="placeOrder" @changeDeliveryType="changeDeliveryType" />
                    </div>
                </div>
        </section>
        <!-------POS SECTION END ----------->
    </div>
    <!-- End Page-content -->
        <!--------- MODAL START -------------->
        <div class="modal fade" id="orderPlaceModal" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-radius-10 border-0">
                    <div class="modal-body text-center p-5 border--top">
                        <div class="mt-4 modal--content">
                            <p class="mb-4 fs-19">Select the staff member you want to assign to this table</p>
                            <div class="row align-items-center mb-4">
                                <label class="col-4 form-label fs-16 padding-start-10 color-gray text-start mb-0">Table:</label>
                                <Select2 :options="avaliableTable" :settings="{ settingOption: value, settingOption: value }" @focusin="addstyle()" @select="checkcustomer($event);" class="col-8"/>
                            </div>
                            <div class="row align-items-center mb-4">
                                <label class="col-4 form-label fs-16 padding-start-10 color-gray text-start mb-0">Contact number :</label>
                                <div class="col-8">
                                    <input type="number" v-model="contactNumber" placeholder="Enter contact number ..." class="border-radius-10 form-control" @input="findContactthroughNumber">
                                </div>
                            </div>
                            <div class="row align-items-center mb-4">
                                <label class="col-4 form-label fs-16 padding-start-10 color-gray text-start mb-0">Customer name :</label>
                                <div class="col-8">
                                    <input type="text" v-model="customerName" placeholder="Enter customer name ..." class="border-radius-10 form-control" :readonly="checkName">
                                </div>
                            </div>
                            <div class="row align-items-center mb-4">
                                <label class="col-4 form-label fs-16 padding-start-10 color-gray text-start mb-0">Customer email :</label>
                                <div class="col-8">
                                    <input type="email" v-model="customerEmail" placeholder="Enter customer email ..." class="border-radius-10 form-control">
                                </div>
                            </div>
                            <div class="hstack gap-3 justify-content-center pt-4">
                                <button type="button" id="closeButton" class="btn btn--1" data-bs-dismiss="modal">Cancel</button>
                                <div class=border--outer>
                                    <button type="button" class="btn btn--2" @click="saveOrder">Order Place</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--------- MODAL END -------------->

</div>
<!-- end main content-->
</template>

<script>
import $ from "jquery";
import "vue3-carousel/dist/carousel.css";
import Select2 from 'vue3-select2-component';
import Cart from './include/Cart.vue';
import CartCanvas from './include/CartCanvas.vue';
import AddToCart from './include/AddToCart.vue';
import {
    Carousel,
    Slide,
    Navigation
} from "vue3-carousel";
import {
    useToast
} from "vue-toastification";
export default {
    name: "Pos",
    data() {
        return {
            featuredcategories: [],
            ingredientCategories: [],
            sizes: [],
            products: [],
            product: {
                id: '',
                name: '',
                price: '',
                image: '',
                submitButton: 'Add to Cart'
            },
            breakpoints: {
                768: {
                    itemsToShow: 3,
                    snapAlign: 'start',
                },
                820: {
                    itemsToShow: 4,
                    snapAlign: 'start',
                },
                992: {
                    itemsToShow: 5,
                    snapAlign: 'start',
                },
                1025: {
                    itemsToShow: 6,
                    snapAlign: 'start',
                },
                1200: {
                    itemsToShow: 6,
                    snapAlign: 'start',
                },
                1400: {
                    itemsToShow: 7,
                    snapAlign: 'start',
                },
                1500: {
                    itemsToShow: 8,
                    snapAlign: 'start',
                },
                1700: {
                    itemsToShow: 9,
                    snapAlign: 'start',
                },
                1900: {
                    itemsToShow: 10,
                    snapAlign: 'start',
                },

            },
            selectSizes: '',
            selectSizesPrice: '',
            selectIngredient: '',
            popUpprice: 0,
            popupQuantityValue: 1,
            popupSelectPriceSize: 0,
            sizeId: 0,
            combo: false,
            ingredient: false,
            cart: {
                data: [],
                total: 0,
            },
            description: '',
            addToCartLoader: false,
            toast: useToast(),
            productId: 0,
            addLoader: false,
            addCartLoader: false,
            addSwiper: false,
            vegOnlySelect: false,
            comboSelect: false,
            offerSelect: false,
            ingredientSelect: false,
            avaliableTable : [],
            orderTable : '',
            customerName : '',
            contactNumber : '',
            customerEmail : '',
            purchase : '',
            description : '',
            tableOrder : [],
            checkName : false,
            message : '',
        }
    },
    components: {
        Carousel,
        Slide,
        Navigation,
        Cart,
        CartCanvas,
        AddToCart,
        Select2
    },
    computed: {
        outSideClick(){
            console.log('yes');
        }
    },
    updated() {
        var highestBox = 0;
        var targetDiv = document.querySelectorAll('.equal-height-pos');
        for (var i = 0; i < targetDiv.length; i++) {
            if (targetDiv[i].clientHeight > highestBox) {
                highestBox = targetDiv[i].clientHeight;
            }
        }
        document.querySelectorAll(".equal-height-pos").forEach(node => node.style.height = highestBox + "px");
        $("span.select2-container--default").css({'width':'100%','z-index': '999'});


    },
    beforeCreate() {
        this.$emit('addLoader');
    },
    created() {
        this.getsetting();
        this.getcategoryfeturedlist();
        this.getCart();
        this.getavaliableTable();
    },
    watch: {},
    methods: {
        getavaliableTable(){
             axios.get('/api/getavaliableTable')
                .then(res => {
                    var arr = [];
                    res.data.table.forEach(function (element) {
                        console.log(element);
                        var obj = {};
                        obj['id'] = element;
                        obj['text'] = 'Table - ' + element;
                        arr.push(obj);
                     });
                     this.avaliableTable = arr;
                    // this.avaliableTable = res.data.table;
                }).catch(err => {})
        },
        getsetting() {
            axios.get('/api/getSettingData')
                .then(res => {

                    this.currencyCode = res.data.setting.currency_symbol;
                }).catch(err => {})
        },
        addcombocart(id) {
            this.product.id = id;
            this.productId = id;
            $('#loader_' + id).removeClass('d-none');
            $('#addtocart_' + id).attr('disabled','disabled');
            this.AddToCart();
        },
        getcategoryfeturedlist() {
            axios.get('/api/getcategoryfeturedlist')
                .then(res => {
                    var categories = res.data.categories;
                    var products = res.data.products;
                    var test = {
                        featured: 0,
                        id: 0,
                        image: "category/default.png",
                        name: "All",
                        slug: "all",
                        activeproducts_count: res.data.total
                    }
                    categories.unshift(test);
                    this.featuredcategories = categories;
                    this.products = products;
                    this.$emit('removeLoader');
                }).catch(err => {})
        },
        sliderChangeSelection() {
            const thisEle = event.target;
            const parentEle = thisEle.closest('.equal-height-pos');
            const allEle = document.querySelectorAll('.equal-height-pos');
            allEle.forEach(ele => {
                ele.classList.remove('active');
            });
            parentEle.classList.add("active");
            this.getproductslist();
        },
        getproductslist(selection) {
            this.addLoader = true;

            if (selection == 'ingredient') {
                this.vegOnlySelect = false;
                this.comboSelect = false;
                this.offerSelect = false;
            }

            if (selection == 'vegOnly') {
                this.ingredientSelect = false;
            }
            if (selection == 'combo') {
                this.ingredientSelect = false;
            }
            if (selection == 'offers') {
                this.ingredientSelect = false;
            }

            var sliders = document.querySelectorAll(".product--list.active");

            var id = sliders[0].getAttribute('data-id');
            const data = {};
            this.getsetting();
            data['id'] = id;
            data['veg'] = this.vegOnlySelect;
            data['combo'] = this.comboSelect;
            data['ingredient'] = this.ingredientSelect;
            axios.post('/api/getproductslist', data)
                .then(res => {
                    this.products = res.data.products;
                    this.addLoader = false;
                }).catch(err => {})

        },
        formatPrice(value) {
            let val = (value / 1).toFixed(2)
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },
        openDetailpopup(id) {
            // $('#loader_product_' + id).removeClass('d-none');
            this.addCartLoader = true;
            var id = id;
            axios.get('/api/getProductPosData/' + id)
                .then(res => {
                    this.product.id = res.data.product.id;
                    this.product.name = res.data.product.name;
                    this.product.price = res.data.product.price;
                    this.product.image = `/storage/` + res.data.product.image;
                    this.ingredientCategories = res.data.ingredientCategories;
                    this.sizes = res.data.sizes;
                    this.popupSelectPriceSize = this.sizes[0].price;
                    this.selectSizes = this.sizes[0].size.name;
                    this.selectSizesPrice = res.data.product.price;
                    this.popupQuantityValue = 1;
                    this.sizeId = this.sizes[0].size_id;
                    $('#loader_product_' + id).addClass('d-none');
                    this.updateTotal();
                        this.addCartLoader = false;
                    if(this.ingredientCategories.length){
                        var opencanvas = document.getElementById('openDetails')
                        var sidetocanvas = new bootstrap.Offcanvas(opencanvas)
                        sidetocanvas.show(this.selectSizesPrice);
                        this.popUpprice = (this.product.price + this.selectSizesPrice[0].price);
                    }else{
                        if(this.sizes.length <= 1){
                            this.AddToCart();
                        }else{
                        var opencanvas = document.getElementById('openDetails')
                        var sidetocanvas = new bootstrap.Offcanvas(opencanvas)
                        sidetocanvas.show()
                        this.popUpprice = (this.product.price + this.selectSizesPrice[0].price);
                        }
                    }
                }).catch(err => {})
        },
        selectSize(price, id, name) {
            var sizes = document.getElementsByClassName('size-selection');
            this.popupSelectPriceSize = price;
            this.selectSizes = name;
            this.sizeId = id;

            this.updateTotal();
        },
        ingredientSelection(event) {
            var ing = document.getElementsByClassName('ingredient-selection');
            event.currentTarget.classList.toggle("active");
            var selectIng = '';
            for (var i = 0; i < ing.length; i++) {
                if (ing[i].classList.contains('active')) {
                    selectIng += ing[i].getAttribute('data-name') + ', ';
                }
            }
            selectIng = selectIng.slice(0, -2);
            this.selectIngredient = selectIng;
            this.updateTotal();
        },
        updateTotal() {
            var quantity = this.popupQuantityValue;
            var productPrize = this.selectSizesPrice;
            var prize = productPrize;

            var ing = document.getElementsByClassName('ingredient-selection');
            for (var i = 0; i < ing.length; i++) {
                if (ing[i].classList.contains('active')) {
                    prize = parseInt(prize) + parseInt(ing[i].getAttribute('data-price'));
                }
            }
            prize = parseInt(prize) + parseInt(this.popupSelectPriceSize);
            prize = parseInt(prize) * parseInt(quantity);
            this.popUpprice = prize;
        },
        changePopupQuantity(event) {
            var act = event.currentTarget.getAttribute('data-action');
            if (act == 'minus') {
                if (this.popupQuantityValue > 1) {
                    this.popupQuantityValue--;
                }
            }

            if (act == 'plus') {
                this.popupQuantityValue++;
            }
            this.updateTotal();
        },
        async AddToCart() {
            // this.addToCartLoader = true;
            this.addSwiper = true;
            var productId = this.product.id;
            var Quantity = this.popupQuantityValue;
            var sizes = document.getElementsByClassName('size-selection');
            $("#loader_" + productId).removeClass("d-none");
            var sizeId = this.sizeId;
            var ingArray = [];
            var ing = document.getElementsByClassName('ingredient-selection');
            for (var i = 0; i < ing.length; i++) {
                if (ing[i].classList.contains('active')) {
                    ingArray.push(ing[i].getAttribute('data-id'))
                }
            }

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            var formData = new FormData();
            formData.append('productId', productId);
            formData.append('Quantity', Quantity);
            formData.append('sizeId', sizeId);
            formData.append('ingArray', ingArray);
            formData.append('combo', this.comboSelect);
            formData.append('ingredient', this.ingredientSelect);
            if (productId) {
                await axios
                    .post("/api/addtocart", formData, config)
                    .then((res) => {
                        this.getCart();
                        this.product.id = '';
                        this.product.name = '';
                        this.product.price = '';
                        this.product.image = null;
                        this.ingredientCategories = '';
                        this.sizes = '';
                        this.selectSizes = '';
                        this.selectIngredient = '';
                        this.popupSelectPriceSize = 0;
                        this.sizeId = 0;
                        $('#addtocart_' + productId).removeAttr('disabled');
                        this.addToCartLoader = false;
                        var el = document.getElementById('closeProductDetail');
                        el.click();
                        $('#loader_' + productId).addClass('d-none');

                    }).catch((error) => {})
            }
        },
        getCart() {
            axios.get('/api/getCart')
                .then(res => {
                    this.cart.data = res.data.cart;
                    this.cart.total = res.data.total;
                }).catch(err => {})
        },
        removeCart(index) {
            var index = index;
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            axios
                .post("/api/removeCart", {
                    index: index
                }, config)
                .then((res) => {
                    this.getCart();
                }).catch((error) => {})
        },
        changeCartQuantity(index, event) {
            var index = index;
            var action = event.currentTarget.getAttribute('data-action');
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            axios
                .post("/api/changeCartQuantity", {
                    index: index,
                    action: action
                }, config)
                .then((res) => {
                    this.getCart();
                }).catch((error) => {})
        },

        placeOrder(purchase, description){
            this.purchase = purchase;
            this.description = description;
        },

        saveOrder() {
            var purchase = this.purchase;
            var description = this.description;
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            var error = 0;
            if(this.orderTable == '' && this.customerName != '' && this.contactNumber != '' && this.customerEmail != ''){
                this.$emit("showToast","Please select any one table.",'error');
                error = 1;
            }
            if(this.orderTable != '' && this.customerName == '' && this.contactNumber != '' && this.customerEmail != ''){
                this.$emit("showToast","Please enter customer name.",'error');
                error = 1;
            }

            if(this.orderTable != '' && this.customerName != '' && this.contactNumber == '' && this.customerEmail != ''){
                this.$emit("showToast","Please enter contect number.",'error');
                error = 1;
            }

            if(this.orderTable != '' && this.customerName != '' && this.contactNumber != '' && this.customerEmail == ''){
                this.$emit("showToast","Please enter customer email.",'error');
                error = 1;
            }

            if(error == 1){
                return false;
            }

            if(this.orderTable == '' || this.customerName == '' || this.contactNumber == '' || this.customerEmail == ''){
                this.$emit("showToast","Please fill out above details.",'error');
                return false;
            }

            axios
                .post("/api/saveOrder", {
                    purchase: purchase,
                    description: description,
                    orderTable: this.orderTable,
                    customerName: this.customerName,
                    contactNumber: this.contactNumber,
                    customerEmail: this.customerEmail,
                }, config,{
                    progress: () => {
                        $('#loader_CartOrder').removeClass('d-none');
                    }
                })
                .then((res) => {
                    document.getElementById('closeButton').click();
                    this.getCart();
                    this.$emit("showToast","Your order added successfully.",'success');
                    $('#loader_CartOrder').addClass('d-none');
                    this.$router.push(`/orders`);
                }).catch((error) => {})
        },
        changeDeliveryType(type) {
            var all = document.querySelectorAll('.purchase_type');
            all.forEach(function (al) {
                al.classList.remove("active");
            })
            var ele = document.querySelectorAll('.purchase_type[data-type=' + type + ']');
            ele.forEach(function (el) {
                el.classList.add("active");
            })
        },
        checkcustomer(select){
            this.orderTable = select.id;
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }
            var table = this.orderTable;
            axios
            .post("/api/check-customer-for-ongoingorder", {
                table: table,
            }, config)
            .then((res) => {
                if(res.data.getDetail){
                    this.customerName = res.data.tableorder.customer.name;
                    this.contactNumber = res.data.tableorder.customer.phone;
                    this.customerEmail = res.data.tableorder.customer.email;
                }else{
                    this.customerName = '';
                    this.contactNumber = '';
                    this.customerEmail = '';
                }
            }).catch((error) => {})


        },
        addstyle(){
            $(".select2-dropdown").css({'top': '-42px'});
            $(".select2-search--dropdown").css({'min-height': '42px'});
        },
        /* Contact Detail Find Through Contact Number */
        findContactthroughNumber() {

            if(this.contactNumber.toString().length == 10){
                const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }
            var phone = this.contactNumber;
            axios
            .post("/api/find-customer-through-number", {
                phone: phone,
            }, config)
            .then((res) => {
                if(res.data.getDetail){
                    this.customerName = res.data.customer.name;
                    this.contactNumber = res.data.customer.phone;
                    this.customerEmail = res.data.customer.email;
                }else{
                    // this.customerName = '';
                    // this.contactNumber = '';
                    // this.customerEmail = '';
                }
            }).catch((error) => {})
            }
        }
    },
};
</script>

<style scoped>
/* --------- COMMAN CLASS -------------- */
    .addtocart-btn-spinner{
        right: 10%;
        top: 25%;
        width : 1.5rem;
        height : 1.5rem;
    }
    .equal-height-pos{
        min-height: 41px;
    }
  .equal-height-pos a.stretched-link{
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2; /* number of lines to show */
            line-clamp: 2;
    -webkit-box-orient: vertical;
    word-break: break-word;
  }

  .ingredient-selection{
    cursor: pointer;
  }

  .modal-dialog {
      max-width: 700px;
      margin: 1.75rem auto;
  }
/* ------------------------SMALL IMG SLIDER START ---------------*/
    .small-slider-card img {
    width:100%;
    margin: 0 auto;
    height:100%;
    max-height: 31px;
    border-radius: 100px !important;
    max-width:34px;

    }

    .small-slider-card {
    width: 116px;
    height:41px !important;
    transition: all 1s ease;
    }

    .small-slider-card:hover,
    .small-slider-card.active {
    background-color: #0ab39c !important;
    }

    .small-slider-card:hover .card-body-title a,
    .small-slider-card:hover p,
    .small-slider-card.active p,
    .small-slider-card.active a {
    color: #fff !important;
    }

    .small-slider-card .card-body-title a,
    .small-slider-card p {
    transition: all 1s ease;

    }
/* ------------------------SMALL IMG SLIDER END-------------*/

/* ---------------------POS MENU CARD START -----------------*/
.main-content .pos-main .pos-right-main  .pos-menu-card {
    background: #FFFCFC;
    box-shadow: 0px 0px 4px 1px rgb(0 0 0 / 25%);
    border-radius: 10px;
}
.main-content .pos-main .pos-right-main .pos-menu-card .menu-card-inner{
    height: 100vh;
    max-height: calc(100vh - 205px);
    overflow: auto;
}
.main-content .pos-main .pos-right-main .pos-menu-card .menu-card-inner::-webkit-scrollbar{
  width:3px;
  background:transparent;
}
.main-content .pos-main .pos-right-main .pos-menu-card .menu-card-inner::-webkit-scrollbar-thumb {
    background: #8b8a8a;
    border-radius: 10px;
}
.main-content .pos-main .pos-right-main .pos-menu-card .pos-single-card{
    max-height:178px;
    box-shadow: 0px 0px 8px 1px rgba(0, 0, 0, 0.25);
    background:#FFFFFF;
    border-radius:10px !important
}
.main-content .pos-main .pos-right-main .pos-menu-card .pos-single-card .pos-card-img{
    min-height: 70px;
    border-radius: 50%;
    margin-top: -8px;
}
.main-content .pos-main .pos-right-main .pos-menu-card .menu-card-inner .card-content{
  max-height:34px;
}
.main-content .pos-main .pos-right-main .pos-menu-card .menu-card-header .form-check-label {
  line-height:20px;
  font-weight:500;
}
.main-content .pos-main .pos-right-main .pos-menu-card .card .ribbon-box .ribbon-three::after{
    border-left: 34px solid transparent;
    border-right: 34px solid transparent;
}
.main-content .page-content .pos-main .pos-inner .pos-menu-card .card .ribbon-three::after{
  right: 0px;
  top:27px;
}
.main-content .page-content .pos-main .pos-inner .pos-menu-card .card .ribbon-box.right .ribbon-three{
  right:-3px
}
.main-content .pos-main .pos-right-main .pos-menu-card .card .ribbon-box .ribbon-three span{
  width:68px;
  padding: 11px 5px 7px;
  white-space:nowrap;
}
/* ---------------------POS MENU CARD END -----------------*/
.addtocart-btn-spinner.product--loader{
    top:15%;
}
.loading {
    height: 0;
    width: 0;
    padding: 15px;
    border: 6px solid #0ab39c;
    border-right-color: transparent;
    border-radius: 22px;
    -webkit-animation: rotate-0349ff8e 1s infinite linear;
    position: absolute;
    left: 50%;
    top: 50%;
    z-index: 10;
}

@-webkit-keyframes rotate {
  100% {
    -webkit-transform: rotate(360deg);
  }
}
#orderPlaceModal .modal-content .modal-body.border--top::after{
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    border-top: 7px solid #0AB39C;
    border-radius: 10px 10px 0 0;
}
  @media screen and (max-width:1024px){
  .main-content .page-content{
    padding-top:23px;
  }
  .main-content .page-content .pos-main .pos-notification{
    margin:0;
  }
}

@media screen and (min-width:1025px) and (max-width:1230px){
  .pos-main .nav.nav-responsive .nav-item a.nav-link{
    padding:0.5rem 0.5rem;
    font-size:15px;
  }
}
@media screen and (max-width:1440px){
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
    .main-content .pos-main .pos-right-main .pos-menu-card .menu-card-inner{
    max-height: calc(100vh - 230px) ;
  }
}
@media screen and (max-width:991px){
   .col-md-lg{
    width:100%;
    max-width:527px;
  }
  .small-slider-card {
    width: 110px;
  }
}
@media (min-width: 992px){
.col-lg-4 {
  -webkit-box-flex: 0;
  -ms-flex: 0 0 auto;
  flex: 0 0 auto;
  width: 32.333333%;
}
}
@media screen and (max-width:820px){
  .main-content .pos-main .pos-right-main .pos-menu-card .menu-card-inner{
    max-height: calc(100vh - 230px);
  }
  .main-content .page-content .pos-main .pos-inner .pos-menu-card .card .ribbon-three::after {
    top: 27px;
    }
    .main-content .pos-main .pos-right-main .pos-menu-card .card .ribbon-box .ribbon-three::after {
    border-left: 32px solid transparent;
    border-right: 33px solid transparent;
    }
    .addtocart-btn-spinner.product--loader{
        right:6%;
    }
}
.equal-height-pos{
  min-height: 41px;
}
.equal-height-pos a.stretched-link{
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2; /* number of lines to show */
          line-clamp: 2;
  -webkit-box-orient: vertical;
  word-break: break-word;
}

.ingredient-selection{
  cursor: pointer;
}

.modal-dialog {
    max-width: 700px;
    margin: 1.75rem auto;
}

#orderPlaceModal .modal--content button{
    padding: 12px 42px;
    font-size: 16px;
    line-height:16px;
    border-radius:10px !important;
    color: #FFFFFF;
}
#orderPlaceModal .modal--content h4, #orderPlaceModal .modal--content p{
    color:#6D7080;
}
#orderPlaceModal .modal--content button.btn--1{
    border: 1px solid #6D7080;
    color: #6D7080;
    padding: 12px 56px;
}
#orderPlaceModal .modal--content button.btn--2{
    background: #0AB39C;
}
</style>
<style>
    /* -------- SELECT2 OPTION CSS ------------ */
    span.select2-selection--single{
        min-height: '42px';
    }
    .select2-selection__arrow{
        top: '8px';
    }
    .select2-selection__rendered{
        line-height: '40px';
    }
    .select2-search--dropdown--height{
        min-height: 42px;
    }
    span.select2-container {
        text-align: left;
        z-index: 9999;
    }
    .carousel__next {
        right: -6px;
    }
    .carousel__prev {
        left: -6px;
    }
</style>
