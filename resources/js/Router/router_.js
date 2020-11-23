window.Vue = require('vue');

import VueRouter from 'vue-router';

Vue.use(VueRouter);

const routes = [
    { path: '/', name: 'Dashboard', component: require('../components/Pages/Dashboard.vue').default },
    { path: '/login', name: 'Login', component: require('../components/Auth/Login.vue').default },
    { path: '/register', name: 'Register', component: require('../components/Auth/Register.vue').default },
    { path: '/attendance', name: 'Attendance', component: require('../components/Pages/Attendance.vue').default },
    { path: '/book-entry', name: 'BookEntry', component: require('../components/Pages/BookEntry.vue').default },
    { path: '/issued-return', name: 'IssuedReturn', component: require('../components/Pages/IssuedReturn.vue').default },
    { path: '/borrowers', name: 'Borrowers', component: require('../components/Pages/Borrowers.vue').default },
    { path: '/user-management', name: 'UserManagement', component: require('../components/Pages/UserManagement.vue').default },
    { path: '/audit-log', name: 'AuditLog', component: require('../components/Pages/AuditLog.vue').default },
    { path: '/reports', name: 'Reports', component: require('../components/Pages/Reports.vue').default },
    { path: '/settings', name: 'Settings', component: require('../components/Pages/Settings.vue').default },
];

const router = new VueRouter({
    hashbang: false,
    mode: 'history',
    routes, // short for `routes: routes`
});

export default router