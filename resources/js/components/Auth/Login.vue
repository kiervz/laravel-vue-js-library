<template>
    <div class="container">
        <br><br>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card mx-auto">
                    <div class="card-body">
                        <span class="text-danger" v-if="error">
                            <div class="alert alert-danger" role="alert">{{ error }}</div>
                        </span>
                        <div class="form-group">
                            <label>Email address</label>
                            <input 
                                v-model="form['email']"
                                type="email" 
                                class="form-control" 
                                placeholder="Email">
                            <span class="text-danger" v-if="errors.email">{{ errors.email[0] }}</span>
                        </div>
                        
                        <div class="form-group">
                            <label>Password</label>
                            <input 
                                v-model="form['password']"
                                type="password" 
                                class="form-control" 
                                placeholder="Password">
                            <span class="text-danger" v-if="errors.password">{{ errors.password[0] }}</span>
                        </div>
                        
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
        created() {
            if(User.loggedIn()) {
                this.$router.push({ name: 'dashboard'});
            }
        },
        methods: {
            login() {
                this.error = ''
                this.errors = ''
                axios.post('/api/auth/login', this.form)
                    .then(res => User.responseAfterLogin(res))
                    .catch(error => {
                        let status = error.response.status
                        if (!status == 401 || status == 422) {
                            this.errors = error.response.data.errors
                        }
                        else { 
                            this.error = error.response.data.error
                        }
                    });
            }
        },
    }
</script>