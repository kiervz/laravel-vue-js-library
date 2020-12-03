<template>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown">
                    <i class="fas fa-user-circle" style="font-size: 2em;"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">Sign in as {{ userType }}</span>
                    <div class="dropdown-divider"></div>
                    <router-link to="/settings" class="dropdown-item">
                        <i class="fas fa-cog mr-1"></i> Settings
                    </router-link> 
                    <router-link to="/logout" class="dropdown-item">
                        <i class="fas fa-sign-out-alt mr-1"></i> Logout
                    </router-link>
                </div>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        data() {
            return {
                userType: null
            }
        },
        created() {
            axios.post('api/auth/me')
                .then(res => {
                    this.userType = res.data.user_type
                })
                .catch(error => Exception.handle(error))
        }
    }
</script>