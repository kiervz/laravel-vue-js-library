<template>
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card mx-auto">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Email address</label>
                            <input 
                                v-model="form['email']"
                                type="email" 
                                class="form-control" 
                                placeholder="Email">
                        </div>
                        <span class="red--text" v-if="errors.email">{{ errors.email[0] }}</span>
                        
                        <div class="form-group">
                            <label>Password</label>
                            <input 
                                v-model="form['password']"
                                type="password" 
                                class="form-control" 
                                placeholder="Password">
                        </div>
                        <span class="red--text" v-if="errors.password">{{ errors.password[0] }}</span>
                        
                        <button 
                            class="btn btn-sm btn-primary form-control"
                            @click="login">
                            Login
                        </button>
                        <div class="mt-5 text-center">
                            <router-link to="/register" class="text-decoration-none">Create your Account</router-link>
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
        name: "Login",
        data() {
            return {
                message: "Login your account.",
                form: {
                    email: null,
                    password: null,
                },
                error: null,
                errors:{},
            }
        },
        methods: {
            login() {
                axios.post('/api/auth/login', this.form)
                    .then(res => {
                        console.log("gago");
                    })
                    .catch(error => error.response.data);
            }
        },
    }
</script>