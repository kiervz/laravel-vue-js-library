<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a 
                        class="nav-link" 
                        id="v-pills-options-tab" 
                        data-toggle="pill" 
                        href="#v-pills-options" 
                        role="tab" 
                        aria-controls="v-pills-options" 
                        aria-selected="false">
                        Options
                    </a>
                    <a 
                        class="nav-link active" 
                        id="v-pills-cpass-tab" 
                        data-toggle="pill" 
                        href="#v-pills-cpass" 
                        role="tab" 
                        aria-controls="v-pills-cpass" 
                        aria-selected="true">
                        Change Password
                    </a>
                </div>
            </div>
            <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div 
                        class="tab-pane fade show active" 
                        id="v-pills-cpass" 
                        role="tabpanel" 
                        aria-labelledby="v-pills-cpass-tab">
                        <change-password></change-password>
                    </div>
                    <div 
                        class="tab-pane fade" 
                        id="v-pills-options" 
                        role="tabpanel" 
                        aria-labelledby="v-pills-options-tab">
                        Options ...
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</template>
<script>    
    import ChangePassword from './ChangePassword.vue'
    export default {
        components: { ChangePassword },
        data() {
            return {

            }
        },

    }
</script>