<template>
<div class="main-content">
    <div class="page-content pb-0 pt-4 complete-order">
        <div class="complete-order-inner">
            <div class="row px-2">
                <div class="px-2" :class="completed_orders.length == 0 ? 'col-lg-12 col-md-12' : 'col-lg-7 col-md-6'">
                    <div class="complete-order-left">
                        <div class="row align-items-center mb-3 justify-content-between">
                            <div class="col-5">
                                <div class="search-box">
                                    <input type="text" v-model="searchData" class="form-control border-radius-10" placeholder="Search Order..." @keyup="filterCompleteOrder"><i class="fa-solid fa-magnifying-glass search-icon fs-16" data-v-66f63333=""></i>
                                </div>
                            </div>
                            <div class="col-5 row">
                                <input type="text" class="form-control shawCalRanges" @input="filterCompleteOrder">
                            </div>
                            <div class="col-2 ps-0">
                                <p class="mb-0 text-end color--gray-2 fs-12">{{completed_orders.length}} Results</p>
                            </div>
                        </div>
                        <!-- <div class="loading" :class="{ 'd-none' : !addLoader}"></div> -->
                        <div class="no--order-box" v-if="completed_orders.length == 0">
                            <div class="no--order--text text-center">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width:75px;height:75px">
                                </lord-icon>
                                <h1 class="mb-0 color-gray">No Order Found</h1>
                            </div>
                        </div>
                        <div class="complete-order-card pb-5 mb-5" v-else>
                            <div class="card single-order-card border-radius-10 mb-2" v-for="order in completed_orders" :key="order.id" :class="{ 'active': activeOrder == order.id }" @click="activeOrder = order.id;getOrderProduct(order.id,order.table_order.table_id)">
                                <div class="card-body d-flex justify-content-between py-2 ">
                                    <div class="card--order-detail">
                                        <h6 class="fs-14 text-success mb-1">Order #{{order.id}}</h6>
                                        <p class="mb-1 color--gray-2 fs-12"><i class="ri-time-line pe-2" style="vertical-align: bottom;"></i>{{ order.create }}</p>
                                        <p class="mb-1 color--gray-2 fs-12" v-if="order.table_order"><i class="fa-regular fa-user pe-2"></i>{{ order.table_order.customer.email ? order.table_order.customer.email : order.table_order.customer.name}}</p>
                                    </div>
                                    <div class="card--items">
                                        <h6 class="card-title text-success mt-2">{{currencySymbol}} {{ order.total_amount.toFixed(2) }}</h6>
                                        <p class="mb-1 color--gray-2 fs-12 text-end">{{order.order_product_count}} items</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6 px-2" :class="{ 'd-none' : completed_orders.length == 0}">
                    <div class="complete-order-right">
                        <!-- <div class="loading" :class="{ 'd-none' : !addproductLoader}"></div> -->
                        <div class="no--order-box" v-if="completed_orders.length == 0">
                            <div class="no--order--text text-center">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width:75px;height:75px">
                                </lord-icon>
                                <h1 class="mb-0 color-gray">No Order Found</h1>
                            </div>
                        </div>
                        <div class="order-right-inner" v-else :class="{ 'd-none' : addproductLoader}">
                            <div class="row align-items-center mb-4">
                                <div class="col-5">
                                    <button class="btn btn-success fs-16 btn-custom text-white">Order #{{activeOrderId}}</button>
                                </div>
                                <div class="col-7">
                                     <p class="mb-0 color--gray-2 fs-14 border-bottom"><i class="fa-regular fa-user pe-2"></i>{{ activeOrderemail ? activeOrderemail : activeOrdername}}</p>
                                </div>
                            </div>
                            <div class="order-right-details">
                                <div class="order-right-details-main">
                                    <div class="order-details-single border-bottom pb-3 mb-3" v-for="product in orderProduct" :key="product">
                                        <div class="row align-items-center mx-0">
                                            <div class="col-2 px-2">
                                                <img :src="'/storage/'+product.image" alt="order" class="img-fluid border-radius-10">
                                            </div>
                                            <div class="col-8 px-2">
                                                <p class="fs-12 color-gray mb-0">{{product.name}}</p>
                                                <p class="fs-11 mb-0 color--gray-2">{{currencySymbol}}{{product.price.toFixed(2)}} x {{product.quantity}}</p>
                                            </div>
                                            <div class="col-2 px-2">
                                                <p class="fs-11 mb-0 color--gray-2 text-end">{{currencySymbol}}{{product.total_price.toFixed(2)}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-details-bottom">
                                    <div class="order--total mb-1 d-flex justify-content-between align-items-center">
                                        <p class="mb-0 fs-15">Sub total :</p>
                                        <p class="mb-0 fs-15">{{currencySymbol}} {{(activeOrdersubprice).toFixed(2)}}</p>
                                    </div>
                                    <div class="order--total mb-1 d-flex justify-content-between align-items-center" v-for="(tax, taxId) in activeOrderTax" :key="taxId">
                                        <p class="mb-0 fs-15">{{ tax.name }} :</p>
                                        <p class="mb-0 fs-15">{{currencySymbol}} {{(tax.value).toFixed(2)}}</p>
                                    </div>
                                    <div class="order--total mb-3 d-flex justify-content-between align-items-center">
                                        <p class="mb-0 text-success fs-15">Total Amount</p>
                                        <p class="mb-0 text-success fs-15">{{currencySymbol}} {{activeOrderprice.toFixed(2)}}</p>
                                    </div>
                                    <div class="row">
                                        <div :class="activeOrderemail ? 'col-6' : 'col-12'">
                                            <button type="button" class="btn btn-success w-100 fs-16 btn--custom" @click="printOrder(activeOrderId)"> <i class="ri-printer-line"></i> Print Invoice</button>
                                        </div>
                                        <div class="col-6" v-if="activeOrderemail">
                                            <button type="button" class="btn btn-dark w-100 fs-16 btn--custom" id="emailInvoiceButton"  @click="emailInvoice(activeOrderId)"><i class="fa-solid fa-envelope-open-text pe-2"></i>Email Invoice </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-------- Print Invoice Part --------->
                    <div class="section-to-print d-none" id="section-to-print">
                        <Print :printData="printData" :printOrdersData="printOrdersData" />
                    </div>
                <!--------- Print Invoice Part ---------->
            </div>
        </div>
    </div>
    <!------FOOTER START -------->
    <footer class="footer-start">
        <div class="footer-main bg-white" style="position:fixed; bottom: 0; width: 100%;">
            <div class="footer-link d-flex align-items-center justify-content-between">
                <a href="javascript:;" @click="$router.go(-1)" class="text-success fs-16"><i class="ri-arrow-go-back-line "></i> Back</a>
            </div>
        </div>
    </footer>
    <!------FOOTER END -------->
    <button id="dateSelect" class="border-0" @click="filterCompleteOrder"></button>


</div>
</template>

<script>
import $ from "jquery";
import Print from "./include/Print.vue";
import DateRangePicker from 'vue3-daterange-picker';
// import 'vue3-daterange-picker/dist/vue3-daterange-picker.css'

import moment from 'moment';
import daterangepicker from 'bootstrap-daterangepicker';


export default {
    name: 'CompleteOrder',
    components: {
        Print,
        DateRangePicker
    },
    data() {
        return {
            completed_orders : [],
            currencySymbol : '',
            orderProduct : [],
            activeOrder : 0,
            activeOrderId : 0,
            activeOrdername : '',
            activeOrderemail : '',
            activeOrdersubprice : 0,
            activeOrderprice : 0,
            activeOrderTax : [],
            printOrdersData : [],
            printData: {
                data: [],
                sub_total: 0,
                pay_total: 0,
                current_date: '',
                current_time: '',
                purchase_type: '',
                table: 0,
                footer: '',
                taxes: []
            },
            searchData : '',
            addLoader : false,
            addproductLoader : false,
            dateValue: '',
            picker: ''
        }
    },
    beforeCreate(){
        this.$emit('addLoader');
    },
    created(){
        this.getsetting();
        this.getCompletedOrderList();

    },
    
    methods: {
        formatDate(date) {
            return data.toLocaleDateString();
        },
        getsetting(){
            axios.get('/api/getSettingData')
            .then(res => {
                this.currencySymbol = res.data.setting.currency_symbol;
            }).catch(err => {
            })
        },
        getCompletedOrderList() {
            axios.get('/api/getcompleteorderddata')
                .then(res => {
                    this.completed_orders = res.data.completed_orders;
                    console.log(this.completed_orders.length);
                    if(this.completed_orders.length != 0){
                        setTimeout(() => {
                            this.datepicker();
                        }, 3000);
                    }
                    this.$emit('removeLoader');
                    var orderId = this.completed_orders[0].id;
                    var tableId = this.completed_orders[0].table_order.table_id;
                    this.activeOrder = orderId;
                    this.getOrderProduct(orderId, tableId);
                }).catch(err => {})
        },
        getOrderProduct(tableId,orderId){
            this.addproductLoader = true;
            axios.get('/api/getOrderProduct/'+orderId+'/'+tableId)
                .then(res => {
                    this.orderProduct = res.data.products.data;
                    this.activeOrderId = res.data.products.id;
                    this.activeOrdername = res.data.products.customer_name;
                    this.activeOrderemail = res.data.products.customer_email;
                    this.activeOrderprice = res.data.products.total_amount;
                    this.activeOrderTax = res.data.products.taxes;
                    this.activeOrdersubprice = res.data.products.pay_amount;
                    this.addproductLoader = false;
                    this.$emit('removeLoader');
                }).catch(err => {
                })
        },
        printOrder(id) {
            axios
                .get("/api/printCompletedorder/" + id)
                .then((res) => {
                    this.printData = res.data.printData;
                    this.printOrdersData = res.data.printOrdersData;
                    setTimeout(() => {
                        this.orderForPrinting();
                    }, 1000);
                })
                .catch((err) => {});
        },
        emailInvoice(id){
            $("#emailInvoiceButton").attr('disabled','disabled');
            const config = {
                headers: { 'content-type': 'multipart/form-data'}
            }
            axios.post('/api/emailInvoice',{id: id},config)
            .then(res => {

                $("#emailInvoiceButton").removeAttr('disabled');
                this.$emit("showToast","Mail Send successfully",'success');
            }).catch(err => {
            })
        },
        orderForPrinting() {

            // Get HTML to print from element
            const prtHtml = document.getElementById('section-to-print').innerHTML;

            // Get all stylesheets HTML
            let stylesHtml = "";
            for (const node of [
                    ...document.querySelectorAll('link[rel="stylesheet"], style'),
                ]) {
                stylesHtml += node.outerHTML;
            }

            // Open the print window
            const WinPrint = window.open(
                "",
                "",
                "left=0,top=0"
            );

            WinPrint.document.write(`<!DOCTYPE html>
            <html>
            <head>
                ${stylesHtml}
            </head>
            <body>
                ${prtHtml}
            </body>
            </html>`);

            WinPrint.document.close();
            WinPrint.focus();
            WinPrint.print();
            // WinPrint.close();
        },
        filterCompleteOrder(){
            this.addLoader = true;
            this.addproductLoader = true;
            var shawCalRanges = $('.shawCalRanges').val();

            axios
                .post("/api/filterCompleteOrder", {
                    search: this.searchData,
                    daterange : shawCalRanges,
                })
                .then((res) => {
                    this.completed_orders = res.data.completed_orders;
                    var orderId = this.completed_orders[0].id;
                    var tableId = this.completed_orders[0].table_order.table_id;
                    this.activeOrder = orderId;
                    this.getOrderProduct(orderId,tableId);
                    this.addLoader = false;
                }).catch((error) => {})
        },
        datepicker() {
            console.log("here");
            $('.shawCalRanges').daterangepicker({
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minViewMode: 1,
                clearBtn: true,
                autoclose: true,
                enableOnReadonly: true,
                locale: {
                    format: 'YYYY-MM-DD'
                },
                alwaysShowCalendars: true,
            }).on('change', function (selected) {
                $('#dateSelect').click();
            });
        },
    },
};
</script>
<style scoped>
    /********** complete order left css *************/
    .complete-order-inner .no--order-box{
        display: flex;
        justify-content: center;
        align-items: center;
        height: calc(100vh - 250px);
    }
   .complete-order .complete-order-left .form-control{
        background: #FFFFFF;
        border: 1px solid #878A99;
        border-radius: 10px;
        height: 100%;
        max-height: 35px;
    }
    .complete-order .complete-order-left .complete-order-card .single-order-card{
        cursor: pointer;
    }
    .complete-order .complete-order-left .complete-order-card .single-order-card.active{
        border: 1.5px solid #0AB39C;
    }
    /********** complete order right css *************/

    .complete-order .complete-order-inner .complete-order-right{
        background: #FFFFFF;
        box-shadow: 0px 1px 9px rgb(0 0 0 / 10%);
        border-radius: 10px;
        position: sticky;
        height: 100vh;
        padding: 15px;
        top: 94px;
        max-height: calc(100vh - 165px);
    }
    .complete-order .complete-order-right .order-right-inner .btn-custom {
        font-weight: 400;
        line-height: 20px;
        padding: 5px 8px;
        border-radius: 5px !important;
    }
    .complete-order .complete-order-right .order-right-details .order-details-bottom .btn--custom{
        padding: 11px;
        line-height:16px;
        font-weight: 400;
    }
    .complete-order .complete-order-right .order-right-details-main {
        height: 100vh;
        max-height: calc(100vh - 410px);
        overflow-y: auto;
        overflow-x: hidden;
    }
    .loading {
        height: 0;
        width: 0;
        padding: 15px;
        border: 6px solid #0ab39c;
        border-right-color: transparent;
        border-radius: 22px;
        -webkit-animation: rotate-0349ff8e 1s infinite linear;
        position: absolute;
        left: 50%;
        top: 50%;
        z-index: 10;
    }

    @-webkit-keyframes rotate {
    100% {
        -webkit-transform: rotate(360deg);
    }
    }
    /*************** RESPONSIVE CSS ********************/
    @media screen and (max-width:1180px) {
        .complete-order .complete-order-inner .complete-order-right{
            max-height: calc(100vh - 194px);
        }
        .complete-order .complete-order-right .order-right-details-main{
            max-height: calc(100vh - 447px);
        }
    }
</style>
<style>
    .dp__today{
        border-color: #0ab39c;
    }
    .dp__range_end, .dp__range_start, .dp__active_date{
        background: #0ab39c;
    }
    .dp__select{
        color: #0ab39c;
    }
</style>
