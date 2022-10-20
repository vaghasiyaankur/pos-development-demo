<template>
<!-- CATEGORIES LIST START -->
<!-------Start page title start-------->
<div class="row">
    <div class="col-12">
        <div class="p-4 d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 fs-5 fw-bold">{{ title }}</h4>
        </div>
    </div>
</div>
<!--- Start page title end -->
<section class="categories">
    <div class="categories-main mt-5">
        <div class="catagory-inner d-flex flex-wrap px-2">
            <div class="catagory-single-card  mb-4"  v-for="item in items" :key="item.id">
                <div class="card equal-height-ingredient" :class="item.status == 1 ? '' : 'deactive' ">
                    <router-link  class="card-body px-3 py-2 text-center" :to="{name: 'Product', params: {'slug': item.slug}}">
                        <div class="mx-auto avatar-lg mb-2 card-image rounded-circle">
                            <img :src="'/storage/'+item.image"  alt="itemslist" class="img-fluid rounded-circle">
                        </div>
                        <h5 class="card-title mb-1 fs-12 mt-3 title--name justify-content-center align-items-center">{{ item.name }}</h5>
                    </router-link >
                    <div class="card-bottom px-2 pb-2 text-center border-0">
                        <ul class="list-inline mb-0 d-flex justify-content-between align-items-center">
                            <li class="list-inline-item">
                                <a href="javascript:;" class="align-middle"  data-bs-toggle="modal" data-bs-target="#removedataalert"  @click="removeCategory(item.id)" v-if="allpermissions.CategoryDelete"><i class="fa-solid fa-trash-can text-success"></i></a>
                            </li>
                            <li class="list-inline-item">
                            <router-link class="align-middle fs-10 color-gray" :to="{name: 'Product', params: {'slug': item.slug}}">{{ item.products_count}} items</router-link>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript:;" class="align-middle" data-bs-toggle="modal" data-bs-target="#addeditcategory" @click="openEditPopup(item.id)" v-if="allpermissions.CategoryEdit"><i class="fa-solid fa-pen-to-square text-success"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-------- CATEGORIES LIST END --------->
</template>

<script>
import $ from "jquery";
export default {
    name: 'ItemList',
    props: {
        items : Array,
        title : String,
        allpermissions : Array,
    },
    methods: {
        openEditPopup(id){
            this.$emit('getCategorySingleData',id);
        },
        removeCategory(id){
            this.$emit('removeCategory',id);
        }
    }
}
</script>

<style scoped>
    .title--name {
        min-height: 30px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2; /* number of lines to show */
                line-clamp: 2;
        -webkit-box-orient: vertical;
        word-break: break-word;
    }
      /*********** CATEGORIES LIST START ***********/
    .categories{
        overflow: auto;
        height: 100%;
        max-height: calc(100% - 68px);
    }
    .catagory-mang .categories-main .catagory-inner .catagory-single-card .card .avatar-lg{
        width:5.5rem;
        height:5.5rem;
    }
    .catagory-mang .categories-main .catagory-inner .catagory-single-card .card .card-image{
        margin-top:-40px;
        background: #FFFFFF;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
        display: flex;
        justify-content: center;
        align-items : center;
    }
    .catagory-mang .categories-main .catagory-inner .catagory-single-card{
        flex: 0 0 9%;
        max-width:9%;
    }
    .catagory-mang .categories-main .catagory-inner .catagory-single-card .card{
        background: #FFFFFF;
        border: 1px solid #0AB39C;
        box-shadow: -4px -1px 8px rgba(137, 137, 137, 0.25);
        border-radius: 10px;
        max-width:123px;
        margin-right:auto;
        margin-left:auto;
    }
    
        /*********** DEACTIVE CARD CSS ***************/
        .categories-main .catagory-inner .catagory-single-card .card.deactive{
            border : 1px solid #878787 !important;
        }
        .categories-main .catagory-inner .catagory-single-card .card.deactive .text-success{
            color: #878787 !important;
        }
    /*********** CATEGORIES LIST END ***********/
    
    /*********** RESPONSIVE CSS *****************/
    @media screen and (max-width:1440px){
        .catagory-mang .categories-main .catagory-inner .catagory-single-card{
            flex:0 0 10%;
            max-width:10%;
        }
    }
     @media screen and (min-width:1181px) and (max-width:1366px){
        .catagory-mang .categories-main .catagory-inner .catagory-single-card{
            flex:0 0 11%;
            max-width:11%;
        }
    }
     @media screen and (max-width:1180px){
        .catagory-mang .categories-main .catagory-inner .catagory-single-card{
            flex:0 0 12.5%;
            max-width:12.5%;
        }

    }
     @media screen and (min-width:1024px) and (max-width:1179px){
        .catagory-mang .categories-main .catagory-inner .catagory-single-card{
            flex:0 0 14%;
            max-width:14%;
        }
    }
    @media screen and (min-width:992px) and (max-width:1023px){
        .catagory-mang .categories-main .catagory-inner .catagory-single-card{
            flex:0 0 14.28%;
            max-width:14.28%;
        }
    }
    @media screen and (min-width:576px) and (max-width:991px){
        .catagory-mang .categories-main .catagory-inner .catagory-single-card{
            flex:0 0 20%;
            max-width:20%;
        }
    }
    @media screen and (max-width:1024px){
        .catagory-mang{
            margin-top:20px;
        }
    }

</style>
