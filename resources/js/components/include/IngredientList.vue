<template>
<div class="col-lg-4 col-md-5 col-12">
    <div class="product-right-main">
        <div class="product-right-top pt-4 px-3">
            <div class="search-box">
                <input type="text" v-model="searchIng" class="form-control" placeholder="Description" />
                <i class="ri-search-line search-icon" @click="searchIngredients()"></i>
            </div>
            <div class="product-right-tab">
                <div class="card mb-0 bg-transparent" style="box-shadow: none">
                    <div class="card-body pb-0">
                        <ul class="nav nav-justified border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active bg-transparent text-white" id="ingredientListButton" data-bs-toggle="tab" href="#ingredient--list" role="tab" aria-selected="true">
                                    Ingredients
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link bg-transparent text-white" id="sizeListButton" data-bs-toggle="tab" href="#size--list" role="tab" aria-selected="false">
                                    Size
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- end card-body -->
                </div>
            </div>
        </div>
        <div class="tab-content text-muted ">
            <div class="tab-pane active overflow-auto product-right-ingredients products-right-sidebar"  style="height: calc(100vh - 323px);" id="ingredient--list" role="tabpanel">
                <div class="product-right-des pt-2 px-3 pt-2 mx-3 ">
                    <div class="w-100" :data-id="ingredient.id" v-for="ingredient in ingredients" :key="ingredient.id">
                        <label class="
                  form-check-label
                  product-single-box product-ing-box
                  row
                  align-items-center
                  px-3
                  py-2
                  rounded
                  mb-2
                " :id="'right-selection-'+ingredient.id" :for="'formCheck_' + ingredient.id" :class="{ active : selIng.includes(ingredient.id) }">
                            <div class="col-2 ps-0">
                                <div class="product-img text-center">
                                    <img :src="'/storage/'+ ingredient.image" alt="IMG 1" :id="'ingredient_image_'+ingredient.id" />
                                </div>
                            </div>
                            <div class="col-9" style="border-left: 1px solid #0ab39c">
                                <div class="product-np">
                                    <p class="fw-medium mb-0 fs-14 color-gray" :id="'ingredient_name_'+ingredient.id">
                                        {{ ingredient.name }}
                                    </p>
                                    <p class="mb-0 fs-14 color-gray" style="padding-top: 3px" :id="'ingredient_price_'+ingredient.id">
                                        +{{currencyCode}} {{ ingredient.price.toFixed(2) }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-1 ps-0">
                                <div class="form-check form-check-success">
                                    <input class="form-check-input" v-if="selIng.includes(ingredient.id)" type="checkbox" @change="toggleRightChecking(ingredient.id)" :id="'formCheck_' + ingredient.id" checked />
                                    <input class="form-check-input" v-else type="checkbox" @change="toggleRightChecking(ingredient.id)" :id="'formCheck_' + ingredient.id" />
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="tab-pane overflow-auto product-right-sizes products-right-sidebar" id="size--list" role="tabpanel" style="height: calc(100vh - 323px)" >
            <!-- :for="'formCheck-size' + ingredient.id"  -->
                <div class="product-right-des pt-2 px-3 pt-2 mx-3">
                    <div class="w-100" v-for="ingredient in sizes" :key="ingredient.id" :id="'openSizeModal'+ingredient.id" data-bs-toggle="modal" data-bs-target="#addsizeprice">
                        <label class="
                  form-check-label
                  product-single-box product-ing-box
                  row
                  align-items-center
                  px-3
                  py-2
                  rounded
                  mb-2 formCheck-size
                " :id="'size-selection-'+ingredient.id" :class="{ active : selectSizes.includes(ingredient.id) }">
                            <div class="col-2 ps-0">
                                <div class="product-img">
                                    <div class="rounded text-center color-gray fs-24 fw-bold">
                                        {{ ingredient.name }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-9" style="border-left: 1px solid #0ab39c">
                                <div class="product-np">
                                    <p class="fw-medium mb-0 fs-14 color-gray">
                                        {{ ingredient.name }}
                                    </p>
                                    <p class="mb-0 fs-14 color-gray" style="padding-top: 3px">
                                        +{{currencyCode}} <span :id="'size-price-'+ingredient.id" >{{ ingredient.price.toFixed(2) }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-1 ps-0">
                                <div class="form-check form-check-success">
                                    <input v-if="selectSizes.includes(ingredient.id)" class="form-check-input sizeProduct" checked @Change="checkSize(ingredient.id)" type="checkbox" :id="'formCheck-size' + ingredient.id" />
                                    <input v-else class="form-check-input sizeProduct" @Change="checkSize(ingredient.id)" type="checkbox" :id="'formCheck-size' + ingredient.id" />
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <SizeSetPrice @setPrice="setPrice" :popupSelectPriceSize="popupSelectPriceSize"/>
</div>
</template>

<script>
import $ from "jquery";
import SizeSetPrice from './SizeSetPrice.vue'
export default {
    name: "IngredientList",
    props: {
        ingredients: {
            type: Array,
        },

        selectIngredients: {
            type: Array,
        },

        selectSizes: {
            type: Array,
        },

        sizes: {
            type: Array,
        },

        selIng: {
            type: Array,
        },

        selectSizesPrice: {
            type: Array,
        },

        currencyCode: {
            type: String,
        },
    },
    created() {
    },
    data() {
        return {
            popupSelectSize: 0,
            popupSelectPriceSize: 0,
            searchIng : '',
        }
    },
    components: {
        SizeSetPrice
    },
    methods: {
        toggleRightChecking(id) {
            document.getElementById("right-selection-" + id).classList.toggle('active');
            var image = document.getElementById("ingredient_image_" + id).getAttribute('src');
            var name = document.getElementById("ingredient_name_" + id).textContent;
            var price = document.getElementById("ingredient_price_" + id).textContent;
            var ingredient = {
                id:id,
                image:image,
                name:name,
                price:price
            }
            if(this.selIng.findIndex(p => p == id) == -1){
                this.selIng.push(id);
                this.selectIngredients.push(ingredient);
            }else{
                let int = this.selIng.map(item => item).indexOf(id)
                this.selIng.splice(int, 1)

                let i = this.selectIngredients.map(item => item.id).indexOf(id)
                this.selectIngredients.splice(i, 1)
            }
        },
        checkSize(id){
            // $("#formCheck-size" + id).prop('checked',true);
            let price = $("#size-price-"+id).text();
            this.popupSelectSize = id;
            $("#size-price").val(Math.floor(price));

            // this.popupSelectPriceSize = Math.floor(price);
            // document.getElementById("size-selection-" + id).classList.add('active');
            // if(this.selectSizes.findIndex(p => p == id) == -1){
            //     this.selectSizes.push(id);
            // }
            if(this.selectSizes.findIndex(p => p == id) == -1){
                $("#formCheck-size" + id).prop('checked',false);
            }else{
               $("#formCheck-size" + id).prop('checked',true);
            }
        },
        setPrice(price) {
            let id = this.popupSelectSize;
            $("#formCheck-size" + id).prop('checked',true);
            this.selectSizesPrice[id] = price;
           $("#size-price-" + id).text(price.toFixed(2));
           this.popupSelectPriceSize = 0;

           document.getElementById("size-selection-" + id).classList.add('active');
            if(this.selectSizes.findIndex(p => p == id) == -1){
                this.selectSizes.push(id);
            }

          this.$emit('setPrice', this.selectSizes)

        },
        searchIngredients(){
            var el = document.getElementById('ingredientListButton');
            el.click();
            var ingredients = new FormData();
            ingredients.append('searchIng', this.searchIng);
            this.$emit('searchIngredients', ingredients)
        }
    }
};
</script>

<style scoped>
/* --------- COMMON CLASS ------------- */
.error {
    color: red;
}
.form-check-input {
    width: 18px;
    height: 18px;
    border: 1px solid #0ab39c;
}

.form-check-input[type="checkbox"] {
    border-radius: 5px;
}

.form-check-input:checked {
    background-color: #0ab39c;
}

.product-ingredients .product-ingredients-main .product-ingredients-inner.active .form-check-input {
    display: block !important;
}
/* ----------- product-right-top -------------- */
.product-main-content .product-right-top {
    background: #0ab39c;
    border-radius: 6px 6px 0px 0px;
    box-shadow: 0px 3px 10px rgb(0 0 0 / 25%);
}
.product-main-content .product-right-main .product-right-top .form-control {
    padding-right: 5.9rem;
    padding-left: 17px;
    border-radius: 10px;
}
/*------ Search box -----------*/
.product-main-content .product-right-main .product-right-top .search-box .search-icon {
    background: #0ab39c;
    padding: 9px 14px;
    right: 4px !important;
    top: 4px;
    left: inherit;
    color: #fff;
    width: 37px;
    height: 34px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 10px;
    cursor: pointer;
}
/* --------- Product-right-tab Start-------------- */
.product-right-main .product-right-top .product-right-tab .nav-link.active {
    border-bottom: 5px solid #fff;
}
/* ------------- products-right-sidebar ----------------*/

.product-right-main .product-right-des .product-single-box .product-img img {
    width: 100%;
    max-width: 50px;
    height: 100%;
    max-height: 40px;
}

.product-right-des .product-single-box .product-np p {
    line-height: 16px;
}
.product-main-content .product-main .product-ing-box {
    box-shadow: -2px -2px 5px rgba(0, 0, 0, 0.25);
    border-radius: 10px !important;
    transition: all 0.5s ease-in;
    background: #fff;
}
.product-main-content .product-main .product-ing-box.active {
    background: rgba(10, 179, 156, 0.15);
}
.product-main-content .product-right-main {
    position: sticky;
    top: 93px !important;
    background: #ffffff;
    box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.25);
    border-radius: 10px;
}

/* ------- Scrrollbar --------- */
.product-right-main .tab-content .products-right-sidebar::-webkit-scrollbar {
    width: 3px;
    background: transparent;
}
.product-right-main .tab-content .products-right-sidebar::-webkit-scrollbar-thumb {
    background: #8b8a8a;
    border-radius: 10px;
}

/*---------------- RESPONSIVE CSS ----------------*/

@media screen and (min-width: 992px) and (max-width: 1199px) {
    .col-xlmd {
        flex: 0 0 20%;
        max-width: 20%;
    }
}
@media screen and (max-width:1180px){
    .product-right-main .tab-content .products-right-sidebar{
        height: calc(100vh - 295px) !important;
    }

}
@media screen and (max-width: 1024px) {
    .product-main-content .product-right-main {
        top: 89px !important;
    }
}
@media screen and (max-width:820px){
.product-right-main .tab-content .products-right-sidebar {
    height: calc(100vh - 320px) !important;
    }
}
</style>
