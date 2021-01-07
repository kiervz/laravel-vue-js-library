window.Vue = require('vue');

import VueRouter from 'vue-router';

Vue.use(VueRouter);

const routes = [
    { path: '/dashboard', name: 'Dashboard', component: require('../components/Pages/Dashboard.vue').default, meta: { requiresAuth: true } },
    { path: '/login', name: 'Login', component: require('../components/Auth/Login.vue').default },
    { path: '/logout', name: 'Logout', component: require('../components/Auth/Logout.vue').default, meta: { requiresAuth: true } },
    { path: '/register', name: 'Register', component: require('../components/Auth/Register.vue').default },
    { path: '/book', name: 'Book', component: require('../components/Pages/Book/Book.vue').default, meta: { requiresAuth: true } },
    { path: '/book-category', name: 'BookCategory', component: require('../components/Pages/Book/BookCategory.vue').default, meta: { requiresAuth: { user_type: 'Administrator', redirect: { name: 'login'}, forbiddenRedirect: '/403' }, } },
    { path: '/issued-return', name: 'IssuedReturn', component: require('../components/Pages/IssuedReturn/IssuedReturn.vue').default, meta: { requiresAuth: true } },
    { path: '/book-records', name: 'BookRecords', component: require('../components/Pages/BookRecords/BookRecords.vue').default, meta: { requiresAuth: true } },
    { path: '/student-management', name: 'Student', component: require('../components/Pages/Borrowers/StudentManagement.vue').default, meta: { requiresAuth: true } },
    { path: '/faculty-management', name: 'Faculty', component: require('../components/Pages/Borrowers/FacultyManagement.vue').default, meta: { requiresAuth: true } },
    { path: '/user-management', name: 'UserManagement', component: require('../components/Pages/UserManagement.vue').default,  meta: { requiresAuth: { user_type: 'Administrator', redirect: { name: 'login'}, forbiddenRedirect: '/403' }, } },
    { path: '/settings', name: 'Settings', component: require('../components/Pages/Setting/Settings.vue').default, meta: { requiresAuth: true,} },
    { 
        path: '/forbidden', 
        name: 'Forbidden', 
        component: require('../components/Pages/Forbidden403.vue').default, 
        meta: { 
            requiresAuth: true
        } 
    },
];

const router = new VueRouter({
    hashbang: false,
    mode: 'history',
    routes, // short for `routes: routes`
    linkActiveClass: 'active'
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth) {
        if (User.loggedIn()) {
            const role = to.meta.requiresAuth.user_type
            if (role) {
                if (role === User.userType()) {
                    next()
                } else {
                    next({ path: '/forbidden'})
                }
            }
            next()
        } else {
            next({ name: 'Login' })
        }
    }
    next()
})

export default router