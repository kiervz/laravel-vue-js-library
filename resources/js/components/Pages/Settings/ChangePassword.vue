<template>
    <div class="container-fluid">
        <div class="card mx-auto">
            <div class="card-body">
                <div class="form-group">
                    <label>Current password</label>
                    <input 
                        v-model="form['password']"
                        type="password" 
                        name="password"
                        class="form-control" 
                        placeholder="Password">
                    <span class="text-danger" v-if="errors.password">{{ errors.password[0] }}</span>
                </div>
                
                <div class="form-group">
                    <label>New Password</label>
                    <input 
                        v-model="form['new_password']"
                        type="password" 
                        name="new_password"
                        class="form-control" 
                        placeholder="New Password">
                    <span class="text-danger" v-if="errors.new_password">{{ errors.new_password[0] }}</span>
                </div>

                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input 
                        v-model="form['confirm_new_password']"
                        type="password" 
                        name="confirm_new_password"
                        class="form-control" 
                        placeholder="Confirm New Password">
                    <span class="text-danger" v-if="errors.confirm_new_password">{{ errors.confirm_new_password[0] }}</span>
                </div>
                
                <button class="btn btn-sm btn-primary form-control" @click="changePassword">
                    Change Password
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: new Form({
                    password: null,
                    new_password: null,
                    confirm_new_password: null,
                }),
                errors: [],
                user_id: User.id(),
            }
        },
        methods: {
            changePassword() {
                axios.put(`api/user/${this.user_id}/change-password`, this.form)
                    .then(({data}) => {
                        Toast.fire({
                            icon: data.status,
                            title: data.message
                        });
                        this.errors = []
                        this.form.reset()
                        this.form.clear()
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors
                    })
            }
        }
    }
</script>