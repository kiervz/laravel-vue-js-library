<template>
    <div class="app-home" v-if="user">
        <app-nav-bar></app-nav-bar>
        <app-side-bar></app-side-bar>
        <app-main></app-main>
        <app-footer></app-footer>
    </div>
    <div v-else>
        <router-link></router-link>
    </div>
</template>
<script>
    import AppNavBar from './AppNavBar.vue'
    import AppSideBar from './AppSideBar.vue'
    import AppMain from './AppMain.vue'
    import AppFooter from './AppFooter.vue'

    export default {
        components: { AppNavBar, AppSideBar, AppMain, AppFooter },
        data() {
            return {
                user: 1,
            }
        }
    }
</script>