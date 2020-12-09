window.Vue = require('vue');

import VueRouter from 'vue-router';

Vue.use(VueRouter);

const routes = [
    { path: '/dashboard', name: 'Dashboard', component: require('../components/Pages/Dashboard.vue').default, meta: { requiresAuth: true } },
    { path: '/login', name: 'Login', component: require('../components/Auth/Login.vue').default },
    { path: '/logout', name: 'Logout', component: require('../components/Auth/Logout.vue').default, meta: { requiresAuth: true } },
    { path: '/register', name: 'Register', component: require('../components/Auth/Register.vue').default },
    { path: '/book', name: 'Book', component: require('../components/Pages/Book/Book.vue').default, meta: { requiresAuth: true } },
    { path: '/book-category', name: 'BookCategory', component: require('../components/Pages/Book/BookCategory.vue').default, meta: { requiresAuth: true } },
    { path: '/issued-return', name: 'IssuedReturn', component: require('../components/Pages/IssuedReturn/IssuedReturn.vue').default, meta: { requiresAuth: true } },
    { path: '/penalty-slip', name: 'PenaltySlip', component: require('../components/Pages/IssuedReturn/PenaltySlip.vue').default, meta: { requiresAuth: true }, props: true },
    { path: '/book-records', name: 'BookRecords', component: require('../components/Pages/BookRecords.vue').default, meta: { requiresAuth: true } },
    { path: '/student-management', name: 'Student', component: require('../components/Pages/Borrowers/StudentManagement.vue').default, meta: { requiresAuth: true } },
    { path: '/faculty-management', name: 'Faculty', component: require('../components/Pages/Borrowers/FacultyManagement.vue').default, meta: { requiresAuth: true } },
    { path: '/user-management', name: 'UserManagement', component: require('../components/Pages/UserManagement.vue').default, meta: { requiresAuth: true } },
    { path: '/audit-log', name: 'AuditLog', component: require('../components/Pages/AuditLog.vue').default, meta: { requiresAuth: true } },
    { path: '/reports', name: 'Reports', component: require('../components/Pages/Reports.vue').default, meta: { requiresAuth: true } },
    { path: '/settings', name: 'Settings', component: require('../components/Pages/Setting/Settings.vue').default, meta: { requiresAuth: true } },
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
            next()
        } else {
            next({ name: 'Login' })
        }
    }
    next()
})

export default router