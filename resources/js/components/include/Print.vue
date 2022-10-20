<template>
    <div class="main-content">
        <div class="page-content pt-0">
            <div class="invoice--details">
                <div class="card invoice-card mb-0">
                    <div class="card-header text-center border-0">
                        <img :src="'/storage/'+ printData.logo" alt="print" height="17" data-v-62bad5be="">
                    </div>
                    <div class="card-header px-0 border--bottom">
                        <div class="row">
                            <div class="col-6">
                                <div class="invioce-header">
                                    <p class="mb-0">Date: {{ printData.current_date }}</p>
                                    <p class="mb-0">Table : {{ printData.table }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="invioce-header text-end">
                                    <p class="mb-0">Time: {{ printData.current_time }}</p>
                                    <p class="mb-0">Type : {{ printData.purchase_type }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="invioce-header">
                                    <p class="mb-0">Customer: {{ printData.customer_name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <thead >
                                    <tr>
                                        <th class="fs-18">Item Description</th>
                                        <th class="text-end fs-18">Price</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    <tr  v-for="(data, key) in printOrdersData" :key="key">
                                            <td> {{data.quantity}}X {{data.name}}</td>
                                            <td class="text-end" id="cart-subtotal">{{currencySymbol}} {{(data.price).toFixed(2)}}</td>
                                    </tr>                                    
                                    <tr class="border--bottom">
                                        <td>Sub total :</td>
                                        <td class="text-end"> {{currencySymbol}} {{(printData.sub_total).toFixed(2)}}</td>
                                    </tr>
                                    <tr v-for="(tax, taxId) in printData.taxes" :key="taxId">
                                        <td>{{ tax.name }} :</td>
                                        <td class="text-end"> {{currencySymbol}} {{(tax.value).toFixed(2)}}</td>
                                    </tr>
                                    <tr class="border--top">
                                        <th>Total :</th>
                                        <td class="text-end">
                                            <span class="fw-semibold" id="cart-total">
                                                {{currencySymbol}} {{(printData.pay_total).toFixed(2)}}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                    <div class="card-footer pb-1 px-0 text-center">
                        <div class="text-end pb-2">
                            <span class="signature">Signature :<span class="line"></span></span>
                        </div>
                        <div class="border--div mb-2"></div>
                        <p>Closed Bill</p>
                        <p class="mb-0">{{ printData.footer }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page-content -->
    </div>
</template>
<script>
    export default {
        name : 'Print',
        props: {
            printData: {
                type: Object,
            },
            printOrdersData: {
                type: Array
            }
        },
        data(){
            return{
                currencySymbol : '',
            }
        },
        components: {
        },
        created() {
            this.getsetting();
        },
        methods: {
            getsetting(){
                axios.get('/api/getSettingData')
                .then(res => {
                    this.currencySymbol = res.data.setting.currency_symbol;
                }).catch(err => {
                })
            },
        }
    }
</script>
<style>
    .border--div{
        border: 2px dashed #878A99;
        padding: 1px;
    }
    /*------------ INVOICE DETAILS CSS ----------------------*/
    .invoice--details .border--bottom{
        border-bottom: 1px dashed #878A99;
    }
    .invoice--details .border--top{
        border-top: 1px dashed #878A99;
    }

    .invoice--details{
        background: #fff;
        max-width: 600px;
        margin: 0 auto;
        padding: 12px;
        width: 100%;
    }
    .invoice--details .invoice-card{
        background: transparent;
        box-shadow: none;
        border: 1px solid #878A99;
        border-radius: 0;
        padding: 12px;
    }
    .invoice--details .invoice-card .card-header .invioce-header p{
        font-size: 20px;
        line-height: 27px;
        color: #333;
        white-space: nowrap;
        font-weight: 500;
    }
    .invoice--details .invoice-card .card-body table tr th,
    .invoice--details .invoice-card .card-body table tr td{
        padding-left: 0;
        padding-right:0;
        font-size: 16px;
        color: #333;
        font-weight: 500;
    }
    
    .invoice--details .invoice-card .card-footer p,
    .invoice--details .invoice-card .card-footer span{
        font-size: 20px;
        line-height: 22px;
        color: #333;
        font-weight: 500;
    }
    .invoice--details .invoice-card .signature > .line {
        display: inline-block;
        border-bottom: 1px solid #333333;
        width: 164px;
    }
</style>
