<template>
<div class="main-content">
    <div class="page-content pt-4 pb-2">
        <div class="catagory-mang">            
            <!-------Start page title start-------->
            <div class="row p-4">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Ingredient Categories Management</h4>
                        <div class="page-title-right">
                            <button class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#addeditingcategory" @click="blankForm()" v-if="allpermissions.IngredientCategoryAdd"><i class="ri-add-fill me-1 align-bottom"></i> Add Ingredient</button>
                        </div>
                        <!-- Modal For AddeditIngredientCategory Start-->
                        <div class="modal fade" id="addeditingcategory" ref="modalTest" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">{{ ingcategory.submitTitle }}</h5>
                                        <button type="button" class="btn-close" id="close-button" data-bs-dismiss="modal"
                                            aria-label="Close" @click="blankForm()"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form @submit.prevent="addeditingcategory()">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label for="teammembersName"
                                                            class="form-label padding-start-10 fs-14 color-gray">Name</label>
                                                        <input type="hidden" class="form-control border-radius-10"
                                                            id="category-id" v-model="ingcategory.id">
                                                        <input type="text" class="form-control border-radius-10"
                                                            id="category-name" placeholder="Enter name" v-model="ingcategory.name">
                                                        <span class="error">{{ errors.name }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12" v-if="ingcategory.checkIngCatType">
                                                    <div class="row mb-4">
                                                        <div class="product--status">
                                                            <div class="col-12">
                                                                <label for="image" class="form-label padding-start-10 fs-14 color-gray">Status</label>
                                                            </div>
                                                            <div class="form-check form-check-inline form-radio-success">
                                                                <input class="form-check-input" id="active" type="radio" v-model="ingcategory.status" value="1" name="product--status" checked>
                                                                <label class="form-check-label ps-2 fs-14" for="active">Active</label>
                                                            </div>
                                                            <div class="form-check form-check-inline form-radio-success me-0">
                                                                <input class="form-check-input" type="radio" v-model="ingcategory.status" value="0" id="deactive" name="product--status">
                                                                <label class="form-check-label ps-2 fs-14" for="deactive">Deactive</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal"  @click="blankForm()">Close</button>
                                                        <button type="submit" class="btn btn-success">{{ ingcategory.submitButton }}</button>
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
                        <!-- Moadal For Addeditcategory End -->
                    </div>
                </div>
            </div>            
            <!-------Start page title End-------->
            <section class="categories">
                <div class="categories-main mt-5">
                    <div class="catagory-inner d-flex flex-wrap px-2">
                        <div class="catagory-single-card  mb-4"  v-for="ingcategory in ingcategories" :key="ingcategory.id">
                            <div class="card equal-height-ingredient" :class="ingcategory.status == 1 ? '' : 'deactive' ">
                                <router-link  class="card-body px-3 py-2 text-center" :to="{name: 'Ingredient', params: {'slug': ingcategory.slug}}">
                                    <div class="mx-auto avatar-lg mb-2 card-image rounded-circle">
                                        <img :src="'/storage/'+ ingcategory.image" v-if="ingcategory.name != 'size'" alt="ingredient"  class="img-fluid rounded-circle">
                                        <div v-else><b class="color-gray" style="font-size:50px">S</b></div>
                                    </div>
                                    <h5 class="card-title mb-1 fs-12 mt-3 title--name justify-content-center align-items-center">{{ ingcategory.name }}</h5>
                                    <!-- <h5 class="card-title mb-1 fs-12 mt-2 title--name justify-content-center align-items-center">CHF {{ ingcategory.price.toFixed(2) }}</h5> -->
                                </router-link >
                                <div class="card-bottom px-2 pb-2 text-center border-0">
                                    <ul class="list-inline mb-0 d-flex align-items-center" :class="ingcategory.name == 'size' ? 'justify-content-center' : 'justify-content-between' ">
                                        <li class="list-inline-item" v-if="ingcategory.name != 'size'">
                                            <a href="javascript:;" class="align-middle"  data-bs-toggle="modal" data-bs-target="#removedataalert"  @click="ingCatId = ingcategory.id" v-if="allpermissions.IngredientCategoryDelete"><i class="fa-solid fa-trash-can text-success"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                        <router-link class="mb-0 color-gray" :to="{name: 'Ingredient', params: {'slug': ingcategory.slug}}">{{ ingcategory.ingredients_count }} items</router-link>
                                        </li>
                                        <li class="list-inline-item" v-if="ingcategory.name != 'size'" >
                                            <a href="javascript:;" class="align-middle" data-bs-toggle="modal" data-bs-target="#addeditingcategory" @click="getIngredientCategorySingleData(ingcategory.id)" v-if="allpermissions.IngredientCategoryEdit"><i class="fa-solid fa-pen-to-square text-success"></i></a>
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
import { useToast } from "vue-toastification";
import DeleteAlert from './include/DeleteAlert.vue'
export default {
    components : { DeleteAlert },
    data(){
        return{
            ingcategories : [],
            ingcategory: {
                id : '',
                name: '',
                submitTitle: 'Add IngredientCategory',
                submitButton: 'Add IngredientCategory',
                status : 1,
                checkIngCatType : false,
            },
            errors: {
                name: '',
                image: '',
            },
            toast : useToast(),
            ingCatId : 0,
        }
    },
    props : ['allpermissions'],
    updated() {
        var highestBox = 0;
        var targetDiv = document.querySelectorAll('.equal-height-ingcategory');
        for(var i=0; i<targetDiv.length;i++){
        if(targetDiv[i].clientHeight > highestBox){
                highestBox = targetDiv[i].clientHeight;
        }
        }
        document.querySelectorAll(".equal-height-ingcategory").forEach(node => node.style.height = highestBox + "px");

    },
    beforeCreate(){
        this.$emit('addLoader');
    },
    created() {
        this.getingcategorylist();
    },
    watch: {

    },
    methods:{
        getingcategorylist(){
            axios.get('/api/getingcategorylist')
                .then(res => {
                    this.ingcategories = res.data.content;
                    this.$emit('removeLoader')
                }).catch(err => {
                })
        },
        addeditingcategory(){

            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }

            if(!this.ingcategory.name){ this.$emit("showToast",'Please enter ingredient category name.','error'); return false;}

            var formData = new FormData();
            formData.append('id', this.ingcategory.id);
            formData.append('name', this.ingcategory.name);
            formData.append('status', this.ingcategory.status);
            if(this.ingcategory.id){
                axios
                .post("/api/editingcategory",formData,config)
                .then((res) => {
                    this.$emit("showToast",res.data.success,'success');
                   document.getElementById('close-button').click();
                   this.getingcategorylist();

                }).catch((error) => { })
            }else{
                axios
                .post("/api/addingcategory",formData,config)
                .then((res) => {
                    this.$emit("showToast",res.data.success,'success');
                   document.getElementById('close-button').click();
                   this.getingcategorylist();

                }).catch((error) => { })
            }


        },
        blankForm(){
            this.ingcategory.id = '';
            this.ingcategory.name = '';
            this.errors.name = '';
            this.ingcategory.status = 1;
            this.ingcategory.checkIngCatType = false;
            this.ingcategory.submitTitle = 'Add IngredientCategory';
            this.ingcategory.submitButton = 'Add IngredientCategory';
        },
        getIngredientCategorySingleData(id){
            var id = id;
            axios.get('/api/getIngCategorySingleData/'+id)
            .then(res => {
                this.ingcategory.id = res.data.content.id;
                this.ingcategory.name = res.data.content.name;
                this.ingcategory.checkIngCatType = true;
                this.ingcategory.status = res.data.content.status;
                this.ingcategory.submitTitle = 'Edit IngredientCategory';
                this.ingcategory.submitButton = 'Update IngredientCategory';
            }).catch(err => {
            })
        },
        removeData(){
            var formData = new FormData();
            formData.append('id', this.ingCatId);
            axios
            .post("/api/removeIngcategory",formData)
            .then((res) => {
                this.$emit("showToast",res.data.success,'success');
                this.getingcategorylist();
            }).catch((error) => {
            })
        }
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
    box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.25);
    border-radius: 10px;
    height: 100vh;
    max-height: calc(100vh - 131px);
    }
    .categories{
        overflow: auto;
        height: 100%;
        max-height: calc(100% - 120px);
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
    
    /******** DEACTIVE CARD CSS ***************/
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
        overflow: auto;
        height: 100%;
        max-height: calc(100% - 109px);
      }
    }
     @media screen and (min-width:1024px) and (max-width:1179px){
        .categories-main .catagory-inner .catagory-single-card{
            flex:0 0 14%;
            max-width:14%;
        }
    }
    @media screen and (max-width:1024px){
        .categories{
            max-height: calc(100% - 132px);
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
            max-height:calc(100vh - 135px);
        }
        .categories{
            overflow: auto;
            height: 100%;
            max-height: calc(100% - 125px);
        }

    }
</style>
