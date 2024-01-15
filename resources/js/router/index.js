import {createRouter, createWebHistory} from "vue-router";
import HomeView from "../views/HomeView.vue";
import store from "@/store";
import axios from "axios";
import PublicLayout from "@/layout/PublicLayout.vue";
import AdminLayout from "@/layout/AdminLayout.vue";

function isAuthentickedAdmin(to) {
    setLayout(to.meta.layout);
    let token = localStorage.getItem('token');
    if (token) {
        axios.get('auth/user-profile', {
            headers: {
                Authorization: 'Bearer ' + token
            }
        }).then((res) => {
            if (res.data.type !== 'admin') {
                router.push('/');
            }
        }).catch((e) => {
            store.dispatch('removeUser', 0);
            store.dispatch('removeToken', 0);
        });
    } else {
        router.push('/login')
    }
}

function setLayout(param) {
    store.dispatch('setLayout', param);
}

const isAuthenticatedUser = (to) => {
    setLayout(to.meta.layout);
    let token = localStorage.getItem('token');
    if (token) {
        axios.get('auth/user-profile', {
            headers: {
                Authorization: 'Bearer ' + token
            }
        }).then((res) => {
            next();
        }).catch((e) => {
            // router.push('/login');
            // store.dispatch('removeUser', 0);
            // store.dispatch('removeToken', 0);
        })
    } else {
        router.push('/login')
    }
}


const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: PublicLayout,
            children: [
                {
                    path: '',
                    name: 'home',
                    component: HomeView,
                },
                {
                    path: "/register",
                    name: "Register",
                    meta: {layout: 'LayoutPublic'},
                    component: () => import("../views/RegisterView.vue")
                },
                {
                    path: "/home-logged-in",
                    name: "logged-in",
                    meta: {layout: 'LayoutPublic'},
                    component: () => import("../views/HomeLoggedInView.vue"),
                    beforeEnter: (to, from) => {
                        isAuthenticatedUser(to);
                    },
                },
                {
                    path: "/contact",
                    name: "contact",
                    meta: {layout: 'LayoutPublic'},
                    component: () => import("../views/ContactView.vue"),
                    beforeEnter: (to, from) => {
                        isAuthenticatedUser(to);
                    },
                },
                {
                    path: "/blogs",
                    name: "posts",
                    meta: {layout: 'LayoutPublic'},
                    component: () => import("../views/PublicPosts.vue"),
                    beforeEnter: (to, from) => {
                        isAuthenticatedUser(to);
                    },
                },
                {
                    path: "/blog/:slug",
                    name: "single-post",
                    meta: {layout: 'LayoutPublic'},
                    component: () => import("../views/PostView.vue"),
                    beforeEnter: (to, from) => {
                        isAuthenticatedUser(to);
                    },
                },
                {
                    path: "/order-list",
                    name: "OrderList",
                    component: () => import("../views/HomeLoggedInView.vue"),
                    meta: {requiresAuth: true, layout: 'LayoutPublic'},
                    beforeEnter: (to, from) => {
                        isAuthenticatedUser(to);
                    },
                },
                {
                    path: "/login",
                    name: "Login",
                    meta: {layout: 'LayoutPublic'},
                    beforeEnter: (to, from) => {
                        // isAuthenticatedUser(to);
                        console.log(to)
                    },
                    component: () => import("../views/LoginView.vue")
                },
                {
                    name: "Shop",
                    path: "/shop",
                    meta: {layout: 'LayoutPublic'},
                    component: () => import("../views/Shop.vue"),
                    beforeEnter: (to, from) => {
                        isAuthenticatedUser(to);
                    },
                },
                {
                    name: "ProfilePage",
                    path: "/profile",
                    meta: {layout: 'LayoutPublic'},
                    component: () => import("../views/ProfileView.vue"),
                    beforeEnter: (to, from) => {
                        isAuthenticatedUser(to);
                    },
                },
                {
                    name: "product-single",
                    path: "/product/:slug",
                    meta: {layout: 'LayoutPublic'},
                    component: () => import("../views/ProductSingle.vue"),
                    beforeEnter: (to, from) => {
                        isAuthenticatedUser(to);
                    },
                },
                {
                    name: "NotFound",
                    path: "/:pathMatch(.*)*",
                    meta: {layout: 'LayoutPublic'},
                    component: () => import("../views/NotFound.vue")
                }
            ]
        },
        {
            path: '/admin',
            component: AdminLayout,
            children: [
                {
                    name: "Variants",
                    path: "/admin/variants",
                    component: () => import("../views/VariantsView.vue"),
                    beforeEnter: (to, from) => {
                        isAuthentickedAdmin(to);
                    },
                },
                {
                    name: "Admin",
                    path: "/admin",
                    component: () => import("../views/Admin.vue"),
                    beforeEnter: (to, from) => {
                        isAuthentickedAdmin(to);
                    },
                },
                {
                    name: "Posts",
                    path: "/admin/posts",
                    component: () => import("../views/PostsList.vue"),
                    beforeEnter: (to, from) => {
                        isAuthentickedAdmin(to);
                    },
                },
                {
                    name: "ProductList",
                    path: "/admin/products",
                    component: () => import("../views/ProductList.vue"),
                    beforeEnter: (to, from) => {
                        isAuthentickedAdmin(to);
                    },
                },
                {
                    name: "CategoriesList",
                    path: "/admin/category",
                    component: () => import("../views/CategoryView.vue"),
                    beforeEnter: (to, from) => {
                        isAuthentickedAdmin(to);
                    },
                },
                {
                    name: "BrandsList",
                    path: "/admin/brands",
                    component: () => import("../views/BrandsView.vue"),
                    beforeEnter: (to, from) => {
                        isAuthentickedAdmin(to);
                    },
                },
                {
                    name: "SizeList",
                    path: "/admin/sizes",
                    component: () => import("../views/SizeView.vue"),
                    beforeEnter: (to, from) => {
                        isAuthentickedAdmin(to);
                    },
                },
                {
                    name: "Orders",
                    path: "/admin/orders",
                    component: () => import("../views/Orders.vue"),
                    beforeEnter: (to, from) => {
                        isAuthentickedAdmin(to);
                    },
                },
            ]
        }
    ]
});

export default router;

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.name === 'Login') || to.matched.some((record) => record.name === 'Register')) {
        if (store.state.token) {
            return router.push('/')
        }
    }
    next();
})


