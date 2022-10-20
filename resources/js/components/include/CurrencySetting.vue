<template>
    <div class="setting-right currency-setting position-relative">
        <div class="setting-heading">
            <h5 class="fs-14 fw-medium color-gray mb-4">Add new Currency</h5>
        </div>
        <div class="currency-setting-inner">
            <form class="carrency-setting-from">
                <div class="row margin--bottom--10">
                    <div class="col-12">
                        <div class="input-type-field">
                            <label for="p-name" class="form-label fs-14 padding-start-10 color-gray">Name
                                <span class="text-danger"> * </span></label>
                            <input type="text" v-model="currency_name" class="form-control border-radius-10 fs-16" placeholder="e.g. Us Dollar">
                        </div>
                    </div>
                </div>
                <div class="row margin--bottom--10">
                    <div class="col-12">
                        <div class="input-type-field">
                            <label for="p-name" class="form-label fs-14 padding-start-10 color-gray">Code
                                <span class="text-danger"> * </span></label>
                            <input type="text" v-model="currency_code" class="form-control border-radius-10 fs-16"
                                placeholder="e.g. usd for US Dollar">
                        </div>
                    </div>
                </div>
                <div class="row margin--bottom--10">
                    <div class="col-12">
                        <div class="input-type-field">
                            <label for="p-name" class="form-label fs-14 padding-start-10 color-gray">Symbol
                                <span class="text-danger"> * </span></label>
                            <input type="text" v-model="currency_symbol" class="form-control border-radius-10 fs-16" placeholder="e.g. $,₹">
                        </div>
                    </div>

                </div>

            </form>

        </div>
        <div class="text-end save--btn position-absolute" style="bottom:20px; right:12px;">
            <button class="btn btn-success" @click="saveSetting()">Save</button>
        </div>
    </div>
</template>
<script>
import { useToast } from "vue-toastification";
export default {
    name: 'CurrencySetting',
    data() {
        return {
            currency_name : '',
            currency_code : '',
            currency_symbol : '',
            toast : useToast(),
        }
    },
    beforeCreate(){
        this.$emit('addLoader');
    },
    methods: {
        getSettingData(){
            axios.get(`/api/getSettingData`)
                .then(res => {
                    var data = res.data.setting;
                    this.currency_name = data.currency_name
                    this.currency_code = data.currency_code
                    this.currency_symbol = data.currency_symbol
                    this.$emit('removeLoader');
                }).catch(err => {
                })
        },
         saveSetting(){
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }
            
            if (!this.currency_name && this.currency_code && this.currency_symbol){ this.$emit("showToast","Please fill the currency name field.",'error'); return false; }

            if (this.currency_code && !this.currency_code && this.currency_symbol){ this.$emit("showToast","Please fill the currency code field.",'error'); return false; }

            if (this.currency_symbol && this.currency_code && !this.currency_symbol){ this.$emit("showToast","Please fill the currency symbol field.",'error'); return false; }

            if(!this.currency_name || !this.currency_code || !this.currency_symbol){ this.$emit('showToast',"Please fill out form details.",'error'); return false; }


            var button = event.target;
            button.disabled = true;
            button.textContent = 'saving...';

            var formData = new FormData();
            formData.append('currency_name', this.currency_name);
            formData.append('currency_code', this.currency_code);
            formData.append('currency_symbol', this.currency_symbol);

            axios
            .post("/api/edit-setting",formData,config)
            .then((res) => {
                this.$emit("showToast",res.data.success,'success');
                this.getSettingData();
                button.disabled = false;
                button.textContent = 'save';
            }).catch((error) => {
            })
        }
    },
    created() {
        this.getSettingData();
    },
}
</script>
