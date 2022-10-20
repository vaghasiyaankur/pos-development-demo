<template>

    <div class="modal fade" id="addsizeprice" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-radius-10 border-0">
                <div class="modal-body text-center py-5 px-4 border--top">
                    <h2 class="fs-1 color-gray">Edit Size</h2>
                    <div class="mt-5 modal--content">
                        <div class="row align-items-center mb-3 pb-1">
                            <label for="size-price" class="col-2 form-label fs-19 padding-start-10 color-gray text-start mb-0">Price : </label>
                            <div class="col-10">
                                <input type="number" name="size-price" id="size-price" class="form-control border-radius-10" v-model="popupSelectPriceSize">
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-10 offset-2">
                                <div class="hstack gap-3 justify-content-between">
                                    <button type="button" class="btn btn--1" data-bs-dismiss="modal">Cancel</button>
                                    <div class=border--outer>
                                        <button type="button" class="btn btn--2" data-bs-dismiss="modal" @click="setPrice()">Set price</button>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</template>
<script>
export default {
    name: "SizeSetPrice",
    data(){
        return{
            price : 0,
            popupSelectPriceSize: 0,
        }
    },
    props:{
        // popupSelectPriceSize: {
        //     type: Number,
        // },
    },
    methods: {
        setPrice(){
            const price = this.popupSelectPriceSize;
            this.$emit('setPrice', price);
            this.price = 0;
        }
    },
};
</script>
<style scoped>
#addsizeprice .modal-content .modal-body.border--top::after{
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    border-top: 7px solid #0AB39C;
    right: 0;
    border-radius: 10px 10px 0 0;
}
#addsizeprice .modal--content button{
    padding:12px 54px;
    font-size:16px;
    line-height:16px;
    font-weight:600px !important;
    border-radius:10px !important;
    color:#fff;
}
#addsizeprice .modal--content .border--outer{
    border-radius: 5px;
    padding:4px;
}

#addsizeprice .modal--content h4, #addsizeprice .modal--content p{
    color:#6D7080;
}
#addsizeprice .modal--content button.btn--1{
   border:1px solid #6D7080;
   color: #6D7080;
}
#addsizeprice .modal--content button.btn--2{
   background: #0AB39C;
   }
</style>
