<template>
    <div class="app-home" v-if="userLoggedIn">
        <vue-progress-bar></vue-progress-bar>
        <app-nav-bar></app-nav-bar>
        <app-side-bar></app-side-bar>
        <app-main></app-main>
        <app-footer></app-footer>
    </div>
    <div v-else>
        <router-view></router-view>
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
                userLoggedIn: null
            }
        },
        created() {
            this.userLoggedIn = User.loggedIn();
            EventBus.$on('logout', () => {
                User.logOut()
            })
        }
    }
</script>