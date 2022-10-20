<template>
    <div class="auth-page-wrapper pt-5">
            <!-- auth page bg -->
            <div class="auth-one-bg-position auth-one-bg"  id="auth-particles">
                <div class="bg-overlay"></div>

                <div class="shape">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                        <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                    </svg>
                </div>
            </div>

            <!-- auth page content -->
            <div class="auth-page-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center mt-sm-5 mb-4 text-white-50">
                                <div>
                                    <router-link hred="javascript:;" to="/" class="d-inline-block auth-logo">
                                        <img src="assets/images/logo-light.png" alt="login" height="20">
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6 col-xl-5">
                            <div class="card mt-4">

                                <div class="card-body p-4">
                                    <div class="text-center mt-2">
                                        <h5 class="text-primary">Welcome Back !</h5>
                                    </div>
                                    <div class="p-2 mt-4">
                                        <form @submit.prevent="login()">

                                            <!-- <span class="text-danger">{{ errors.error }}</span>
                                            <span class="text-success">{{ success }}</span> -->

                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" placeholder="Enter Email" v-model="email">
                                                <span class="error">{{ errors.email }}</span>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="password">Password</label>
                                                <div class="position-relative auth-pass-inputgroup mb-3">
                                                    <input type="password" class="form-control pe-5" placeholder="Enter password" id="password-input" v-model="password">
                                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                </div>

                                                <span class="error">{{ errors.email }}</span>
                                            </div>

                                            <!-- <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                                <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                            </div> -->

                                            <div class="mt-4">
                                                <button class="btn btn-success w-100" type="submit">Sign In</button>
                                            </div>

                                            <!-- <div class="mt-4 text-center">
                                                <div class="signin-other-title">
                                                    <h5 class="fs-13 mb-4 title">Sign In with</h5>
                                                </div>
                                                <div>
                                                    <button type="button" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-facebook-fill fs-16"></i></button>
                                                    <button type="button" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-google-fill fs-16"></i></button>
                                                    <button type="button" class="btn btn-dark btn-icon waves-effect waves-light"><i class="ri-github-fill fs-16"></i></button>
                                                    <button type="button" class="btn btn-info btn-icon waves-effect waves-light"><i class="ri-twitter-fill fs-16"></i></button>
                                                </div>
                                            </div> -->
                                        </form>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->

                        </div>
                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
            </div>
            <!-- end auth page content -->


        </div>
        <!-- end auth-page-wrapper -->
</template>

<script>
import { useToast } from "vue-toastification";
    export default {
        data(){
            return{
                email: '',
                password: '',
                success: '',
                errors: {
                    email : '',
                    password : '',
                    error : '',
                },
                toast : useToast(),
            }
        },
        mounted() {
            document.getElementById("password-addon").addEventListener("click",function(){var e=document.getElementById("password-input");"password"===e.type?e.type="text":e.type="password"});
        },
        methods:{
            login(){

            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }

            var formData = new FormData();
            formData.append('email', this.email);
            formData.append('password', this.password);

                axios
                .post("/api/login",formData,config)
                .then((res) => {
                    this.errors.email = '';
                    this.errors.password = '';
                    this.errors.error = '';
                    // this.success = res.data.success;
                    this.$emit('showToast',res.data.success,"success");
                    // this.$router.push('Index');
                    setTimeout(function(){
                        this.success = '';
                        this.email = '';
                        this.password = '';
                        if(res.data.indexper){
                            window.location.href = '/';
                        }else{
                            window.location.href = '/pos';
                        }
                    }, 2000);

                }).catch((error) => {
                    var errors = error.response.data.error
                    var data = this.errors;
                    if (errors) {
                    // this.success = '';
                    data.email = errors.email && errors.email[0];
                    data.password = errors.password && errors.password[0];
                    data.error = errors.message && errors.message[0];
                    if(data.email)
                        this.$emit('showToast',data.email,'error')
                    if(data.password)
                        this.$emit('showToast',data.password,'error')
                    if(data.error)
                        this.$emit('showToast',data.error,'error')
                    }
                })


        },
        }
    }


</script>

<style scoped>
.error{
    color : red;
}
</style>
