<template>
     <div class="setting-right tax-setting">
        <div class="tax-setting-inner">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="tax-notes">
                        <div class="tax-notes-inner">
                            <div class="setting-heading">
                                <h5 class="fs-14 fw-medium color-gray mb-4">Notes</h5>
                            </div>
                            <div class="tax-notes-card p-2 mb-3" v-for="tax in taxes" :key="tax.id">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="notes-card-body">
                                            <p class="mb-2 fs-14 color-gray fw-medium">{{ tax.name }}</p>
                                            <p class="mb-0 fs-14 color-gray fw-medium">{{ tax.tax_value }} {{ tax.tax_type == 'flat' ? currencyCode : '%'}}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="notes-card-body text-end">
                                            <p class="mb-2"><i class="fa-solid fa-pen-to-square text-success pe-2 fs-14 cursor-pointer" @click="getSingleData(tax.id)"></i>
                                            <i class=" ri-delete-bin-7-line text-danger fs-14 z-pointer" style="vertical-align:middle;" data-bs-toggle="modal" data-bs-target="#removedataalert" @click="deleteId = tax.id"></i></p>
                                             <div class="form-check form-check-inline form-radio-success">
                                                <input class="form-check-input"  type="radio" :id="'status-on-'+tax.id" :name="'on-off'+tax.id" :checked="tax.status == 1" @change="statusChange(tax.id, 1)">
                                                <label class="form-check-label ps-2 fs-14" :for="'status-on-'+tax.id">On</label>
                                            </div>
                                            <div class="form-check form-check-inline form-radio-success me-0">
                                                <input class="form-check-input"  type="radio" :id="'status-off-'+tax.id" :name="'on-off'+tax.id" :checked="!tax.status" @change="statusChange(tax.id, 0)">
                                                <label class="form-check-label ps-2 fs-14" :for="'status-off-'+tax.id">Off</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12 mt-lg-0 mt-3">
                    <div class="add-taxes">
                        <div class="add-taxes-inner">
                            <div class="setting-heading">
                                <h5 class="fs-14 fw-medium color-gray mb-4">Add Taxes</h5>
                            </div>
                            <div class="add-taxes-details">
                                <div class="input-type-field margin--bottom--10">
                                    <label for="p-name" class="form-label fs-14 padding-start-10 color-gray">Tax Name <span class="text-danger"> * </span></label>
                                    <input type="hidden" class="form-control border-radius-10" v-model="id">
                                    <input type="text" class="form-control border-radius-10" placeholder="Tax Name" v-model="name">
                                </div>
                                <div class="taxes--tab mt-2">
                                    <label for="p-name" class="form-label fs-14 padding-start-10 color-gray">Tax Charge<span class="text-danger"> * </span></label>
                                    <div class="card tab--card bg-transparent">
                                        <div class="card-body p-0">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-pills nav-custom mb-3 justify-content-between" role="tablist">
                                                <li class="nav-item w-50 text-center">
                                                    <a class="nav-link text-success active fs-16 tax-type" data-bs-toggle="tab" href="#nav-light-precentage" role="tab" data-type="percentage" aria-selected="false" style="min-height:42px;">
                                                        Percentage
                                                    </a>
                                                </li>
                                                <li class="nav-item w-50 text-center">
                                                    <a class="nav-link text-success fs-16 flat tax-type" data-bs-toggle="tab" href="#nav-light-flat" role="tab" data-type="flat" aria-selected="false" style="min-height:42px;">
                                                        Flat
                                                    </a>
                                                </li>

                                            </ul>
                                            <div class="tab-content text-muted">
                                                <div class="tab-pane tab-tax-type active" id="nav-light-precentage" role="tabpanel" data-type="percentage">
                                                    <div class="input-type-field d-flex align-items-center border-radius-10">
                                                            <input type="number" class="form-control border-0 py-0 pe-2 ps-0" placeholder="10" v-model="valueper">
                                                            <i class=" ri-percent-line text-success fs-16"></i>
                                                    </div>
                                                </div>
                                                <div class="tab-pane tab-tax-type" id="nav-light-flat" role="tabpanel" data-type="flat">
                                                    <div class="input-type-field d-flex align-items-center border-radius-10">
                                                            <input type="number" class="form-control border-0 py-0 pe-2 ps-0" placeholder="100" v-model="valueflat">
                                                            <P class="mb-0 fs-16">{{currencyCode}}</P>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end card-body -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-end save--btn position-absolute" style="bottom:20px; right:24px;">
            <button class="btn btn-success" @click="taxAddUpdate">Save</button>
        </div>
    </div>
    <DeleteAlert @removeData="removeData" />
</template>
<script>
import $ from "jquery";
import DeleteAlert from './DeleteAlert.vue'
import { useToast } from "vue-toastification";
    export default {
        name : 'TaxSetting',
        data(){
            return{
                id : 0,
                name : '',
                type : 'percentage',
                valueper : '',
                valueflat : '',
                status : 1,
                taxes : [],
                toast : useToast(),
                deleteId : 0,
                currencyCode : '',
            }
        },
        components: {
            DeleteAlert
        },
        beforeCreate(){
            this.$emit('addLoader');
        },
        created() {
            this.gettaxes();
            this.getsetting();
        },
        methods: {
            getsetting(){
                axios.get('/api/getSettingData')
                .then(res => {
                    this.currencyCode = res.data.setting.currency_symbol;
                    this.$emit('removeLoader')
                }).catch(err => {
                })
            },
            gettaxes(){
                axios.get(`/api/gettaxes`)
                .then(res => {
                    this.taxes = res.data.taxes;
                }).catch(err => {
                })
            },
            taxAddUpdate(){

            this.$emit('showToast',"You Can not change this on demo account.",'error'); 
            return false;
                // var type = $(".tax-type.active").data('type');
                // var name = this.name;
                // if(type == 'percentage'){
                //     var value = this.valueper;
                // }
                // if(type == 'flat'){
                //     var value = this.valueflat;
                // }

                // if(value == '' && name != ''){ this.$emit('showToast',"Please Enter Tax Charge",'error'); return false;}
                // if(value != '' && name == ''){ this.$emit('showToast',"Please Enter Tax Name",'error'); return false;}

                // if(type == 'percentage' && value){
                //     if(value > 100){this.$emit('showToast',"Please Enter Tax Percentage in 100",'error'); return false; }
                //     if(value < 1){this.$emit('showToast',"Please Enter Tax Percentage in 100",'error'); return false; }
                // }

                //  if(type == 'flat' && value){
                //     value < 0 ? this.$emit('showToast',"Please Enter Positive value For tax price",'error') : '';
                //     if(value < 0)
                //     return ;
                // }

                // if(value == '' || name == ''){ this.$emit('showToast',"Please fill out form details.",'error'); return false;}

                // var button = event.target;
                // button.disabled = true;
                // button.textContent = 'saving...';

                // const config = {
                //     headers: { 'content-type': 'multipart/form-data' }
                // }

                // var formData = new FormData();
                // formData.append('tax_type', type);
                // formData.append('tax_value', value);
                // formData.append('name', name);
                // formData.append('id', this.id);
                // formData.append('status', this.status);

                // axios
                // .post("/api/tax-add-update",formData,config)
                // .then((res) => {
                //     this.$emit('showToast',res.data.success,"success");
                //     this.gettaxes();
                //     this.blankForm();
                //     button.disabled = false;
                //     button.textContent = 'save';
                // }).catch((error) => {
                // })
            },
            blankForm(){
                this.id = 0;
                this.name = '';
                this.type = 'percentage';
                this.valueper = '';
                this.valueflat = '';
                this.status = 1;
                $(".tax-type[data-type='percentage']").addClass('active');
                $(".tax-type[data-type='flat']").removeClass('active');
                $("#nav-light-precentage").addClass('active');
                $("#nav-light-flat").removeClass('active');
            },
            statusChange(id, value){

            this.$emit('showToast',"You Can not change this on demo account.",'error'); 
            return false;
                // const config = {
                //     headers: { 'content-type': 'multipart/form-data' }
                // }

                // var formData = new FormData();
                // formData.append('id', id);
                // formData.append('value', value);

                // axios
                // .post("/api/tax-status-change",formData,config)
                // .then((res) => {
                //     this.$emit('showToast',"Status changed successfully.","success");
                //     this.gettaxes();
                // }).catch((error) => {
                // })
            },
            getSingleData(id){
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }
                axios
                .get("/api/tax-single-data/"+id)
                .then((res) => {
                    this.id = res.data.tax.id;
                    this.name = res.data.tax.name;
                    $(".tax-type").removeClass('active');
                    $(".tax-type[data-type="+res.data.tax.tax_type+"]").addClass('active');

                    $(".tab-tax-type").removeClass('active');
                    $(".tab-tax-type[data-type="+res.data.tax.tax_type+"]").addClass('active');

                    this.type = res.data.tax.tax_type;
                    if(res.data.tax.tax_type == 'percentage') this.valueper = res.data.tax.tax_value;
                    if(res.data.tax.tax_type == 'flat') this.valueflat = res.data.tax.tax_value;
                    this.status = res.data.tax.status;
                }).catch((error) => {
                })
            },
            removeData(){

            this.$emit('showToast',"You Can not change this on demo account.",'error'); 
            return false;
                // var formData = new FormData();
                // formData.append('id', this.deleteId);
                // axios
                // .post("/api/tax-delete",formData)
                // .then((res) => {
                //     this.$emit('showToast',"Tax  deleted successfully.","success");
                //     this.gettaxes();
                // }).catch((error) => {
                // })
            }


        }
    }
</script>
<style>
    .tax-setting .tax-notes .tax-notes-card{
        background: #FFFFFF;
        box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.25);
    }
    .tax-setting .tax-notes .tax-notes-card .form-check-input{
        width: 16px;
        height: 16px;
    }
    .tax-setting .add-taxes .add-taxes-details .taxes--tab .card{
        box-shadow: none;
    }
    .tax-setting .add-taxes .add-taxes-details .taxes--tab .tab--card .nav-custom {
        background: #FFFFFF;
        border: 1px solid rgba(0, 0, 0, 0.12);
        border-radius: 10px;
        color: #000;
    }
    .tax-setting .add-taxes .add-taxes-details .taxes--tab .nav-custom .nav-item .nav-link.active {
        color: #ffff !important;
        background-color: #0AB39C;
        border: 1px solid #0AB39C;
        border-radius: 10px 0px 0px 10px;
    }
    .tax-setting .add-taxes .add-taxes-details .taxes--tab .nav-custom .nav-item .nav-link.active.flat{
        border-radius:0px 10px 10px 0px;
    }
    .tax-setting .add-taxes .add-taxes-details .taxes--tab .tab-content .input-type-field{
        background: #FFFFFF;
        border: 1px solid rgba(0, 0, 0, 0.12);
        padding: 0.5rem 0.9rem;
    }
    .cursor-pointer{
        cursor : pointer;
    }
</style>
