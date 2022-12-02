<template>
    <div class="setting-right general-setting position-relative">
        <div class="setting-heading">
            <h5 class="fs-14 fw-medium color-gray mb-3">Add General</h5>
        </div>
        <div class="general-setting-inner">
            <form class="general-setting-form">
                <div class="row margin--bottom--10">
                    <div class="col-12">
                        <div class="input-type-field">
                            <label for="p-name" class="form-label fs-14 padding-start-10 color-gray mb-1">Restaurant Name <span class="text-danger"> * </span></label>
                            <input type="text" v-model="restaurantName" class="form-control border-radius-10" placeholder="Restaurant Name">
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row margin--bottom--10">
                        <div class="col-6 pe-2">
                            <label for="p-name" class="form-label fs-14 padding-start-10 color-gray mb-1">Logo</label>
                            <div class="icon--box mb-2">
                                <div class="icon--box--inner">
                                    <span class="logo-lg"><img :src="logo_image_url" class="img-fluid" alt="settings"></span>
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input class="custom-file-input" id="logo-image" type="file" @change="onLogoImageChange">
                                    <label class="custom-file-label" for="logo-image"><span>{{logo_image_name.name ? logo_image_name.name : logo_image_name }}</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 ps-2">
                            <label for="p-name" class="form-label fs-14 padding-start-10 color-gray mb-1">Fav Icon</label>
                            <div class="icon--box mb-2">
                                <div class="icon--box--inner">
                                    <img :src="fav_icon_image_url" class="img-fluid" alt="settings">
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input class="custom-file-input" id="fav-icon-image" type="file" @change="onFavIconImageChange">
                                    <label class="custom-file-label" for="fav-icon-image"><span>{{fav_icon_image_name.name ? fav_icon_image_name.name : fav_icon_image_name }}</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 margin--bottom--10">
                        <div class="col-6 pe-2">
                            <label for="p-name" class="form-label fs-14 padding-start-10 color-gray mb-1">Light Logo</label>
                            <div class="icon--box mb-2">
                                <div class="icon--box--inner">
                                    <span class="logo-lg"><img :src="light_logo_image_url" class="img-fluid" alt="settings"></span>
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input class="custom-file-input" id="light-logo-image" type="file" @change="onLightLogoImageChange">
                                    <label class="custom-file-label" for="light-logo-image"><span>{{light_logo_image_name.name ? light_logo_image_name.name : light_logo_image_name }}</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row margin--bottom--10 mt-3">
                        <div class="col-12">
                            <div class="product-description-text">
                                <label class="form-label fs-14 fw-medium padding-start-10 color-gray mb-1">Address <span class="text-danger">*</span>  </label>
                                <textarea class="form-control border-radius-10" v-model="address" rows="2" placeholder="Address"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row margin--bottom--10">
                        <div class="col-6 pe-2">
                           <div class="input-type-field">
                                <label for="p-name" class="form-label fs-14 padding-start-10 color-gray mb-1">Phone <span class="text-danger"> * </span></label>
                                <input type="text" class="form-control border-radius-10" v-model="phoneNumber" placeholder="+91 0000 000 000">
                            </div>
                        </div>
                        <div class="col-6 ps-2">
                            <div class="input-type-field">
                                <label for="p-name" class="form-label fs-14 padding-start-10 color-gray mb-1">Time Zone   <span class="text-danger"> * </span></label>
                                <Select2 v-model="time_zone" class="border-radius-10" :options="timeZone" :settings="{ settingOption: value, settingOption: value }" @change="myChangeEvent($event)"  />
                            </div>
                        </div>
                    </div>
                    <div class="row margin--bottom--10">
                        <div class="col-6 pe-2">
                           <div class="input-type-field">
                                <label for="p-name" class="form-label fs-14 padding-start-10 color-gray mb-1">Print Bill Header</label>
                                <input type="text" v-model="print_bill_header" class="form-control border-radius-10" placeholder="Optional">
                            </div>
                        </div>
                        <div class="col-6 ps-2">
                            <div class="input-type-field">
                                <label for="p-name" class="form-label fs-14 padding-start-10 color-gray mb-1">Print Bill Footer</label>
                                <input type="text" v-model="print_bill_footer" class="form-control border-radius-10" placeholder="Optional">
                            </div>
                        </div>
                    </div>
                    <div class="text-end sav-btn-tab save--btn">
                        <button type="button" class="btn btn-success" @click="saveSetting()">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
import { useToast } from "vue-toastification";
import Select2 from 'vue3-select2-component';
export default {
    name: 'GeneralSetting',
    components: {Select2},
    data() {
        return {
            restaurantName : '',
            address : '',
            phoneNumber : 0,
            print_bill_header : '',
            print_bill_footer : '',
            logo_image_name: 'Choose Flie',
            logo_image_url : '',
            light_logo_image_name: 'Choose Flie',
            light_logo_image_url : '',
            fav_icon_image_name: 'Choose Flie',
            fav_icon_image_url: '',
            toast : useToast(),
            timeZone : [],
            time_zone : 'Africa/Abidjan',
        }
    },
    beforeCreate(){
        this.$emit('addLoader');
    },
    updated() {
        $("span.select2-container--default").css({'z-index': '10','width':'100%'});
    },
    methods: {
        onLogoImageChange(e){
            this.logo_image_name = e.target.files[0];
            this.logo_image_url = URL.createObjectURL(this.logo_image_name);
        },
        onLightLogoImageChange(e){
            this.light_logo_image_name = e.target.files[0];
            this.light_logo_image_url = URL.createObjectURL(this.light_logo_image_name);
        },
        onFavIconImageChange(e){
            this.fav_icon_image_name = e.target.files[0];
            this.fav_icon_image_url = URL.createObjectURL(this.fav_icon_image_name);
        },
        getSettingData(){
            axios.get(`/api/getSettingData`)
                .then(res => {
                    var data = res.data.setting;
                    this.restaurantName = data.restaurent_name
                    this.address = data.address
                    this.phoneNumber = data.phone
                    this.print_bill_header = data.print_bill_header
                    this.print_bill_footer = data.print_bill_footer
                    this.logo_image_url = `/storage/`+data.logo
                    this.light_logo_image_url = `/storage/`+data.light_logo
                    this.fav_icon_image_url = `/storage/`+data.fav_icon
                    this.time_zone = data.time_zone
                    this.timeZone = res.data.timeZone;
                    $('.logo img').attr('src',this.logo_image_url);
                    $('.light_logo img').attr('src',this.light_logo_image_url);
                    $('link[rel="shortcut icon"]').attr('href',this.fav_icon_image_url);
                    this.$emit('removeLoader')
                }).catch(err => {
                })
        },
        saveSetting(){

            this.$emit('showToast',"You Can not change this on demo account.",'error'); 
            return false;
            // const config = {
            //     headers: { 'content-type': 'multipart/form-data' }
            // }

            // var check_error = 0;

            // if (this.restaurantName == '' && this.address != '' && this.phoneNumber != '' && this.time_zone != ''){ this.$emit('showToast',"Please fill the restaurant name field.","error"); return false; }

            // if (this.restaurantName != '' && this.address == '' && this.phoneNumber != '' && this.time_zone != ''){ this.$emit('showToast',"Please fill the address field.","error"); return false; }

            // if (this.restaurantName != '' && this.address != '' && this.phoneNumber == '' && this.time_zone != ''){ this.$emit('showToast',"Please fill the phone number field.","error"); return false; }

            // if (this.restaurantName != '' && this.address != '' && this.phoneNumber != '' && this.time_zone == ''){ this.$emit('showToast',"Please select any one time zone.","error"); return false; }

            // if(this.restaurantName == '' || this.address == '' || this.phoneNumber == '' || this.time_zone == '') { this.$emit('showToast',"Please fill out form details.",'error'); return false; }


            // var button = event.target;
            // button.disabled = true;
            // button.textContent = 'saving...';

            // var formData = new FormData();
            // formData.append('restaurent_name', this.restaurantName);
            // formData.append('address', this.address);
            // formData.append('phone', this.phoneNumber);
            // formData.append('print_bill_header', this.print_bill_header);
            // formData.append('print_bill_footer', this.print_bill_footer);
            // formData.append('logo', this.logo_image_name);
            // formData.append('light_logo', this.light_logo_image_name);
            // formData.append('fav_icon', this.fav_icon_image_name);
            // formData.append('time_zone', this.time_zone);

            // axios
            // .post("/api/edit-setting",formData,config)
            // .then((res) => {
            //     this.$emit('showToast',res.data.success,"success");
            //     this.getSettingData();
            //     button.disabled = false;
            //     button.textContent = 'save';
            // }).catch((error) => {
            // })
        }
    },
    created() {
        this.getSettingData();
    },
}
</script>
<style>
    /*--------SETTING RIGHT----------------*/
    .setting-right{
        background: #FFFFFF;
        box-shadow: 0px 0px 10px 1px rgba(0, 0, 0, 0.25);
        border-radius: 10px;
        height: 100vh;
        max-height: calc(100vh - 195px);
        padding: 15px 12px 15px;
        overflow: auto;
    }
    /*--------------- GENERAL SETTING FORM CSS-------------------------*/
    .general-setting .general-setting-form .icon--box{
        height: 100px;
        background: #ffff;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px solid rgba(0, 0, 0, 0.12);
        border-radius: 10px;
    }
    .general-setting .general-setting-form .icon--box .icon--box--inner img{
        max-height: 80px;
    }
    .general-setting .general-setting-inner .general-setting-form .form-control{
        max-height: 36px;
    }
    .setting-right .save--btn .btn{
        padding: 12px 25px;
        font-size: 16px;
        line-height: 16px;
        font-weight: 500;
    }
    /********** FILE UPLOAD CSS *********/

    .general-setting .general-setting-inner .general-setting-form .input-group {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -webkit-box-align: stretch;
        -ms-flex-align: stretch;
        align-items: stretch;
        width: 100%;
    }
    .general-setting .general-setting-inner .general-setting-form .input-group > .custom-file {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
    }
    .general-setting .general-setting-inner .general-setting-form .input-group > .form-control, .input-group > .custom-select, .input-group > .custom-file {
        position: relative;
        -webkit-box-flex: 1;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        width: 1%;
        margin-bottom: 0;
    }
    .general-setting .general-setting-inner .general-setting-form .custom-file-input {
        position: relative;
        z-index: 2;
        width: 100%;
        margin: 0;
        opacity: 0;
    }
    .general-setting .general-setting-inner .general-setting-form button, input {
        overflow: visible;
    }
    .general-setting .general-setting-inner .general-setting-form input, button, select, optgroup, textarea {
        margin: 0;
        font-family: inherit;
        font-size: inherit;
        line-height: inherit;
    }
    .general-setting .general-setting-inner .general-setting-form .input-group > .custom-file:not(:last-child) .custom-file-label, .input-group > .custom-file:not(:last-child) .custom-file-label::before {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    .general-setting .general-setting-inner .general-setting-form .custom-file-label {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        z-index: 1;
        max-height: 36px;
        padding: 10px 11px;
        line-height: 1.5;
        color: #333;
        display: flex;
        background: #fff;
        align-items: center;
        border: 1px solid rgba(0, 0, 0, 0.12);
        border-radius: 10px;
        }
    .general-setting .general-setting-inner .general-setting-form .custom-file-label::after {
        position: absolute;
        top: 0px;
        right: 0;
        bottom: 0;
        z-index: 3;
        display: block;
        max-height: 36px;
        padding: 10px 24px;
        line-height: 16px;
        font-size: 16px;
        color: #6F827F;
        content: "Browse";
        font-weight: 400;
        background: #FFFFFF;
        border-left: 1px solid rgba(0, 0, 0, 0.12);
        border-radius: 0px 10px 10px 0px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    /*--------------- RESPONSIVE CSS -------------------*/
    @media screen and (max-width:1180px){
        .setting-right{
            max-height: calc(100vh - 160px);
        }
    }
    @media screen and (max-width:820px){
        .setting-right{
            max-height: calc(100vh - 190px);
        }
        .setting-right .general-setting-inner .general-setting-form .sav-btn-tab{
            position: absolute;
            bottom: 20px;
            right: 12px;
        }
    }

</style>
