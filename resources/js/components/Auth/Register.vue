<template>
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card mx-auto">
                    <div class="card-body">
                        <div class="form-group" v-for="(item, index) in items" :key="index">
                            <label>{{ item.label }}</label>
                            <input 
                                v-model="form[item.name]"
                                :type="item.type" 
                                class="form-control" 
                                :placeholder="item.label">
                            <span class="red--text" v-if="errors[item.name]">{{ errors[item.name] }}</span>
                        </div>
                        
                        <button 
                            class="btn btn-sm btn-primary form-control"
                            @click="register">
                            Register
                        </button>
                        <div class="mt-5 text-center">
                            Already have an Account? <router-link to="/login" class="text-decoration-none">Login</router-link>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Register",
        data() {
            return {
                message: "Create your account.",
                form: {
                    name: null,
                    email: null,
                    password: null,
                    password_confirm: null,
                }, 
                items: [
                    {
                        label: 'Name',
                        name: 'name',
                        required: 'required',
                        type: 'text'
                    },
                    {
                        label: 'Email',
                        name: 'email',
                        required: 'required',
                        type: 'email'
                    },
                    {
                        label: 'Password',
                        name: 'password',
                        required: 'required',
                        type: 'password'
                    },
                    {
                        label: 'Confirm Password',
                        name: 'password_confirm',
                        required: 'required',
                        type: 'password'
                    },
                ],
                errors: []
            }
        },
        methods: {
            register() {
                axios.post('/api/auth/register', this.form)
                    .then(res => {
                        console.log("gago ka");
                    })
                    .catch(error => error.response.data);
            }
        }
    }
</script>