<template>
<div class="main-content">
    <div class="page-content pt-4 pb-2">
        <div class="catagory-mang">
            <!-------Start page title start-------->
            <div class="row p-4">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 color-gray fs-18">Combo</h4>
                    </div>
                </div>
            </div>
            <!-------Start page title End-------->
             <section class="categories pt-1">
                <div class="categories-main">
                    <div class="catagory-inner d-flex flex-wrap px-2">
                        <div class="catagory-single-card " v-for="combo in combos" :key="combo.id">
                            <div class="card equal-height-ingredient" :class="combo.status == 1 ? '' : 'card--deactive' ">
                                <div class="card-body px-3 py-2 text-center">
                                    <div class="mx-auto avatar-lg mb-2 card-image">
                                        <img :src="'/storage/'+ combo.image" alt="combo" class="w-100 border-radius-10" style="height:100%; max-height:59px;">
                                    </div>
                                    <p class="fs-12 title--name color-gray mb-0">{{ combo.name }}</p>
                                </div>
                                <div class="card-bottom px-1 text-center border-0">
                                    <ul class="list-inline mb-0 d-flex justify-content-between align-items-center">
                                        <li class="list-inline-item me-0 list--delete" v-if="allpermissions.ComboDelete">
                                            <a href="javascript:;" class="align-middle" data-bs-toggle="modal" data-bs-target="#removedataalert"  @click="comboId = combo.id"><i class="fa-solid fa-trash-can text-danger"></i></a>
                                        </li>
                                        <li class="fs-11 px-1 color--gray-2">{{currencyCode}} {{ combo.price.toFixed(2) }}</li>
                                        <li class="list-inline-item list--edit" v-if="allpermissions.ComboEdit">
                                            <a href="javascript:;" class="align-middle" @click="editCombo(combo.slug)"><i class="fa-solid fa-pen-to-square color-gray"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card--footer border-0">
                                    <div class="card-footer-detalis text-end">
                                        <p class="mb-0">{{combo.create}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <DeleteAlert @removeData="removeData" />
    <!------FOOTER START -------->
        <footer>
            <div class="footer-main bg-white" style="position:fixed; bottom: 0; width: 100%;">
                <div class="footer-link d-flex align-items-center justify-content-between">
                    <a href="javascript:;" @click="$router.go(-1)" class="text-success fs-16"><i class="ri-arrow-go-back-line "></i> Back</a>
                    <div class="submit-btn">
                        <button class="btn btn-success btn-custom fs-16"  @click="AddCombo()" v-if="allpermissions.ComboAdd"><i class="ri-add-fill me-1 align-bottom" ></i> Add Combo</button>
                    </div>
                </div>
            </div>
        </footer>
    <!------FOOTER END -------->
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
            products : [],
            combos : [],
            currencyCode : '',
            toast : useToast(),
            comboId : 0,
        }
    },
    props : ['allpermissions'],
    mounted() {
        $(this.$refs.modalTest).on("hidden.bs.modal", () => { alert('yes')} );
    },
    updated() {
        var highestBox = 0;
        var targetDiv = document.querySelectorAll('.equal-height-product');
        for(var i=0; i<targetDiv.length;i++){
        if(targetDiv[i].clientHeight > highestBox){
                highestBox = targetDiv[i].clientHeight;
        }
        }
        document.querySelectorAll(".equal-height-product").forEach(node => node.style.height = highestBox + "px");

    },
    beforeCreate(){
        this.$emit('addLoader');
    },
    created() {
        this.getsetting();
        this.getcombolist();
    },
    watch: {

    },
    methods:{
        getsetting(){
            axios.get('/api/getSettingData')
            .then(res => {
                this.currencyCode = res.data.setting.currency_symbol;
            }).catch(err => {
            })
        },
        getcombolist(){
            axios.get(`/api/getcombolist`)
                .then(res => {
                    this.combos = res.data.combo;
                    this.$emit('removeLoader');
                }).catch(err => {
                })
        },
        editCombo(slug){
            var slug = slug;
            this.$router.push(`/combo/edit/`+slug);
        },
        AddCombo(){
            this.$router.push(`/combo/add`);
        },
        removeData(){
            var formData = new FormData();
            formData.append('id', this.comboId);
            axios
            .post("/api/removeCombo",formData)
            .then((res) => {
                this.$emit("showToast",res.data.success,'success');
                this.getcombolist();

            }).catch((error) => {
            })
        },
    }
};


</script>

<style scoped>
    .title--name {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2; /* number of lines to show */
                line-clamp: 2;
        -webkit-box-orient: vertical;
        word-break: break-word;
        min-height: 27px;
        line-height: 13px;
    }

    /*********** CATEGORIES LIST START ***********/
    .catagory-mang{
        background: #FFFFFF;
        box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.25);
        border-radius: 10px;
        height: 100vh;
        max-height: calc(100vh - 179px);
    }
     .categories{
        overflow: auto;
        height: 100%;
        max-height: calc(100% - 75px);
      }
     .categories-main .catagory-inner .catagory-single-card .card .avatar-lg{
        width:5.5rem;
        height:5.5rem;
    }
     .categories-main .catagory-inner .catagory-single-card .card .card-image{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        max-width: 76px;
        width: 100%;
        max-height: 59px;
    }
     .categories-main .catagory-inner .catagory-single-card{
        flex: 0 0 9%;
        max-width:9%;
    }
     .categories-main .catagory-inner .catagory-single-card .card{
        background: #0ab39c0a;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        max-width:128px;
        margin-right:auto;
        margin-left:auto;
        height: 100%;
        max-height: 150px;
    }
    .categories .catagory-single-card .card--footer .card-footer-detalis{
        padding: 4px 10px;
        font-size: 9px;
        line-height: 13px;
        border-radius: 0px 0px 10px 10px;
        color: #878a99;
        font-weight: 400;
    }
    .categories .catagory-single-card .card-bottom .list--delete{
        height: 20px;
        padding: 3px;
        width: 20px;
        background: rgb(234 124 105 / 18%);
        border-radius: 4px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .categories .catagory-single-card .card--deactive .card-bottom .list--delete{
        z-index:100;
        background: rgb(248 165 151 / 20%);
    }
    .categories .catagory-single-card .card-bottom .list--edit{
        height: 20px;
        padding: 3px;
        width: 20px;
        background: #F4F4F4;
        border-radius: 4px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .categories .catagory-single-card .card--deactive .card-bottom .list--edit{
        z-index:100;
        background: rgba(244 ,244 ,244,0.35);
    }
    .categories-main .catagory-inner .catagory-single-card .card--deactive{
        position:relative;

    }
     .categories-main .catagory-inner .catagory-single-card .card--deactive::before{
        position: absolute;
        content: "";
        background-color: rgba(0,0,0,0.5);
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 99;
        border-radius: 10px;
        border-bottom: 3px solid #DD3333;
     }
    .categories-main .catagory-inner .catagory-single-card .card--deactive::after{
        position: absolute;
        content: "\f05e";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        right:0;
        left: 6px;
        top: 6px;
        bottom: 0;
        z-index: 99;
        color: #DD3333;
    }
    /************ FOOTER CSS START **************/
    .footer-main{
        padding:8px 15px 8px 32px;
    }
    .footer-main .footer-link .btn-custom{
        padding:12px 42px;
        font-weight:500;
        line-height:16px;
    }
    /*********** CATEGORIES LIST END ***********/
    /*********** RESPONSIVE CSS ***************/
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
        max-height: calc(100vh - 213px);
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
    @media screen and (max-width:820px){
        .catagory-mang{
            max-height:calc(100vh - 200px);
        }
    }

</style>
