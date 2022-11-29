<template>
<div class="main-content">
    <div class="page-content pb-0 pt-4">
        <section class="current-order">
            <h4 class="order-title mb-0">Current Orders</h4>
            <div class="c-order-main h-100 positionn-relative">
                <div class="no--order-box" v-if="orders.length == 0">
                    <div class="no--order--text text-center">
                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width:75px;height:75px">
                        </lord-icon>
                        <h1 class="mb-0 color-gray">No Order Found</h1>
                    </div>
                </div>
                <div class="row mx-3 mt-3 pt-3" v-else>
                    <div class="col-xl-2 col-lg-3 col-md-4 mb-5" v-for="(order, key) in orders" :key="key">
                        <div class="order-single-card position-relative">
                            <div class="card single--card bg-blue" style="top:-18px;" :style="'background : rgb(' + order.color + ')'" v-if="order.order_count > 3"></div>
                                <div class="card single--card bg-blue position-absolute w-100" style="top:-12px;" :style="'background : rgb(' + order.color + ')'" v-if="order.order_count > 2"></div>
                                <div class="card single--card bg-blue position-absolute w-100" style="top:-6px;" :style="'background : rgb(' + order.color + ')'" v-if="order.order_count > 1"></div>
                            <div class="card single--card position-absolute w-100" style="top:0px;">
                                    <div class="card-header bg-blue border-bottom-0 fs-10 py-1 px-2" :style="'background : rgb(' + order.color + ')'" data-bs-toggle="modal" data-bs-target="#fadeInUpModal" @click="addLoader = true; getordersforpopup(order.table)">
                                    <div class="header-top">
                                        <div class="header-top-right d-flex justify-content-between">
                                            <p class="mb-0">
                                                <span>{{ order.diff }}</span>
                                                <span>
                                                    <i class="fa-solid fa-clock ps-2"></i>
                                                </span>
                                            </p>
                                            <p class="mb-0">{{currencyCode}} {{ (order.total_amount).toFixed(2) }}</p>
                                        </div>
                                        <div class="header-top-right d-flex justify-content-between">
                                            <p class="mb-0">
                                                <span>Table-{{ order.table }}</span>
                                            </p>
                                            <p class="mb-0">
                                                <span><i class="fa-solid fa-user ps-2"></i> {{ order.customer_name }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body px-0 equal-height-order">
                                    <div class="items-details" v-for="(products, category) in order.data" :key="category">
                                        <!-- <h6 class="items-list-bg-orange ps-2 mb-0 fs-12 fw-medium d-flex align-items-center" :style="'background : rgba('+order.color+',0.7)'">
                                            <i class="fa-solid fa-circle pe-1" style="font-size:6px;"></i>
                                            {{ category }}
                                        </h6> -->
                                        <div class="sub-items mb-0 fs-10 fw-medium">
                                            <div class="sub-items-list ps-3 pe-3" v-for="(product, key) in products" :key="key">
                                                <div class="row">
                                                    <p class="mb-0 col-8">
                                                        <span>{{product.quantity}} Χ</span>
                                                        {{ product.name }}
                                                    </p>
                                                    <p class="mb-0 col-4 text-end ps-0">{{currencyCode}} {{ (product.price).toFixed(2) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer border-top-0 pt-2 pb-2 px-2">
                                    <div class="d-flex justify-content-between" v-if="!removeOrderLoader.includes(key)">
                                        <button class="btn btn-green fs-12 fw-medium" :disabled="order.ordered == 1" @click="orderSave(key,order.tableId)" >{{ order.ordered == 1 ? 'Served' : 'Serve' }}</button>
                                        <button class="btn btn-danger fs-12 fw-medium" @click="orderPay(key,order.tableId)">Pay</button>
                                        <button class="btn btn-black" @click="printOrder(order.tableId)" >
                                            <i class="fa-solid fa-print"></i>
                                        </button>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center" v-if="removeOrderLoader.includes(key)">
                                        <img src="assets/images/loading.gif" alt="order" width="30" :id="'load-image-'+key" class="loading_image">
                                        <b class="loader_second" :id="'bold-loader-count-down-'+key"><span style="font-size: 11px;">Order will be removed in <span id="table-loader-count-down-{{$table_order_id}}">{{ countdown }}</span> seconds.</span></b>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal start  -->
                <div class="modal fade" id="fadeInUpModal" tabindex="-1" aria-labelledby="fullscreeexampleModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen">
                        <div class="loading" :class="{ 'd-none' : !addLoader}"></div>
                        <div class="modal-content" :class="{ 'd-none' : addLoader}">
                            <div class="modal-header justify-content-end">
                                <a href="javascript:;" class="btn btn-link text-white fw-medium" data-bs-dismiss="modal">
                                    <i class="ri-close-line me-1 align-middle"></i>
                                </a>
                            </div>
                            <div class="modal-body d-flex align-items-center">
                                <div class="row w-100 h-auto mx-auto my-auto">
                                    <div class="col-xl-2 col-lg-3 col-md-4  mb-3" v-for="(order, key) in ordersPopup" :key="key">
                                        <div class="order-single-card d-flex jutify-content-between">
                                            <div class="card single--card">
                                                <div class="card-header bg-orange border-bottom-0 fs-10 py-1 px-2" :style="'background : rgb(' + order.color + ')'">
                                                    <div class="header-top">
                                                        <div class="header-top-right d-flex justify-content-between">
                                                            <p class="mb-0">
                                                                <span>{{ order.diff }}</span>
                                                                <span>
                                                                    <i class="fa-solid fa-clock ps-2"></i>
                                                                </span>
                                                            </p>
                                                            <p class="mb-0">
                                                                {{currencyCode}} {{ (order.total_amount).toFixed(2)
                                  }}
                                                            </p>
                                                        </div>
                                                        <div class="header-top-right d-flex justify-content-between">
                                                            <p class="mb-0">
                                                                <span>Table-{{ order.table }}</span>
                                                            </p>
                                                            <p class="mb-0">
                                                                <span><i class="fa-solid fa-user ps-2"></i> {{ order.customer_name }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body px-0">
                                                    <div class="items-details" v-for="(products, category) in order.data" :key="category">
                                                        <div class="sub-items mb-0 pe-2 fs-10 fw-medium">
                                                            <div class="sub-items-list ps-3 pe-3" v-for="(product, key) in products" :key="key">
                                                                <div class="d-flex justify-content-between">
                                                                    <p class="mb-0">
                                                                        <span>{{product.quantity}} Χ</span>
                                                                        {{ product.name }}
                                                                    </p>
                                                                    <p class="mb-0">{{currencyCode}} {{ (product.price).toFixed(2) }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer border-top-0 pt-2 pb-2 d-flex justify-content-between px-2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal end  -->

                <!-- Print Invoice Part-->
                <div class="section-to-print d-none" id="section-to-print">
                    <Print :printData="printData" :printOrdersData="printOrdersData" />
                </div>
                <!-- Print Invoice Part-->
            </div>
        </section>
    </div>
    <!-------Start page footer start --------->
    <footer class="footer-start">
        <div class="footer-main bg-white">
            <div class="footer-link d-flex align-items-center justify-content-between">
                <a href="javascript:;" @click="$router.go(-1)" class="text-success fs-16" data-v-66f63333>
                    <i class="ri-arrow-go-back-line" data-v-66f63333></i>
                    Back
                </a>
            </div>
        </div>
    </footer>
</div>
</template>

<script>
import $ from "jquery";
import Print from "./include/Print.vue";
import {
    useToast
} from "vue-toastification";
export default {
    components: {
        Print
    },
    data() {
        return {
            orders: [],
            ordersPopup: [],
            currencyCode: '',
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
            printOrdersData: [],
            toast: useToast(),
            addLoader: true,
            countdown : 7,
            removeOrderLoader : [],

        };
    },
    props : ['allpermissions'],
    beforeCreate() {
        this.$emit('addLoader');
    },
    created() {
        this.getsetting();
        this.getorders();

    },
    methods: {
        getsetting() {
            axios.get('/api/getSettingData')
                .then(res => {
                    this.currencyCode = res.data.setting.currency_symbol;
                }).catch(err => {})
        },
        getorders() {
            axios
                .get("/api/getorders")
                .then((res) => {
                    this.orders = res.data.orders;
                    this.callInterval();
                    this.$emit('removeLoader')
                })
                .catch((err) => {});
        },
        callInterval() {
            setInterval(this.intervalFun, 60000);
        },
        intervalFun() {
            axios
                .get("/api/getorderstime")
                .then((res) => {
                    var td = res.data.timediff;
                    var order = this.orders;
                    for (let [key, value] of Object.entries(td)) {
                        if (this.orders[key]) {
                            this.orders[key].diff = value;
                        }
                        if (this.ordersPopup[key]) {
                            this.ordersPopup[key].diff = value;
                        }
                    }
                })
                .catch((err) => {});
        },
        getordersforpopup(table) {
            axios
                .get("/api/getordersforpopup/" + table)
                .then((res) => {
                    this.ordersPopup = res.data.popupOrders;
                    this.intervalFun();
                    this.addLoader = false;
                })
                .catch((err) => {});
        },
        orderSave(orderId,tableId) {
            axios
                .post("/api/order-save", {
                    orderId: orderId,
                    tableId : tableId
                })
                .then((res) => {
                    this.$emit('showToast',res.data.success,'success');
                    this.getorders();
                }).catch((error) => {})
        },
        orderPay(orderId,tableId) {
            axios
                .post("/api/order-pay", {
                    orderId: orderId,
                    tableId : tableId
                })
                .then((res) => {
                    this.$emit('showToast',res.data.success,'success');
                    this.removeOrderLoader.push(orderId);
                    this.countdown = 7;
                    setInterval(() => {
                        this.countdown = this.countdown - 1;
                        if(this.countdown == 0){
                            this.countdown = 7;
                            this.getorders();
                            this.removeOrderLoader.length = 0;
                        }
                    }, 1000);
                }).catch((error) => {
                    this.$emit('showToast',error.response.data.error,'error');
                })
        },
        printOrder(id) {
            axios
                .get("/api/prinorder/" + id)
                .then((res) => {
                    this.printData = res.data.printData;
                    this.printOrdersData = res.data.printOrdersData;
                    setTimeout(() => {
                        this.orderForPrinting();
                    }, 1000);
                })
                .catch((err) => {});
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
        }
    },

};
</script>

<style scoped>

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
/* --------------- CURRENT ORDER CSS --------------------- */
    .single--card {
        background: #ffffff;
        box-shadow:none;
        border-radius: 10px !important;
        height: 100%;
        width:100%;
    }
    /* -------- NO-ORDER BOX ----------- */
    .current-order .c-order-main .no--order-box{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
.main-content .page-content .current-order{
    background: #fff;
    height: calc(100vh - 164px);
    border-radius: 10px;
    box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.25);
}
.main-content .page-content .current-order .order-title {
    font-style: normal;
    font-weight: 700;
    font-size: 18px;
    line-height: 16px;
    text-transform: capitalize;
    padding: 20px 0 4px 18px;
}
.main-content .page-content .current-order .c-order-main {
    overflow: auto;
    max-height: calc(100vh - 250px);
}
    /*------------ ORDER SINGLE CARD ----------------- */
    .main-content .page-content .current-order .c-order-main .order-single-card {
        height: 100%;
        min-height: 232px;
        width: 100%;
        max-width: 270px;
        box-shadow: 0px 4px 4px rgb(0 0 0 / 25%), 0px -4px 4px rgb(0 0 0 / 25%);
        border-radius: 10px;
    }
    .main-content .page-content .current-order .c-order-main .order-single-card .bg-orange {
        background: #f79256;
        border-radius: 10px 10px 0px 0px;
        color: #fff;
        font-weight: 600;
    }

    .main-content .page-content .current-order .c-order-main .order-single-card .bg-blue {
        background: #1d4e89;
        border-radius: 10px 10px 0px 0px;
        color: #fff;
        font-weight: 600;
    }

    .main-content .page-content .current-order .c-order-main .order-single-card .bg-green {
        background: #7dcfb6;
        border-radius: 10px 10px 0px 0px;
        font-weight: 600;
    }

    .main-content .page-content .current-order .c-order-main .order-single-card .bg-dark-blue {
        background: #00b2ca;
        border-radius: 10px 10px 0px 0px;
        color: #fff;
        font-weight: 600;
    }

    .main-content .page-content .current-order .c-order-main .order-single-card .single--card .card-body {
        padding: 6px 0;
    }

    .main-content .page-content .current-order .c-order-main .order-single-card .single--card .card-body .items-list-bg-orange {
        background: rgba(249, 212, 191, 0.7);
        color: #fff;
    }

    .main-content .page-content .current-order .c-order-main .order-single-card .single--card .card-body .items-list-bg-blue {
        background: rgba(29, 78, 137, 0.7);
        color: #fff;
    }

    .main-content .page-content .current-order .c-order-main .order-single-card .single--card .card-body .items-list-bg-green {
        background: rgba(125, 207, 182, 0.7);
        color: #333333;
    }

    .main-content .page-content .current-order .c-order-main .order-single-card .single--card .card-body .items-list-bg-dark-blue {
        background: rgba(0, 178, 202, 0.7);
        color: #fff;
    }

    .main-content .page-content .current-order .c-order-main .order-single-card .single--card .card-footer {
        border-radius: 0 0 10px 10px;
    }

    .main-content .page-content .current-order .c-order-main .order-single-card .single--card .card-footer button.btn-green {
        color: #fff;
        padding: 5px 30px;
        border-radius: 5px !important;
        background: #0ccb72;
    }

    .main-content .page-content .current-order .c-order-main .order-single-card .single--card .card-footer button.btn-danger {
        color: #fff;
        border-radius: 5px !important;
        background: #f33e3e;
        padding: 5px 32px;
    }

    .main-content .page-content .current-order .c-order-main .order-single-card .single--card .card-footer button.btn-black {
        padding: 5px 13px;
        background: #38373d;
        color: #fff;
        border-radius: 5px !important;
    }
    /* ---------- MODAL ------------ */
    .modal-header {
        padding: 0;
    }

    .modal-header i.ri-close-line.me-1.align-middle {
        font-size: 30px;
    }

    .modal-content {
        background: transparent;
    }

    .main-content .footer-start .footer-main.bg-white {
        position: fixed;
        width: 100%;
        bottom: 0;
        padding: 8px 15px 8px 32px;
    }
    /***************CSS FOR SCROLLBAR*********************/
    .main-content .page-content .current-order .c-order-main::-webkit-scrollbar-thumb {
        background: #8b8a8a;
        border-radius: 10px;
    }
    .main-content .page-content .current-order .c-order-main::-webkit-scrollbar {
        width: 3px;
        background: transparent;
    }
/* ---------------- RESPONSIVE CSS --------------- */
@media screen and (max-width: 1600px) {
    .main-content .page-content .current-order .c-order-main .order-single-card .single--card .card-footer button.btn-danger {
        padding: 5px 20px;
    }

    .main-content .page-content .current-order .c-order-main .order-single-card .single--card .card-footer button.btn-green {
        padding: 5px 15px;
    }
}

@media screen and (max-width: 1440px) {
    .main-content .page-content .current-order .c-order-main .order-single-card .single--card .card-footer button.btn-danger {
        padding: 5px 14px;
    }

    .main-content .page-content .current-order .c-order-main .order-single-card .single--card .card-footer button.btn-green {
        padding: 5px 11px;
    }
}

@media screen and (max-width: 1199px) {
    .main-content .page-content .current-order .c-order-main .order-single-card .single--card .card-footer button.btn-danger {
        padding: 5px 30px;
    }

    .main-content .page-content .current-order .c-order-main .order-single-card .single--card .card-footer button.btn-green {
        padding: 5px 22px;
    }
}

@media screen and (max-width:1180px) {
    .main-content .page-content .current-order {
        height: calc(100vh - 190px);
    }

    .main-content .page-content .current-order .c-order-main {
        max-height: calc(100vh - 272px);
    }
}

@media screen and (max-width:820px) {
    .main-content .page-content .current-order {
        height: calc(100vh - 180px);
    }

    .main-content .page-content .current-order .c-order-main {
        max-height: calc(100vh - 221px);
    }
}

@media screen and (max-width:1024px) {
    .main-content .page-content .current-order {
        height: calc(100vh - 160px);
    }

    .main-content .page-content .current-order .c-order-main {
        overflow: auto;
        max-height: calc(100vh - 219px);
    }
    .page-content {
        margin-top: 65px;
    }
    .main-content .page-content .current-order .c-order-main .order-single-card .single--card .card-footer button.btn-danger {
        padding: 5px 23px;
    }

    .main-content .page-content .current-order .c-order-main .order-single-card .single--card .card-footer button.btn-green {
        padding: 5px 16px;
    }
}
@media screen and (max-width:991px) {
    .main-content .page-content .current-order {
        height: calc(100vh - 160px);
    }

    .main-content .page-content .current-order .c-order-main {
        overflow: auto;
        max-height: calc(100vh - 215px);
    }
}
</style>
