import { createWebHistory, createRouter } from 'vue-router'
import Login from './components/Login.vue'
import LockScreen from './components/LockScreen.vue'
import Index from './components/Index.vue'
import Pos from './components/Pos.vue'
import Category from './components/Category.vue'
import subCategory from './components/subCategory.vue'
import Product from './components/Product.vue'
import ProductAdd from './components/ProductAdd.vue'
import ProductEdit from './components/ProductEdit.vue'
import IngredientCategory from './components/IngredientCategory.vue'
import Combo from './components/Combo.vue'
import AddCombo from './components/AddCombo.vue'
import EditCombo from './components/EditCombo.vue'
import Ingredient from './components/Ingredient.vue'
import UserManagement from './components/UserManagement.vue'
import Orders from './components/Orders.vue'
import Table from './components/Table.vue'
import Setting from './components/Setting.vue'
import GeneralSetting from './components/include/GeneralSetting.vue'
import CurrencySetting from './components/include/CurrencySetting.vue'
import TaxSetting from './components/include/TaxSetting.vue'
import CompleteOrder from './components/CompleteOrder.vue'

const routes = [
    {
        name : 'Login',
        path : '/login',
        component : Login,
        beforeEnter: (to, from, next) => {
            requireNotLogin(to, from, next, 'Login');
        }
    },
    {
        name : 'LockScreen',
        path : '/lock',
        component : LockScreen,
    },
    {
        name : 'Index',
        path : '/',
        component : Index,
        beforeEnter: (to, from, next) => {
            requireLogin(to, from, next, 'Index');
        }
    },
    {
        name : 'Pos',
        path : '/pos',
        component : Pos,
        beforeEnter: (to, from, next) => {
            requireLogin(to, from, next, 'Pos');
        }
    },
    {
        name : 'Category',
        path : '/category',
        component : Category,
        beforeEnter: (to, from, next) => {
            requireLogin(to, from, next, 'Category');
        }
    },
    {
        name : 'subCategory',
        path : '/sub-category',
        component : subCategory,
        beforeEnter: (to, from, next) => {
            requireLogin(to, from, next, 'subCategory');
        }
    },
    {
        name : 'Product',
        path : '/products/:slug',
        component : Product,
        props: true,
        beforeEnter: (to, from, next) => {
            requireLogin(to, from, next, 'Product');
        }
    },
    {
        name : 'Products',
        path : '/products',
        component : Product,
        props: true,
        beforeEnter: (to, from, next) => {
            requireLogin(to, from, next, 'Product');
        }
    },
    {
        name : 'ProductAdd',
        path : '/products/:slug/add',
        component : ProductAdd,
        props: true,
        beforeEnter: (to, from, next) => {
            requireLogin(to, from, next, 'ProductAdd');
        }
    },
    {
        name : 'AddProduct',
        path : '/add/product',
        component : ProductAdd,
        props: true,
        beforeEnter: (to, from, next) => {
            requireLogin(to, from, next, 'ProductAdd');
        }
    },
    {
        name : 'ProductEdit',
        path : '/products/:catslug/edit/:slug',
        component : ProductEdit,
        props: true,
        beforeEnter: (to, from, next) => {
            requireLogin(to, from, next, 'ProductEdit');
        }
    },
    {
        name : 'EditProduct',
        path : '/products/edit/:slug',
        component : ProductEdit,
        props: true,
        beforeEnter: (to, from, next) => {
            requireLogin(to, from, next, 'ProductEdit');
        }
    },
    {
        name : 'IngredientCategory',
        path : '/ingredient-category',
        component : IngredientCategory,
        beforeEnter: (to, from, next) => {
            requireLogin(to, from, next, 'IngredientCategory');
        }
    },
    {
        name : 'Combo',
        path : '/combo',
        component : Combo,
        beforeEnter: (to, from, next) => {
            requireLogin(to, from, next, 'Combo');
        }
    },
    {
        name : 'AddCombo',
        path : '/combo/add',
        component : AddCombo,
        beforeEnter: (to, from, next) => {
            requireLogin(to, from, next, 'ComboAdd');
        }
    },
    {
        name : 'EditCombo',
        path : '/combo/edit/:slug',
        component : EditCombo,
        beforeEnter: (to, from, next) => {
            requireLogin(to, from, next, 'ComboEdit');
        }
    },
    {
        name : 'Ingredient',
        path : '/ingredient/:slug',
        component : Ingredient,
        props: true,
        beforeEnter: (to, from, next) => {
            requireLogin(to, from, next, 'Ingredient');
        }
    },
    {
        name : 'Orders',
        path : '/orders',
        component : Orders,
        beforeEnter: (to, from, next) => {
            requireLogin(to, from, next, 'Orders');
        }
    },
    {
        name : 'Table',
        path : '/table',
        component : Table,
        beforeEnter: (to, from, next) => {
            requireLogin(to, from, next, 'Table');
        }
    },
    {
        name : 'CompleteOrder',
        path : '/complete-order',
        component : CompleteOrder,
        beforeEnter: (to, from, next) => {
            requireLogin(to, from, next, 'CompleteOrder');
        }
    },
    {
        path: "/setting",
        name: "Setting",
        component: Setting,
        beforeEnter: (to, from, next) => {
            requireLogin(to, from, next, 'Setting');
        },
        children: [
          {
            name: "GeneralSetting",
            path: "",
            component: GeneralSetting,
            beforeEnter: (to, from, next) => {
                requireLogin(to, from, next, 'Setting');
            },
          },
          {
            name: "CurrencySetting",
            path: "currency",
            component: CurrencySetting,
            beforeEnter: (to, from, next) => {
                requireLogin(to, from, next, 'Setting');
            },
          },
          {
            name: "TaxSetting",
            path: "taxes",
            component: TaxSetting,
            beforeEnter: (to, from, next) => {
                requireLogin(to, from, next, 'Setting');
            },
          },
          {
              name : 'UserManagement',
              path : 'user-management',
              component : UserManagement,
              beforeEnter: (to, from, next) => {
                  requireLogin(to, from, next, 'UserManagement');
              }
          },
        ],
    },
]

const router = createRouter({
    history:createWebHistory(),
    routes
});

function requireLogin(to, from, next, page) {
    axios.get(`/api/checklogin/${page}`)
    .then(res => {
        if(res.data.lock){
            window.location.href = '/lock';
        }else{
            if(res.data.success){
                next(true);
            }else{
                window.location.href = '/pos';
            }
        }
    }).catch(err => {
        // next(Login);
        // this.$router.push('Login')
        if(err.response.status == 401){
            window.location.href = '/login';
        }
    })
}

function requireNotLogin(to, from, next) {
    axios.get('/api/checknotlogin')
    .then(res => {
        next(true);
    }).catch(err => {
        if(err.response.status == 401){
            if(err.response.data.indexper){
                window.location.href = '/';
            }else{
                window.location.href = '/pos';
            }
        }
    })
}

// function checkSubAdmin(to, from, next) {
//     axios.get('/api/checksubmin')
//     .then(res => {
//         next(true);
//     }).catch(err => {
//         window.location.href = '/';
//     })
// }

// function checkKitchenManager(to, from, next) {
//     axios.get('/api/checklitchenmanager')
//     .then(res => {
//         next(true);
//     }).catch(err => {
//         window.location.href = '/';
//     })
// }

// function checkWaiter(to, from, next) {
//     axios.get('/api/checkwaiter')
//     .then(res => {
//         next(true);
//     }).catch(err => {
//         window.location.href = '/';
//     })
// }

export default router;

