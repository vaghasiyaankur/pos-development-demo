<template>
    <div>
        <Header  v-if="!isLogin && !isLock" :allpermissions="allpermissions" :image_url="image_url"></Header>

        <router-view :allpermissions="allpermissions" :currencyCode="currencyCode" @addLoader="addLoader" @removeLoader="removeLoader"  @showToast="showToast"></router-view>
            <div class="overlay">
                <div class="overlayDoor"></div>
                <div class="overlayContent">
                    <div class="loader">
                        <div class="inner"></div>
                    </div>
                </div>
            </div>
    </div>
</template>

<script>
import $ from "jquery";
import { useToast } from "vue-toastification";
import Header from './include/Header.vue'
import Notification from '../../components/include/Notification.vue';
export default {
    name: 'Master',
    data(){
        return{
            allpermissions : [],
            toast : useToast(),
            image_url : '/assets/images/logo-dark.png',
            currencyCode : '',
            events : ['click', 'mousemove', 'mousedown', 'scroll', 'keypress', 'load'],
            warningTimer : null,
            logoutTimer : null,
        }
    },
    beforeCreate(){
        $('.skip').click(function() {
            $('.overlay, body').addClass('loaded');
        })
    },
    mounted() {
      this.events.forEach(function(event){
        window.addEventListener(event, this.resetTimer);
      }, this);
      this.setTimer();
    },
    async created() {
        $(window).bind('load', function() {
            $('.overlay, body').addClass('loaded');
            setTimeout(function() {
                $('.overlay').css({'display':'none'})
            }, 2000)
        });

        // await this.recentOrder();
        this.getsetting();

        axios.get('/api/checkheaderpermission')
        .then(res => {
        this.allpermissions = res.data.permissions;
        setTimeout(function() {
            $('.overlay, body').addClass('loaded');
        }, 10000);
        }).catch(err => {
        });

    },
    updated() {
    },
    methods:{
        recentOrder() {
        axios.get('/api/recentOrder')
        .then(res => {
            res.data.forEach(element => {
                this.showToast('order Added in table no : '+element,"success");
            });
            // this.callInterval();
        }).catch(err => {

        });
        },
        async callInterval(){
            setInterval(this.intervalFun, 4000)
        },intervalFun() {
            axios.get('/api/recentOrder')
            .then(res => {
                res.data.forEach(element => {
                    this.showToast('order Added in table no : '+element,"success");
                });
            }).catch(err => {

            });
        },
        getsetting(){
            axios.get('/api/getSettingData')
            .then(res => {
                this.image_url = `/storage/`+res.data.setting.logo;
                this.currencyCode = res.data.setting.currency_symbol;
                $('link[rel="shortcut icon"]').attr('href',`storage/`+res.data.setting.fav_icon);
            }).catch(err => {
            })
        },
        addLoader(){
            document.getElementById('preloader').classList.add('on');
            document.getElementById('preloader').classList.remove('off');
        },
        removeLoader(){
            setTimeout(function(){
                document.getElementById('preloader').classList.remove('on');
                document.getElementById('preloader').classList.add('off');
            }, 1000);
        },
        showToast(message,type) {
            const content = {
                component: Notification,
                props: {
                    message: message,
                    type : type
                },
            }
            if(type == 'success'){
                this.toast.success(content);
            }else{
                this.toast.error(content);
            }
        },

        setTimer() {
          this.warningTimer = setTimeout(this.warningMessage, 15*60*1000);
        },
        warningMessage(){
          $(".modal-backdrop").hide();
          this.$router.push('/lock');
          this.lockScreenEnable();
        },
        resetTimer() {
          clearTimeout(this.warningTimer);
          this.setTimer();
        },
        lockScreenEnable(){
        const config = {
            headers: { 'content-type': 'multipart/form-data' }
        }
        axios.post('/api/lockenabledisable',{lock : 1},config)
        .then(res => {
        }).catch(err => {
        })
    }
    },
    components: {
        Header
    },
    computed: {
    isLogin() {
        return this.$route.name === 'Login'

    },
    isLock() {
        return this.$route.name === 'LockScreen'

    },

}
}
</script>



<style>

body.loaded {
  overflow-y: auto;
}

.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 100000000;
}
.overlay .overlayDoor:before, .overlay .overlayDoor:after {
  content: "";
  position: absolute;
  width: 50%;
  height: 100%;
  background: #111;
  transition: 0.5s cubic-bezier(0.77, 0, 0.18, 1);
  transition-delay: 0.8s;
}
.overlay .overlayDoor:before {
  left: 0;
}
.overlay .overlayDoor:after {
  right: 0;
}
.overlay.loaded .overlayDoor:before {
  left: -50%;
}
.overlay.loaded .overlayDoor:after {
  right: -50%;
}
.overlay.loaded .overlayContent {
  opacity: 0;
  margin-top: -15px;
}
.overlay .overlayContent {
  position: relative;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  transition: 0.5s cubic-bezier(0.77, 0, 0.18, 1);
  background-color:#f3f3f9;
}
.overlay .overlayContent .skip {
  display: block;
  width: 130px;
  text-align: center;
  margin: 50px auto 0;
  cursor: pointer;
  color: #fff;
  font-family: "Nunito";
  font-weight: 700;
  padding: 12px 0;
  border: 2px solid #fff;
  border-radius: 3px;
  transition: 0.2s ease;
}
.overlay .overlayContent .skip:hover {
  background: #ddd;
  color: #444;
  border-color: #ddd;
}

.loader {
  width: 128px;
  height: 128px;
  border: 3px solid #0ab39c;
  border-bottom: 3px solid transparent;
  border-radius: 50%;
  position: relative;
  -webkit-animation: spin 1s linear infinite;
          animation: spin 1s linear infinite;
  display: flex;
  justify-content: center;
  align-items: center;
}
.loader .inner {
  width: 64px;
  height: 64px;
  border: 3px solid transparent;
  border-top: 3px solid #0ab39c;
  border-radius: 50%;
  -webkit-animation: spinInner 1s linear infinite;
          animation: spinInner 1s linear infinite;
}

@-webkit-keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
@-webkit-keyframes spinInner {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(-720deg);
  }
}
@keyframes spinInner {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(-720deg);
  }
}
    .btn{
        border-radius:0.625rem !important;
    }
    .color-gray{
        color:#333333;
    }
    .color--gray-2{
      color: #878A99;
    }
    .form-control{
        font-size:1rem;
        background: #FFFFFF;
        border: 1px solid rgba(0, 0, 0, 0.12);
    }
    .border-radius-10{
        border-radius:10px;
    }
    .padding-start-10{
        padding-left:9px;
    }
  @media screen and (max-width:820px){
    .page-content {
      margin-top: 65px;
    }
  }
</style>
