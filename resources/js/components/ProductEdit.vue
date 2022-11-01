<template>
        <div class="main-content product-main-content">
            <div class="page-content pb-0 pt-4" style="margin-top:49px;">
               <section class="pos-main product-main">
                  <div class="pos-inner product-inner">
                    <!--------PRODUCT SECTION START ---------->
                    <div class="row px-2 py-3 my-1 tab-view-product">
                        <div class="col-lg-8 col-md-7 col-12 pe-0">
                            <div class="product-left-main h-100">
                                <form class="product-form">
                                        <div class="col-12">
                                            <div class="row mb-3 pb-1">
                                                <div class="col-lg-8 mb-lg-0 mb-3">
                                                    <div class="input-type-field">
                                                        <label for="p-name" class="form-label fs-14 padding-start-10 color-gray" data-v-3f321cdd="">Product Name:</label>
                                                        <input type="text" class="form-control" placeholder="Enter Product name" id="p-name" v-model="product.name">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="input-type-field-price">
                                                        <label for="regprice" class="form-label fs-14 padding-start-10 color-gray">Regular price:</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" placeholder="0.0" id="regprice" v-model="product.price" @focusout="ProductPriceSet()" ><span class="input-group-text">{{currencyCode}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-3 pb-1">
                                                <div class="col-lg-8 col-md-7 mb-lg-0">
                                                    <label class="form-label fs-14 padding-start-10 color-gray">Category:</label>
                                                         <Select2 v-model="categoryName" :options="categories" :settings="{ settingOption: value, settingOption: value }" @change="myChangeEvent($event)" />
                                                </div>
                                                <div class="col-lg-4 col-md-5">
                                                     <label class="form-label fs-14 padding-start-10 color-gray"></label>
                                                    <div class="form-group mt-2">
                                                        <div class="fileUpload">
                                                            <div class="fileUpload_preview" :class="{ 'd-block' : image_url }">
                                                                <img v-if="image_url" :src="image_url" alt="productedit" class="img_fileUpload_preview">
                                                            </div>
                                                            <div class="fileUpload_input">
                                                                <input type="file" class="upload input_file_upload" @change="onImageChange">
                                                                <span><i class="ri-upload-cloud-2-line text-success fs-20 pe-lg-2 pe-1"></i><span class="text_file_upload fs-16 text-success">Edit Picture</span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="row mb-3 pb-1">
                                                <div class="col-lg-4 col-12">
                                                    <div class="col-12">
                                                        <label class="form-label fs-14 padding-start-10 color-gray">Status:</label>
                                                    </div>
                                                    <div class="form-check form-check-inline form-radio-success">
                                                        <input class="form-check-input" v-model="product.status" type="radio" id="active" name="status" value="1" checked>
                                                        <label class="form-check-label ps-2 fs-14" for="active" style="vertical-align:sub;">Active</label>
                                                    </div>
                                                     <div class="form-check form-check-inline form-radio-success">
                                                        <input class="form-check-input" v-model="product.status" type="radio" id="deactivate" name="status" value="0">
                                                        <label class="form-check-label ps-2 fs-14" for="deactivate" style="vertical-align:sub;">Deactivate</label>
                                                    </div>
                                                </div>
                                                <!------ Sub Catagory -------->
                                                 <div class="col-lg-4 col-12">
                                                    <div class="col-12 mt-3 mt-lg-0">
                                                        <label class="form-label fs-14 padding-start-10 color-gray">Food Type:</label>
                                                    </div>
                                                    <div class="form-check form-check-inline form-radio-success">
                                                        <input class="form-check-input" v-model="product.foodType" type="radio" id="veg" name="foodType" value="1">
                                                        <label class="form-check-label ps-2 fs-14" for="veg" style="vertical-align:sub;">Veg</label>
                                                    </div>
                                                     <div class="form-check form-check-inline form-radio-success">
                                                        <input class="form-check-input" v-model="product.foodType" type="radio" id="non-veg" name="foodType" value="0">
                                                        <label class="form-check-label ps-2 fs-14" for="non-veg" style="vertical-align:sub;">Non-veg</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3 pb-1">
                                            <div class="col-12">
                                                <div class="product-description-text">
                                                    <label class="form-label fs-14 fw-medium padding-start-10 color-gray">Description
                                                        <div class="tooltip ps-2"><i class="ri-information-line tooltip-icon fs-16"></i>
                                                                <span class="tooltiptext">This text Will be available under product names in the Physician Menu Card.
                                                                </span>
                                                        </div>
                                                    </label>
                                                    <textarea class="form-control border-radius-10" v-model="product.description" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <!----- Product Size Start -------->                                        
                                        <div class="col-12 mb-3 pb-1">
                                            <div class="product-size">
                                                <label class="form-label fs-14 fw-medium padding-start-10">Size </label>
                                                <div class="size-box-main d-flex align-items-center">
                                                    <div class="sizebox-inner pe-3 me-1" v-for="ingredient in sizes" :key="ingredient.id" @click="addSize(ingredient.id)" >
                                                        <div class="avatar-sm border-radius-10 sizebox-single position-relative" :style="{ 'cursor' : 'pointer' }" :class="{ active : selectSizes.includes(ingredient.id) }">
                                                            <i class="ri-checkbox-circle-fill position-absolute fs-18 text-success" v-if="selectSizes.includes(ingredient.id)" style="top: -7px; right: -3px;"></i>
                                                            <div class="avatar-title rounded product-ing-box color-gray fs-24 fw-bold">
                                                                {{ ingredient.name }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!----- Product Size End -------->
                                        <!-------- Product-ingredients Start-------->
                                        <!-- {{selectIngredients}} -->
                                        <div class="col-12">
                                            <div class="product-ingredients">
                                                <label class="form-label fs-14 fw-medium padding-start-10">ingredients </label>
                                                <div class="product-ingredients-main row">
                                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-2 col-12 col-xlmd mb-3" v-for="ing in selectIngredients" :key="ing">
                                                         <!------ Active box Start --------->
                                                        <div class="product-ing-box position-relative product-ingredients-inner active text-center">
                                                            <i class="ri-checkbox-circle-fill position-absolute fs-18 text-success" style="top:-7px; right:-3px;"></i>
                                                            <span class="position-absolute translate-middle badge" style="top: 8px; left:35px; width: 72px; background-color:#333333; line-height:11px; font-size:11px; border-radius:10px 0;">{{ing.price}}</span>
                                                            <div class="mx-auto pt-4 ingredient-image">
                                                                <img :src="ing.image" alt="productedit" class="img-fluid rounded-circle">
                                                            </div>
                                                             <div class="image--name">
                                                                <p class="mb-0 pt-1 color-gray fs-13">{{ing.name}}</p>
                                                            </div>
                                                        </div>
                                                        <!------- Active box end ------->
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-2 col-12 col-xlmd mb-3">
                                                         <!------ ADD MORE BOX ------>
                                                        <div class="border-radius-10 add-more-box d-flex justify-content-center align-items-center text-dark text-center position-relative" style="background-color: #0AB39C;">
                                                            <a href="javascript:;" @click="addIngredient()"><i class=" ri-add-line text-white" style="font-size: 40px;"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-------- Product-ingredients End-------->
                                </form>
                            </div>
                        </div>
                        <IngredientList :ingredients="ingredients" :selectSizesPrice="selectSizesPrice" @setPrice="setPrice" :sizes="sizes" :currencyCode="currencyCode" :selectSizes="selectSizes" :selectIngredients="selectIngredients" :selIng="selIng" ref="childComponent" @searchIngredients="searchIngredients"/>
                    </div>
                    <!--------PRODUCT SECTION END ---------->
                  </div>
               </section>
               <!-------PRODUCT SECTION END ----------->
            </div>
            <!-- End Page-content -->
              <!------FOOTER START -------->
            <footer>
                <div class="footer-main bg-white" style="position:fixed; bottom: 0; width: 100%;">
                    <div class="footer-link d-flex align-items-center justify-content-between">
                        <a href="javascript:;" @click="$router.go(-1)" class="text-success fs-16"><i class="ri-arrow-go-back-line "></i> Back</a>
                        <div class="submit-btn btn btn-success fs-16" @click="addeditproduct()">{{ product.submitButton }}</div>
                    </div>
                </div>
            </footer>
            <!------FOOTER END -------->
        </div>
        <!-- end main content-->



</template>

<script>
import $ from "jquery";
import Select2 from 'vue3-select2-component';
import IngredientList from './include/IngredientList.vue';
import { useToast } from "vue-toastification";
export default {
    components: {Select2,IngredientList},
    data(){
        return{
            sizes : [],
            selectSizes : [],
            selectSizesPrice : [],
            selectIngredients : [],
            selIng : [],
            ingredients : [],
            categories : [],
            category: {
                name: '',
            },
            product: {
                id : '',
                name: '',
                price: '',
                image: '',
                description : '',
                status : 0,
                foodType: '',
                previewImage: `/assets/images/addimageicon.png`,
                submitButton: 'Add Product'
            },
            errors: {
                product: {
                    name: '',
                    price: '',
                    image: '',
                    description : '',
                }
            },
            image_url : null,
            categoryName : '',
            typeOfFood : ['Veg','Non-veg'],
            allcategories : [],
            catwithslug : [],
            toast : useToast(),
            currencyCode : "",
            popupSelectSize: 0,
            popupSelectPriceSize: 0,
        }
    },
    mounted() {
        $(this.$refs.modalTest).on("hidden.bs.modal", () => { alert('yes')} );
    },
    updated() {
        var highestBox = 0;
        var targetDiv = document.querySelectorAll('.equal-height-product');
        for(var i=0; i<targetDiv.length;i++){
        if(targetDiv[i].clientHeight > highestBox){
                highestBox = targetDiv[i].clientHeight;
        }
        }
        document.querySelectorAll(".equal-height-product").forEach(node => node.style.height = highestBox + "px");
        $("span.select2-container--default").css({'z-index': '10','width':'100%'});

    },
    beforeCreate(){
        this.$emit('addLoader');
    },
    created() {
        this.getsetting();
        this.getaddproductpagedata();
    },
    watch: {

    },
    methods:{
        getsetting(){
            axios.get('/api/getSettingData')
            .then(res => {
                this.currencyCode = res.data.setting.currency_symbol;
            }).catch(err => {
            })
        },
        onImageChange(e){
            this.product.image = e.target.files[0];
            this.image_url = URL.createObjectURL(this.product.image);
        },
        getaddproductpagedata(){
            let slug = this.$route.params.slug;
            axios.get(`/api/geteditproductpagedata/`+slug)
                .then(res => {
                    this.sizes = res.data.sizes;
                    this.ingredients = res.data.ingredients;
                    this.product.id = res.data.product.id;
                    this.product.name = res.data.product.name;
                    this.product.price = res.data.product.price.toFixed(2);
                    this.product.status = res.data.product.status;
                    this.product.description = res.data.product.description;
                    this.product.submitButton = 'Saved Product';
                    this.product.previewImage = `/storage/`+res.data.product.image;
                    this.image_url = this.product.previewImage;
                    this.allcategories = res.data.categories;
                    this.product.foodType = res.data.product.food_type;
                    this.catwithslug = res.data.categoriewithslug;
                    this.categories = Object.values(res.data.categories);

                    this.$emit('removeLoader');

                    if(this.$route.params.slug){
                        this.categoryName = res.data.product.category.name;
                    }
                    res.data.selectSize.forEach(ele => {
                        this.selectSizes.push(ele.size_id);
                        this.selectSizesPrice[ele.size_id] = ele.price;
                    });
                    this.getsetting();
                    // this.$emit('removeLoader');
                    res.data.selectIng.forEach(data => {
                        var ingredient = {
                            id:data.id,
                            image:`/storage/`+data.image,
                            name:data.name,
                            price:`+ `+ this.currencyCode + ` ` +data.price.toFixed(2)
                        }
                        this.selIng.push(data.id);
                        this.selectIngredients.push(ingredient);
                    });
                }).catch(err => {
                })
        },
        ProductPriceSet(){
            this.product.price = this.product.price.toFixed(2);
        },
        addeditproduct(){

            this.$emit('showToast',"You Can not change this on demo account.",'error'); 
            return false;
            // const config = {
            //     headers: { 'content-type': 'multipart/form-data' }
            // }

            // var ingredient = this.selectIngredients.map(item => item.id);

            // var category = this.allcategories;
            // var categoryId = Object.keys(category).find(key => category[key] === this.categoryName);

            // if(categoryId == undefined){
            //     categoryId = '';
            //     if(this.product.name && this.product.price && categoryId == undefined && this.selectSizes.length != 0){ this.$emit("showToast","Please select any one category",'error'); return false; }
            // }

            // if(!this.product.name && this.product.price && categoryId != undefined && this.selectSizes.length != 0){ this.$emit("showToast","Please enter your product name.",'error'); return false; }

            // if(this.product.name && !this.product.price && categoryId != undefined && this.selectSizes.length != 0){ this.$emit("showToast","Please enter your product price.",'error'); return false; }

            // if(this.product.name && this.product.price && categoryId != undefined && this.selectSizes.length == 0){ this.$emit("showToast","Please select any one size of product.",'error'); return false; }

            // if(!this.product.name || !this.product.price || categoryId == undefined || this.selectSizes.length == 0){ this.$emit("showToast","Please fill out form details.",'error'); return false;}


            // var formData = new FormData();
            // formData.append('category_slug', this.$route.params.catslug);
            // formData.append('id', this.product.id);
            // formData.append('name', this.product.name);
            // formData.append('price', this.product.price);
            // formData.append('image', this.product.image);
            // formData.append('status', this.product.status);
            // formData.append('categoryId', categoryId);
            // formData.append('ingredient', ingredient);
            // formData.append('description', this.product.description);
            // formData.append('foodType', this.product.foodType);
            // this.selectSizesPrice.forEach((element, index) => {
            //      formData.append('sizes['+index+']', element);
            // });

            // axios
            // .post("/api/editproduct",formData,config)
            // .then((res) => {
            //     this.$emit("showToast",res.data.success,"success");
            //     var category = res.data.category.slug;
            //     this.$router.push(`/products/`+category);
            // }).catch((error) => {
            //     var errors = error.response.data.error
            // })


        },
        selectImage () {
            this.$refs.filesubInput.click()
        },
       pickFile () {
        var input = this.$refs.filesubInput
        var file = input.files
        if (file && file[0]) {
          var reader = new FileReader
          reader.onload = e => {
            this.product.previewImage = e.target.result
            document.getElementById("product-image-preview").classList.remove("d-none");
          }
          reader.readAsDataURL(file[0])
          this.$emit('input', file[0])
        }
      },
      blankForm(){
        this.product.id = '';
        this.product.name = '';
        this.product.price = '';
        this.product.image = '';
        this.errors.product.name = '';
        this.errors.product.price = '';
        this.errors.product.image = '';
        this.product.submitButton = 'Add Product';
        this.product.previewImage = null;
        document.getElementById('product-image').value = "";
        document.getElementById("product-image-preview").classList.add("d-none");
      },
      getProductSingleData(id){
        var id = id;
        document.getElementById("product-image-preview").classList.remove("d-none");
        axios.get('/api/getProductSingleData/'+id)
        .then(res => {
            this.product.id = res.data.content.id;
            this.product.name = res.data.content.name;
            this.product.price = res.data.content.price;
            this.product.submitButton = 'Saved Product';
            this.product.previewImage = `/storage/`+res.data.content.image;
        }).catch(err => {
        })
      },

        addIngredient(){
            var el = document.getElementById('ingredientListButton');
            el.click();
        },

        addSize(id){
            var el = document.getElementById('sizeListButton');
            el.click();
            var el2 = document.getElementById('openSizeModal'+id);
            el2.click();

            this.$refs.childComponent.checkSize(id);
        },
        setPrice(sizes){
            // let id = this.popupSelectSize;
            // this.selectSizesPrice[id] = price;
            // $("#size-price-" + id).text(price.toFixed(2));
            // this.popupSelectPriceSize = 0;
            this.selectSizes = sizes;
        },

        searchIngredients(ingredients){
            axios
            .post("/api/searchIngredients",ingredients)
            .then((res) => {
                this.ingredients = res.data.ingredients;
            }).catch((error) => {

            })
        }

    }
};

</script>
<style scoped>
     .form-check-input{
        width:18px;
        height:18px;
    }
    .form-check-input[type=checkbox]{
        border-radius:5px;
    }
    /******* File upload Css Start *********/
    .product-left-main .product-form .form-group .fileUpload{
            background: #FFFFFF;
            border: 1px solid rgba(0, 0, 0, 0.12);
            border-radius: 10px;
            overflow: hidden;
            padding: 0;
            position: relative;
            text-align: center;
            width: 100%;
            cursor: pointer;
            max-width: 571px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            justify-content: center;
            min-height: 42px;
    }
    .product-left-main .product-form .form-group .fileUpload .fileUpload_preview {
        display: none;
        border: 1px solid #0AB39C;
        background: #0AB39C;
        border-radius: 10px;
        height: 100%;
        min-height: 40px;
        line-height:40px;
        flex:0 0 20%;
        max-width:20%;
    }
    .product-left-main .product-form .form-group .fileUpload .fileUpload_preview img {
        max-height: 37px;
        border-radius: 50%;
        max-width: 37px;
        width: 100%;
        height: 100%;
    }
    .product-left-main .product-form .form-group .fileUpload .fileUpload_input {
        flex: 0 0 80%;
        max-width: 80%;
        padding: 10.5px 19px;
    }
    .product-left-main .product-form .form-group .fileUpload input.upload {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    .product-left-main .product-form .form-group input {
        background: #FFFFFF;
        border: 1px solid rgba(0, 0, 0, 0.12);
        border-radius: 10px;
        width: 100%;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        outline: 0;
        -webkit-transition: .2s all;
        transition: .2s all;
    }
    .product-left-main .product-form .form-group .fileUpload span {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        font-weight: 400;
        line-height: 16px;
        white-space:nowrap;
    }
    /******* File upload Css End *********/
    .product-left-main .product-form .product-size .size-box-main .sizebox-single.active{
        border:2px solid #0AB39C;
    }
    .tab-view-product .product-form .input-type-field input.form-control{
        background: #FFFFFF;
        border: 1px solid rgba(0, 0, 0, 0.12);
        border-radius: 10px;
    }
    .tab-view-product .product-form .input-type-field-price input.form-control{
        border-top-left-radius:10px;
        border-bottom-left-radius:10px;
        background: #FFFFFF;
        border: 1px solid rgba(0, 0, 0, 0.12);
    }
    .tab-view-product .product-form .input-type-field-price .input-group-text{
        background-color:#0ab39c;
        color:#fff;
        border-top-right-radius:10px;
        border-bottom-right-radius:10px;
    }
    .product-right-main .product-right-top .product-right-tab .nav-link.active{
        border-bottom:5px solid #fff;
    }
    /* --------- TOOLTIP CSS ------------ */
    .product-left-main .product-form .product-description-text .tooltip {
        position: relative;
        display: inline-block;
        vertical-align:middle;
        opacity:1;
        z-index:9;
    }
    .product-left-main .product-form .product-description-text .tooltip .tooltiptext {
            visibility: hidden;
            width:230px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgb(0 0 0 / 25%);
            color: #333;
            text-align: center;
            padding: 9px;
            border-radius: 6px;
            position: absolute;
            z-index: 1;
            bottom: 32px;
            left: -88px;
            font-size:14px;
    }
    .product-left-main .product-form .product-description-text .tooltip .tooltiptext::after {
        content: "";
        position: absolute;
        top: 106%;
        right: 50%;
        margin-top: -5px;
        border-width: 12px;
        border-style: solid;
        border-color: white transparent transparent transparent;
    }
    .product-left-main .product-form .product-description-text .tooltip:hover .tooltiptext {
        visibility: visible;
    }
    .product-ingredients .product-ingredients-main .product-ingredients-inner{
        height:auto;
        min-height:115px;
    }
    .product-ingredients .product-ingredients-main .product-ingredients-inner.active{
       border: 2px solid #0AB39C;
    }
     .product-ingredients .product-ingredients-main .add-more-box{
        width:100%;
        max-width:50px;
        height:100%;
        min-height:90px;
        margin-bottom:15px;
        margin-right:15px;
     }
     .product-ingredients .product-ingredients-main .product-ingredients-inner .ingredient-image{
        height:100%;
        min-height:78px;
     }
     .product-ingredients .product-ingredients-main .product-ingredients-inner .ingredient-image img{
        width:100%;
        max-width:55px;
        height:100%;
        max-height:55px;
     }
     .product-right-main .product-right-des .product-single-box .product-img img{
        width:100%;
        max-width:24px;
        height:100%;
        max-height:24px;
     }
     .product-right-des .product-single-box .product-np p{
        line-height:16px;
     }
    .error{
        color : red;
    }
    .title--name {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2; /* number of lines to show */
                line-clamp: 2;
        -webkit-box-orient: vertical;
        word-break: break-word;
    }
    .product-main-content .product-main .product-ing-box{
        box-shadow: -2px -2px 5px rgba(0, 0, 0, 0.25);
        border-radius: 10px !important;
        transition: all 0.5s ease-in;
        background:#fff;
    }
    .product-main-content .product-main .product-ing-box.active{
        background: rgba(10, 179, 156, 0.15);
    }
     .product-main-content .product-main .product-ing-box .badge{
        border-radius:10px 0;
     }
    .product-main-content .product-main .product-ing-box.active .badge
    {
        background-color: #0AB39C !important;
        transition: all 0.5s ease-in;

    }
    .product-main-content .product-right-main .product-right-top .form-control{
            padding-right: 5.9rem;
            padding-left: 17px;
            border-radius:10px;
    }
    .product-main-content .product-right-main .product-right-top .search-box .search-icon{
        background: #0ab39c;
        padding: 9px 14px;
        right: 4px !important;
        top: 4px;
        left: inherit;
        color: #fff;
        width: 37px;
        height: 34px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 10px;
    }
    .product-main-content .product-left-main{
        background: #FFFFFF;
        box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.25);
        border-radius: 10px;
        padding: 27px 19px;
        max-height: calc(100vh - 200px);
        overflow: auto;
    }
    .product-main-content .product-right-main{
        position: sticky;
        top: 93px !important;
        background: #FFFFFF;
        box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.25);
        border-radius: 10px;
    }
    .product-main-content .product-right-top{
        background: #0AB39C;
        border-radius: 6px 6px 0px 0px;
        box-shadow: 0px 3px 10px rgb(0 0 0 / 25%);
    }
    .product-right-main .tab-content::-webkit-scrollbar {
        display: none;
    }
    /* ------Scrollbar css -------------*/
    .product-main-content .product-left-main::-webkit-scrollbar-thumb {
        background: #8b8a8a;
        border-radius: 10px;
    }
    .product-main-content .product-left-main::-webkit-scrollbar {
        width: 3px;
        background: transparent;
    }
    /* --------------- FOOTER CSS --------------- */
    .footer-main{
        padding:8px 15px 8px 32px;
    }
    .footer-main .footer-link .submit-btn{
        padding:12px 42px;
        font-weight:500;
        line-height:16px;
    }
    /*******RESPONSIVE CSS ********/
    @media screen and (min-width:992px) and (max-width:1199px){
        .col-xlmd{
            flex:0 0 20%;
            max-width:20%;
        }

    }
   @media screen and (max-width:1024px) {
      .product-main-content .product-right-main{
            top:89px !important;
        }
        .product-right-main .product-right-des{
            height: calc(100vh - 271px) !important;
        }
    }
     @media screen and (max-width:1180px){
        .product-main-content .product-left-main{
        max-height: calc(100vh - 205px);
        }
    }
   @media screen and (max-width:820px){
     .product-main-content .product-left-main{
                max-height: calc(100vh - 198px);
            }
    .product-left-main .product-form .form-group .fileUpload .fileUpload_preview img{
        margin-top:6px;
    }
   }

</style>
