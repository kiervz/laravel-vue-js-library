<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <div class="d-flex align-items-center">
                                <h3 class="card-title">Books</h3>
                            </div>
                            <div class="float-right">
                                <router-link class="btn btn-sm btn-primary" to="/book-category">
                                    Categories <i class="fas fa-tasks"></i>
                                </router-link>
                                <button class="btn btn-sm btn-primary show-book-modal" @click="bookModal" data-title="ADD">
                                    Book Register <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Call No.</th>
                                        <th>ISBN</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Category</th>
                                        <th>Copies</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="book in books" :key="book.id">
                                        <td>{{ book.id }}</td>
                                        <td>{{ book.call_number }}</td>
                                        <td>{{ book.isbn }}</td>
                                        <td>{{ book.title }}</td>
                                        <td>{{ book.author }}</td>
                                        <td>{{ book.category }}</td>
                                        <td>{{ book.total_copies }}</td>
                                        <td>
                                            <i class="fas fa-folder-plus" @click="updateCopiesModal(book)"></i>
                                            |
                                            <i class="fas fa-edit" @click="editModal(book)"></i>
                                            |
                                            <i class="fas fa-trash" @click="deleteBook(book.id)"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <div class="float-right">
                            <!-- pagination here -->
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal for adding and updating book -->
            <div class="modal fade" id="add_book" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form @submit.prevent="editMode ? updateBook() : addBook()">
                            <!-- Modal Header -->
                            <div class="modal-header bg-dark text-white">
                                <h5 v-show="!editMode" class="modal-title">Register Book</h5>
                                <h5 v-show="editMode" class="modal-title">Update Book</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span class="text-white" aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <!-- Modal Content -->
                            <div class="modal-body text-muted">
                                <div class="row">
                                    <!-- first row -->
                                    <div class="col-6">
                                        <div v-for="(item, $index) in item_col_1" :key="$index" class="form-group-sm">
                                            <label :for="item.name" class="mt-1">{{ item.label }}</label>
                                            <input
                                                :id="item.name"
                                                :name="item.name"
                                                :type="item.type"
                                                v-model="form[item.name]"
                                                class="form-control"
                                                :class="errors[item.name] ? 'is-invalid' : form.errors.has(item.name)"
                                            >
                                            <span role="alert" v-if="errors[item.name]" :class="errors[item.name] ? 'invalid-feedback d-block' : ''">
                                                <strong>{{ errors[item.name][0] }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- second row -->
                                    <div class="col-6">
                                        <div v-for="(item, $index) in item_col_2" :key="$index" class="form-group-sm">
                                            <label :for="item.name" class="mt-1">{{ item.label }}</label>
                                            <div v-if="item.type == 'dropdown'">
                                                <select
                                                    :name="item.name"
                                                    :id="item.name"
                                                    v-model="form[item.name]"
                                                    class="form-control"
                                                    :class="errors[item.name] ? 'is-invalid' : form.errors.has(item.name)"
                                                >
                                                    <option value="" disabled selected>Select Book Category</option>
                                                    <option
                                                        v-for="item in categories"
                                                        v-bind:value="item.id"
                                                        v-bind:key="item.id">
                                                        {{ item.name }}
                                                    </option>
                                                </select>
                                                <span role="alert" v-if="errors[item.name]" :class="errors[item.name] ? 'invalid-feedback d-block' : ''">
                                                    <strong>{{ errors[item.name][0] }}</strong>
                                                </span>
                                            </div>
                                            <div v-else>
                                                <div>
                                                    <!-- When edit modal is active, the copies field will be disabled -->
                                                    <input
                                                        :disabled="editMode && item.name == 'total_copies'"
                                                        :id="item.name"
                                                        :name="item.name"
                                                        :type="item.type"
                                                        v-model="form[item.name]"
                                                        class="form-control"
                                                        :class="errors[item.name] ? 'is-invalid' : form.errors.has(item.name)"
                                                    >
                                                </div>
                                                <span role="alert" v-if="errors[item.name]" :class="errors[item.name] ? 'invalid-feedback d-block' : ''">
                                                    <strong>{{ errors[item.name][0] }}</strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary p-18" data-dismiss="modal">Cancel</button>
                                <button v-show="!editMode" type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i>Save
                                </button>
                                <button v-show="editMode" type="submit" class="btn btn-primary">
                                    <i class="fas fa-pen mr-1"></i>Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal for updating copies of book -->
            <div class="modal fade" id="update_copies" role="dialog">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <form @submit.prevent="updateBookCopies">
                            <div class="modal-header bg-dark text-white">
                                <h5 class="modal-title" id="exampleModalLabel">Acquire New Copies</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span class="text-white" aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-header">
                                        Book Details
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row ml-1">
                                            <div class="col-md-5">
                                                <label for="book_title" class="mr-4">Book Title: </label>
                                            </div>
                                            <div class="col">
                                                {{ form.title }}
                                            </div>
                                        </div>
                                        <div class="form-group row ml-1">
                                            <div class="col-md-5">
                                                <label for="avail_copies" class="mr-4">Available Copies: </label>
                                            </div>
                                            <div class="col">
                                                {{ form.avail_copies }}
                                            </div>
                                        </div>
                                        <div class="form-group row ml-1">
                                            <div class="col-md-5">
                                                <label for="total_copies" class="mr-4">Total Copies: </label>
                                            </div>
                                            <div class="col">
                                                {{ form.total_copies }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="number_copies">Number of Copies</label>
                                    <input
                                        type="number"
                                        v-model="form['number_copies']"
                                        class="form-control"
                                        id="number_copies"
                                        name="number_copies"
                                        :class="errors['number_copies'] ? 'is-invalid' : ''"
                                    >
                                    <span role="alert" v-if="errors['number_copies']" :class="errors['number_copies'] ? 'invalid-feedback d-block' : ''">
                                        <strong>{{ errors['number_copies'][0] }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Copies</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: "Book",
        data() {
            return {
                form: new Form({
                    id: '',
                    isbn: '',
                    call_number: '',
                    title: '',
                    author: '',
                    publisher: '',
                    description: '',
                    category_id: '',
                    year_published: '',
                    series: '',
                    price: '',
                    avail_copies: '',
                    total_copies: ''
                }),
                books: {},
                categories: {},
                editMode: false,
                item_col_1: [
                    {
                        label: "ISBN",
                        name: "isbn",
                        required: "required",
                        type: "number"
                    },
                    {
                        label: "Call Number",
                        name: "call_number",
                        required: "required",
                        type: "text"
                    },
                    {
                        label: "Title",
                        name: "title",
                        required: "required",
                        type: "text"
                    },
                    {
                        label: "Author",
                        name: "author",
                        required: "required",
                        type: "text"
                    },
                    {
                        label: "Publisher",
                        name: "publisher",
                        required: "required",
                        type: "text"
                    },
                ],
                item_col_2: [
                    {
                        label: "Description",
                        name: "description",
                        required: "required",
                        type: "text"
                    },
                    {
                        label: "Category",
                        name: "category_id",
                        required: "required",
                        type: "dropdown"
                    },
                    {
                        label: "Year Published",
                        name: "year_published",
                        required: "required",
                        type: "number"
                    },
                    {
                        label: "Series",
                        name: "series",
                        required: "required",
                        type: "text"
                    },
                    {
                        label: "Copies",
                        name: "total_copies",
                        required: "required",
                        type: "number"
                    },
                    {
                        label: "Price",
                        name: "price",
                        required: "required",
                        type: "number"
                    },
                ],
                error: null,
                errors: [],
            }
        },
        created() {
            this.fetchBooks()
            this.fetchCategories()
            this.$on('refreshBooks', () => { 
                this.fetchBooks()
            })
        },
        methods: {
            fetchBooks() {
                this.$Progress.start()
                axios.get('api/book')
                    .then(({data}) => {
                        this.books = data.books.data
                        this.$Progress.finish()
                    })
                    .catch(error => {
                        error.response.data
                        this.$Progress.fail();
                    })
            },
            fetchCategories() {
                axios.get('api/category')
                    .then(({data}) => this.categories = data.categories.data)
                    .catch(error => error.response.data)
            },
            bookModal() {
                this.form.clear()
                this.form.reset()
                this.editMode = false
                $('#add_book').modal('show')
            },
            editModal(book) {
                this.form.clear()
                this.form.reset()
                this.errors= []
                this.editMode = true
                $('#add_book').modal('show')
                this.form.fill(book)
            },
            updateCopiesModal(book) {
                this.form.clear()
                this.form.reset()
                $('#update_copies').modal('show')
                this.form.fill(book)
            },
            updateBookCopies() {
                Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, add new copies!'
                    }).then((result) => {
                        if (result.value) {
                            this.$Progress.start();
                            this.form.put('api/book/copies/' + this.form.id)
                                .then(({ data }) => {
                                    Toast.fire({
                                        icon: data.status,
                                        title: data.message,
                                    });
                                    this.form.reset();
                                    this.$emit('refreshBooks');
                                    $('#update_copies').modal('hide');
                                    this.$Progress.finish();
                                })
                                .catch(error => {
                                    this.errors = error.response.data.errors;
                                    Toast.fire({
                                        icon: 'warning',
                                        title: 'Something went wrong. Please, try again later.',
                                    });
                                    this.$Progress.fail();
                                });
                        }
                    })
            },
            addBook() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, save it!'
                }).then((result) => {
                    if (result.value) {
                        this.$Progress.start();
                        this.form.post('api/book', this.form)
                            .then(({ data }) => {
                                Toast.fire({
                                    icon: data.status,
                                    title: data.message
                                });
                                this.$emit('refreshBooks')
                                $('#add_book').modal('hide')
                                this.$Progress.finish();
                            })
                            .catch(error => {
                                this.errors = error.response.data.errors;
                                Toast.fire({
                                    icon: 'warning',
                                    title: 'Something went wrong.',
                                });
                                this.$Progress.fail();
                            })
                    }
                });
            },
            updateBook() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, update it!'
                }).then((result) => {
                    if (result.value) {
                        this.$Progress.start();
                        this.form.put('api/book/'+ this.form.id)
                            .then(({ data }) => {
                                Toast.fire({
                                    icon: data.status,
                                    title: data.message
                                });
                                this.$emit('refreshBooks')
                                $('#add_book').modal('hide')
                                this.$Progress.finish();
                            })
                            .catch(error => {
                                this.errors = error.response.data.errors;
                                Toast.fire({
                                    icon: 'warning',
                                    title: 'Something went wrong.',
                                });
                                this.$Progress.fail();
                            })
                    }
                });
            },
            deleteBook(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        this.$Progress.start();
                        axios.delete('api/book/'+ id)
                            .then(({ data }) => {
                                Toast.fire({
                                    icon: data.status,
                                    title: data.message
                                });
                                this.$emit('refreshBooks')
                                $('#add_book').modal('hide')
                                this.$Progress.finish();
                            })
                            .catch(error => {
                                this.errors = error.response.data.errors;
                                Toast.fire({
                                    icon: 'warning',
                                    title: 'Something went wrong.',
                                });
                                this.$Progress.fail();
                            })
                    }
                });
            },
        }
    }
</script>