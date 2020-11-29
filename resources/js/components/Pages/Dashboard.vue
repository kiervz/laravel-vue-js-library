<template>
    <div class="container-fluid">
        <div class="row">
            <div v-for="(item, $index) in items" :key="$index" class="col-md-4 col-sm-6">
                <div class="small-box" :class="item.bg"> 
                    <div class="inner">
                        <h3>{{ item.total }}</h3>

                        <p>{{ item.text }}</p>
                    </div>
                    <div class="icon">
                        <i :class="'fa-5x mt-3 fas fa-' + item.icon"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'Dashboard',
        data() {
            return {
                items: [
                    {
                        icon: 'swatchbook',
                        text: "Books",
                        description: "Total books registered",
                        total: 171,
                        bg: 'bg-info'
                    },
                    {
                        icon: 'book',
                        text: "Books Lost",
                        description: "Total books lost recorded.",
                        total: 1,
                        bg: 'bg-secondary'
                    },
                    {
                        icon: 'exclamation-triangle',
                        text: "Books Overdue",
                        description: "Total books overdue recorded.",
                        total: 4,
                        bg: 'bg-success'
                    },
                    {
                        icon: 'book-reader',
                        text: "Borrowers",
                        description: "Total borrowers recorded.",
                        total: 56,
                        bg: 'bg-danger'
                    },
                    {
                        icon: 'users',
                        text: "Students",
                        description: "Total students registered",
                        total: 200,
                        bg: 'bg-warning'
                    },
                    {
                        icon: 'user-tie',
                        text: "Faculties",
                        description: "Total faculties today recorded.",
                        total: 10,
                        bg: 'bg-primary'
                    }
                ]
            }
        },
    }
</script>