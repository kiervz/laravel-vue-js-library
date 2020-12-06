<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="index3.html" class="brand-link">
            <img :src="'/images/logo.jpg'" alt="Logo" class="brand-image img-circle elevation-3"
                style="opacity: .8">
            <span class="brand-text font-weight-light">e-Library</span>
        </a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img :src="'/images/user-avatar.png'" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">Kiervey Maghanoy</a>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                   <li class="nav-item" v-for="(item, index) in items" :key="index">
                        <router-link :to="item.link" class="nav-link">
                            <i :class="'nav-icon fas fa-' + item.icon"></i>
                            <p>
                                {{ item.name }}
                                <i v-if="item.istreeview" class="right fas fa-angle-left"></i>
                            </p>
                        </router-link>
                        <ul v-if="item.istreeview" class="nav nav-treeview">
                            <li class="nav-item" v-for="(item, index) in items[index].treeview" :key="index">
                                <router-link :to="item.link" class="nav-link">
                                    <i :class="'nav-icon fas fa-' + item.icon"></i>
                                    <p>{{ item.name }}</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
</template>
<script>
    export default {
        data() {
            return {
                items: [
                    {
                        name : 'Dashboard',
                        link : "/dashboard",
                        icon : "tachometer-alt",
                        istreeview: false,
                    },
                    {
                        name : 'Manage Book',
                        link : "/book", 
                        icon : "book-open",
                        istreeview: true,
                        treeview: [
                            {
                                name : 'Book',
                                link : "/book", 
                                icon : "book",
                            },
                            {
                                name : 'Category',
                                link : "/book-category", 
                                icon : "swatchbook",
                            },
                        ]
                    },
                    {
                        name : 'Issued & Return',
                        link : "/issued-return",
                        icon : "paste",
                        istreeview: false,
                    },
                    {
                        name : 'Book Records',
                        link : "/book-records",
                        icon : "swatchbook",
                        istreeview: false,
                    },
                    {
                        name : 'Borrowers',
                        link : "/student-management",
                        icon : "users",
                        istreeview: true,
                        treeview: [
                            {
                                name : 'Student Management',
                                link : "/student-management", 
                                icon : "user",
                            },
                            {
                                name : 'Faculty Management',
                                link : "/faculty-management", 
                                icon : "user-tie",
                            }
                        ]
                    },
                    {
                        name : 'User Management',
                        link : "/user-management",
                        icon : "users-cog",
                        istreeview: false,
                    },
                    {
                        name : 'Audit Log',
                        link : "/audit-log",
                        icon : "history",
                        istreeview: false,
                    },
                    {
                        name : 'Reports',
                        link : "/reports",
                        icon : "file-download",
                        istreeview: false,
                    }
                ],
            }
        },
    }
</script>