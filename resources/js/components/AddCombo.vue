<template>
<div class="main-content">
    <div class="page-content pb-0 pt-4">
        <div class="addcombo-main">
            <div class="addcombo-inner">
                <div class="row">
                    <div class="col-lg-8 col-md-lg pe-0">
                        <div class="addcombo-left addcombo-start">
                            <div class="addcombo-search">
                                <div class="search-box comboname-input">
                                    <input type="text" class="form-control border-radius-10" v-model="searchProd" placeholder="Search Products..." @keyup="searchProduct()">
                                    <i class="fa-solid fa-magnifying-glass search-icon fs-16"></i>
                                </div>
                            </div>
                            <div class="addcombo-card-main px-2 py-3">
                                <div class="addcombo-card d-flex flex-wrap">
                                    <div class="addcombo-single-card mb-3 position-relative" v-for="product in allProducts" :key="product">
                                        <div class="card overflow-hidden" :class="{active : selproduct.includes(product.id)}" style="cursor:pointer" @click="addProduct(product.id)">
                                            <img v-if="selproduct.includes(product.id)" alt="combo" src="/assets/images/check.png" class="position-absolute text-success"  style="top: -1px; right: -1px; z-index:99;">
                                            <div class="card-body p-0">
                                                <div class="body-content position-relative">
                                                    <img :src="'/storage/'+product.image" alt="combo" class="combo-img" :id="'combo_image_'+product.id">
                                                    <p class="mb-0 fs-10 px-lg-2 px-1 py-2 color-gray fw-bold line--clamp" :id="'combo_name_'+product.id">{{ product.name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col--md--lg">
                        <div class="addcombo-right addcombo-start">
                            <div class="addcombo-name">
                                <div class="row">
                                    <div class="col-7 pe-0">
                                        <div class="comboname-input">
                                            <label class="form-label padding-start-10 color-gray fs-14">Combo Name</label>
                                            <input type="text" v-model="combo.name" class="form-control border-radius-10" placeholder="Combo Name">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                         <div class="comboname-input">
                                            <label class="form-label padding-start-10 color-gray fs-14">Price</label>
                                            <input type="number" v-model.number="combo.price" @focusout="ComboPriceSet()" class="form-control border-radius-10" placeholder="16.00">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="comboname-input">
                                        <div class="col-12">
                                            <label class="form-label fs-14 padding-start-10 color-gray">Food Type:</label>
                                        </div>
                                        <div class="form-check form-check-inline form-radio-success">
                                            <input class="form-check-input" v-model="combo.foodType" type="radio" id="veg" name="foodType" value="1">
                                            <label class="form-check-label ps-2 fs-14" for="veg" style="vertical-align:sub;">Veg</label>
                                        </div>
                                        <div class="form-check form-check-inline form-radio-success">
                                            <input class="form-check-input" v-model="combo.foodType" type="radio" id="non-veg" name="foodType" value="0">
                                            <label class="form-check-label ps-2 fs-14" for="non-veg" style="vertical-align:sub;">Non-veg</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                  <div class="product--status">
                                        <div class="col-12">
                                            <label for="image" class="form-label fs-14 padding-start-10 color-gray">Status</label>
                                        </div>
                                        <div class="form-check form-check-inline form-radio-success">
                                            <input class="form-check-input" v-model="combo.status" id="active" type="radio" value="1" name="product--status" checked>
                                            <label class="form-check-label ps-2 fs-14" for="active">Active</label>
                                        </div>
                                        <div class="form-check form-check-inline form-radio-success me-0">
                                            <input class="form-check-input" v-model="combo.status" type="radio" id="deactive" value="0" name="product--status">
                                            <label class="form-check-label ps-2 fs-14" for="deactive">Deactive</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="addcombo-img mt-2">
                                    <div class="form-group">
                                        <div class="fileUpload">
                                            <div v-if="image_url" class="fileUpload_preview">
                                                <img :src="image_url" alt="combo" class="img_fileUpload_preview">
                                            </div>
                                            <div class="fileUpload_input">
                                                <input type="file" class="upload input_file_upload" @change="onImageChange">
                                                <span><i class="ri-upload-cloud-2-line text-success fs-20 pe-2"></i><span class="text_file_upload fs-16 text-success">{{image_text}}</span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="addcombo-card-main px-2 py-3">
                                <div class="addcombo-card d-flex flex-wrap">
                                    <div class="addcombo-single-card" v-for="item in selectedProduct" :key="item">
                                        <div class="card active overflow-hidden">
                                            <img  src="/assets/images/check.png" alt="combo" class="position-absolute text-success"  style="top: -1px; right: -1px; z-index:99;">
                                            <div class="card-body p-0">
                                                <div class="body-content position-relative">
                                                    <img :src="item.image" alt="combo" class="combo-img">
                                                    <div class="d-flex align-items-center justify-content-between  px-lg-2 px-1 py-1">
                                                        <p class="mb-0 fs-10 color-gray fw-bold line--clamp ">{{ item.name }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!------FOOTER START -------->
    <footer class="footer-start">
        <div class="footer-main bg-white" style="position:fixed; bottom: 0; width: 100%;">
            <div class="footer-link d-flex align-items-center justify-content-between">
                <a href="javascript:;" @click="$router.go(-1)" class="text-success fs-16"><i class="ri-arrow-go-back-line "></i> Back</a>
                <div class="add-catagory-btn">
                    <button class="btn fs-16 btn-custom me-2 text-white" style="background-color:#878A99;" @click="clearData()">Clear All</button>
                    <button class="btn btn-success fs-16 btn-custom text-white" @click="addCombo()">Add Combo</button>
                </div>
            </div>
        </div>
    </footer>
<!------FOOTER END -------->
</div>
</template>

<script>
import { useToast } from "vue-toastification";
import Select2 from 'vue3-select2-component';
export default {
    components: {Select2},
    data(){
        return{
            allProducts:[],
            selectedProduct : [],
            selproduct : [],
            image_url : '',
            image_text : 'Add a Picture',
            typeOfFood : ['Veg','Non-veg'],
            combo : {
                name: '',
                price: '',
                foodType : '1',
                image: '',
                status : 1,
            },
            toast : useToast(),
            searchProd : '',
        }
    },
    beforeCreate(){
        this.$emit('addLoader');
    },
    created(){
        this.getproductList();
    },
    methods:{
        onImageChange(e){
            this.combo.image = e.target.files[0];
            this.image_url = URL.createObjectURL(this.combo.image);
            this.image_text = 'Edit Picture';
        },
        ComboPriceSet(){
            this.combo.price = this.combo.price.toFixed(2);
        },
        getproductList(){
            axios.get(`/api/getproductlist`)
                .then(res => {
                    this.allProducts = res.data.products;
                    this.$emit('removeLoader')
                }).catch(err => {
                    console.log(err);
                })
        },
        addProduct(product_id){
            var image = document.getElementById("combo_image_" + product_id).getAttribute('src');
            var name = document.getElementById("combo_name_" + product_id).textContent;
             var product = {
                id:product_id,
                image:image,
                name:name,
            }
             if(this.selproduct.findIndex(p => p == product_id) == -1){
                this.selectedProduct.push(product);
                this.selproduct.push(product_id);
            }else{
                let int = this.selproduct.map(item => item).indexOf(product_id)
                this.selproduct.splice(int, 1)

                let i = this.selectedProduct.map(item => item.id).indexOf(product_id)
                this.selectedProduct.splice(i, 1)
            }
        },
        addCombo(){

            this.$emit('showToast',"You Can not change this on demo account.",'error'); 
            return false;
            // const config = {
            //     headers: { 'content-type': 'multipart/form-data' }
            // }

            // var formData = new FormData();
            // formData.append('name', this.combo.name);
            // formData.append('price', this.combo.price);
            // formData.append('foodType', this.combo.foodType);
            // formData.append('image', this.combo.image);
            // formData.append('products', this.selproduct);
            // formData.append('status', this.combo.status);

            // axios
            // .post("/api/addcombo",formData,config)
            // .then((res) => {
            //     this.clearData();
            //     this.$emit("showToast",res.data.success,"success");
            //     this.$router.push(`/combo`);
            // }).catch((error) => {
            //     if(error.response){
            //         var errors = error.response.data.error
            //         var data = this.errors;
            //         if (errors) {
            //             if(errors.name && errors.name[0] && !errors.price && !errors.image && !errors.products){
            //                 this.$emit("showToast",errors.name[0],'error'); return false;}
            //             if(!errors.name && errors.price && errors.price[0] && !errors.image && !errors.products){
            //                 this.$emit("showToast",errors.price[0],'error'); return false;}
            //             if(!errors.name && !errors.price && errors.image && errors.image[0] && !errors.products){
            //                 this.$emit("showToast",errors.image[0],'error'); return false;}
            //             if(!errors.name && !errors.price && !errors.image && errors.products && errors.products[0]){
            //                 this.$emit("showToast",errors.products[0],'error'); return false; }

            //             if(errors.name || errors.price || errors.image || errors.products) this.$emit("showToast","Please fill out form details.",'error');

            //         }
            //     }
            // })
        },
        clearData(){
            this.combo.name = '';
            this.combo.price = '';
            this.combo.foodType = '1';
            this.combo.status = '1';
            this.image_url = '';
            this.combo.image = '';
            this.selproduct.length = 0;
            this.selectedProduct.length = 0;
            this.image_text = 'Add a Picture';
        },
        searchProduct(){
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }
            axios
            .post("/api/search-product",{product : this.searchProd},config)
            .then((res) => {
                this.allProducts = res.data.products;
            }).catch((error) => {
            })
        },
    }
};


</script>

<style scoped>

    .form-check-input{
        width:18px;
        height:18px;
        border: 1px solid #0AB39C;
    }
    .form-check-input[type=checkbox]{
        border-radius:5px;
    }
    .form-check-input:checked {
        background-color: #0AB39C;
    }
    .addcombo-main .addcombo-inner .addcombo-start {
        border-radius:10px;
        height:calc(100vh - 200px);
        background:#fff;
    }
    .addcombo-main .addcombo-inner .comboname-input .form-control{
        background: #FFFFFF;
        border: 1px solid rgba(170, 203, 192, 0.5);
        box-shadow: 0px 1.3px 3px rgba(25, 25, 29, 0.05), 0px 3px 6px rgba(25, 25, 29, 0.11);
        height:100%;
        max-height:35px;
    }
    .addcombo-single-card .card .line--clamp{
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
    }
    /*********ADD COMBOLEFT CSS START*********/
    .addcombo-main .addcombo-inner .addcombo-search{
        background: #FFFFFF;
        box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.25);
        border-radius: 10px 10px 0px 0px;
        padding:10px 12px;
    }

    /******* ADD COMBO CARD START **********/
    .addcombo-main .addcombo-inner .addcombo-left .addcombo-single-card{
        flex:0 0 11.11%;
        max-width:11.11%;
    }

    .addcombo-main .addcombo-inner .addcombo-right .addcombo-single-card{
        flex: 0 0 25%;
        max-width:25%;
    }
    .addcombo-main .addcombo-inner .addcombo-left .addcombo-card .addcombo-single-card .card{
        background: #FFFFFF;
        box-shadow: 0px 0px 2px 1px rgba(137, 137, 137, 0.25);
        border-radius: 10px;
        height:100%;
        max-height:120px;
        width:100%;
        max-width:110px;
        margin-right:auto;
        margin-left:auto;
    }
     .addcombo-main .addcombo-inner .addcombo-right .addcombo-card .addcombo-single-card .card{
        background: #FFFFFF;
        box-shadow: 0px 0px 2px 1px rgba(137, 137, 137, 0.25);
        border-radius: 10px;
        height:100%;
        max-height:120px;
        width:100%;
        max-width:110px;
        margin-right:auto;
        margin-left:auto;
    }
    .addcombo-main .addcombo-inner .addcombo-card .addcombo-single-card .card.active{
        background: rgba(10, 179, 156, 0.15);
        box-shadow: 0px 0px 2px 1px rgba(137, 137, 137, 0.25);
        border: 2px solid #0AB39C;
    }
    .addcombo-main .addcombo-inner .addcombo-left .addcombo-card-main{
        height:100%;
        overflow: auto;
        max-height: calc(100vh - 259px);
        border-radius: 0px 0px 10px 10px;
    }
    .addcombo-main .addcombo-inner .addcombo-card .addcombo-single-card .card .body-content img.combo-img{
        width:100%;
        height:100%;
        max-height:80px !important;
        border-radius:10px;
        filter: drop-shadow(1px 1px 2px rgba(0, 0, 0, 0.25));
    }
    /******* ADD COMBO CARD END **********/

    /*********ADD COMBOLEFT CSS END*********/
    .addcombo-main .addcombo-inner .addcombo-right .addcombo-name{
            background: #FFFFFF;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.25);
            border-radius: 10px;
        }
    .addcombo-main .addcombo-inner .addcombo-right .addcombo-name {
        padding:10px 12px;
    }
     /*********ADD COMBORIGHT CSS START*********/
    .addcombo-main .addcombo-inner .addcombo-right .addcombo-card-main{
        height: 100%;
        overflow: auto;
        max-height: calc(100vh - 454px);
        border-radius: 0px 0px 10px 10px;
    }
    /******* File upload Css Start *********/
    .addcombo-right .addcombo-img .form-group .fileUpload{
        background: #FFFFFF;
        border: 1px solid rgba(0, 0, 0, 0.12);
        border-radius: 10px;
        overflow: hidden;
        padding: 0;
        position: relative;
        text-align: center;
        width: 100%;
        cursor: pointer;
        max-width: 600px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        justify-content: center;
    }
    .addcombo-right .addcombo-img .form-group .fileUpload .fileUpload_preview {
        border: 1px solid #0AB39C;
        background: #0AB39C;
        border-radius: 10px;
        height: 100%;
        max-height: 55px;
        flex:0 0 25%;
        max-width:25%;
        padding-left:2px;
    }
    .addcombo-right .addcombo-img .form-group .fileUpload .fileUpload_preview img {
        height:100%;
        max-height: 50px;
        border-radius: 50px;
        width:100%;
        max-width: 65px;
    }
    .addcombo-right .addcombo-img .form-group .fileUpload .fileUpload_input {
        flex: 0 0 75%;
        max-width: 75%;
        padding: 10.5px 19px;
    }
    .addcombo-right .addcombo-img .form-group .fileUpload input.upload {
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
    .addcombo-right .addcombo-img .form-group input {
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
    .addcombo-right .addcombo-img .form-group .fileUpload span {
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

     /*********ADD COMBORIGHT CSS END*********/
    /********** FOOTER CSS ***************/
    .footer-main{
        padding:8px 15px 8px 32px;
    }
    .footer-main .footer-link .btn-custom{
        padding:12px 25px;
        font-weight:500;
        line-height:16px;
    }

    /************RESPONSIVE CSSS*********/
    @media screen and (min-width:1501px) and (max-width:1700px) {
        .addcombo-main .addcombo-inner .addcombo-left .addcombo-single-card{
            flex:0 0 12.5%;
            max-width:12.5%;
        }
    }
    @media screen and (max-width:1500px){
        .addcombo-main .addcombo-inner .addcombo-left .addcombo-single-card{
            flex:0 0 14.28%;
            max-width:14.28%;
        }
        .addcombo-main .addcombo-inner .addcombo-right .addcombo-single-card{
            flex: 0 0 33.33%;
            max-width: 33.33%;
        }
    }
    @media screen and (max-width:1240px){
        .addcombo-main .addcombo-inner .addcombo-left .addcombo-single-card{
            flex: 0 0 16.66%;
            max-width: 16.66%;
        }
        .addcombo-main .addcombo-inner .addcombo-right .addcombo-single-card {
            flex: 0 0 33.33%;
            max-width: 33.33%;
        }
    }
    @media screen and (max-width:1180px){
        .addcombo-main .addcombo-inner .addcombo-start{
            height: calc(100vh - 170px);
        }
        .addcombo-main .addcombo-inner .addcombo-left .addcombo-card-main{
            max-height: calc(100vh - 225px);
        }
    }
    @media screen and (max-width:1024px){
        .addcombo-main .addcombo-inner .addcombo-start{
            height:calc(100vh - 171px);
        }
        .addcombo-main .addcombo-inner .addcombo-left .addcombo-single-card{
            flex: 0 0 20%;
            max-width: 20%;
        }
        .page-content{
            margin-top: 60px;
        }
        .addcombo-main .addcombo-inner .addcombo-start{
            height: calc(100vh - 178px);
        }
    }
    @media screen and (max-width:991px){
        .col-md-lg{
            width:100%;
            max-width:507px;
        }
        .col--md--lg{
            width:100%;
            max-width:313px;
        }
        .addcombo-main .addcombo-inner .addcombo-left .addcombo-card .addcombo-single-card{
            flex:0 0 25%;
            max-width:25%;
        }
          .addcombo-main .addcombo-inner .addcombo-right .addcombo-card .addcombo-single-card{
            flex:0 0 50%;
            max-width:50%;
        }
        .addcombo-main .addcombo-inner .addcombo-right .addcombo-card .addcombo-single-card .card{
            height: 100%;
            max-height: 110px;
            width: 100%;
            max-width: 100px;
        }
    }
    @media screen and (max-width:1180px){
        .addcombo-main .addcombo-inner .addcombo-right .addcombo-card-main{
            max-height: calc(100vh - 440px);
        }

    }
    @media screen and (max-width:820px){
         .addcombo-main .addcombo-inner .addcombo-start{
            height: calc(100vh - 208px);
        }
        .addcombo-main .addcombo-inner .addcombo-left .addcombo-card-main{
            max-height: calc(100vh - 264px);
        }
        .addcombo-main .addcombo-inner .addcombo-right .addcombo-card-main{
            max-height: calc(100vh - 462px);
        }

    }
    @media screen and (max-width:768px){
        .col-md-lg {
            width: 100%;
            max-width: 500px;
        }
        .col--md--lg{
            width: 100%;
            max-width: 268px;
        }
    }

</style>
