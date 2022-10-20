<template>
<div class="main-content">
    <div class="page-content pt-4 pb-2">
     <div class="catagory-mang">
        <!-------Start page title start-------->
        <div class="row p-4 mx-0">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ category.name }}</h4>
                    <div class="page-title-right">
                    </div>
                </div>
            </div>
        </div><!-------Start page title End-------->
        <section class="categories pt-1">
            <div class="categories-main">
                <div class="catagory-inner d-flex flex-wrap px-2">
                    <div class="catagory-single-card mb-3"  v-for="product in products" :key="product.id">
                    <!-- :class="product.status == 1 ? '' : 'deactive' " -->
                        <div class="card equal-height-ingredient" :class="product.status == 1 ? '' : 'card--deactive' ">
                            <div class="card-bottom px-1 pb-2 text-center border-0" :class="product.status == 1 ? '' : 'mt-auto' ">
                                <ul class="list-inline mb-0 mt-2 d-flex justify-content-between align-items-center">
                                    <li class="list-inline-item me-0 list--delete" v-if="allpermissions.ProductDelete">
                                        <a href="javascript:;" class="align-middle" data-bs-toggle="modal" data-bs-target="#removedataalert"  @click="proId = product.id"><i class="fa-solid fa-trash-can text-danger"></i></a>
                                    </li>
                                    <li class="list-inline-item list--edit" v-if="allpermissions.ProductEdit">
                                        <a href="javascript:;" class="align-middle" @click="editProduct(product.slug)" ><i class="fa-solid fa-pen-to-square color-gray"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body px-3 py-2 text-center img--height">
                                <div class="mx-auto avatar-lg mb-2 card-image">
                                    <img :src="'/storage/'+ product.image"  alt="product" class="w-100 border-radius-10" >
                                </div>
                            </div>                                
                            <p  class="fs-11 title--name px-1 text-center mb-0">{{ product.name }} </p>
                            <div class="card--footer border-0 mt-auto" v-if="product.status == 1">
                                <div class="card-footer-detalis d-flex justify-content-between align-items-center fs-8 color-gray">
                                    <p class="mb-0">Last updated</p>
                                    <p class="mb-0">{{ format_date(product.updated_at) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    </div>
    <DeleteAlert @removeData="removeData" />
    <!------FOOTER START -------->
        <footer>
            <div class="footer-main bg-white" style="position:fixed; bottom: 0; width: 100%;">
                <div class="footer-link d-flex align-items-center justify-content-between">
                    <a href="javascript:;" @click="$router.go(-1)" class="text-success fs-16"><i class="ri-arrow-go-back-line "></i> Back</a>
                    <div class="submit-btn">
                        <button class="btn btn-success btn-custom fs-16"  @click="AddProduct()" v-if="allpermissions.ProductAdd"><i class="ri-add-fill me-1 align-bottom" ></i> Add Product</button>
                    </div>
                </div>
            </div>
        </footer>
    <!------FOOTER END -------->
</div>
</template>

<script>
import $ from "jquery";
import { useToast } from "vue-toastification";
import DeleteAlert from './include/DeleteAlert.vue';
import moment from 'moment';
export default {
    components : { DeleteAlert },
    data(){
        return{
            products : [],
            category: {
                name: '',
                slug: '',
            },
            product: {
                id : '',
                name: '',
                price: '',
                image: '',
                previewImage: null,
                submitButton: 'Add Product'
            },
            errors: {
                product: {
                    name: '',
                    price: '',
                    image: '',
                }
            },
            currencyCode : '',
            toast : useToast(),
            proId : 0,
        }
    },
    props : ['allpermissions'],
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

    },
    beforeCreate(){
        this.$emit('addLoader');
    },
    created() {
        this.getsetting();
        this.getproductlist();
    },
    watch: {

    },
    methods:{
        format_date(date){
            if (date) {
                return moment(String(date)).format('DD-MM-YYYY H:mm')
            }
        },
        getsetting(){
            axios.get('/api/getSettingData')
            .then(res => {
                this.currencyCode = res.data.setting.currency_symbol;
            }).catch(err => {
            })
        },
        onImageChange(e){
        this.product.image = e.target.files[0];
        },
        getproductlist(){
            var url = `/api/getallproductlist`;
            if(this.$route.params.slug){
                url = `/api/getproductlist/${this.$route.params.slug}`;
            }
            console.log(url);
            axios.get(url)
                .then(res => {
                    this.products = res.data.products;
                    this.$emit('removeLoader');
                    this.category.name = res.data.category.name;
                    this.category.price = res.data.category.price;
                    this.category.slug = res.data.category.slug;
                }).catch(err => {
                })
        },
      editProduct(slug){
        var slug = slug;
        if(this.category.slug)
            this.$router.push(`/products/`+this.category.slug+`/edit/`+slug);
        else
            this.$router.push(`/products/edit/`+slug);
      },
      AddProduct(){
        if(this.category.slug)
            this.$router.push(`/products/`+this.category.slug+`/add`);
        else
            this.$router.push(`/add/product`);
      },
        removeData(){
            var formData = new FormData();
            formData.append('id', this.proId);
            axios
            .post("/api/removeProduct",formData)
            .then((res) => {
                this.$emit("showToast",res.data.success,'success');
                this.getproductlist();

            }).catch((error) => {
            })
        },
    }
};


</script>

<style scoped>

    .ribbon {
        opacity: 0;
        transition: all 0.5S ease;
        transform: translateY(50px);
    }

    .ribbon-box:hover .ribbon {
        opacity: 1;
        transform: translateY(0px);
    }
    .imagePreviewWrapper {
        width: 250px;
        height: 250px;
        display: block;
        cursor: pointer;
        margin: 0 auto 30px;
        background-size: cover;
        background-position: center center;
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
        min-height: 33px;
    }
    /*********** CATEGORIES LIST START ***********/
    .catagory-mang{
        background: #FFFFFF;
        box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.25);
        border-radius: 10px;
        height: 100vh;
        max-height: calc(100vh - 174px);
    }
    .categories{
        overflow: auto;
        height: 100%;
        max-height: calc(100% - 75px);
    }
    .categories .categories-main .catagory-single-card .card .img--height{
        width: 100%;
        max-height: 52px;
    }
     .categories-main .catagory-inner .catagory-single-card .card .avatar-lg{
        width:5.5rem;
        height:5.5rem;
    }
     .categories-main .catagory-inner .catagory-single-card .card .card-image{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        max-width: 76px;
        width: 100%;
        max-height: 76px;
        margin-top: -11px;
    }
     .categories-main .catagory-inner .catagory-single-card{
        flex: 0 0 8.33%;
        max-width:8.33%;
    }
     .categories-main .catagory-inner .catagory-single-card .card{
        background: #FFFFFF;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        max-width:128px;
        margin-right:auto;
        margin-left:auto;
        height: 150px;
        max-height: 150px;
    }
    .categories .catagory-single-card .card--footer .card-footer-detalis{
        padding: 4px 3px;
        font-size: 8px;
        line-height: 13px;
        white-space: nowrap;
        background: #F4F4F4;
        box-shadow: 0px -1px 5px rgba(0, 0, 0, 0.1);
        border-radius: 0px 0px 10px 10px;
        color: #878a99;
        font-weight: 400;
    }
    .categories .catagory-single-card .card-bottom .list--delete{
        height: 20px;
        padding: 3px;
        width: 20px;
        background: rgb(234 124 105 / 18%);
        border-radius: 4px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .categories .catagory-single-card .card--deactive .card-bottom .list--delete{
        z-index:100;
        background: rgb(248 165 151 / 20%);
    }
    .categories .catagory-single-card .card-bottom .list--edit{
        height: 20px;
        padding: 3px;
        width: 20px;
        background: #F4F4F4;
        border-radius: 4px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .categories .catagory-single-card .card--deactive .card-bottom .list--edit{
        z-index:100;
        background: rgba(244 ,244 ,244,0.35);
    }
    .categories-main .catagory-inner .catagory-single-card .card--deactive{
        position:relative;

    }
     .categories-main .catagory-inner .catagory-single-card .card--deactive::before{
        position: absolute;
        content: "";
        background-color: rgba(0,0,0,0.5);
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 99;
        border-radius: 10px;
        border-bottom: 3px solid #DD3333;
     }
    .categories-main .catagory-inner .catagory-single-card .card--deactive::after{
        position: absolute;
        content: "\f05e";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        right: 6px;
        top: 6px;
        bottom: 0;
        z-index: 99;
        color: #DD3333;
    }
    section.categories::-webkit-scrollbar {
        width: 3px;
        background: transparent;
    }
    section.categories::-webkit-scrollbar-thumb {
        background: #8B8A8A;
        border-radius: 10px;
    }
    /********** FOOTER CSS START ***********/
     .footer-main{
        padding:8px 15px 8px 32px;
    }
    .footer-main .footer-link .btn-custom{
        padding:12px 42px;
        font-weight:500;
        line-height:16px;
    }
    /*********** CATEGORIES LIST END ***********/
     @media screen and (max-width:1550px){
        .categories-main .catagory-inner .catagory-single-card{
            flex:0 0 10%;
            max-width:10%;
        }
    }
    @media screen and (min-width:1551px) and (max-width:1740px){
        .categories-main .catagory-inner .catagory-single-card{
            flex:0 0 9%;
            max-width:9%;
        }
    }
     @media screen and (min-width:1181px) and (max-width:1366px){
        .categories-main .catagory-inner .catagory-single-card{
            flex:0 0 11%;
            max-width:11%;
        }
    }

     @media screen and (max-width:1180px){
        .categories-main .catagory-inner .catagory-single-card{
            flex:0 0 12.5%;
            max-width:12.5%;
        }
        .catagory-mang{
        max-height: calc(100vh - 213px);
        }
    }
    @media screen and (max-width:1024px) {
        .catagory-mang{
            max-height: calc(100vh - 163px);
        }
    }
     @media screen and (min-width:1024px) and (max-width:1179px){
        .categories-main .catagory-inner .catagory-single-card{
            flex:0 0 14%;
            max-width:14%;
        }
    }
    @media screen and (min-width:992px) and (max-width:1023px){
        .categories-main .catagory-inner .catagory-single-card{
            flex:0 0 14.28%;
            max-width:14.28%;
        }
    }
    @media screen and (min-width:576px) and (max-width:991px){
        .categories-main .catagory-inner .catagory-single-card{
            flex:0 0 20%;
            max-width:20%;
        }
    }
    @media screen and (max-width:820px){
        .catagory-mang{
            max-height:calc(100vh - 200px);
        }
    }

</style>
