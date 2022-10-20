<template>
<div class="main-content">
    <div class="page-content pt-4 pb-2">
        <div class="catagory-mang">
            <!-------Start page title start-------->
            <div class="row p-4">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ ingcategory.name }}</h4>
                        <div class="page-title-right"  v-if="ingcategory.name != 'size'">
                            <button class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#addeditingredient" @click="blankForm()" v-if="allpermissions.IngredientAdd"><i class="ri-add-fill me-1 align-bottom"></i> Add Ingredient</button>
                        </div>
                        <!-- Modal For AddeditsubCategory Start-->
                        <div class="modal fade" id="addeditingredient" ref="modalTest" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">{{ ingredient.submitButton }}</h5>
                                        <button type="button" class="btn-close" id="close-button" data-bs-dismiss="modal"
                                            aria-label="Close" @click="blankForm()"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form @submit.prevent="addeditingredient()">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label for="teammembersName"
                                                            class="form-label padding-start-10">Name</label>
                                                        <input type="hidden" class="form-control"
                                                            id="ingredient-id" v-model="ingredient.id">
                                                        <input type="text" class="form-control border-radius-10"
                                                            id="ingredient-name" placeholder="Enter name" v-model="ingredient.name">
                                                        <span class="error">{{ errors.ingredient.name }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12" v-if="ingcategory.name != 'size'">
                                                    <div class="mb-3">
                                                        <label for="teammembersName"
                                                            class="form-label padding-start-10">Price</label>
                                                        <input type="number" class="form-control border-radius-10"
                                                            id="ingredient-price" placeholder="Enter Price" v-model="ingredient.price">
                                                        <span class="error">{{ errors.ingredient.price }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12" v-if="ingredient.checkIngredientType">
                                                    <div class="row mb-4">
                                                        <div class="product--status">
                                                            <div class="col-12">
                                                                <label for="image" class="form-label padding-start-10 fs-14 color-gray">Status</label>
                                                            </div>
                                                            <div class="form-check form-check-inline form-radio-success">
                                                                <input class="form-check-input" id="active" type="radio" v-model="ingredient.status" value="1" name="product--status" checked>
                                                                <label class="form-check-label ps-2 fs-14" for="active">Active</label>
                                                            </div>
                                                            <div class="form-check form-check-inline form-radio-success me-0">
                                                                <input class="form-check-input" type="radio" v-model="ingredient.status" value="0" id="deactive" name="product--status">
                                                                <label class="form-check-label ps-2 fs-14" for="deactive">Deactive</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12" v-if="ingcategory.name != 'size'">
                                                    <div class="mb-4">
                                                        <label for="image" class="form-label padding-start-10">Profile
                                                            Images</label>
                                                        <input type="file" class="form-control border-radius-10"  id="ingredient-image" ref="filesubInput"
                                                            @input="pickFile" @change="onImageChange"/>
                                                        <span class="error">{{ errors.ingredient.image }}</span>
                                                    </div>
                                                <div class="file_up_box tp-image-w imagePreviewWrapper d-none" :style="{ 'background-image': `url(${ingredient.previewImage})` }" @click="selectImage" id="ingredient-image-preview"></div>

                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal"  @click="blankForm()">Close</button>
                                                        <button type="submit" class="btn btn-success">{{ ingredient.submitButton }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!--end modal-content-->
                            </div>
                            <!--end modal-dialog-->
                        </div>
                        <!-- Moadal For Addeditingredient End -->
                    </div>
                </div>
            </div>            
            <!-------Start page title end --------->
            <section class="categories">
                <div class="categories-main mt-4">
                    <div class="catagory-inner d-flex flex-wrap px-2">
                        <div class="catagory-single-card  mb-4"  v-for="ingredient in ingredients" :key="ingredient.id">
                            <div class="card"  :class="ingredient.status == 1 ? '' : 'deactive' ">
                                <a href="javascript:;" class="card-body px-3 py-2 text-center">
                                    <div class="mx-auto avatar-lg mb-2 card-image rounded-circle">
                                        <img :src="'/storage/'+ingredient.image"  v-if="ingcategory.name != 'size'" alt="ingredient" class="img-fluid rounded-circle">
                                        <div v-else><b class="color-gray" style="font-size:50px">{{ ingredient.name }}</b></div>
                                    </div>
                                    <h5 class="card-title mb-1 fs-12 mt-3 title--name justify-content-center align-items-center equal-height-ingredient">{{ ingredient.name }}</h5>
                                    <h5 class="card-title mb-1 fs-12 mt-2 title--name justify-content-center align-items-center">{{currencyCode}} {{ ingredient.price.toFixed(2) }}</h5>
                                </a>
                                <div class="card-bottom px-2 pb-2 text-center border-0">
                                    <ul class="list-inline mb-0 d-flex justify-content-between align-items-center">
                                        <li class="list-inline-item" v-if="ingcategory.name != 'size'">
                                            <a href="javascript:;" class="align-middle"  data-bs-toggle="modal" data-bs-target="#removedataalert"  @click="ingId = ingredient.id"><i class="fa-solid fa-trash-can text-success"  v-if="allpermissions.IngredientDelete"></i></a>
                                        </li>
                                        <li class="list-inline-item" v-if="ingcategory.name != 'size'">
                                            <a href="javascript:;" class="align-middle" data-bs-toggle="modal" data-bs-target="#addeditingredient" @click="getIngredientSingleData(ingredient.id)"  v-if="allpermissions.IngredientEdit"><i class="fa-solid fa-pen-to-square text-success"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <DeleteAlert @removeData="removeData" />
</div>
</template>

<script>
import $ from "jquery";
import { useToast } from "vue-toastification";
import DeleteAlert from './include/DeleteAlert.vue';
export default {
    components : { DeleteAlert },
    data(){
        return{
            ingredients : [],
            ingcategory: {
                name: '',
            },
            ingredient: {
                id : '',
                name: '',
                price: '',
                image: '',
                previewImage: null,
                submitButton: 'Add Ingredient',
                status : 1,
                checkIngredientType : false,
            },
            errors: {
                ingredient: {
                    name: '',
                    price: '',
                    image: '',
                }
            },
            toast : useToast(),
            ingId : 0 ,
            currencyCode : '',
        }
    },
    props : ['allpermissions'],
    mounted() {
        $(this.$refs.modalTest).on("hidden.bs.modal", () => { alert('yes')} );
    },
    updated() {
        var highestBox = 0;
        var targetDiv = document.querySelectorAll('.equal-height-ingredient');
        for(var i=0; i<targetDiv.length;i++){
        if(targetDiv[i].clientHeight > highestBox){
                highestBox = targetDiv[i].clientHeight;
        }
        }
        document.querySelectorAll(".equal-height-ingredient").forEach(node => node.style.height = highestBox + "px");

    },
    beforeCreate(){
        this.$emit('addLoader');
    },
    created() {
        this.getsetting();
        this.getingredientlist();
    },
    watch: {

    },
    methods:{
        onImageChange(e){
        this.ingredient.image = e.target.files[0];
        },
        getsetting() {
            axios.get('/api/getSettingData')
                .then(res => {
                    this.currencyCode = res.data.setting.currency_symbol;
                }).catch(err => {})
        },
        getingredientlist(){
            axios.get(`/api/getingredientlist/${this.$route.params.slug}`)
                .then(res => {
                    this.ingredients = res.data.ingredients;
                    this.ingcategory.name = res.data.ingcategory.name;
                    this.$emit('removeLoader');
                }).catch(err => {
                })
        },
        addeditingredient(){

            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }
            if(!this.ingredient.name && this.ingredient.price && this.ingredient.image){ this.$emit("showToast","Please enter your ingredient name.",'error'); return false; }
            if(this.ingredient.name && !this.ingredient.price && this.ingredient.image){ this.$emit("showToast","Please enter your ingredient price.",'error'); return false; }
            if(this.ingredient.name && this.ingredient.price && (!this.ingredient.id && !this.ingredient.image)){ this.$emit("showToast","Please enter your ingredient image.",'error'); return false; }

            if(!this.ingredient.name || !this.ingredient.price || (!this.ingredient.id && !this.ingredient.image)){ this.$emit("showToast","Please fill out form details.",'error'); return false; }

            var formData = new FormData();
            formData.append('ingcategory_slug', this.$route.params.slug);
            formData.append('id', this.ingredient.id);
            formData.append('name', this.ingredient.name);
            formData.append('price', this.ingredient.price);
            formData.append('image', this.ingredient.image);
            formData.append('status', this.ingredient.status);
            if(this.ingredient.id){
                axios
                .post("/api/editingredient",formData,config)
                .then((res) => {
                   this.$emit("showToast",res.data.success,'success');
                   document.getElementById('close-button').click();
                   this.getingredientlist();

                }).catch((error) => {

                })
            }else{
                axios
                .post("/api/addingredient",formData,config)
                .then((res) => {
                   this.$emit("showToast",res.data.success,'success');
                   document.getElementById('close-button').click();
                   this.getingredientlist();

                }).catch((error) => {

                })
            }


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
            this.ingredient.previewImage = e.target.result
            document.getElementById("ingredient-image-preview").classList.remove("d-none");
          }
          reader.readAsDataURL(file[0])
          this.$emit('input', file[0])
        }
      },
      blankForm(){
        this.ingredient.id = '';
        this.ingredient.name = '';
        this.ingredient.price = '';
        this.ingredient.image = '';
        this.errors.ingredient.name = '';
        this.errors.ingredient.price = '';
        this.errors.ingredient.image = '';
        this.ingredient.submitButton = 'Add Ingredient';
        this.ingredient.previewImage = null;
        this.ingredient.status = 1;
        this.ingredient.checkIngredientType = false;

        if(this.ingcategory.name != 'size') {
        document.getElementById('ingredient-image').value = "";
        document.getElementById("ingredient-image-preview").classList.add("d-none");
        }
      },
      getIngredientSingleData(id){
        var id = id;
        if(this.ingcategory.name != 'size') {
            document.getElementById("ingredient-image-preview").classList.remove("d-none");
        }
        axios.get('/api/getIngredientSingleData/'+id)
        .then(res => {
            this.ingredient.id = res.data.content.id;
            this.ingredient.name = res.data.content.name;
            this.ingredient.checkIngredientType = true;
            this.ingredient.status = res.data.content.status;
            this.ingredient.price = res.data.content.price;
            this.ingredient.submitButton = 'Edit Ingredient';
            this.ingredient.previewImage = `/storage/`+res.data.content.image;
        }).catch(err => {
        })
      },
        removeData(){
            var formData = new FormData();
            formData.append('id', this.ingId);
            axios
            .post("/api/removeIngredint",formData)
            .then((res) => {
                this.$emit("showToast",res.data.success,'success');
                this.getingredientlist();

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
    }
    /*********** CATEGORIES LIST START ***********/
    .catagory-mang{
        background: #FFFFFF;
        box-shadow: 0px 3px 10px rgb(0 0 0 / 25%);
        border-radius: 10px;
        height: 100vh;
        max-height: calc(100vh - 131px);
    }
    .categories{
        overflow: auto;
        height: 100%;
        max-height: calc(100% - 68px);
    }
     .categories-main .catagory-inner .catagory-single-card .card .avatar-lg{
        width:5.5rem;
        height:5.5rem;
    }
     .categories-main .catagory-inner .catagory-single-card .card .card-image{
        margin-top:-40px;
        background: #FFFFFF;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
        display: flex;
        justify-content: center;
        align-items : center;
    }
     .categories-main .catagory-inner .catagory-single-card{
        flex: 0 0 9%;
        max-width:9%;
    }
     .categories-main .catagory-inner .catagory-single-card .card{
        background: #FFFFFF;
        border: 1px solid #0AB39C;
        box-shadow: -4px -1px 8px rgba(137, 137, 137, 0.25);
        border-radius: 10px;
        max-width:123px;
        margin-right:auto;
        margin-left:auto;
    }
    /*---------- DEACTIVE CARD CSSS ---------------*/
    .categories-main .catagory-inner .catagory-single-card .card.deactive{
        border : 1px solid #878787 !important;
    }
    .categories-main .catagory-inner .catagory-single-card .card.deactive .text-success{
        color: #878787 !important;
    }
    /*********** CATEGORIES LIST END ***********/
    /*********** RESPONSIVE CSS ****************/
     @media screen and (max-width:1440px){
        .categories-main .catagory-inner .catagory-single-card{
            flex:0 0 10%;
            max-width:10%;
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
            max-height: calc(100vh - 140px);
        }
        .categories{
            max-height: calc(100% - 109px);
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
    @media screen and (max-width:820px) {
        .catagory-mang{
            max-height: calc(100vh - 135px);
        }
        .categories{
            max-height: calc(100% - 125px);
        }
    }
    
</style>
