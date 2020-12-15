<template>
    <div class="container-fluid">
        <div class="form-group">
            <label for="Category">Category</label>
            <input type="text" class="form-control" v-model="form['name']">
        </div>
        <button class="btn btn-sm btn-primary" @click="editMode ? updateCategory() : addCategory() ">
            {{ editMode ? 'UPDATE CATEGORY' : 'ADD CATEGORY' }}
        </button>
        <button class="btn btn-sm btn-light" v-if="editMode" @click="cancel">CANCEL</button>
        <br><br>
        <div class="card">
            <div class="card-header">
                Book Categories
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in book_categories.data" :key="item.id">
                                <td>{{ item.id }}</td>
                                <td>{{ item.name }}</td>
                                <td>
                                    <i class="fas fa-edit" @click="editCategory(item)"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <div class="float-center">
                    <advanced-laravel-vue-paginate 
                        :data="book_categories" 
                        :onEachSide="1"
                        dots="..."
                        @paginateTo="fetchCategory"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'BookCategory',
        data() {
            return {
                form: new Form({
                    id: '',
                    name: '',
                }),
                book_categories: {},
                editMode: false
            }
        },
        mounted() {
            axios.post('api/auth/me')
                .then(res => {
                    if (res.data.user_type == 'Librarian') {
                        this.$router.push('dashboard');
                    }
                })
                .catch(error => Exception.handle(error))
        },
        created() {
            this.fetchCategory()
            this.$on('refreshCategories', () => {
                this.fetchCategory()
            })
        },
        methods: {
            fetchCategory(page) {
                let url = page ? `api/category?page=${page}` : 'api/category'
                this.$Progress.start()
                axios.get(url)
                    .then(({ data }) => { 
                        this.book_categories = data.categories
                        this.$Progress.finish(); 
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors;
                        this.$Progress.fail();
                    })
            },
            addCategory() {
                this.$Progress.start()
                this.form.post('api/category', this.form)
                    .then(({ data }) => {
                        this.$Progress.finish();
                        this.cancel()
                        this.$emit('refreshCategories')
                        Toast.fire({
                            icon: data.status,
                            title: data.message
                        });
                    })
                    .catch(err => {
                        this.$Progress.fail();
                        this.errors = err.response.data.errors;
                        Toast.fire({
                            icon: 'error',
                            title: 'Something went wrong. Please, try again later.',
                        });
                    });
            },
            editCategory(item) {
                this.form.clear()
                this.form.reset()
                this.editMode = true
                this.form.fill(item)
            },
            cancel() {
                this.editMode = false
                this.form.clear()
                this.form.reset()
            },
            updateCategory() {
                this.$Progress.start();
                this.form.put('api/category/' + this.form.id)
                    .then(({ data }) => {
                        this.$Progress.finish();
                        this.cancel()
                        this.$emit('refreshCategories')
                        Toast.fire({
                            icon: data.status,
                            title: data.message,
                        });
                    })
                    .catch(error => {
                        this.$Progress.fail();
                        this.errors = error.response.data.errors;
                        Toast.fire({
                            icon: 'error',
                            title: 'Something went wrong. Please, try again later.',
                        });
                    });
            }
        }
    }
</script>