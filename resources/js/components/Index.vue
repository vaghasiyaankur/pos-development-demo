<template>
    <div class="main-content">        
        <!-- Start Page-content -->
        <div class="page-content pb-0 pt-4">
            <div class="dashboards pb-3">
                <div class="dashboards-contact pt-3 px-2">
                    <div class="row mx-0">
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                            <div class="total-order text-center bg-orange">
                                <h3 class="pb-1 order-title text-white ">Total Order</h3>
                                <p class="mb-0 order-text text-white">{{total_orders}}</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                            <div class="total-order text-center bg-blue">
                                <h3 class="pb-1 order-title text-white">Completed Orders</h3>
                                <p class="mb-0 order-text text-white">{{complete_orders}}</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                            <div class="total-order text-center bg-green">
                                <h3 class="pb-1 order-title text-white">Pending Orders</h3>
                                <p class="mb-0 order-text text-white">{{pending_orders}}</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                            <div class="total-order text-center bg-dark-blue">
                                <h3 class="pb-1 order-title text-white">Total Billed</h3>
                                <p class="mb-0 order-text text-white">{{total_billed}}</p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="dashboards-card px-2">
                    <div class="row mx-0 mb-3">
                        <div class="col-xxl-3 col-xl-4 col-6 mt-3 h-100">
                            <h3 class="fs-22 text-center dashboards-card-title mb-0 py-2">List 5 Latest Orders</h3>
                            <div class="card mx-auto">
                                <div class="card-header bg-orange border-botton-0 p-2">
                                    <div
                                        class="header-top d-flex align-items-center justify-content-between text-white px-2">
                                        <p class="mb-0 fs-20 ">ID</p>
                                        <p class="mb-0 fs-20 ">Order ID</p>
                                        <p class="mb-0 fs-20 ">Total Amount</p>
                                    </div>
                                </div>
                                <div class="card-body px-2" :class="latest_orders.length < 1 ? 'noorder-card-body' : ''">
                                    <div class="card-items-details d-flex align-items-center justify-content-between my-2 px-2 py-1" v-for="(latest_order,index) in latest_orders.slice(0,5)" :key="latest_order">
                                        <p class="mb-0 fs-16 pe-3">{{index + 1}}.</p>
                                        <p class="mb-0 fs-16 title--name--clamp">Order # {{latest_order.id}}</p>
                                        <p class="mb-0 fs-16 white--space">{{ currencySymbol }} {{ (latest_order.total_amount).toFixed(2) }}</p>
                                    </div>
                                    <div class="no-order-card text-center" v-if="latest_orders.length < 1">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width: 65px; height: 65px;"></lord-icon>
                                        <p class="mb-0 color-gray fs-20">No Order Available</p>
                                    </div>
                                </div>
                                <div class="card-footer text-center border-top-0">
                                    <router-link to="/orders" class="btn btn-success fs-16" v-if="latest_orders.length > 5">View All</router-link>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-4 col-6 mt-3 h-100">
                            <h3 class="fs-22 text-center dashboards-card-title mb-0 py-2">Top 5 Selling Products</h3>
                            <div class="card mx-auto">
                                <div class="card-header bg-blue border-botton-0 p-2">
                                    <div
                                        class="header-top d-flex align-items-center justify-content-between text-white px-2">
                                        <p class="mb-0 fs-20 ">ID</p>
                                        <p class="mb-0 fs-20 ">Product Name</p>
                                        <p class="mb-0 fs-20 ">Price</p>
                                    </div>
                                </div>
                                <div class="card-body px-2" :class="top_selling.length < 1 ? 'noorder-card-body' : ''">
                                    <div class="card-items-details d-flex align-items-center justify-content-between my-2 px-2 py-1" v-for="(top_sell,index) in top_selling.slice(0,5)" :key="top_sell.id">
                                        <p class="mb-0 fs-16 pe-3">{{index + 1}}.</p>
                                        <p class="mb-0 fs-16 title--name--clamp">{{top_sell.name}}</p>
                                        <p class="mb-0 fs-16 white--space">{{ currencySymbol }} {{ (top_sell.price).toFixed(2) }}</p>
                                    </div>
                                    <div class="no-order-card text-center" v-if="top_selling.length < 1">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width: 65px; height: 65px;"></lord-icon>
                                        <p class="mb-0 color-gray fs-20">No Product Available</p>
                                    </div>
                                </div>
                                <div class="card-footer text-center border-top-0">
                                    <router-link to="/products" class="btn btn-success fs-16" v-if="top_selling.length > 5">View All</router-link>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-4 col-6 mt-3 h-100">
                            <h3 class="fs-22 text-center dashboards-card-title mb-0 py-2">Recently Added Products</h3>
                            <div class="card mx-auto">
                                <div class="card-header bg-green border-botton-0 p-2">
                                    <div
                                        class="header-top d-flex align-items-center justify-content-between text-white px-2">
                                        <p class="mb-0 fs-20 ">ID</p>
                                        <p class="mb-0 fs-20 ">Product Name</p>
                                        <p class="mb-0 fs-20 ">Price</p>
                                    </div>
                                </div>
                                <div class="card-body px-2" :class="recently_add.length < 1 ? 'noorder-card-body' : ''">
                                    <div
                                        class="card-items-details d-flex align-items-center justify-content-between my-2 px-2 py-1" v-for="(r_add,index) in recently_add.slice(0,5)" :key="r_add.id">
                                        <p class="mb-0 fs-16 pe-3">{{index + 1}}.</p>
                                        <p class="mb-0 fs-16 title--name--clamp">{{r_add.name}}</p>
                                        <p class="mb-0 fs-16 white--space">{{ currencySymbol }} {{ (r_add.price).toFixed(2) }}</p>
                                    </div>
                                    <div class="no-order-card text-center" v-if="recently_add.length < 1">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width: 65px; height: 65px;"></lord-icon>
                                        <p class="mb-0 color-gray fs-20">No Product Available</p>
                                    </div>
                                </div>
                                <div class="card-footer text-center border-top-0">
                                    <router-link to="/products" class="btn btn-success fs-16" v-if="recently_add.length > 5">View All</router-link>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-4 col-6 mt-3 h-100">
                            <h3 class="fs-22 text-center dashboards-card-title mb-0 py-2">Recently updated Products</h3>
                            <div class="card mx-auto">
                                <div class="card-header bg-dark-blue border-botton-0 p-2">
                                    <div
                                        class="header-top d-flex align-items-center justify-content-between text-white px-2">
                                        <p class="mb-0 fs-20 ">ID</p>
                                        <p class="mb-0 fs-20 ">Product Name</p>
                                        <p class="mb-0 fs-20 ">Price</p>
                                    </div>
                                </div>
                                <div class="card-body px-2" :class="recently_update.length < 1 ? 'noorder-card-body' : ''">
                                    <div
                                        class="card-items-details d-flex align-items-center justify-content-between my-2 px-2 py-1" v-for="(r_update,index) in recently_update.slice(0,5)" :key="r_update.id">
                                        <p class="mb-0 fs-16 pe-3">{{index + 1}}.</p>
                                        <p class="mb-0 fs-16 title--name--clamp">{{r_update.name}}</p>
                                        <p class="mb-0 fs-16 white--space">{{ currencySymbol }} {{ (r_update.price).toFixed(2) }}</p>
                                    </div>
                                    <div class="no-order-card text-center" v-if="recently_update.length < 1">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width: 65px; height: 65px;"></lord-icon>
                                        <p class="mb-0 color-gray fs-20">No Product Available</p>
                                    </div>
                                </div>
                                <div class="card-footer text-center border-top-0">
                                    <router-link to="/products" class="btn btn-success fs-16" v-if="recently_update.length > 5">View All</router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page-content -->
    </div>
    <!-- end main content-->
</template>

<script>
export default {
    name: 'Index',
    data() {
        return {
            total_orders : 0,
            complete_orders : 0,
            pending_orders : 0,
            total_billed : 0,
            currencySymbol : '',
            latest_orders : [],
            top_selling : [],
            recently_add : [],
            recently_update : [],
        }
    },
    props: {
        allpermissions: '',
    },
    beforeCreate() {
        this.$emit('addLoader');
    },
    created() {
        this.getsetting();
        this.getData();
        this.$emit('removeLoader');
    },
    methods: {
        getsetting() {
            axios.get('/api/getSettingData')
                .then(res => {
                    this.currencySymbol = res.data.setting.currency_symbol;
                }).catch(err => {})
        },
        getData(){
            axios
                .get("/api/getdashboarddata")
                .then((res) => {
                    this.total_orders = res.data.total_orders;
                    this.complete_orders = res.data.complete_orders;
                    this.pending_orders = res.data.pending_orders;
                    this.latest_orders = res.data.latest_orders;
                    this.top_selling = res.data.top_selling;
                    this.recently_add = res.data.recently_add;
                    this.recently_update = res.data.recently_update;
                })
                .catch((err) => {});
        }
    },
}
</script>
<style>
/*---------------BASIC CSS---------------*/        
.title--name--clamp{
    display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.white--space{
    white-space: nowrap;
}
/* ----------------------DASHBOARD START----------------------- */
.main-content .page-content .dashboards {
    background: #fff;
    height: calc(100vh - 114px);
    border-radius: 10px;
    box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.25);
    overflow-y: auto;
    overflow-x: hidden;
}
    /* -----------------DASHBOARD CONTACT START------------------ */
    .main-content .page-content .bg-orange {
        background: linear-gradient(289.42deg, #F79256 14.21%, #FFC09A 105.95%);
    }
    .main-content .page-content .bg-blue {
        background: linear-gradient(283.67deg, #1D4E89 -6.51%, #5481B8 107.4%);
    }
    .main-content .page-content .bg-green {
        background: linear-gradient(284.08deg, #7DCFB6 -1.79%, #b2E4D5 103.82%);
    }
    .main-content .page-content .bg-dark-blue {
        background: linear-gradient(284.58deg, #00B2CA 0.32%, #7AD9E6 105.82%);
    }
    .main-content .page-content .dashboards-contact .total-order {
        width: 100%;
        height: 100%;
        min-height: 133px;
        padding: 20px 0;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.15);
        border-radius: 10px;
    }
    .main-content .page-content .dashboards-contact .total-order .order-title {
        font-size: 22px;
        line-height: 32px;
        font-weight: 600;
    }
    .main-content .page-content .dashboards-contact .total-order .order-text {
        font-size: 38px;
        line-height: 48px;
        font-weight: 600;
    }
    .dashboards-card .dashboards-card-title {
        font-weight: 600;
        line-height: 28px;
        color: #333333;
    }
    /* ------------------ DASHBOARD CONTACT END ----------------- */

    /* ----------------DASHBOARD CARD START ----------------- */
    .dashboards-card .card {
        border-radius: 10px;
        width: 100%;
        height: 100%;
        min-height: 361px;
        border-radius: 10px !important;
        box-shadow: 0px -2px 11px rgba(0, 0, 0, 0.13);
    }

    .dashboards-card .card .card-header {
        border-radius: 10px 10px 0 0;
    }
    .dashboards-card .card-body{
        height:100%;
        min-height: 240px;
    }

    .card .card-body .card-items-details {
        background: rgba(239, 238, 243, 0.5);
        border-radius: 5px;
    }

    .dashboards-card .card .card-footer {
        border-radius: 0 0 10px 10px;
    }
    .main-content .page-content .dashboards::-webkit-scrollbar {
        width: 3px;
        background: transparent;
    }
    .main-content .page-content .dashboards::-webkit-scrollbar-thumb {
        background: #8b8a8a;
        border-radius: 10px;
    }
    .dashboards-card .card-body.noorder-card-body{
        display: flex;
        justify-content: center;
        align-items:center;
    }
    /* ---------------DASHBOARD CARD END --------------- */

/* ---------------DASHBOARD END --------------- */

/* --------------- RESPONSIVE CSS START --------------- */
@media screen and (max-width: 1024px){
    .main-content .page-content {
        margin-top: 60px;
    }
} 
@media screen and (max-width:1180px) {
    .main-content .page-content .dashboards {
        height: calc(100vh - 140px);
    }
}
/* --------------- RESPONSIVE CSS END -------------*/

</style>
