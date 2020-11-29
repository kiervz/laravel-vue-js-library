<template>
    <div class="content-wrapper">
        <div class="content">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {

            }
        },
        created() {
            axios.post('api/auth/me')
                .then(res => {})
                .catch(error => Exception.handle(error))
        }
    }
</script>