<template>
    <div>
        <h1>{{ data }}</h1>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                data: null,
            }
        },
        created() {
            EventBus.$on('awd', (data) => {
                this.data = data
                console.log(data);
            })
        }
    }
</script>