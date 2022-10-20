<template>
<div class="main-content">
    <div class="page-content">
        <div class="catagory-mang">
            <!------- Start page title start -------->
            <div class="row">
                <div class="col-12">
                    <div class="p-3 d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Sub Category Management</h4>

                    </div>
                </div>
            </div>
            <!--------- Start page title end ---------->
            <section class="categories">
                <!-- CATEGORIES LIST START -->
                <div class="categories-main mt-4">
                    <div class="catagory-inner d-flex flex-wrap px-2">
                        <div class="catagory-single-card  mb-4"  v-for="category in categories" :key="category.id">
                            <div class="card">
                                 <router-link  class="card-body px-3 py-2 text-center" :to="{name: 'Product', params: {'slug': category.slug}}">
                                    <div class="mx-auto avatar-lg mb-2 card-image rounded-circle">
                                        <img :src="'/assets/images/slider-1.jpg'"  alt="subcategory" class="img-fluid rounded-circle">
                                    </div>
                                    <h5 class="card-title mb-1 fs-12">Pizza</h5>
                                </router-link >
                                <div class="card-bottom px-2 pb-2 text-center border-0">
                                    <ul class="list-inline mb-0 d-flex justify-content-between align-items-center">
                                        <li class="list-inline-item">
                                            <a href="javascript:;" class="align-middle"><i class="fa-solid fa-trash-can text-success"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                        <router-link class="align-middle fs-10" :to="{name: 'Product', params: {'slug': category.slug}}">{{ category.products_count}} items</router-link>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:;" class="align-middle"><i class="fa-solid fa-pen-to-square text-success"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                    
                <!-------- CATEGORIES LIST END --------->
            </section>
        </div>
    </div>
    <!------FOOTER START -------->
    <footer class="footer-start">
        <div class="footer-main bg-white" style="position:fixed; bottom: 0; width: 100%;">
            <div class="footer-link d-flex align-items-center justify-content-between">
                <a href="javascript:;" @click="$router.go(-1)" class="text-success fs-16"><i class="ri-arrow-go-back-line "></i> Back</a>
                <div class="add-catagory-btn">
                    <button class="btn btn-success fs-16 btn-custom" data-bs-toggle="modal"
                        data-bs-target="#addeditcategory" @click="blankForm()" v-if="allpermissions.CategoryAdd"><i class="ri-add-fill me-1 align-bottom"></i> Add Category</button>
                </div>
            </div>
        </div>
            <!-- Modal For AddeditCategory Start-->
        <div class="modal fade" id="addeditcategory" ref="modalTest" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">{{ category.submitTitle }}</h5>
                        <button type="button" class="btn-close" id="close-button" data-bs-dismiss="modal"
                            aria-label="Close" @click="blankForm()"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="addeditcategory()">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="teammembersName"
                                            class="form-label">Name</label>
                                        <input type="hidden" class="form-control"
                                            id="category-id" v-model="category.id">
                                        <input type="text" class="form-control"
                                            id="category-name" placeholder="Enter name" v-model="category.name">
                                        <span class="error">{{ errors.name }}</span>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-4">
                                        <label for="image" class="form-label">Profile
                                            Images</label>
                                        <input type="file" class="form-control"  id="category-image" ref="fileInput"
                                            @input="pickFile" @change="onImageChange"/>
                                        <span class="error">{{ errors.image }}</span>
                                    </div>
                                    <div class="file_up_box tp-image-w imagePreviewWrapper d-none" :style="{ 'background-image': `url(${category.previewImage})` }" @click="selectImage" id="category-image-preview"></div>

                                </div>
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal"  @click="blankForm()">Close</button>
                                        <button type="submit" class="btn btn-success">{{ category.submitButton }}</button>
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
    </footer>
    <!------FOOTER END -------->
</div>
</template>

<script>
import $ from "jquery";
export default {
    data(){
        return{
            categories : [],
            category: {
                id : '',
                name: '',
                image: '',
                previewImage: null,
                submitTitle: 'Add Category',
                submitButton: 'Add Category',
            },
            errors: {
                name: '',
                image: '',
            }
        }
    },
    props : ['allpermissions'],
    updated() {
        var highestBox = 0;
        var targetDiv = document.querySelectorAll('.equal-height-category');
        for(var i=0; i<targetDiv.length;i++){
        if(targetDiv[i].clientHeight > highestBox){
                highestBox = targetDiv[i].clientHeight;
        }
        }
        document.querySelectorAll(".equal-height-category").forEach(node => node.style.height = highestBox + "px");

    },
    created() {
        this.getcategorylist();
    },
    watch: {

    },
    methods:{
        onImageChange(e){
        this.category.image = e.target.files[0];
        },
        getcategorylist(){
            axios.get('/api/getcategorylist')
                .then(res => {
                    this.categories = res.data.content;
                }).catch(err => {
                })
        },
        addeditcategory(){

            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }

            var formData = new FormData();
            formData.append('id', this.category.id);
            formData.append('name', this.category.name);
            formData.append('image', this.category.image);
            if(this.category.id){
                axios
                .post("/api/editcategory",formData,config)
                .then((res) => {
                   document.getElementById('close-button').click();
                   this.getcategorylist();

                }).catch((error) => {
                    var errors = error.response.data.error
                    var data = this.errors;
                    if (errors) {
                    data.name = errors.name && errors.name[0];
                    data.image = errors.image && errors.image[0];
                    }
                })
            }else{
                axios
                .post("/api/addcategory",formData,config)
                .then((res) => {
                   document.getElementById('close-button').click();
                   this.getcategorylist();

                }).catch((error) => {
                    var errors = error.response.data.error
                    var data = this.errors;
                    if (errors) {
                    data.name = errors.name && errors.name[0];
                    data.image = errors.image && errors.image[0];
                    }
                })
            }


        },
        selectImage () {
            this.$refs.fileInput.click()
        },
       pickFile () {
        var input = this.$refs.fileInput
        var file = input.files
        if (file && file[0]) {
          var reader = new FileReader
          reader.onload = e => {
            this.category.previewImage = e.target.result
            document.getElementById("category-image-preview").classList.remove("d-none");
          }
          reader.readAsDataURL(file[0])
          this.$emit('input', file[0])
        }
      },
      blankForm(){
        this.category.id = '';
        this.category.name = '';
        this.category.image = '';
        this.errors.name = '';
        this.errors.image = '';
        this.category.submitTitle = 'Add Category';
        this.category.submitButton = 'Add Category';
        this.category.previewImage = null;
        document.getElementById('category-image').value = "";
        document.getElementById("category-image-preview").classList.add("d-none");
      },
      getCategorySingleData(id){
        var id = id;
        document.getElementById("category-image-preview").classList.remove("d-none");
        axios.get('/api/getCategorySingleData/'+id)
        .then(res => {
            this.category.id = res.data.content.id;
            this.category.name = res.data.content.name;
            this.category.submitTitle = 'Edit Category';
            this.category.submitButton = 'Update Category';
            this.category.previewImage = `/storage/`+res.data.content.image;
        }).catch(err => {
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
    }
    .catagory-mang .categories-main .catagory-inner .catagory-single-card .card .avatar-lg{
        width:5.5rem;
        height:5.5rem;
    }
    .catagory-mang .categories-main .catagory-inner .catagory-single-card .card  .card-image{
        margin-top:-40px;
        background: #FFFFFF;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
    }
    .catagory-mang .categories-main .catagory-inner .catagory-single-card{
        flex: 0 0 9%;
        max-width:9%;
    }
    .catagory-mang .categories-main .catagory-inner .catagory-single-card .card{
        background: #FFFFFF;
        border: 1px solid #0AB39C;
        box-shadow: -4px -1px 8px rgba(137, 137, 137, 0.25);
        border-radius: 10px;
        max-width:123px;
        margin-right:auto;
        margin-left:auto;
    }
    .footer-start .form-control::-webkit-file-upload-button {
        background-color: #0ab39c;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        color:#ffff;
    }
    .footer-main{
        padding:8px 15px 8px 32px;
    }
    .footer-main .footer-link .btn-custom{
        padding:12px 42px;
        font-weight:500;
        line-height:16px;
    }
      /*********** CATEGORIES LIST END ***********/
      /*********** RESPONSIVE CSS ****************/
    @media screen and (max-width:1440px){
        .catagory-mang .categories-main .catagory-inner .catagory-single-card{
            flex:0 0 10%;
            max-width:10%;
        }
    }
     @media screen and (min-width:1181px) and (max-width:1366px){
        .catagory-mang .categories-main .catagory-inner .catagory-single-card{
            flex:0 0 11%;
            max-width:11%;
        }
    }
     @media screen and (max-width:1180px){
        .catagory-mang .categories-main .catagory-inner .catagory-single-card{
            flex:0 0 12.5%;
            max-width:12.5%;
        }
    }
     @media screen and (min-width:1024px) and (max-width:1179px){
        .catagory-mang .categories-main .catagory-inner .catagory-single-card{
            flex:0 0 14%;
            max-width:14%;
        }
    }
    @media screen and (min-width:992px) and (max-width:1023px){
        .catagory-mang .categories-main .catagory-inner .catagory-single-card{
            flex:0 0 14.28%;
            max-width:14.28%;
        }
    }
    @media screen and (min-width:576px) and (max-width:991px){
        .catagory-mang .categories-main .catagory-inner .catagory-single-card{
            flex:0 0 20%;
            max-width:20%;
        }
    }
    @media screen and (max-width:1024px){
        .catagory-mang{
            margin-top:20px;
        }
    }
</style>
