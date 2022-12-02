<template>
<div class="main-content">
    <div class="page-content pt-4">
        <div class="catagory-mang">
            <ItemList :title="'Category List'" :allpermissions="allpermissions" :items="categories" @getCategorySingleData="getCategorySingleData" @removeCategory="removeCategory" />
        </div>
    </div>
     <!------FOOTER START -------->
            <footer class="footer-start">
                <div class="footer-main bg-white" style="position:fixed; bottom: 0; width: 100%;">
                    <div class="footer-link d-flex align-items-center justify-content-between">
                        <a href="javascript:;" @click="$router.go(-1)" class="text-success fs-16"><i class="ri-arrow-go-back-line "></i> Back</a>
                        <div class="add-catagory-btn">
                            <button class="btn btn-success fs-16 btn-custom" data-bs-toggle="modal"
                                data-bs-target="#addeditcategory" @click="blankForm()" ><i class="ri-add-fill me-1 align-bottom"></i> Add Category</button>
                        </div>
                    </div>
                </div>
                 <!-- Modal For AddeditCategory Start-->
                        <div class="modal fade" id="addeditcategory" ref="modalTest" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header px-3">
                                        <h5 class="modal-title fs-18 color-gray" id="myModalLabel">{{ category.submitTitle }}</h5>
                                        <button type="button" class="btn-close" id="close-button" data-bs-dismiss="modal"
                                            aria-label="Close" @click="blankForm()"></button>
                                    </div>
                                    <div class="modal-body p-3">
                                        <form @submit.prevent="addeditcategory()">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label for="teammembersName"
                                                            class="form-label  color-gray padding-start-10 fs-14">Product Name</label>
                                                        <input type="hidden" class="form-control border-radius-10"
                                                            id="category-id" v-model="category.id">
                                                        <input type="text" class="form-control border-radius-10"
                                                            id="category-name" placeholder="Enter name" v-model="category.name">
                                                        <span class="error">{{ errors.name }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12" v-if="category.checkCategoryType">
                                                    <div class="row mb-4">
                                                        <div class="product--status">
                                                            <div class="col-12">
                                                                <label for="image" class="form-label padding-start-10 fs-14 color-gray">Status</label>
                                                            </div>
                                                            <div class="form-check form-check-inline form-radio-success">
                                                                <input class="form-check-input" id="active" type="radio" v-model="category.status" value="1" name="product--status" checked>
                                                                <label class="form-check-label ps-2 fs-14" for="active">Active</label>
                                                            </div>
                                                            <div class="form-check form-check-inline form-radio-success me-0">
                                                                <input class="form-check-input" type="radio" v-model="category.status" value="0" id="deactive" name="product--status">
                                                                <label class="form-check-label ps-2 fs-14" for="deactive">Deactive</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="mb-4">
                                                        <label for="image" class="form-label color-gray padding-start-10 fs-14">Profile
                                                            Images</label>
                                                        <input type="file" class="form-control border-radius-10 fs-16"  id="category-image" ref="fileInput"
                                                            @input="pickFile" @change="onImageChange"/>
                                                        <span class="error">{{ errors.image }}</span>
                                                    </div>

                                                <div class="file_up_box tp-image-w imagePreviewWrapper d-none" :style="{ 'background-image': `url(${category.previewImage})` }" @click="selectImage" id="category-image-preview"></div>

                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="button" class="btn btn-light fs-16 px-3 text-white me-3"
                                                            data-bs-dismiss="modal"  @click="blankForm()" style="background-color:#878A99;">Close</button>
                                                        <button type="submit" class="btn btn-success fs-16">{{ category.submitButton }}</button>
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
            <DeleteAlert @removeData="removeData" />
</div>
</template>

<script>
import $ from "jquery";
import { useToast } from "vue-toastification";
import ItemList from './include/ItemList.vue'
import DeleteAlert from './include/DeleteAlert.vue'
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
                status : 1,
                checkCategoryType : false,
            },
            errors: {
                name: '',
                image: '',
            },
            toast : useToast(),
            removecat : '',
        }
    },
    components: {
        ItemList,DeleteAlert
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
    beforeCreate(){
        this.$emit('addLoader');
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
                    this.$emit('removeLoader');
                }).catch(err => {
                })
        },
        addeditcategory(){
            this.$emit('showToast',"You Can not change this on demo account.",'error'); 
            return false;
            // const config = {
            //     headers: { 'content-type': 'multipart/form-data' }
            // }

            // var formData = new FormData();
            // formData.append('id', this.category.id);
            // formData.append('name', this.category.name);
            // formData.append('image', this.category.image);
            // formData.append('status', this.category.status);
            // if(this.category.id){
            //     axios
            //     .post("/api/editcategory",formData,config)
            //     .then((res) => {
            //        document.getElementById('close-button').click();
            //        this.getcategorylist();
            //        this.$emit("showToast",res.data.success,'success');

            //     }).catch((error) => {
            //         var errors = error.response.data.error
            //         var data = this.errors;
            //         if (errors) {
            //             if(errors.name && errors.name[0] && !errors.image) this.$emit("showToast",errors.name[0],"error");

            //             if(!errors.name && errors.image && errors.image[0]) this.$emit("showToast",errors.image[0],"error");

            //             if(errors.name && errors.image) this.$emit("showToast","Please fill out form details.","error");
            //         }
            //     })
            // }else{
            //     axios
            //     .post("/api/addcategory",formData,config)
            //     .then((res) => {
            //        document.getElementById('close-button').click();
            //        this.getcategorylist();
            //         this.$emit("showToast",res.data.success,'success');
            //     }).catch((error) => {
            //         var errors = error.response.data.error
            //         if (errors) {
            //             if(errors.name && errors.name[0] && !errors.image) this.$emit("showToast",errors.name[0],"error");

            //             if(!errors.name && errors.image && errors.image[0]) this.$emit("showToast",errors.image[0],"error");

            //             if(errors.name && errors.image) this.$emit("showToast","Please fill out form details.","error");
            //         }
            //     })
            // }


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
        this.category.status = 1;
        this.category.checkCategoryType = false;
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
            this.category.checkCategoryType = true;
            this.category.status = res.data.content.status;
            this.category.submitTitle = 'Edit Category';
            this.category.submitButton = 'Update Category';
            this.category.previewImage = `/storage/`+res.data.content.image;
        }).catch(err => {
        })
      },
      removeCategory(id){
        this.removecat = id;
      },
      removeData(){

        this.$emit('showToast',"You Can not change this on demo account.",'error'); 
            return false;
        // const config = {
        //     headers: { 'content-type': 'multipart/form-data' }
        // }
        // axios.post('/api/deleteCategoryData',{id: this.removecat},config)
        // .then(res => {
        //     this.$emit("showToast","Category deleted successfully",'success');
        //     this.categories = res.data.content;
        // }).catch(err => {
        // })
      }
    }
};


</script>

<style scoped>
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
      /*********** CATEGORIES LIST START ***********/

      .catagory-mang{
        background: #FFFFFF;
        box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.25);
        border-radius: 10px;
        height: 100vh;
        max-height: calc(100vh - 180px);
    }
    .footer-start .form-control::-webkit-file-upload-button {
        background-color: #0ab39c;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        color:#ffff;
    }
    .footer-start .form-control:hover:not(:disabled):not([readonly])::-webkit-file-upload-button {
        background-color:#0ab39c;
    }
    @media screen and (max-width:1180px){
        /* .catagory-mang{
        max-height: calc(100vh - 213px);
        }*/
    }
     @media screen and (max-width:820px){
        .catagory-mang{
            max-height:calc(100vh - 200px);
        }
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


</style>
<style>
    .categories::-webkit-scrollbar-thumb {
        background: #8b8a8a;
        border-radius: 10px;
    }
    .categories::-webkit-scrollbar {
        width: 3px;
        background: transparent;
    }

</style>
