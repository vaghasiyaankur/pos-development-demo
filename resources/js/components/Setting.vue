<template>
    <div class="main-content">
        <div class="page-content pb-0 pt-4">
            <div class="setting-main">
                <div class="row px-2">
                    <div class="col-lg-3 col-4 px-2">
                        <SettingLeft :navigation="navigation" />
                    </div>
                    <div class="col-lg-9 col-8 px-2">
                    <!-- <SettingRight /> -->
                     <router-view  @addLoader="this.$emit('addLoader')" @removeLoader="this.$emit('removeLoader')" @showToast="showToast"/>
                    </div>
                </div>
            </div>
        </div>
        <!------FOOTER START -------->
            <footer class="footer-start">
                <div class="footer-main bg-white" >
                    <div class="footer-link d-flex align-items-center justify-content-between">
                        <a href="javascript:;" @click="$router.go(-1)" class="text-success fs-16"><i class="ri-arrow-go-back-line "></i> Back</a>
                        <!-- <div class="add-catagory-btn">
                            <button class="btn fs-16 btn-custom me-2 text-white" style="background-color:#878A99;" @click="clearData()">Clear All</button>
                            <button class="btn btn-success fs-16 btn-custom text-white" @click="addCombo()">Add Combo</button>
                        </div> -->
                    </div>
                </div>
            </footer>
        <!------FOOTER END -------->
    </div>
</template>
<script>
import SettingLeft from "./include/SettingLeft.vue";
const navigation=[
  {
    url:"/setting",
    name: "General Setting",
    tab: "GeneralSetting",
    status: true
},
  {
    url:"/setting/currency",
    name: "Currency",
    tab: "CurrencySetting",
    status: true
},
  {
    url:"/setting/taxes",
    name: "Taxes",
    tab: "TaxSetting",
    status: true
},
  {
    url:"/setting/user-management",
    name: "User Management",
    tab: "UserManagement",
    status: true
},
];
export default {
    name: 'Setting',
    components : {
        SettingLeft
    },
    setup() {
      return {
          navigation,
      }
    },
    methods:{
        showToast(message,type) {
           this.$emit('showToast', message, type);
        }
    }
}
</script>
<style >
    .margin--bottom--10{
        margin-bottom: 10px;
    }
     .footer-main{
        padding:8px 15px 8px 32px;
        position:fixed;
        bottom: 0;
        width: 100%;
    }
    @media screen and (max-width:820px){
        .page-content{
            margin-top:20px;
        }
    }

</style>
