<template>
    <div class="main-content">
        <div class="page-content pb-0 pt-4">
            <section class="table-management">
                <div class="row pb-3">
                    <div class="col-12">
                        <div class="table-status-header d-flex align-items-center">
                            <div class="available-status me-3 ">
                                <a href="javascript:;" class="color-gray fs-14 fw-medium"><span> <i class="ri-checkbox-blank-circle-fill me-2 fs-16"></i></span>Available Table </a>
                            </div>
                            <div class="running-status me-3">
                                <a href="javascript:;" class="color-gray fs-14 fw-medium"><span><i class="ri-checkbox-blank-circle-fill me-2 fs-16"></i></span>Running Table </a>
                            </div>
                            <div class="deactivate-status me-3">
                                <a href="javascript:;" class="color-gray fs-14 fw-medium"><span><i class="ri-checkbox-blank-circle-fill me-2 fs-16"></i></span> Deactivate Table </a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="table-status-main">
                    <div class="loading" :class="{ 'd-none' : !addLoader}"></div>
                    <div class="table-status-inner" :class="{ 'd-none' : addLoader}">
                        <div class="row px-2">
                            <div class="col-lg-2 col-3 px-2" v-for="table in availTables" :key="table.id">
                            <!------- AVAILABLE TABLE --------->
                                <div class="single-table mb-3" v-if="table.current == 'Available'">
                                    <div class="card available-table h-100">
                                        <div class="py-2 text-center available-table-header">
                                            <h6 class="mb-0 text-white">Table - {{table.number}}</h6>
                                        </div>
                                        <div class="card-body text-center d-flex align-items-center justify-content-center">
                                            <h5 class=" mb-1 color--blue">Empty</h5>
                                        </div>
                                        <p class="mb-0 color--blue d-flex justify-content-center align-items-center pb-2">Capacity of Person - {{table.capacity}}</p>
                                        <div class="d-flex justify-content-end pe-2"  v-if="allpermissions.TableStatus" >
                                            <label class="switch" :for="'tableStatus_'+table.id">
                                                <input type="checkbox" :id="'tableStatus_'+table.id" @change="activeDeactive(table.id,$event)" :checked="table.current == 'Available'" />
                                                <div class="slider round"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!------- RUNNING TABLE WITH CAPACITY--------->
                            <div class="col-lg-2 col-3 px-2" v-for="table in runningTables" :key="table.id">
                                <div class="single-table mb-3" v-if="table.current == 'Running'">
                                    <div class="card running-table h-100">
                                        <div class="py-2 text-center running-table-header">
                                            <h6 class="mb-0 text-white">Table - {{table.number}}</h6>
                                        </div>
                                        <div class="card-body text-center d-flex align-items-center justify-content-center">
                                            <h5 class=" mb-1 color--green">Ordererd <br> <span class="fs-12"> {{table.diff}} miniutes ago</span></h5>
                                        </div>
                                        <p class="mb-0 color--green d-flex justify-content-center align-items-center pb-2">Capacity of Person - {{table.capacity}}</p>
                                    </div>
                                </div>
                            </div>
                            <!------- DEACTIVATE TABLE --------->

                            <div class="col-lg-2 col-3 px-2" v-for="table in deactiveTables" :key="table.id">
                                <div class="single-table mb-3" v-if="table.current == 'Deactive'">
                                    <div class="card deactivate-table h-100">
                                        <div class="py-2 text-center deactivate-table-header">
                                            <h6 class="mb-0 text-white">Table - {{table.number}}</h6>
                                        </div>
                                        <div class="card-body text-center d-flex align-items-center justify-content-center">
                                            <h5 class=" mb-1 color--gray">Deactivate</h5>
                                        </div>
                                        <div class="d-flex justify-content-end pe-2"  v-if="allpermissions.TableStatus">
                                            <label class="switch" :for="'tableStatus_'+table.id">
                                                <input type="checkbox" :id="'tableStatus_'+table.id" @change="activeDeactive(table.id,$event)" :checked="table.current != 'Deactive'" />
                                                <div class="slider round"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!------- footer start --------->
        <footer class="footer-start">
            <div class="footer-main bg-white">
                <div class="footer-link d-flex align-items-center justify-content-between">
                    <a href="javascript:;" @click="$router.go(-1)" class="text-success fs-16" data-v-66f63333="">
                        <i class="ri-arrow-go-back-line" data-v-66f63333=""></i>
                        Back
                    </a>
                    <div class="add-catagory-btn">
                        <button class="btn btn-success fs-16 btn-custom" data-bs-toggle="modal" data-bs-target="#exampleModalgrid" >
                            + Add Table
                        </button>
                    </div>
                </div>
            </div>
            <!-------- MODAL START ---------->
            <div class="modal fade" id="exampleModalgrid" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true" role="dialog" >
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-radius-10 border-0">
                        <div class="modal-header px-3">
                            <h5 class="mb-0 fs-16 color-gray fw-medium">Add Table</h5>
                            <button type="button" class="btn-close" id="close-button" data-bs-dismiss="modal" aria-label="Close" @click="blankPopupForm()"></button>
                        </div>
                        <div class="modal-body px-3">
                            <form @submit.prevent="addtable()">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="input--field">
                                            <label for="tableName" class="form-label fs-14 fw-medium color-gray padding-start-10">Table Number</label>
                                            <input type="text" class="form-control border-radius-10" id="tableName" placeholder="Table Number" name="number" v-model="popup.number" required>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-12">
                                        <div class="input--field">
                                            <label for="person" class="form-label fs-14 fw-medium color-gray padding-start-10">Capacity of Person</label>
                                            <input type="number" class="form-control border-radius-10" id="person" placeholder="Capacity of Person" name="capacity" v-model.number="popup.capacity" min="1" required>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-12">
                                        <div class="input--field">
                                            <label for="color" class="form-label fs-14 fw-medium color-gray padding-start-10">Color</label>
                                            <div class="color-piker-main ">
                                                <div class="radio-with-Icon d-flex flex-wrap">
                                                    <p class="radioOption-Item"  v-for="(color,index) in popup.colors" :key="color">
                                                        <input type="radio" name="BannerTypes" :id="'color'+index" :value="color" class="ng-valid ng-dirty ng-touched ng-empty" aria-invalid="false" v-model="popup.color">
                                                        <label :for="'color'+index">
                                                            <span class="banner-inner" :style="'background: rgb('+color+');'"><i class="ri-check-fill"></i></span>
                                                        </label>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-12">
                                        <label class="form-label fs-14 fw-medium color-gray padding-start-10">Status:</label>
                                        <div class="status">
                                            <div class="form-check form-check-inline form-radio-success">
                                                <input class="form-check-input" type="radio" name="status" id="active" value="1" v-model="popup.status" checked>
                                                <label class="form-check-label fs-14 fw-medium color-gray" for="active" style="vertical-align:middle;">Active</label>
                                            </div>
                                            <div class="form-check form-check-inline form-radio-success">
                                                <input class="form-check-input" type="radio" name="status" id="deactive" value="0" v-model="popup.status">
                                                <label class="form-check-label fs-14 fw-medium color-gray" for="deactive" style="vertical-align:middle;">Deactive</label>
                                            </div>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light fs-16 px-3 text-white" data-bs-dismiss="modal" data-v-33972369="" style="background-color: rgb(135, 138, 153);" @click="blankPopupForm()">Close</button>
                                            <button type="submit" class="btn btn-success fs-16" data-v-33972369="">Add Table</button>
                                        </div>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
import $ from "jquery";
import { useToast } from "vue-toastification";
export default {
    data() {
        return {
            availTables: [],
            runningTables: [],
            deactiveTables: [],
            ordersPopup: [],
            popup: {
                number: '',
                capacity: 0,
                status: 1,
                color: '',
                colors: [],
            },
            errors: {
                number: '',
                capacity: '',
                color: ''
            },
            toast : useToast(),
            addLoader: false,
        }
    },
    props : ['allpermissions'],
    beforeCreate(){
        this.$emit('addLoader');
    },
  async created() {
      await this.gettabledata();
  },
  methods : {
    async gettabledata(){
        await axios.get('/api/gettabledata')
          .then(res => {

            this.availTables = res.data.availTables;
            this.runningTables = res.data.runningTables;
            this.deactiveTables = res.data.deactiveTables;
            this.popup.colors = res.data.colors;
            this.callInterval();
            this.intervalFun();
            this.$emit('removeLoader');
          }).catch(err => {
          })
    },
    async callInterval(){
        setInterval(await this.intervalFun, 60000);
    },
    async intervalFun(){
         await axios.get('/api/gettabledatatime')
          .then(res => {
            var td = res.data.timediff;
            for (let [key, value] of Object.entries(td)) {
                if(this.runningTables[key]){
                    this.runningTables[key].diff = value;
                }
            }
          }).catch(err => {
          })
    },
    async addtable(){
        this.$emit('showToast',"You Can not change this on demo account.",'error'); 
        return false;
        // const config = {
        //     headers: { 'content-type': 'multipart/form-data' }
        // }

        // if(!this.popup.number && this.popup.capacity && this.popup.color){ this.$emit('showToast',"Please add table name.",'error'); return false; }
        // if(this.popup.number && !this.popup.capacity && this.popup.color){ this.$emit('showToast',"Please add capacity for table member.",'error'); return false; }
        // if(this.popup.number && this.popup.capacity && !this.popup.color){ this.$emit('showToast',"Please add table color.",'error'); return false; }

        // if(!this.popup.number || !this.popup.capacity || !this.popup.color){ this.$emit('showToast',"Please fill out form details.",'error'); return false; }

        // // console.log(this.popup.color);
        // var formData = new FormData();
        // formData.append('number', this.popup.number);
        // formData.append('capacity', this.popup.capacity);
        // formData.append('status', this.popup.status);
        // formData.append('color', this.popup.color);

        // await axios
        // .post("/api/addtable", formData, config)
        // .then((res) => {
        //     this.$emit("showToast","Table added successfully",'success');
        //     document.getElementById('close-button').click();
        //     this.gettabledata();
        //     this.blankPopupForm();

        // }).catch((error) => {
        //     var errors = error.response.data.error
        //     var data = this.errors;
        //     if (errors) {
        //     }
        // })
    },
    blankPopupForm(){
        this.popup.number = '';
        this.popup.capacity = 0;
        this.popup.status = 1;
        this.popup.color = '';
        // $("input:radio[name=language]:checked")[0].checked = false;
    },
    async activeDeactive(id,event){
        
        this.$emit('showToast',"You Can not change this on demo account.",'error'); 
        return false;
        // this.addLoader = true;
        // if(event.target.checked){
        //     var status = 'Available';
        // }else{
        //     var status = 'Deactive';
        // }
        // await axios.post('/api/changeTableStatus',{id : id,status : status})
        //   .then(res => {
        //     this.gettabledata();
        //     this.$emit('showToast',"Table status changed successfully",'success');
        //     setTimeout(() => this.addLoader = false, 2000);
        //   }).catch(err => {
        //   })
    },
    // gettabledataforpopup(table){
    //   axios.get('/api/gettabledataforpopup/'+table)
    //       .then(res => {
    //         this.ordersPopup = res.data.popupOrders;
    //         this.intervalFun();
    //       }).catch(err => {
    //       })
    // },
  }
};

</script>

<style scoped>

.color--blue{
    color:#009BFE;
}
.color--green{
    color: #009049;
}
.color--gray{
    color: #878A99;
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
/*------------ Table management ------------------*/
.table-management{
    background: #FFFFFF;
    box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.25);
    border-radius: 10px;
    height: 100vh;
    max-height: calc(100vh - 213px);
}
/*----------- Table Status Main ----------------*/
.table-management .table-status-main{
    height: 100%;
    max-height: 669px;
    overflow: auto;
    padding: 15px 12px;
}
.table-management .table-status-main::-webkit-scrollbar{
    width:3px;
    background:transparent;
}
.table-management .table-status-main::-webkit-scrollbar-thumb{
    background: #878A99;
    border-radius:10px;
}
.table-management .table-status-header{
    padding-top: 15px;
    padding-left: 12px;
    padding-right: 12px;
}
.table-management .table-status-header i{
    vertical-align:middle;
}
.table-management .table-status-header .available-status i{
    color:#009BFE;
}
.table-management .table-status-header .running-status  i{
    color:#009049;
}
.table-management .table-status-header .deactivate-status i{
  color: #EFEEF3;
}
:focus-visible {
    outline: -webkit-focus-ring-color auto 0px;
}
.color--layer{
    background: #FFFFFF;
    border: 1px solid rgba(0, 0, 0, 0.12);
}
/************ TABLE CARD CSS ***********/
.table-management .table-status-main .single-table {
    height:139px;
}
.table-management .table-status-main .single-table .card .card-body h5{
    font-size:20px;
    line-height:18px;
    font-weight:500;
}
.table-management .table-status-main .table-status-inner .available-table{
    background: rgba(0, 155, 254, 0.2);
    border: 1px dashed #66C3FF;
    border-radius: 10px;
}
.table-management .table-status-main .table-status-inner .available-table-header{
    background: #66C3FF;
    border-radius: 10px 10px 0px 0px;
}
.table-management .table-status-main .table-status-inner .running-table{
    background: rgba(0, 144, 73, 0.2);
    border: 1px solid #009049;
    border-radius: 10px;
}
.table-management .table-status-main .table-status-inner .running-table-header{
    background: #009049;
    border-radius: 10px 10px 0px 0px;
}
.table-management .table-status-main .table-status-inner .deactivate-table{
    background: rgba(135, 138, 153, 0.2);
    border: 1px solid #878A99;
    border-radius: 10px;
}
.table-management .table-status-main .table-status-inner .deactivate-table-header{
    background: #878A99;
    border-radius: 10px 10px 0px 0px;
}
/********** FOOTER CSS ***********/
.main-content .footer-start .footer-main.bg-white {
    position: fixed;
    width: 100%;
    bottom: 0;
    padding: 8px 15px 8px 32px;
}
.footer-main .footer-link .btn-custom{
    padding:10px 13px;
    line-height:16px;
}
/********COLOR PIKER CSS START *********/
.modal .color-piker-main div.radio-with-Icon p.radioOption-Item label span i {
    position: absolute;
    top: 50%;
    left: 50%;
    line-height: initial;
    border-radius: 50%;
    background-color: #0ab39c;
    color: #FFF;
    font-size: 16px;
    padding: 3px;
    transform: translate(-50%, -50%);
    border: 1px solid rgb(255 255 255 / 90%);
    visibility: hidden;

}
.modal .color-piker-main div.radio-with-Icon p.radioOption-Item input[type="radio"]:checked ~ label span i {
    visibility: visible;
}
.modal .color-piker-main .banner-inner{
    width: 45px;
    height: 45px;
    position: relative;
}
.modal .color-piker-main div.radio-with-Icon p.radioOption-Item {
  display: inline-block;
  width: 115px;
  height: auto;
  box-sizing: border-box;
  margin-right:10px;
  border: none;
  flex: 0 0 20%;
  max-width: calc(20% - 10px);
   }
.modal .color-piker-main div.radio-with-Icon p.radioOption-Item label {
  display: flex;
  justify-content:center;
  align-items: center;
  cursor: pointer;
  opacity: 0.8;
  transition: none;
  font-size: 13px;
  text-align: center;
  margin: 0 !important;
}
.modal .color-piker-main div.radio-with-Icon p.radioOption-Item input[type="radio"] {
  display: none;
  width: 0 !important;
  height: 0 !important;
}
.modal .color-piker-main div.radio-with-Icon p.radioOption-Item input[type="radio"]:checked ~ label {
  opacity: 1;
  border: none;
  color: #fff;
}

.switch {
  display: inline-block;
  height: 14px;
  position: relative;
  width: 25px;
}

.switch input {
  display:none;
}

.slider {
  background-color: #ccc;
  bottom: 0;
  cursor: pointer;
  left: 0;
  position: absolute;
  right: 0;
  top: 0;
  transition: .4s;
}

.slider:before {
  background-color: #fff;
  bottom: 2px;
  content: "";
  height: 10px;
  left: 3px;
  position: absolute;
  transition: .4s;
  width: 10px;
}

input:checked + .slider {
  background-color: #0ab39c;
}

input:checked + .slider:before {
  transform: translateX(9px);
}

.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

/********COLOR PIKER CSS END *********/

/*********    RESPONSIVE CSS **********/
@media screen and (max-width:1180px){
    .table-management{
        max-height: calc(100vh - 200px);
    }
    .table-management .table-status-main{
        max-height:565px;
    }
}
@media screen and (max-width:820px){
    .table-management{
        max-height: calc(100vh - 195px);
    }
    .table-management .table-status-main{
       max-height: calc(100vh - 251px);
    }
}
</style>
