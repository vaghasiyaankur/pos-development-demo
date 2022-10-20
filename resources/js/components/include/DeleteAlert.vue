<template>

  <div class="modal fade" id="removedataalert" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-radius-10 border-0">
                <div class="modal-body text-center p-4 border--top">
                    <img src="/assets/images/delete-modal-img.png" class="mt-2" alt="deletealert">
                    <!-- <lord-icon src="https://cdn.lordicon.com/hrqwmuhr.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:120px;height:120px">
                    </lord-icon> -->
                    <div class="mt-5 modal--content">
                        <h4 class="mb-2 fs-2">Are You Sure ?</h4>
                        <p class=" fs-20">You will not be able to revert this!</p>
                        <div class="hstack gap-3 justify-content-center mt-5">
                            <button type="button" class="btn btn--1" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                            <div class=border--outer>
                                <button type="button" class="btn btn--2" data-bs-dismiss="modal" @click="removeData()">Yes, Delete it!</button>
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
    name: "DeleteAlert",
    methods: {
        removeData(){
            this.$emit('removeData');
        }
    },
};
</script>
<style scoped>
#removedataalert .modal--content button{
    padding:17px 32px;
    font-size:20px;
    line-height:14px;
    font-weight:600px !important;
    border-radius:5px !important;
    color:#fff;
}
#removedataalert .modal--content h4, #removedataalert .modal--content p{
    color:#6D7080;
}
#removedataalert .modal--content button.btn--1{
    border-radius: 10px !important;
    color: #6D7080;
    padding: 12px 43px;
    border: 1px solid #6D7080;
    font-weight: 500;
    font-size: 16px;
    line-height: 16px;
}
#removedataalert .modal--content button.btn--2{
    background: rgba(221, 51, 51, 0.8);
    border-radius: 10px !important;
    padding: 12px 22px;
    font-weight: 500;
    font-size: 16px;
    line-height: 16px;
}
#removedataalert .modal-body.border--top:after{
    content: "";
    top: 0px;
    position: absolute;
    border-top: 7px solid rgba(221, 51, 51, 0.8);
    right: 0;
    left: 0;
    border-radius: 10px 10px 0 0;
}
</style>
