<template>
    <div class="cart-offcanvas">
        <div
            class="offcanvas offcanvas-start"
            tabindex="-1"
            id="openDetails"
            aria-labelledby="openDetailsLabel"
            aria-modal="true"
            role="dialog"
        >
            <div
                class="offcanvas-body p-0 position-relative"
                style="overflow-y: hidden"
            >
                <div data-simplebar="init" style="height: calc(100vh - 63px)">
                    <div
                        class="simplebar-wrapper"
                        style="margin: 0px; overflow: unset"
                    >
                        <div class="simplebar-height-auto-observer-wrapper">
                            <div class="simplebar-height-auto-observer"></div>
                        </div>
                        <div class="simplebar-mask overflow-hidden">
                            <div
                                class="simplebar-offset"
                                style="right: 0px; bottom: 0px"
                            >
                                <div
                                    class="loading"
                                    :class="{ 'd-none': !addCartLoader }"
                                    style="z-index: 9999"
                                ></div>
                                <div
                                    class="simplebar-content-wrapper"
                                    style="overflow: unset; height: 100%"
                                    tabindex="0"
                                    role="region"
                                    aria-label="scrollable content"
                                    :class="{ 'opacity-25': addCartLoader }"
                                >
                                    <div
                                        class="simplebar-content"
                                        style="padding: 0px"
                                    >
                                        <div
                                            class="acitivity-timeline p-2 pt-0"
                                            style="overflow: unset"
                                        >
                                            <!----- LARGE SCREEN OFFCANVAS START ------->
                                            <div class="large-screen-offcanvas">
                                                <div class="row">
                                                    <div class="col-4 ps-0">
                                                        <div
                                                            class="select-items-cart text-center p-2 bg-light"
                                                            style="
                                                                height: 100vh;
                                                            "
                                                        >
                                                            <div
                                                                lass="items-cart-heading"
                                                            >
                                                                <h2
                                                                    class="fs-4 text-dark mt-4"
                                                                >
                                                                    {{
                                                                        product.name
                                                                    }}
                                                                </h2>
                                                            </div>
                                                            <div
                                                                class="items-cart-img my-4"
                                                            >
                                                                <img
                                                                    :src="
                                                                        product.image
                                                                    "
                                                                    class="rounded-circle img-fluid" alt="addtocart"
                                                                />
                                                            </div>
                                                            <div
                                                                class="input-step items-cart-count w-50 justify-content-between border-0 bg-transparent mt-2"
                                                            >
                                                                <button
                                                                    type="button"
                                                                    class="minus bg-dark text-white fs-1 popup-minus"
                                                                    data-action="minus"
                                                                    @click="
                                                                        changePopupQuantity(
                                                                            $event
                                                                        )
                                                                    "
                                                                >
                                                                    –
                                                                </button>
                                                                <input
                                                                    type="number"
                                                                    class="product-quantity popupQuantity popup-number"
                                                                    id="popupQuantity"
                                                                    :value="
                                                                        popupQuantityValue
                                                                    "
                                                                    min="1"
                                                                    max="100"
                                                                />
                                                                <button
                                                                    type="button"
                                                                    class="plus bg-dark text-white fs-1 popup-plus"
                                                                    data-action="plus"
                                                                    @click="
                                                                        changePopupQuantity(
                                                                            $event
                                                                        )
                                                                    "
                                                                >
                                                                    +
                                                                </button>
                                                            </div>
                                                            <div
                                                                class="addtocart-details"
                                                            >
                                                                <div
                                                                    class="addtocart-heading mt-5"
                                                                >
                                                                    <h4
                                                                        class="text-dark fs-5 mb-0"
                                                                    >
                                                                        Select
                                                                        Size
                                                                    </h4>
                                                                </div>
                                                                <div
                                                                    class="size-varient"
                                                                >
                                                                    <div
                                                                        class="card bg-transparent"
                                                                        style="
                                                                            box-shadow: none;
                                                                        "
                                                                    >
                                                                        <div
                                                                            class="card-body px-0"
                                                                        >
                                                                            <!-- Nav tabs -->
                                                                            <ul
                                                                                class="nav nav-pills nav-justified flex-wrap nav-success"
                                                                                role="tablist"
                                                                            >
                                                                                <li
                                                                                    class="nav-item"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-bs-trigger="hover"
                                                                                    data-bs-placement="top"
                                                                                    title
                                                                                    data-bs-original-title="Home"
                                                                                    v-for="(
                                                                                        size,
                                                                                        index
                                                                                    ) in sizes"
                                                                                    :key="
                                                                                        size.id
                                                                                    "
                                                                                >
                                                                                    <a
                                                                                        :data-price="
                                                                                            size.price
                                                                                        "
                                                                                        :data-id="
                                                                                            size
                                                                                                .size
                                                                                                .id
                                                                                        "
                                                                                        class="nav-link size-selection"
                                                                                        :class="{
                                                                                            active:
                                                                                                index ===
                                                                                                0,
                                                                                        }"
                                                                                        data-bs-toggle="tab"
                                                                                        href="#toptab-dai20cm"
                                                                                        role="tab"
                                                                                        aria-selected="true"
                                                                                        @click="
                                                                                            this.$emit(
                                                                                                'selectSize',
                                                                                                size.price,
                                                                                                size
                                                                                                    .size
                                                                                                    .id,
                                                                                                size
                                                                                                    .size
                                                                                                    .name
                                                                                            )
                                                                                        "
                                                                                        >{{
                                                                                            size
                                                                                                .size
                                                                                                .name
                                                                                        }}</a
                                                                                    >
                                                                                </li>
                                                                            </ul>
                                                                            <!-- Tab panes -->
                                                                            <div
                                                                                class="tab-content text-muted"
                                                                            >
                                                                                <div
                                                                                    class="tab-pane active"
                                                                                    id="toptab-dai20cm"
                                                                                    role="tabpanel"
                                                                                >
                                                                                    <div
                                                                                        class="varient-list"
                                                                                    >
                                                                                        <ul
                                                                                            class="list-group list-group-flush mt-5"
                                                                                        >
                                                                                            <li
                                                                                                class="list-group-item bg-transparent text-left text-start border-0"
                                                                                            >
                                                                                                <i
                                                                                                    class="ri-checkbox-circle-fill text-success"
                                                                                                ></i>
                                                                                                <span
                                                                                                    class="fw-bold fs-5 px-2"
                                                                                                >
                                                                                                    Selected
                                                                                                    Size:
                                                                                                </span>
                                                                                                <p
                                                                                                    class="mb-0"
                                                                                                >
                                                                                                    {{
                                                                                                        selectSizes
                                                                                                    }}
                                                                                                </p>
                                                                                            </li>
                                                                                            <li
                                                                                                class="list-group-item bg-transparent text-left text-start border-0"
                                                                                            >
                                                                                                <i
                                                                                                    class="ri-checkbox-circle-fill text-success"
                                                                                                ></i>
                                                                                                <span
                                                                                                    class="fw-bold fs-5 px-2"
                                                                                                >
                                                                                                    Selected
                                                                                                    ingredients:
                                                                                                </span>
                                                                                                <p
                                                                                                    class="mb-0 overflow-auto"
                                                                                                    style="
                                                                                                        max-height: 115px;
                                                                                                    "
                                                                                                >
                                                                                                    {{
                                                                                                        this
                                                                                                            .selectIngredient
                                                                                                    }}
                                                                                                </p>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="tab-pane"
                                                                                    id="toptab-dai30cm"
                                                                                    role="tabpanel"
                                                                                >
                                                                                    <div
                                                                                        class="varient-list"
                                                                                    >
                                                                                        <ul
                                                                                            class="list-group list-group-flush mt-5"
                                                                                        >
                                                                                            <li
                                                                                                class="list-group-item bg-transparent text-left text-start border-0"
                                                                                            >
                                                                                                <i
                                                                                                    class="ri-checkbox-circle-fill text-success"
                                                                                                ></i>
                                                                                                <span
                                                                                                    class="fw-bold fs-5 px-2"
                                                                                                >
                                                                                                    Selected
                                                                                                    Size:
                                                                                                </span>
                                                                                                <p
                                                                                                    class="mb-0"
                                                                                                >
                                                                                                    Daimeter
                                                                                                    30cm
                                                                                                </p>
                                                                                            </li>
                                                                                            <li
                                                                                                class="list-group-item bg-transparent text-left text-start border-0"
                                                                                            >
                                                                                                <i
                                                                                                    class="ri-checkbox-circle-fill text-success"
                                                                                                ></i>
                                                                                                <span
                                                                                                    class="fw-bold fs-5 px-2"
                                                                                                >
                                                                                                    Selected
                                                                                                    ingredients:
                                                                                                </span>
                                                                                                <p
                                                                                                    class="mb-0"
                                                                                                >
                                                                                                    Mozzarella,
                                                                                                    spicy
                                                                                                    salami,
                                                                                                    tuna
                                                                                                </p>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="tab-pane"
                                                                                    id="toptab-dai50cm"
                                                                                    role="tabpanel"
                                                                                >
                                                                                    <div
                                                                                        class="varient-list"
                                                                                    >
                                                                                        <ul
                                                                                            class="list-group list-group-flush mt-5"
                                                                                        >
                                                                                            <li
                                                                                                class="list-group-item bg-transparent text-left text-start border-0"
                                                                                            >
                                                                                                <i
                                                                                                    class="ri-checkbox-circle-fill text-success"
                                                                                                ></i>
                                                                                                <span
                                                                                                    class="fw-bold fs-5 px-2"
                                                                                                >
                                                                                                    Selected
                                                                                                    Size:
                                                                                                </span>
                                                                                                <p
                                                                                                    class="mb-0"
                                                                                                >
                                                                                                    Daimeter
                                                                                                    50cm
                                                                                                </p>
                                                                                            </li>
                                                                                            <li
                                                                                                class="list-group-item bg-transparent text-left text-start border-0"
                                                                                            >
                                                                                                <i
                                                                                                    class="ri-checkbox-circle-fill text-success"
                                                                                                ></i>
                                                                                                <span
                                                                                                    class="fw-bold fs-5 px-2"
                                                                                                >
                                                                                                    Selected
                                                                                                    ingredients:
                                                                                                </span>
                                                                                                <p
                                                                                                    class="mb-0"
                                                                                                >
                                                                                                    Gorgonzola,
                                                                                                    mascarpone,
                                                                                                    mozzarella,
                                                                                                    spicy
                                                                                                    salami,
                                                                                                    tuna
                                                                                                </p>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- end card-body -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="addtocart-btn position-relative"
                                                            >
                                                                <button
                                                                    type="button"
                                                                    class="btn btn-success waves-effect waves-light w-100"
                                                                    @click="
                                                                        AddToCart(
                                                                            product.id
                                                                        )
                                                                    "
                                                                >
                                                                    Add to Cart
                                                                    -
                                                                    {{
                                                                        this.popUpprice.toFixed(
                                                                            2
                                                                        )
                                                                    }}
                                                                    {{
                                                                        currencyCode
                                                                    }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="col-8 ps-0 pt-2"
                                                    >
                                                        <div
                                                            class="offcanvas-header justify-content-between px-0 pt-4"
                                                        >
                                                            <div
                                                                class="items-cart-heading"
                                                            >
                                                                <h2
                                                                    class="fs-4 text-dark"
                                                                >
                                                                    select
                                                                    ingredients
                                                                </h2>
                                                            </div>
                                                            <button
                                                                id="closeProductDetail"
                                                                type="button"
                                                                class="btn-close text-reset fs-3 pe-4"
                                                                data-bs-dismiss="offcanvas"
                                                                aria-label="Close"
                                                                @click="
                                                                    addToCartLoader = false
                                                                "
                                                            ></button>
                                                        </div>
                                                        <div
                                                            class="scrollbar px-2"
                                                            id="style-3"
                                                        >
                                                            <div
                                                                class="force-overflow mt-3"
                                                            >
                                                                <div
                                                                    class="menu-cart-option"
                                                                >
                                                                    <div
                                                                        class="diff-menucart"
                                                                        v-for="ingredientCategory in ingredientCategories"
                                                                        :key="
                                                                            ingredientCategory.id
                                                                        "
                                                                    >
                                                                        <div
                                                                            class="small-title text-start"
                                                                        >
                                                                            <h4
                                                                                class="text-dark"
                                                                            >
                                                                                {{
                                                                                    ingredientCategory.name
                                                                                }}
                                                                            </h4>
                                                                        </div>
                                                                        <div
                                                                            class="row"
                                                                        >
                                                                            <div
                                                                                class="col-xl-3 col-lg-4 col-md-6"
                                                                                v-for="ingredient in ingredientCategory.activeingredients"
                                                                                :key="
                                                                                    ingredient.id
                                                                                "
                                                                            >
                                                                                <div
                                                                                    :data-name="
                                                                                        ingredient.name
                                                                                    "
                                                                                    :data-price="
                                                                                        ingredient.price
                                                                                    "
                                                                                    :data-id="
                                                                                        ingredient.id
                                                                                    "
                                                                                    class="card card-body text-center ingredient-selection"
                                                                                    @click="
                                                                                        ingredientSelection(
                                                                                            $event
                                                                                        )
                                                                                    "
                                                                                >
                                                                                    <div
                                                                                        class="flex-shrink-0"
                                                                                    >
                                                                                        <img
                                                                                            :src="
                                                                                                'storage/' +
                                                                                                ingredient.image
                                                                                            "
                                                                                            class="avatar-sm rounded-circle"
                                                                                            alt="addtocart"
                                                                                        />
                                                                                    </div>
                                                                                    <div
                                                                                        class="menucart-text flex-grow-1 ms-2"
                                                                                    >
                                                                                        <div
                                                                                            class="flex-grow-1 ms-2"
                                                                                        >
                                                                                            <h5
                                                                                                class="card-title mb-1"
                                                                                            >
                                                                                                {{
                                                                                                    ingredient.name
                                                                                                }}
                                                                                            </h5>
                                                                                            <p
                                                                                                class="text-muted mb-0"
                                                                                            >
                                                                                                (+{{
                                                                                                    ingredient.price.toFixed(
                                                                                                        2
                                                                                                    )
                                                                                                }})
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>                                                                   
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!----- LARGE SCREEN OFFCANVAS END ------>
                                            <!-----TABLATE VIEW OFFCANVAS START------->
                                            <div
                                                class="tablate-view-offcanvas d-none"
                                            >
                                                <div class="offcanvas-header">
                                                    <h2 class="fs-4 text-dark">
                                                        {{ product.name }}
                                                    </h2>
                                                    <button
                                                        type="button"
                                                        class="btn-close text-reset fs-4"
                                                        data-bs-dismiss="offcanvas"
                                                        aria-label="Close"
                                                        @click="
                                                            addToCartLoader = false
                                                        "
                                                    ></button>
                                                </div>
                                                <div
                                                    class="select-items-cart text-center p-2"
                                                >
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div
                                                                class="items-cart-img"
                                                            >
                                                                <img
                                                                    :src="
                                                                        product.image
                                                                    "
                                                                    class="rounded-circle img-fluid" alt="addtocart"
                                                                />
                                                            </div>
                                                            <div
                                                                class="input-step items-cart-count w-50 justify-content-between border-0 bg-transparent mt-2"
                                                            >
                                                                <button
                                                                    type="button"
                                                                    class="minus bg-dark text-white fs-1 popup-minus"
                                                                    data-action="minus"
                                                                    @click="
                                                                        changePopupQuantity(
                                                                            $event
                                                                        )
                                                                    "
                                                                >
                                                                    –
                                                                </button>
                                                                <input
                                                                    type="number"
                                                                    class="product-quantity popupQuantity popup-number"
                                                                    id="popupQuantity"
                                                                    :value="
                                                                        popupQuantityValue
                                                                    "
                                                                    min="1"
                                                                    max="100"
                                                                />
                                                                <button
                                                                    type="button"
                                                                    class="plus bg-dark text-white fs-1 popup-plus"
                                                                    data-action="plus"
                                                                    @click="
                                                                        changePopupQuantity(
                                                                            $event
                                                                        )
                                                                    "
                                                                >
                                                                    +
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div
                                                                class="addtocart-details"
                                                            >
                                                                <div
                                                                    class="addtocart-heading text-start"
                                                                >
                                                                    <h4
                                                                        class="text-dark fs-5 mb-0"
                                                                    >
                                                                        Select
                                                                        Size
                                                                    </h4>
                                                                </div>
                                                                <div
                                                                    class="size-varient"
                                                                >
                                                                    <div
                                                                        class="card bg-transparent"
                                                                        style="
                                                                            box-shadow: none;
                                                                        "
                                                                    >
                                                                        <div
                                                                            class="card-body px-0"
                                                                        >
                                                                            <!-- Nav tabs -->
                                                                            <ul
                                                                                class="nav nav-pills nav-justified flex-wrap nav-success"
                                                                                role="tablist"
                                                                            >                                                                               
                                                                                <li
                                                                                    class="nav-item bg-light"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-bs-trigger="hover"
                                                                                    data-bs-placement="top"
                                                                                    title
                                                                                    data-bs-original-title="Home"
                                                                                    v-for="(
                                                                                        size,
                                                                                        index
                                                                                    ) in sizes"
                                                                                    :key="
                                                                                        size.id
                                                                                    "
                                                                                >
                                                                                    <a
                                                                                        :data-price="
                                                                                            size.price
                                                                                        "
                                                                                        :data-id="
                                                                                            size
                                                                                                .size
                                                                                                .id
                                                                                        "
                                                                                        class="nav-link size-selection"
                                                                                        :class="{
                                                                                            active:
                                                                                                index ===
                                                                                                0,
                                                                                        }"
                                                                                        data-bs-toggle="tab"
                                                                                        href="#toptab-dai20cm"
                                                                                        role="tab"
                                                                                        aria-selected="true"
                                                                                        @click="
                                                                                            this.$emit(
                                                                                                'selectSize',
                                                                                                size.price,
                                                                                                size
                                                                                                    .size
                                                                                                    .id,
                                                                                                size
                                                                                                    .size
                                                                                                    .name
                                                                                            )
                                                                                        "
                                                                                        >{{
                                                                                            size
                                                                                                .size
                                                                                                .name
                                                                                        }}</a
                                                                                    >
                                                                                </li>
                                                                            </ul>
                                                                            <!-- Tab panes -->
                                                                            <div
                                                                                class="tab-content text-muted"
                                                                            >
                                                                                <div
                                                                                    class="tab-pane active"
                                                                                    id="toptab-dai20cm"
                                                                                    role="tabpanel"
                                                                                >
                                                                                    <div
                                                                                        class="varient-list"
                                                                                    >
                                                                                        <ul
                                                                                            class="list-group list-group-flush mt-5"
                                                                                        >
                                                                                            <li
                                                                                                class="list-group-item bg-transparent text-left text-start border-0"
                                                                                            >
                                                                                                <i
                                                                                                    class="ri-checkbox-circle-fill text-success"
                                                                                                ></i>
                                                                                                <span
                                                                                                    class="fw-bold fs-5 px-2"
                                                                                                >
                                                                                                    Selected
                                                                                                    Size:
                                                                                                </span>
                                                                                                <p
                                                                                                    class="mb-0"
                                                                                                >
                                                                                                    {{
                                                                                                        selectSizes
                                                                                                    }}
                                                                                                </p>
                                                                                            </li>
                                                                                            <li
                                                                                                class="list-group-item bg-transparent text-left text-start border-0"
                                                                                            >
                                                                                                <i
                                                                                                    class="ri-checkbox-circle-fill text-success"
                                                                                                ></i>
                                                                                                <span
                                                                                                    class="fw-bold fs-5 px-2"
                                                                                                >
                                                                                                    Selected
                                                                                                    ingredients:
                                                                                                </span>
                                                                                                <p
                                                                                                    class="mb-0 overflow-auto"
                                                                                                    style="
                                                                                                        max-height: 58px;
                                                                                                    "
                                                                                                >
                                                                                                    {{
                                                                                                        this
                                                                                                            .selectIngredient
                                                                                                    }}
                                                                                                </p>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="tab-pane"
                                                                                    id="toptab-dai30cm"
                                                                                    role="tabpanel"
                                                                                >
                                                                                    <div
                                                                                        class="varient-list"
                                                                                    >
                                                                                        <ul
                                                                                            class="list-group list-group-flush mt-5"
                                                                                        >
                                                                                            <li
                                                                                                class="list-group-item bg-transparent text-left text-start border-0"
                                                                                            >
                                                                                                <i
                                                                                                    class="ri-checkbox-circle-fill text-success"
                                                                                                ></i>
                                                                                                <span
                                                                                                    class="fw-bold fs-5 px-2"
                                                                                                >
                                                                                                    Selected
                                                                                                    Size:
                                                                                                </span>
                                                                                                <p
                                                                                                    class="mb-0"
                                                                                                >
                                                                                                    Daimeter
                                                                                                    30cm
                                                                                                </p>
                                                                                            </li>
                                                                                            <li
                                                                                                class="list-group-item bg-transparent text-left text-start border-0"
                                                                                            >
                                                                                                <i
                                                                                                    class="ri-checkbox-circle-fill text-success"
                                                                                                ></i>
                                                                                                <span
                                                                                                    class="fw-bold fs-5 px-2"
                                                                                                >
                                                                                                    Selected
                                                                                                    ingredients:
                                                                                                </span>
                                                                                                <p
                                                                                                    class="mb-0"
                                                                                                >
                                                                                                    Mozzarella,
                                                                                                    spicy
                                                                                                    salami,
                                                                                                    tuna
                                                                                                </p>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="tab-pane"
                                                                                    id="toptab-dai50cm"
                                                                                    role="tabpanel"
                                                                                >
                                                                                    <div
                                                                                        class="varient-list"
                                                                                    >
                                                                                        <ul
                                                                                            class="list-group list-group-flush mt-5"
                                                                                        >
                                                                                            <li
                                                                                                class="list-group-item bg-transparent text-left text-start border-0"
                                                                                            >
                                                                                                <i
                                                                                                    class="ri-checkbox-circle-fill text-success"
                                                                                                ></i>
                                                                                                <span
                                                                                                    class="fw-bold fs-5 px-2"
                                                                                                >
                                                                                                    Selected
                                                                                                    Size:
                                                                                                </span>
                                                                                                <p
                                                                                                    class="mb-0"
                                                                                                >
                                                                                                    Daimeter
                                                                                                    50cm
                                                                                                </p>
                                                                                            </li>
                                                                                            <li
                                                                                                class="list-group-item bg-transparent text-left text-start border-0"
                                                                                            >
                                                                                                <i
                                                                                                    class="ri-checkbox-circle-fill text-success"
                                                                                                ></i>
                                                                                                <span
                                                                                                    class="fw-bold fs-5 px-2"
                                                                                                >
                                                                                                    Selected
                                                                                                    ingredients:
                                                                                                </span>
                                                                                                <p
                                                                                                    class="mb-0"
                                                                                                >
                                                                                                    Gorgonzola,
                                                                                                    mascarpone,
                                                                                                    mozzarella,
                                                                                                    spicy
                                                                                                    salami,
                                                                                                    tuna
                                                                                                </p>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- end card-body -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="select-ing">
                                                    <div
                                                        class="items-cart-heading mb-3"
                                                    >
                                                        <h2
                                                            class="fs-4 text-dark"
                                                        >
                                                            select ingredients
                                                        </h2>
                                                    </div>
                                                    <div
                                                        class="scrollbar px-2"
                                                        id="style-3"
                                                    >
                                                        <div
                                                            class="force-overflow mt-3"
                                                        >
                                                            <div
                                                                class="menu-cart-option"
                                                            >
                                                                <div
                                                                    class="diff-menucart"
                                                                    v-for="ingredientCategory in ingredientCategories"
                                                                    :key="
                                                                        ingredientCategory.id
                                                                    "
                                                                >
                                                                    <div
                                                                        class="small-title text-start"
                                                                    >
                                                                        <h4
                                                                            class="text-dark"
                                                                        >
                                                                            {{
                                                                                ingredientCategory.name
                                                                            }}
                                                                        </h4>
                                                                    </div>
                                                                    <div
                                                                        class="row"
                                                                    >
                                                                        <div
                                                                            class="col-4"
                                                                            v-for="ingredient in ingredientCategory.activeingredients"
                                                                            :key="
                                                                                ingredient.id
                                                                            "
                                                                        >
                                                                            <div
                                                                                :data-name="
                                                                                    ingredient.name
                                                                                "
                                                                                :data-price="
                                                                                    ingredient.price
                                                                                "
                                                                                :data-id="
                                                                                    ingredient.id
                                                                                "
                                                                                class="card card-body text-center ingredient-selection"
                                                                                @click="
                                                                                    ingredientSelection(
                                                                                        $event
                                                                                    )
                                                                                "
                                                                            >
                                                                                <div
                                                                                    class="flex-shrink-0"
                                                                                >
                                                                                    <img
                                                                                        :src="
                                                                                            'storage/' +
                                                                                            ingredient.image
                                                                                        "
                                                                                        class="avatar-sm rounded-circle" alt="addtocart"
                                                                                    />
                                                                                </div>
                                                                                <div
                                                                                    class="menucart-text flex-grow-1 ms-2"
                                                                                >
                                                                                    <div
                                                                                        class="flex-grow-1 ms-2"
                                                                                    >
                                                                                        <h5
                                                                                            class="card-title mb-1"
                                                                                        >
                                                                                            {{
                                                                                                ingredient.name
                                                                                            }}
                                                                                        </h5>
                                                                                        <p
                                                                                            class="text-muted mb-0"
                                                                                        >
                                                                                            (+{{
                                                                                                ingredient.price.toFixed(
                                                                                                    2
                                                                                                )
                                                                                            }})
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="addtocart-btn position-relative"
                                                >
                                                    <button
                                                        type="button"
                                                        class="btn btn-success waves-effect waves-light w-100"
                                                        @click="
                                                            AddToCart(
                                                                product.id
                                                            )
                                                        "
                                                    >
                                                        Add to Cart -
                                                        {{
                                                            this.popUpprice.toFixed(
                                                                2
                                                            )
                                                        }}
                                                        {{ currencyCode }}
                                                    </button>
                                                    <div
                                                        class="spinner-border text-light position-absolute addtocart-btn-spinner"
                                                        :id="
                                                            'loader_' +
                                                            product.id
                                                        "
                                                        role="status"
                                                        :class="{
                                                            'd-none':
                                                                !addToCartLoader,
                                                        }"
                                                    >
                                                        <span class="sr-only"
                                                            >Loading...</span
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                            <!------TABLATE VIEW OFFCANVAS END ------>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import $ from "jquery";
export default {
    name: "AddToCart",
    data() {
        return {};
    },
    props: {
        product: {
            type: Array,
        },
        sizes: {
            type: Array,
        },
        selectSizes: {
            type: String,
        },
        currencyCode: {
            type: String,
        },
        selectIngredient: {
            type: Array,
        },
        ingredientCategories: {
            type: Array,
        },
        popUpprice: {
            type: Number,
        },
        popupQuantityValue: {
            type: Number,
        },
        addToCartLoader: {
            type: Boolean,
        },
        addCartLoader: {
            type: Boolean,
        },
    },
    methods: {
        changePopupQuantity(event) {
            this.$emit("changePopupQuantity", event);
        },
        AddToCart(id) {
            $("#loader_" + id).removeClass("d-none");
            this.$emit("AddToCart");
        },
        ingredientSelection(event) {
            this.$emit("ingredientSelection", event);
        },
    },
};
$(document).on("click", ".offcanvas-backdrop", function () {
    $("#closeProductDetail").click();
});
</script>

<style scoped>
h5.card-title {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    word-break: break-word;
    min-height: 40px;
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

/* --------------------- CART OFFCANVAS START ------------------*/
.main-content .page-content .pos-main .cart-offcanvas .offcanvas-start {
    top: 118px;
    left: 0;
    width: 75%;
}

.main-content .pos-main .cart-offcanvas .menu-cart-option .diff-menucart .card {
    box-shadow: 0 0 10px -5px #333 !important;
    transition: all 0.5s ease;
    max-height: 140px;
}

.addtocart-btn-spinner {
    right: 10%;
    top: 20%;
    width: 1.5rem;
    height: 1.5rem;
}

.main-content .pos-main .cart-offcanvas .menu-cart-option .diff-menucart .card.active {
    background-color: #0ab39c;
}

.main-content .pos-main .cart-offcanvas .menu-cart-option .diff-menucart .card.active .card-title {
    color: #fff;
}

.main-content .pos-main .cart-offcanvas .menu-cart-option .diff-menucart .card.active p {
    color: #ffff !important;
}

.main-content .pos-main .cart-offcanvas .addtocart-details .size-varient a.nav-link {
    font-size: 13px;
    white-space: nowrap;
    padding: 5px;
    border-radius: 5px;
}

.main-content .pos-main .cart-offcanvas .addtocart-details .size-varient li.nav-item {
    background-color: #fff;
    border-radius: 5px;
    margin-right: 5px;
    margin-bottom: 10px;
}

.cart-offcanvas .select-items-cart .addtocart-details {
    height: 100%;
    max-height: 268px;
}

.main-content .pos-main .cart-offcanvas .scrollbar {
    background-color: #ffff;
    overflow-y: auto;
    margin-bottom: 25px;
    overflow-x: hidden;
}

.main-content .pos-main .cart-offcanvas .tablate-view-offcanvas .scrollbar {
    min-height: 520px;
}

.main-content .pos-main .cart-offcanvas .force-overflow {
    max-height: 666px;
    height: 100%;
}

.main-content .pos-main .pos-inner #style-3::-webkit-scrollbar-track {
    -webkit-box-shadw: inset 0 0 6px #0ab39c33;
    background-color: transparent;
}

.main-content .pos-main .pos-inner #style-3::-webkit-scrollbar {
    width: 3px;
    background-color: transparent;
}

.main-content .pos-main .pos-inner #style-3::-webkit-scrollbar-thumb {
    background-color: #0ab39c;
}

.main-content .page-content .pos-main .cart-offcanvas .items-cart-img img {
    width: 235px;
    height: 235px;
}

.cart-offcanvas .tablate-view-offcanvas .select-items-cart .addtocart-details {
    height: 100%;
    min-height: 302px !important;
}

/*****RESPONSIVE CSS********/
@media screen and (max-width: 1024px) {
    .cart-offcanvas .tablate-view-offcanvas {
        display: block !important;
    }
    .cart-offcanvas .large-screen-offcanvas {
        display: none;
    }
    .main-content .page-content .pos-main .cart-offcanvas .tablate-view-offcanvas .addtocart-heading {
        margin-top: 0 !important;
    }
    .main-content .pos-main .pos-inner .cart-offcanvas .tablate-view-offcanvas .force-overflow {
        max-height: calc(100vh - 522px) !important;
    }
    .main-content .page-content .pos-main .cart-offcanvas .tablate-view-offcanvas .items-cart-img img {
        width: 200px !important;
        height: 200px !important;
    }
}
@media screen and (max-width: 1280px) {
    .cart-offcanvas .select-items-cart .addtocart-details {
        max-height: 441px !important;
    }
}
@media screen and (max-width: 1024px) {
    .main-content .page-content .pos-main .cart-offcanvas .menu-cart-option .diff-menucart h5.card-title {
        font-size: 14px;
    }
    .main-content .page-content .pos-main .addtocart-details .list-group-item {
        padding: 10px 5px;
    }
}
@media screen and (min-width: 1025px) and (max-width: 1083px) {
    .main-content .page-content .pos-main .cart-offcanvas .addtocart-btn {
        margin-top: 70px !important;
    }
}
@media screen and (max-width: 1399px) {
    .main-content .page-content .pos-main .cart-offcanvas .items-cart-img img {
        width: 150px !important;
        height: 150px !important;
    }
    .main-content .page-content .pos-main .cart-offcanvas .items-cart-img {
        margin: 0px !important;
    }
    .main-content .page-content .pos-main .cart-offcanvas .addtocart-heading {
        margin-top: 20px !important;
    }
    .main-content .page-content .pos-main .cart-offcanvas .offcanvas-start {
        top: 70px;
        height: calc(100% - 70px);
    }
    .main-content .page-content .pos-main .cart-offcanvas .list-group {
        margin-top: 20px !important;
    }
}
@media screen and (max-width: 1180px) {
   .cart-offcanvas .select-items-cart .addtocart-details {
        height: 100%;
        max-height: 320px !important;
    }

    .main-content .pos-main .cart-offcanvas .force-overflow {
        max-height: 518px;
    }
}
@media screen and (max-width: 820px) {
    .main-content .pos-main .pos-inner .cart-offcanvas .tablate-view-offcanvas .force-overflow {
        max-height: calc(100vh - 650px) !important;
    }

    .cart-offcanvas .select-items-cart .addtocart-details {
        height: 100%;
        max-height: 665px !important;
    }
}
</style>
