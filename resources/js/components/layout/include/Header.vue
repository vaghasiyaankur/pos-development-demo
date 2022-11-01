<template>
  <header id="page-topbar">
    <div class="navbar-header">
      <div class="d-flex align-items-center">
        <!-- LOGO -->
        <div class="navbar-brand-box horizontal-logo page-header-user-div">
          <router-link href="javascript:;" to="/" class="logo logo-dark">
            <span class="logo-sm">
              <img
                :src="image_url"
                alt="logo"
                class="logo_image"
              />
            </span>
            <span class="logo-lg">
              <img
                :src="image_url"
                alt="logo"
                class="logo_image"
              />
            </span>
          </router-link>

          <router-link href="javascript:;" to="/" class="logo logo-light">
            <span class="logo-sm">
              <img
                :src="image_url"
                alt="logo"
                class="logo_image"
              />
            </span>
            <span class="logo-lg">
              <img
                :src="image_url"
                alt="logo"
                class="logo_image"
              />
            </span>
          </router-link>
        </div>

        <button
          type="button"
          class="
            btn btn-sm
            px-3
            fs-16
            header-item
            vertical-menu-btn
            topnav-hamburger"
          id="topnav-hamburger-icon" @click="bodyAddClass()"
        >
          <span class="hamburger-icon">
            <span></span>
            <span></span>
            <span></span>
          </span>
        </button>
        <!-- ========== App Menu ========== -->
      <div class="app-menu navbar-menu">
        <!-- LOGO -->
        <div class="navbar-brand-box">
          <!-- Dark Logo-->
          <router-link href="javascript:;" to="/" class="logo logo-dark">
            <span class="logo-sm">
              <img
                src="/assets/images/logo-sm.png"
                alt="logo"
                class="logo_image"
              />
            </span>
            <span class="logo-lg">
              <img
                src="/assets/images/logo-dark.png"
                alt="logo"
                class="logo_image"
              />
            </span>
          </router-link>
          <!-- Light Logo-->
          <router-link href="javascript:;" to="/" class="logo logo-light">
            <span class="logo-sm">
              <img
                src="/assets/images/logo-sm.png"
                 alt="logo"
                class="logo_image"
              />
            </span>
            <span class="logo-lg">
              <img
                src="/assets/images/logo-light.png"
                 alt="logo"
                class="logo_image"
              />
            </span>
          </router-link>
          <button
            type="button"
            class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover"
          >
            <i class="ri-record-circle-line"></i>
          </button>
        </div>

        <div id="scrollbar">
          <div class="container-fluid m-0 ps-2">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
              <li class="nav-item">
                <router-link class="nav-link menu-link small--size--navlink" :class="this.$route.name == 'Index' ? 'text-success' : ''" href="javascript:;" to="/"> <span data-key="t-dashboards">Dashboards</span></router-link>
              </li>
              <!-- end Dashboard Menu -->
              <li class="nav-item">
                <router-link class="nav-link menu-link small--size--navlink" :class="this.$route.name == 'Pos' ? 'text-success' : ''" href="javascript:;" to="/pos"> <span data-key="t-apps">POS</span></router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link menu-link small--size--navlink" :class="this.$route.name == 'Orders' ? 'text-success' : ''" href="javascript:;" to="/orders">

                  <span data-key="t-landing">Orders</span>
                </router-link>
              </li>
              <li class="nav-item menumanagement--header" :class="{'d-none' : type == 'Kitchen Manager' || type == 'Waiter'}" >
                <a
                  class="nav-link menu-link collapse--class menu--management--toggle" href="javascript:;"
                  :class="this.$route.name == 'Category'|| this.$route.name == 'subCategory' || this.$route.name == 'Product' || this.$route.name == 'Products' || this.$route.name == 'ProductAdd' || this.$route.name == 'ProductEdit' || this.$route.name == 'EditProduct'  || this.$route.name == 'IngredientCategory'  || this.$route.name == 'Combo' || this.$route.name == 'AddCombo' || this.$route.name == 'EditCombo'  || this.$route.name == 'Ingredient' ? 'text-success' : ''"
                  data-bs-toggle="collapse"
                  role="button"
                  aria-expanded="false"
                  aria-controls="sidebarLayouts"
                >
                  <span data-key="t-layouts">Menu Management</span>
                </a>
                <div class="menu-dropdown block--show" id="menumanagement--div">
                  <ul class="nav nav-sm flex-column">
                    <li class="nav-item" >
                      <router-link class="nav-link menu-link small--size--navlink" :class="this.$route.name == 'Category' || this.$route.name == 'subCategory' ? 'text-success' : ''" to="/category"> <span data-key="t-category-management">Category</span></router-link>
                    </li>
                    <li class="nav-item" >
                      <router-link class="nav-link menu-link small--size--navlink" :class="this.$route.name == 'IngredientCategory' || this.$route.name == 'Ingredient' ? 'text-success' : ''" to="/ingredient-category"> <span data-key="t-dashboards">Ingredient</span></router-link>
                    </li>
                    <li class="nav-item" >
                      <router-link class="nav-link menu-link small--size--navlink" :class="this.$route.name == 'Combo' || this.$route.name == 'AddCombo' || this.$route.name == 'EditCombo' ? 'text-success' : ''" to="/combo"> <span data-key="t-dashboards">Combo</span></router-link>
                    </li>
                    <li class="nav-item" >
                      <router-link class="nav-link menu-link small--size--navlink" :class="this.$route.name == 'Product' || this.$route.name == 'Products' || this.$route.name == 'ProductAdd' || this.$route.name == 'ProductEdit' || this.$route.name == 'EditProduct' ? 'text-success' : ''"  to="/products"> <span data-key="t-dashboards">Product</span></router-link>
                    </li>
                  </ul>
                </div>
              </li>
              <!-- <li class="menu-title" v-if="permissions.Orders">
                <a class="nav-link menu-link collapse--class" href="#">

                  <span data-key="t-pages">Orders</span>
                </a>
              </li> -->
              <!-- <li class="nav-item" :class="{'d-none' : type == 'Super Admin' || type ==  'Sub Admin' }" >
                <router-link class="nav-link menu-link small--size--navlink" :class="this.$route.name == 'Category' || this.$route.name == 'subCategory' ? 'text-success' : ''" to="/category"> <span data-key="t-category-management">Category</span></router-link>
              </li>
              <li class="nav-item" :class="{'d-none' : type == 'Super Admin' || type == 'Sub Admin' }" >
                <router-link class="nav-link menu-link small--size--navlink" :class="this.$route.name == 'IngredientCategory' || this.$route.name == 'Ingredient' ? 'text-success' : ''" to="/ingredient-category"> <span data-key="t-dashboards">Ingredient</span></router-link>
              </li>
              <li class="nav-item" :class="{'d-none' : type == 'Super Admin' || type == 'Sub Admin' }" >
                <router-link class="nav-link menu-link small--size--navlink" :class="this.$route.name == 'Combo' || this.$route.name == 'AddCombo' || this.$route.name == 'EditCombo' ? 'text-success' : ''" to="/combo"> <span data-key="t-dashboards">Combo</span></router-link>
              </li>
              <li class="nav-item" :class="{'d-none' : type == 'Super Admin' || type == 'Sub Admin' }" >
                <router-link class="nav-link menu-link small--size--navlink" :class="this.$route.name == 'Product' || this.$route.name == 'Products' || this.$route.name == 'ProductAdd' || this.$route.name == 'ProductEdit' || this.$route.name == 'EditProduct' ? 'text-success' : ''"  to="/products"> <span data-key="t-dashboards">Product</span></router-link>
              </li> -->


              <li class="nav-item" >
              <router-link class="nav-link menu-link small--size--navlink" href="javascript:;" :class="this.$route.name == 'Table' ? 'text-success' : ''"  to="/table"> <span data-key="t-pages">Floorplan</span></router-link>
              </li>

              <!-- <li class="nav-item" v-if="permissions.UserManagement">
              <router-link class="nav-link menu-link small--size--navlink" href="javascript:;" to="/user-management">  <span data-key="t-apps">User Management</span></router-link>
              </li> -->
              <!-- <li class="nav-item" >
                <a class="nav-link menu-link small--size--navlink" :class="this.$route.name == 'Reports' ? 'text-success' : ''"  href="javascript:;">
                  <span data-key="t-landing">Reports</span>
                </a>
              </li> -->
              <li class="nav-item" >
                <router-link class="nav-link menu-link small--size--navlink" :class="this.$route.name == 'CompleteOrder' ? 'text-success' : ''" to="/complete-order"> <span data-key="t-dashboards">Complete order</span></router-link>
              </li>
              <li class="nav-item" >
                <router-link class="nav-link menu-link small--size--navlink" href="javascript:;" :class="this.$route.name == 'Setting' || this.$route.name == 'GeneralSetting'|| this.$route.name == 'CurrencySetting' || this.$route.name == 'TaxSetting' || this.$route.name == 'UserManagement' ? 'text-success' : ''" to="/setting">

                  <span data-key="t-landing">Setting</span>
                </router-link>
              </li>
            </ul>
          </div>
          <!-- Sidebar -->
        </div>
      </div>
      </div>

      <div class="d-flex align-items-center">

        <div class="dropdown ms-sm-3 header-item page-header-user-div">
          <router-link href="javascript:;" style="line-height:0;" to="/lock" @click="lockScreenEnable()">
            <i class="bx bx-power-off text-danger" style="font-size:30px; line-height:36px;"></i>
          </router-link>
          <button
            type="button"
            class="btn"
            id="page-header-user-dropdown"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
            @click="profileShowHide($event)"
          >
            <span class="d-flex align-items-center">
              <img
                class="rounded-circle header-profile-user"
                :src="'/storage/user/super_admin.jpg'"
                alt="Header Avatar"
              />
              <span class="text-start ms-xl-2">
                <span
                  class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"
                  >{{ name }}</span
                >
                <span
                  class="
                    d-none d-xl-block
                    ms-1
                    fs-12
                    text-muted
                    user-name-sub-text
                  "
                  >{{ type }}</span
                >
              </span>
            </span>
          </button>
          <div class="dropdown-menu dropdown-menu-end" id="profile-drop-down">
            <!-- item-->
            <h6 class="dropdown-header">Welcome {{ name }}!</h6>
            <!-- <a class="dropdown-item" href="javascript:;"
              ><i
                class="
                  mdi mdi-account-circle
                  text-muted
                  fs-16
                  align-middle
                  me-1
                "
              ></i>
              <span class="align-middle">Profile</span></a
            > -->
            <a class="dropdown-item" href="/logout"
              ><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
              <span class="align-middle" data-key="t-logout">Logout</span></a
            >
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- ========== App Menu ========== -->
  <div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
      <!-- Dark Logo-->
      <router-link href="javascript:;" to="/" class="logo logo-dark">
        <span class="logo-sm">
          <img
            src="/assets/images/logo-sm.png"
             alt="logo"
            height="22"
          />
        </span>
        <span class="logo-lg">
          <img
            src="/assets/images/logo-dark.png"
             alt="logo"
            height="17"
          />
        </span>
      </router-link>
      <!-- Light Logo-->
      <router-link href="javascript:;" to="/" class="logo logo-light">
        <span class="logo-sm">
          <img
            src="/assets/images/logo-sm.png"
             alt="logo"
            height="22"
          />
        </span>
        <span class="logo-lg">
          <img
            src="/assets/images/logo-light.png"
             alt="logo"
            height="17"
          />
        </span>
      </router-link>
      <button
        type="button"
        class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
        id="vertical-hover"
      >
        <i class="ri-record-circle-line"></i>
      </button>
    </div>

    <div id="scrollbar">
      <div class="container-fluid m-0 ps-2">
        <div id="two-column-menu"></div>
        <ul class="navbar-nav" id="navbar-nav">
          <li class="nav-item">
            <router-link class="nav-link menu-link small--size--navlink" :class="this.$route.name == 'Index' ? 'text-success' : ''" href="javascript:;" to="/"> <span data-key="t-dashboards">Dashboards</span></router-link>
          </li>
          <!-- end Dashboard Menu -->
          <li class="nav-item" v-if="permissions.Pos">
            <router-link class="nav-link menu-link small--size--navlink" href="javascript:;" to="/pos"> <span data-key="t-apps">POS</span></router-link>
          </li>
          <li class="nav-item" v-if="permissions.Category || permissions.Ingredient || permissions.Combo || permissions.ProductAdd">
            <a
              class="nav-link menu-link collapse--class" href="javascript:;"
              data-bs-toggle="collapse"
              role="button"
              aria-expanded="false"
              aria-controls="sidebarLayouts"
            >
              <i class="ri-layout-3-line"></i>
              <span data-key="t-layouts">Menu Management</span>
            </a>
            <div class="menu-dropdown" id="sidebarLayouts" :class="{'d-none' : addMenu }">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item" v-if="permissions.Category" @click="addMenu = true;addMenuChange()">
                  <router-link class="nav-link menu-link small--size--navlink" to="/category"> <span data-key="t-category-management">Category</span></router-link>
                </li>
                <li class="nav-item" v-if="permissions.IngredientCategory" @click="addMenu = true;addMenuChange()">
                   <router-link class="nav-link menu-link small--size--navlink" to="/ingredient-category"> <span data-key="t-dashboards">Ingredient</span></router-link>
                </li>
                <li class="nav-item" v-if="permissions.Combo" @click="addMenu = true;addMenuChange()">
                   <router-link class="nav-link menu-link small--size--navlink" to="/combo"> <span data-key="t-dashboards">Combo</span></router-link>
                </li>
                <li class="nav-item" v-if="permissions.Product" @click="addMenu = true;addMenuChange()">
                   <router-link class="nav-link menu-link small--size--navlink" to="/products"> <span data-key="t-dashboards">Product</span></router-link>
                </li>
              </ul>
            </div>
          </li>
          <li class="menu-title">
            <a class="nav-link menu-link collapse--class" href="#">

              <span data-key="t-pages">Orders</span>
            </a>
          </li>
          <li class="nav-item" v-if="permissions.Setting">
             <router-link class="nav-link menu-link small--size--navlink" href="javascript:;" to="/setting">

              <span data-key="t-landing">Setting</span>
            </router-link>
          </li>
        </ul>
      </div>
      <!-- Sidebar -->
    </div>
  </div>
  <div id="preloader" class="preloader on">
    <div class="black_wall"></div>
    <div class="loader"></div>
  </div>
</template>

<script>
  import $ from "jquery";
export default {
  name: "Header",
  data(){
      return{
          permissions : {
            Login : 0,
            Index : 0,
            Pos : 0,
            Category : 0,
            subCategory : 0,
            Product : 0,
            ProductAdd : 0,
            ProductAdd : 0,
            ProductEdit : 0,
            IngredientCategory : 0,
            Combo : 0,
            Ingredient : 0,
            UserManagement : 0,
            Orders : 0,
            Table : 0,
            Setting : 0,
          },
          name: '',
          type: '',
          photo: '',
          addMenu : false,
          MenuManagement : false
      }
  },
  props : {
    image_url: String
  },
  created() {
      // axios.get('/api/checkheaderpermission')
      // .then(res => {
      // this.permissions = res.data.permissions;
      // }).catch(err => {
      // })

      // axios.get('/api/getuserdata')
      // .then(res => {
      // this.name = res.data.name;

      // if(res.data.type == 'super_admin')
      // this.type = 'Super Admin';
      // else if(res.data.type == 'sub_admin')
      // this.type = 'Sub Admin';
      // else if(res.data.type == 'kitchen_manager')
      // this.type = 'Kitchen Manager';
      // else if(res.data.type == 'waiter')
      // this.type = 'Waiter';

      // this.photo = `/storage/` + res.data.photo;

      // }).catch(err => {
      // });
  },
  methods:{
    addMenuChange(){
        this.addMenu = false;
    },
    /* Lock Screen Enable for backend side */
    lockScreenEnable(){
        const config = {
            headers: { 'content-type': 'multipart/form-data' }
        }
        axios.post('/api/lockenabledisable',{lock : 1},config)
        .then(res => {
        }).catch(err => {
        })
    },
    /* Profile Show and hide */
    profileShowHide(event){
      var element = document.getElementById("profile-drop-down");
      element.classList.toggle("show");
    },
    /* Body Toggle Class for small view */
    bodyAddClass(){
      document.querySelector("body").classList.toggle("menu");
    }
  }
}
</script>

<style scoped>

/***********CSS FOR HEADER ************/
.logo_image{
    height: 100%;
    max-height: 50px;
    width: 100%;
    max-width: 50px;
}
[data-layout=horizontal] .navbar-menu {
    background: transparent;
    padding: 0 calc(1.5rem / 2);
    -webkit-box-shadow: none;
    box-shadow: none;
    margin-top: 12px;
    position: fixed;
    left: 0;
    right: 0;
    z-index: 100;
    width: 100%;
    bottom: auto;
  }
  [data-layout=horizontal] .navbar-menu .navbar-nav{
    justify-content: center;
  }
  [data-layout=horizontal] .container-fluid, [data-layout=horizontal] .layout-width{
    max-width: 100%;
  }
  @media screen and (max-width:1024px){
    [data-layout=horizontal] .navbar-menu {
    background: var(--vz-topnav-bg);
    padding: 0 calc(1.5rem / 2);
    -webkit-box-shadow: 0 2px 4px rgb(15 34 58 / 12%);
    box-shadow: 0 2px 4px rgb(15 34 58 / 12%);
    margin-top: 70px;
    }
    [data-layout=horizontal] .menu .navbar-menu {
    display: block;
    /*min-height:226px;*/
    max-height: 315px;
    overflow-y: auto;
    padding-left: 0;
    }
  }

/*************CSS for loader ************/
/**********1********/

#preloader{
  position:fixed;
  top:71px !important;
  right:0;
  bottom:0;
  left:0;
  background-color: #FFFCFC;
  transform-origin:bottom;
  z-index:11111;
  }
  .preloader .black_wall{
    height:100%;
    background-color: var(--vz-body-bg);
    transform-origin:top;
    animation:preloader_slide 0.5s ease-in-out 0s 1 normal both
    }
    .preloader .loader{
      width:100%;
      height:1px;
      position:absolute;
      border-radius:2px;
      top:0;
      right:0;
      left:0;
      margin:auto;
      background-color: #0ab39c;
      border: 1px solid #0ab39c;
      transform-origin:left;
      animation:loader_running 3s ease-in-out 1s infinite normal both
      }
      .preloader.off{
        animation:preloader_slide 0.5s ease-in-out 0s 1 reverse both
        }
        @keyframes loader_running{
          0%{
            transform:scaleX(0);transform-origin:left
          }
          49%{
            transform:scaleX(1);transform-origin:left
            }
            50%{
              transform:scaleX(1);transform-origin:right
              }
              100%{
                transform-origin:right;transform:scaleX(0)
                }
        }
        @keyframes preloader_slide{
          from{
            transform:scaleY(0)
            }
            to{
              transform:scaleY(1)
              }
        }
div#scrollbar .nav-item a.nav-link {
    white-space: nowrap;
    font-size:14px ;
    padding: 0.75rem 1rem ;
}
@media screen and (max-width:1180px){
 div#scrollbar .nav-item a.nav-link {
      font-size:14px ;
      padding: 0.75rem;
}
}
@media screen and (max-width:820px){
#preloader {
    top:70px !important;
}
}
.navbar-menu .navbar-nav>.nav-item>.nav-link[data-bs-toggle=collapse]:after{
  content: '';
}
.page-header-user-div{
  z-index: 999999;
}
</style>
