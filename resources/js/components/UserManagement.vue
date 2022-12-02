<template>
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <section class="user-management">
                <div class="row mx-0">
                    <div class="col-12 mx-0 px-0">
                        <div class="user-content d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 fs-16 ">User Management</h4>
                            <div class="page-title-right">
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#adduser"
                                    @click="blankForm()"><i class="ri-add-fill me-1 align-bottom"></i> Add User</button>
                            </div>
                            <!-- Modal For AddeditIngredientCategory Start-->
                            <div class="modal fade" id="adduser" ref="modalTest" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-radius-10">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel">{{ user.submitTitle }}</h5>
                                            <button type="button" class="btn-close" id="close-button"
                                                data-bs-dismiss="modal" aria-label="Close"
                                                @click="blankForm()"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form @submit.prevent="adduser()">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label for="teammembersName" class="form-label">Name</label>
                                                            <input type="hidden" class="form-control border-radius-10" id="user-id"
                                                                v-model="user.id">
                                                            <input type="text" class="form-control  border-radius-10 " id="user-name"
                                                                placeholder="Enter name" v-model="user.name">
                                                            <span class="error">{{ errors.name }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12" v-if="user.modal == 'add'">
                                                        <div class="mb-3">
                                                            <label for="teammembersName"
                                                                class="form-label">Email</label>
                                                            <input type="email" class="form-control border-radius-10" id="user-email"
                                                                placeholder="Enter Email" v-model="user.email">
                                                            <span class="error">{{ errors.email }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12" v-if="user.modal == 'add'">
                                                        <div class="mb-3">
                                                            <label for="user-password"
                                                                class="form-label">Password</label>
                                                            <input type="password" class="form-control  border-radius-10"
                                                                id="user-password" placeholder="Enter Password"
                                                                v-model="user.password">
                                                            <span class="error">{{ errors.password }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12" v-if="user.modal == 'add'">
                                                        <div class="mb-3">
                                                            <label for="user-confirmation-password"
                                                                class="form-label">Confirm Password</label>
                                                            <input type="password" class="form-control border-radius-10" id=""
                                                                placeholder="Enter Confirm Password"
                                                                v-model="user.password_confirmation">
                                                            <span class="error">{{ errors.password_confirmation
                                                            }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label for="teammembersName" class="form-label">Type</label>
                                                            <select name="uset-type" class="form-control border-radius-10" id="user-type"
                                                                v-model="user.type">
                                                                <option value="super_admin">Super Admin</option>
                                                                <option value="sub_admin">Sub Admin</option>
                                                                <option value="kitchen_manager">Kitchen Manager</option>
                                                                <option value="waiter">Waiter</option>
                                                            </select>
                                                            <span class="error">{{ errors.type }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-4">
                                                            <label for="image" class="form-label">Photo</label>
                                                            <input type="file" class="form-control border-radius-10" id="user-image"
                                                                ref="filephoto" @input="pickPhotoFile"
                                                                @change="onPhotoChange" />
                                                            <span class="error">{{ errors.photo }}</span>
                                                        </div>
                                                        <div class="file_up_box tp-image-w imagePreviewWrapper d-none"
                                                            :style="{ 'background-image': `url(${user.previewPhoto})` }"
                                                            @click="selectPhoto" id="photo-preview"></div>

                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="mb-4">
                                                            <label for="image" class="form-label">Goverment Id</label>
                                                            <input type="file" class="form-control border-radius-10" id="user-image"
                                                                ref="govt_idInput" @input="pickGovIdFile"
                                                                @change="onGovIdChange" />
                                                            <span class="error">{{ errors.govt_id }}</span>
                                                        </div>
                                                        <div class="file_up_box tp-image-w imagePreviewWrapper d-none"
                                                            :style="{ 'background-image': `url(${user.previewGovId})` }"
                                                            @click="selectGovId" id="gov-id-preview"></div>

                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn py-2 px-4 fs-16 text-white" style="background: #878A99;"
                                                                data-bs-dismiss="modal"
                                                                @click="blankForm()">Close</button>
                                                            <button type="submit" class="btn btn-success py-2 px-4 fs-16">{{
                                                                    user.submitButton
                                                            }}</button>
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
                            <!-- Moadal For Addedituser End -->
                        </div>
                    </div>
                </div>
                <div class="user-management-table overflow-auto">
                    <div class="row px-0 mx-0">
                        <div class="col-lg-3 col-md-6">
                            <div class="card user-single-card mx-auto">
                                <div class="card-header bg-orange border-bottom m-0 py-1">
                                    <div class="header-top text-center text-white">
                                        <span class="fs-22"><i class="fa-solid fa-user-gear"></i></span>
                                        <p class="mb-0 fs-14 fw-medium">Super Admin</p>
                                    </div>
                                </div>
                                <div class="card-body user--content px-0" :class="{ 'card-body-data' : super_admin_allData}">
                                    <div v-for="(user,index) in super_admin" :key="user">
                                        <div class="card-items-details d-flex justify-content-between fs-10 fw-medium" v-if="user.type == 'super_admin'">
                                            <p class="mb-0 ps-1">{{index + 1}}. {{user.name}}</p>
                                            <button class="mb-0 icons border-0" data-bs-toggle="modal" data-bs-target="#adduser" @click="getUserSingleData(user.id)"> <i class=" ri-pencil-fill"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer border-top-0 pt-2 pb-0 d-flex justify-content-center px-2" v-if="super_admin.length > 8 && super_admin_allData == false">
                                    <button class="btn btn-green fs-12 fw-medium"  @click="super_admin_allData = true">See All</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card user-single-card mx-auto">
                                <div class="card-header bg-blue border-bottom m-0 py-1">
                                    <div class="header-top text-center text-white">
                                        <span class="fs-22"><i class="fa-solid fa-user-clock"></i></span>
                                        <p class="mb-0 fs-14 fw-medium">Sub Admin</p>
                                    </div>
                                </div>
                                <div class="card-body px-0" :class="{ 'card-body-data' : sub_admin_allData}">
                                    <div v-for="(user,i) in sub_admin" :key="user">
                                        <div class="card-items-details d-flex justify-content-between fs-10  fw-medium" v-if="user.type == 'sub_admin'">
                                            <p class="mb-0 ps-1">{{i + 1}}. {{user.name}}</p>
                                            <button class="mb-0 icons border-0" data-bs-toggle="modal" data-bs-target="#adduser" @click="getUserSingleData(user.id)"> <i class=" ri-pencil-fill"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer border-top-0 pt-2 pb-0 d-flex justify-content-center px-2" v-if="sub_admin.length > 8 && sub_admin_allData == false">
                                    <button class="btn btn-green fs-12 fw-medium" @click="sub_admin_allData = true">See All</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card user-single-card mx-auto">
                                <div class="card-header bg-green border-bottom m-0 py-1">
                                    <div class="header-top text-center text-white">
                                        <span class="fs-22"><i class="fa-solid fa-user-secret"></i></span>
                                        <p class="mb-0 fs-14 fw-medium">Kitchen Manager</p>
                                    </div>
                                </div>
                                <div class="card-body px-0" :class="{ 'card-body-data' : kitchen_manager_allData}">
                                    <div v-for="(user,i) in kitchen_manager" :key="user">
                                        <div class="card-items-details d-flex justify-content-between fs-10  fw-medium" v-if="user.type == 'kitchen_manager'">
                                            <p class="mb-0 ps-1">{{i + 1}}. {{user.name}}</p>
                                            <button class="mb-0 icons border-0" data-bs-toggle="modal" data-bs-target="#adduser" @click="getUserSingleData(user.id)"> <i class=" ri-pencil-fill"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer border-top-0 pt-2 pb-0 d-flex justify-content-center px-2" v-if="kitchen_manager.length > 8 && kitchen_manager_allData == false">
                                    <button class="btn btn-green fs-12 fw-medium" @click="kitchen_manager_allData = true">See All</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card user-single-card mx-auto">
                                <div class="card-header bg-dark-blue border-bottom m-0 py-1">
                                    <div class="header-top text-center text-white">
                                        <span class="fs-22"><i class="fa-solid fa-people-carry-box"></i></span>
                                        <p class="mb-0 fs-14 fw-medium">Waiter</p>
                                    </div>
                                </div>
                                <div class="card-body px-0" :class="{ 'card-body-data' : waiter_allData}">
                                    <div v-for="(user,i) in waiter" :key="user">
                                        <div class="card-items-details d-flex justify-content-between fs-10  fw-medium" v-if="user.type == 'waiter'">
                                            <p class="mb-0 ps-1">{{i + 1}}. {{user.name}}</p>
                                            <button class="mb-0 icons border-0" data-bs-toggle="modal" data-bs-target="#adduser" @click="getUserSingleData(user.id)"> <i class=" ri-pencil-fill"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer border-top-0 pt-2 pb-0 d-flex justify-content-center px-2" v-if="waiter.length > 8 && waiter_allData == false">
                                    <button class="btn btn-green fs-12 fw-medium" @click="waiter_allData = true">See All</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--- Start page title end -->
            </section>
        <!-------Start page footer start --------->
        <footer class="footer-start">
            <div class="footer-main bg-white">
                <div class="footer-link d-flex align-items-center justify-content-between">
                    <a href="javascript:;" @click="$router.go(-1)" class="text-success fs-16" data-v-66f63333="">
                        <i class="ri-arrow-go-back-line" data-v-66f63333=""></i>
                        Back
                    </a>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
import { useToast } from "vue-toastification";
export default {
    data() {
        return {
            super_admin: [],
            sub_admin : [],
            kitchen_manager: [],
            waiter: [],
            super_admin_allData: false,
            sub_admin_allData : false,
            kitchen_manager_allData: false,
            waiter_allData: false,
            user: {
                id: '',
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                type: 'super_admin',
                photo: '',
                previewPhoto: '',
                govt_id: '',
                previewGovId: '',
                submitTitle: 'Add User',
                submitButton: 'Add User',
                modal: 'add',
            },
            errors: {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                type: '',
                photo: '',
                govt_id: '',
            },
            toast : useToast(),
        }
    },
    beforeCreate(){
        this.$emit('addLoader');
    },
    updated() {
        var highestBox = 0;
        var targetDiv = document.querySelectorAll('.equal-height-user');
        for (var i = 0; i < targetDiv.length; i++) {
            if (targetDiv[i].clientHeight > highestBox) {
                highestBox = targetDiv[i].clientHeight;
            }
        }
        this.$emit('removeLoader');
        document.querySelectorAll(".equal-height-user").forEach(node => node.style.height = highestBox + "px");

    },
    created() {
        this.getuserlist();
    },
    watch: {

    },
    methods: {
        getuserlist() {
            axios.get('/api/getuserlist')
                .then(res => {
                    this.super_admin = res.data.super_admin;
                    this.sub_admin = res.data.sub_admin;
                    this.kitchen_manager = res.data.kitchen_manager;
                    this.waiter = res.data.waiter;
                    this.$emit('removeLoader');
                }).catch(err => {
                })
        },
        adduser() {

            this.$emit('showToast',"You Can not change this on demo account.",'error'); 
            return false;
            // const config = {
            //     headers: { 'content-type': 'multipart/form-data' }
            // }

            // var formData = new FormData();
            // formData.append('id', this.user.id);
            // formData.append('name', this.user.name);
            // formData.append('email', this.user.email);
            // formData.append('password', this.user.password);
            // formData.append('password_confirmation', this.user.password_confirmation);
            // formData.append('type', this.user.type);
            // formData.append('photo', this.user.photo);
            // formData.append('govt_id', this.user.govt_id);
            // if (this.user.id) {
            //     axios
            //         .post("/api/edituser", formData, config)
            //         .then((res) => {
            //             this.$emit("showToast",res.data.success,'success');
            //             document.getElementById('close-button').click();
            //             // this.$emit('addLoader');
            //             this.getuserlist();
            //         }).catch((error) => {
            //              var errors = error.response.data.error
            //             var data = this.errors;
            //             if (errors) {
            //                 if(errors.name && errors.name[0] && !errors.type && !errors.photo && !errors.govt_id){
            //                     this.$emit("showToast",errors.name[0],'error');
            //                     return false;
            //                 }
            //                 if(!errors.name && errors.type && errors.type[0] && !errors.photo && !errors.govt_id){
            //                     this.$emit("showToast",errors.type[0],'error');
            //                     return false;
            //                 }
            //                 if(!errors.name && !errors.type && errors.photo && errors.photo[0] && !errors.govt_id){
            //                     this.$emit("showToast",errors.photo[0],'error');
            //                     return false;
            //                 }
            //                 if(!errors.name && !errors.type && !errors.photo && errors.govt_id && errors.govt_id[0]){
            //                     this.$emit("showToast",errors.govt_id[0],'error');
            //                     return false;
            //                 }

            //                 if(errors.name || errors.type || errors.photo || errors.govt_id){
            //                     this.$emit("showToast","Please fill out form details.",'error');
            //                     return false;
            //                 }
            //             }
            //         })
            // } else {
            //     axios
            //         .post("/api/adduser", formData, config)
            //         .then((res) => {
            //             this.$emit("showToast",res.data.success,'success');
            //             document.getElementById('close-button').click();
            //             // this.$emit('addLoader');
            //             this.getuserlist();
            //         }).catch((error) => {
            //             var errors = error.response.data.error
            //             var data = this.errors;
            //             if (errors) {
            //                 if(errors.name && errors.name[0] && !errors.password && !errors.password_confirmation && !errors.type && !errors.photo && !errors.govt_id){
            //                     this.$emit("showToast",errors.name[0],'error');
            //                     return false;
            //                 }
            //                 if(!errors.name && errors.password && errors.password[0] && !errors.password_confirmation && !errors.type && !errors.photo && !errors.govt_id){
            //                     this.$emit("showToast",errors.password[0],'error');
            //                     return false;
            //                 }
            //                 if(!errors.name && !errors.password && errors.password_confirmation && errors.password_confirmation[0] && !errors.type && !errors.photo && !errors.govt_id){
            //                     this.$emit("showToast",errors.password_confirmation[0],'error');
            //                     return false;
            //                 }
            //                 if(!errors.name && !errors.password && !errors.password_confirmation && errors.type && errors.type[0] && !errors.photo && !errors.govt_id){
            //                     this.$emit("showToast",errors.type[0],'error');
            //                     return false;
            //                 }
            //                 if(!errors.name && !errors.password && !errors.password_confirmation && !errors.type && errors.photo && errors.photo[0] && !errors.govt_id){
            //                     this.$emit("showToast",errors.photo[0],'error');
            //                     return false;
            //                 }
            //                 if(!errors.name && !errors.password && !errors.password_confirmation && !errors.type && !errors.photo && errors.govt_id && errors.govt_id[0]){
            //                     this.$emit("showToast",errors.govt_id[0],'error');
            //                     return false;
            //                 }

            //                 if(errors.name || errors.password || errors.password_confirmation || errors.type || errors.photo || errors.govt_id){
            //                     this.$emit("showToast","Please fill out form details.",'error');
            //                     return false;
            //                 }
            //             }
            //         })
            // }


        },
        blankForm() {
            this.user.id = '';
            this.user.name = '';
            this.user.email = '';
            this.user.password = '';
            this.user.password_confirmation = '';
            this.user.type = 'super_admin';
            this.user.photo = '';
            this.user.previewPhoto = '';
            this.user.govt_id = '';
            this.user.previewGovId = '';
            this.errors.name = '';
            this.errors.email = '';
            this.errors.password = '';
            this.errors.password_confirmation = '';
            this.errors.type = '';
            this.errors.photo = '';
            this.errors.govt_id = '';
            this.user.submitTitle = 'Add User';
            this.user.submitButton = 'Add User';
            this.user.modal = 'add';
            document.getElementById("photo-preview").classList.add("d-none");
            document.getElementById("gov-id-preview").classList.add("d-none");
        },
        getUserSingleData(id) {
            var id = id;
            document.getElementById("photo-preview").classList.remove("d-none");
            document.getElementById("gov-id-preview").classList.remove("d-none");
            axios.get('/api/getUserSingleData/' + id)
                .then(res => {
                    this.user.id = res.data.content.id;
                    this.user.name = res.data.content.name;
                    // this.user.email = res.data.content.email;
                    // this.user.password = res.data.content.password;
                    this.user.type = res.data.content.type;
                    this.user.previewPhoto = `/storage/` + res.data.content.photo;
                    this.user.previewGovId = `/storage/` + res.data.content.govt_id;
                    this.user.submitTitle = 'Edit User';
                    this.user.submitButton = 'Update User';
                    this.user.modal = 'edit';
                }).catch(err => {
                })
        },
        onPhotoChange(e) {
            this.user.photo = e.target.files[0];
        },
        selectPhoto() {
            this.$refs.filephoto.click()
        },
        pickPhotoFile() {
            var input = this.$refs.filephoto
            var file = input.files
            if (file && file[0]) {
                var reader = new FileReader
                reader.onload = e => {
                    this.user.previewPhoto = e.target.result
                    document.getElementById("photo-preview").classList.remove("d-none");
                }
                reader.readAsDataURL(file[0])
                this.$emit('input', file[0])
            }
        },
        onGovIdChange(e) {
            this.user.govt_id = e.target.files[0];
        },

        selectGovId() {
            this.$refs.govt_idInput.click()
        },
        pickGovIdFile() {
            var input = this.$refs.govt_idInput
            var file = input.files
            if (file && file[0]) {
                var reader = new FileReader
                reader.onload = e => {
                    this.user.previewGovId = e.target.result
                    document.getElementById("gov-id-preview").classList.remove("d-none");
                }
                reader.readAsDataURL(file[0])
                this.$emit('input', file[0])
            }
        },
    }
};
</script>


<style scoped>
.main-content .page-content .user-management {
    background: #fff;
    height: calc(100vh - 201px);
    border-radius: 10px;
    box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.25);
}
.main-content .page-content .user-management-table{
    height: 100%;
    max-height: calc(100% - 64px);
}
.main-content .page-content .user-management .user-content {
    padding: 12px 22px 12px 12px;
}
.user-single-card {
    background: #FFFFFF;
    box-shadow: 0px 0px 8px 1px rgba(0, 0, 0, 0.25);
    border-radius: 10px;
    height: auto;
    min-height: 293px;
    width: 100%;
    max-width: 256px;
}
.main-content .page-content .user-management .user-single-card .bg-orange {
    background: #F79256;
    border-radius: 10px 10px 0px 0px;
}
.main-content .page-content .user-management .user-single-card .bg-blue {
    background: #1D4E89;
    border-radius: 10px 10px 0px 0px;
}
.main-content .page-content .user-management .user-single-card .bg-green {
    background: #7DCFB6;
    border-radius: 10px 10px 0px 0px;
}
.main-content .page-content .user-management .user-single-card .bg-dark-blue {
    background: #00B2CA;
    border-radius: 10px 10px 0px 0px;
}

.main-content .page-content .user-management .user-single-card .card-items-details {
    background: #EFEEF3;
    border-radius: 4px;
    margin: 8px 13px;
}
.main-content .page-content .user-management .user-single-card .card-items-details .icons {
    width: 14px;
    height: 15px;
    background: #0ab39c;
    color: #fff;
    border-radius: 4px;
    align-items: center;
    display: flex;
    justify-content: center;
}
.main-content .page-content .user-management .user-single-card .card-footer button.btn-green {
    color: #fff;
    padding: 2px 8px;
    border-radius: 5px !important;
    background: #0AB39C;
}
.main-content .page-content .user-management .user-single-card .card-body {
    padding: 6px 0;
    overflow: hidden;
    max-height: 195px;
}
.main-content .page-content .user-management .user-single-card .card-body-data {
    overflow: auto;
    max-height: 225px;
}
.main-content .page-content .user-management .user-single-card .card-body-data::-webkit-scrollbar {
    width: 3px;
	background-color: #F5F5F5;
}
.main-content .page-content .user-management .user-single-card .card-body-data::-webkit-scrollbar-thumb{
    border-radius: 20px;
	-webkit-box-shadow0: inset 0 0 6px rgba(0,0,0,.6);
	background-color: transparent;
}
.main-content .footer-start .footer-main {
    position: fixed;
    width: 100%;
    bottom: 0;
    padding: 8px 15px 8px 32px;
}

@media screen and (max-width:1024px) {
    .main-content .page-content .user-management {
       height: calc(100vh - 160px);

    }
}
@media screen and (max-width:1180px) {
    .main-content .page-content .user-management {
    height: calc(100vh - 158px);
    }
}
@media screen and (max-width:820px) {
    .main-content .page-content .user-management{
    height: calc(100vh - 190px);
    }
}

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

.error {
    color: red;
}

.title--name {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    /* number of lines to show */
    line-clamp: 2;
    -webkit-box-orient: vertical;
    word-break: break-word;
}

select {
    -webkit-appearance: listbox !important
}
</style>
