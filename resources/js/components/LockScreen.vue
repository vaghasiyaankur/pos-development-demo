<template>
    <div id="preloader" class="preloader on">
        <div class="black_wall">
        </div>
    </div>
    <div class="lock-screen" :style="{background: 'url(' + '\'/assets/images/lockscreenbg.png\'' + ') no-repeat center/cover'}">
        <div class="lock-screen-main ">
            <div class="lock-screen-inner text-cen-ter ">
                <div class="row w-100 mx-0 align-items-center">
                    <div class="col-6">
                        <div class="lock-screen-left">
                            <div class="logo--title d-flex align-items-center justify-content-center">
                                <div class="lock-screen-logo pe-2">
                                    <img src="assets/images/lockscreen-logo.png" class="img-fluid" alt="screen">
                                </div>
                                <div class="lock-screen-title">
                                    <h1 class="text-white mb-0 font--50">Foodknot</h1>
                                    <p class="mb-0 text-white text-start fs-20">Restaurant</p>
                                </div>
                            </div>
                            <div class="lock-screen-time text-center mt-5 pt-4">
                                <h1 class="mb-0 text-white font--50">8:53 AM</h1>
                                <p class="mb-0 text-white fs-2">Wednesday June 1, 2022</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="lock-screen-right">
                           <div class="lock-scren-right-logo text-white fs-22">
                                <div class="lock--icon">
                                    <i class="ri-lock-2-fill"></i>
                                </div>
                                <div class="unlock--icon d-none">
                                    <i class="ri-lock-unlock-fill"></i>
                                </div>
                           </div>
                           <div class="lockscreen-right-heading mt-3">
                                <h1 class="text-white">Enter passcode</h1>
                           </div>
                           <div id="fields">
                                <div class="grid">
                                    <div class="grid__col grid__col--1-of-4 numberfield" id="position-1"><span></span></div>
                                    <div class="grid__col grid__col--1-of-4 numberfield" id="position-2"><span></span></div>
                                    <div class="grid__col grid__col--1-of-4 numberfield" id="position-3"><span></span></div>
                                    <div class="grid__col grid__col--1-of-4 numberfield" id="position-4"><span></span></div>
                                </div>
                            </div>
                            <div>
                                <span class="text-white">Hint : 0000</span>
                            </div>
                                <div id="numbers" class="pt-3">
                                    <div class="grid">
                                        <div class="grid__col grid__col--1-of-3"><button @click="addLockPin(1)">1</button></div>
                                        <div class="grid__col grid__col--1-of-3"><button @click="addLockPin(2)">2</button></div>
                                        <div class="grid__col grid__col--1-of-3"><button @click="addLockPin(3)">3</button></div>

                                        <div class="grid__col grid__col--1-of-3"><button @click="addLockPin(4)">4</button></div>
                                        <div class="grid__col grid__col--1-of-3"><button @click="addLockPin(5)">5</button></div>
                                        <div class="grid__col grid__col--1-of-3"><button @click="addLockPin(6)">6</button></div>

                                        <div class="grid__col grid__col--1-of-3"><button @click="addLockPin(7)">7</button></div>
                                        <div class="grid__col grid__col--1-of-3"><button @click="addLockPin(8)">8</button></div>
                                        <div class="grid__col grid__col--1-of-3"><button @click="addLockPin(9)">9</button></div>

                                        <div class="grid__col grid__col--1-of-3"><button @click="removeLockPin()"><i class="ri-delete-back-2-fill"></i></button></div>
                                        <div class="grid__col grid__col--1-of-3"><button @click="addLockPin(0)">0</button></div>
                                        <div class="grid__col grid__col--1-of-3"><button @click="passwordVerify">OK</button></div>

                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import $ from "jquery";
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
                enterCode : '',
                passcode : 0,
                pinposition : 0,
                pin: '',
                indexper : 0,
            }
        },
        created() {
            this.getusepasscode();
        },
        beforeCreate() {
            // this.$emit('addLoader');
        },
        mounted() {
            this.$emit('removeLoader');
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

            /* User Passcode catch from database */
            getusepasscode(){
                axios.get('/api/getuserpasscode')
                .then(res => {
                    this.passcode = res.data.passcode;
                    this.indexper = res.data.indexpermission;
                })
                .catch(err => {
                    console.log(err);
                });
            },

            /* verify user passcode */
            passwordVerify(){
                if(this.pin.length == 4 && (parseInt(this.passcode) == parseInt(this.pin))){
                    $('.lock-screen').addClass('scale-out-ver-top');
                    var routes = this.$router;
                    $(".numberfield").removeClass('active');
                    this.pinposition = 0;
                    this.pin = '';
                    var indexper = this.indexper
                    this.lockScreenDisable();
                    setTimeout(function() {
                        if(indexper == 1){
                            routes.push('/');
                        }else{
                            routes.push('/pos');
                        }
                    }, 500);
                }else{
                    $(".numberfield").removeClass('active');
                    this.pinposition = 0;
                    this.pin = '';
                    $("#fields").addClass('miss');
                    setTimeout(function() {
                        $("#fields").removeClass('miss');
                    }, 500);
                }
            },

            /* Pin number set */
            addLockPin(number){
                
                var element = event.target;
                element.classList.add("active");
                
                setTimeout(function() {
                    element.classList.remove("active")
                }, 500);

                if(this.pin.length < 4){
                    var pos = this.pinposition + 1;
                    $("#position-"+pos).addClass('active');
                    this.position = this.pinposition++;
                    let newpin = '' + this.pin + number;
                    this.pin = newpin;
                    if(newpin.length == 4){
                        this.passwordVerify();
                    }
                }
            },

            /* Remove last number of the pin*/
            removeLockPin() {
                if(this.pin.length > 0){

                    var pos = this.pinposition;
                    $("#position-"+pos).removeClass('active');
                    this.position = this.pinposition--;

                    let newpin = this.pin.slice(0, -1);
                    this.pin = newpin;

                }
            },

            /* Lock Screen Disable for backend side */
            lockScreenDisable(){
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }
                axios.post('/api/lockenabledisable',{lock : 0},config)
                .then(res => {
                }).catch(err => {
                })
            }
        }
    }


</script>

<style scoped>
    
.error{
    color : red;
}
/******Animation for passwordverify click********/
    .scale-out-ver-top {
        -webkit-animation: scale-out-ver-top 10s cubic-bezier(0,1.56,0,1.57) both;
        animation:scale-out-ver-top 10s cubic-bezier(0,1.56,0,1.57) both;
    }
    @-webkit-keyframes scale-out-ver-top {
        0% {
            -webkit-transform: scaleY(1);
                    transform: scaleY(1);
            -webkit-transform-origin: 100% 0%;
                    transform-origin: 100% 0%;
            opacity: 1;
        }
        100% {
            -webkit-transform: scaleY(0);
                    transform: scaleY(0);
            -webkit-transform-origin: 100% 0%;
                    transform-origin: 100% 0%;
            opacity: 0;
        }
    }
    @keyframes scale-out-ver-top {
        0% {
            -webkit-transform: scaleY(1);
                    transform: scaleY(1);
            -webkit-transform-origin: 100% 0%;
                    transform-origin: 100% 0%;
            opacity: 1;
        }
        100% {
            -webkit-transform: scaleY(0);
                    transform: scaleY(0);
            -webkit-transform-origin: 100% 0%;
                    transform-origin: 100% 0%;
            opacity: 0;
        }
    }
    /********* animation for lock-screen ***********/
    #preloader{
    position:fixed;
    top:0 !important;
    right:0;
    bottom:0;
    left:0;
    background-color: #FFFCFC;
    transform-origin:bottom;
    z-index:111111;
    }
    .preloader.off{
    animation:preloader_slide 0.5s ease-in-out 0s 1 reverse both;
    }
    @keyframes preloader_slide{
        from{
        transform:scaleY(0)
        }
        to{
            transform:scaleY(1)
            }
    }
    /************* ANIMATION FOR WRONG PIN **************/
    .miss {
        -webkit-animation: miss .8s ease-out 1;
        animation: miss .8s ease-out 1;
        animation-iteration-count: 2;
      }              
      @keyframes miss {
        0% {
          -webkit-transform: translate(0, 0);
          transform: translate(0, 0);
        }
        10% {
          -webkit-transform: translate(-25px, 0);
          transform: translate(-25px, 0);
        }
        20% {
          -webkit-transform: translate(25px, 0);
          transform: translate(25px, 0);
        }
        30% {
          -webkit-transform: translate(-20px, 0);
          transform: translate(-20px, 0);
        }
        40% {
          -webkit-transform: translate(20px, 0);
          transform: translate(20px, 0);
        }
        50% {
          -webkit-transform: translate(-10px, 0);
          transform: translate(-10px, 0);
        }
        60% {
          -webkit-transform: translate(10px, 0);
          transform: translate(10px, 0);
        }
        70% {
          -webkit-transform: translate(-5px, 0);
          transform: translate(-5px, 0);
        }
        80% {
          -webkit-transform: translate(5px, 0);
          transform: translate(5px, 0);
        }
        100% {
          -webkit-transform: translate(0, 0);
          transform: translate(0, 0);
        }
      }
    /************* LOCK SCREEEN CSS *******************/
    .lock-screen{
        height:100vh;
        overflow: hidden;
        z-index: 1100;
    }
    .lock-screen-main{    
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100%;
        transform: translate(-50%, -50%);
        text-align: center;
        overflow: hidden;
    }
    .lock-screen .lock-screen-left .font--50{
        font-size:50px;
    }
    .lock-screen .lock-screen-right .lockscreen-right-heading h1{
        font-size:36px;
        line-height:46px;
        font-weight:500;
    }
    .lock-screen .lock-screen-right #fields {
        max-width: 300px;
        padding: 0 20px;
        margin: 30px auto;
        position: relative;
        display: block;
    }
    .lock-screen .lock-screen-right .grid {
        list-style: none;
        margin-left: -20px;
    }
    .lock-screen .lock-screen-right .grid__col {
        box-sizing: border-box;
        display: inline-block;
        margin-right: -0.25em;
        min-height: 1px;
        padding-left: 20px;
        vertical-align: top;
        }
    .lock-screen .lock-screen-right .grid__col--1-of-4{
        width: 25%;
    }
    .lock-screen .lock-screen-right .grid__col--1-of-3{
        width:33.33%;
    }
    .lock-screen .lock-screen-right #fields .numberfield span {
        height: 20px;
        width: 20px;
        background-color:rgba(40, 186, 167, 0.3);
        border-radius: 100%;
        position: relative;
        display: inline-block;
        text-align: center;
    }
    .lock-screen .lock-screen-right #fields .numberfield.active span{
        background-color:#0AB39C;
    }

    .lock-screen .lock-screen-right #numbers {
        max-width: 350px;
        padding: 0 20px;
        margin: 0 auto;
        position: relative;
        display: block;
        -webkit-transition: all 1s ease-out;
        -moz-transition: all 1s ease-out;
        transition: all 1s ease-out;
        opacity: 1;
    }
    .lock-screen .lock-screen-right #numbers button{
        width: 87px;
        height: 60px;
        margin-bottom: 10px;
        background-color: rgba(40, 186, 167, 0.3);
        border: 0;
        color: #fff;
        font-size: 27px;
        line-height: 37.5px;
        border-radius: 8px;
        opacity: 1;
        outline: 0;
    }
    .lock-screen .lock-screen-right #numbers button.active {
        background-color: #0ab39c;
        box-shadow: 0 5px #0f5e58;
        transform: translateY(-4px);
    }
    /************** RESPONSIVE CSS ****************/
    @media screen and (max-width:1180px){
        .lock-screen{
            height: 96vh;
        }
    }
    @media screen and (max-width:820px){
        .lock-screen{
            height: 98vh;
        }
    }



</style>
