<template>
    <div class="container-fluid">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" 
                    id="book-inventory-tab" 
                    data-toggle="tab" 
                    href="#book-inventory" 
                    role="tab" 
                    aria-controls="book-inventory" 
                    aria-selected="true">
                    Book Inventory
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" 
                    id="book-borrowed-tab" 
                    data-toggle="tab" 
                    href="#book-borrowed" 
                    role="tab" 
                    aria-controls="book-borrowed" 
                    aria-selected="false">
                    Book Borrowed
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" 
                    id="book-returned-tab" 
                    data-toggle="tab" 
                    href="#book-returned" 
                    role="tab" 
                    aria-controls="book-returned" 
                    aria-selected="false">
                    Book Returned
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" 
                    id="book-lost-tab" 
                    data-toggle="tab" 
                    href="#book-lost" 
                    role="tab" 
                    aria-controls="book-lost" 
                    aria-selected="false">
                    Book Lost
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" 
                    id="book-overdue-tab" 
                    data-toggle="tab" 
                    href="#book-overdue" 
                    role="tab" 
                    aria-controls="book-overdue" 
                    aria-selected="false">
                    Book Overdue
                </a>
            </li>
        </ul>
        <!-- TAB CONTENT -->
        <div class="tab-content">
            <div class="tab-pane fade show active" 
                id="book-inventory" 
                role="tabpanel" 
                aria-labelledby="book-inventory-tab">
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
                                <th>Publisher</th>
                                <th>Total Copies</th>
                                <th>Borrowed</th>
                                <th>Lost</th>
                                <th>Avail. Copies</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="data in book_inventory" :key="data.id">
                                <td>{{ data.id }}</td>
                                <td>{{ data.call_number }}</td>
                                <td>{{ data.isbn }}</td>
                                <td>{{ data.title }}</td>
                                <td>{{ data.author }}</td>
                                <td>{{ data.category }}</td>
                                <td>{{ data.publisher }}</td>
                                <td>{{ data.total_copies }}</td>
                                <td>{{ data.total_borrowers }}</td>
                                <td>{{ data.total_lost }}</td>
                                <td>{{ data.avail_copies }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" 
                id="book-borrowed" 
                role="tabpanel" 
                aria-labelledby="book-borrowed-tab">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Call No.</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Borrower's Name</th>
                                <th>Date Borrowed</th>
                                <th>Date Due</th>
                                <th>Process By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="data in book_borrowed" :key="data.id">
                                <td>{{ data.id }}</td>
                                <td>{{ data.call_number }}</td>
                                <td>{{ data.title }}</td>
                                <td>{{ data.author }}</td>
                                <td>{{ data.student_name || data.faculty_name }}</td>
                                <td>{{ data.date_borrowed }}</td>
                                <td>{{ data.due_date }}</td>
                                <td>{{ data.name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" 
                id="book-returned" 
                role="tabpanel" 
                aria-labelledby="book-returned-tab">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Call No.</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Borrower's Name</th>
                                <th>Date Borrowed</th>
                                <th>Date Due</th>
                                <th>Process By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data, index) in book_returned" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>{{ data.call_number }}</td>
                                <td>{{ data.title }}</td>
                                <td>{{ data.author }}</td>
                                <td>{{ data.student_name || data.faculty_name }}</td>
                                <td>{{ data.date_borrowed }}</td>
                                <td>{{ data.due_date }}</td>
                                <td>{{ data.name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" 
                id="book-lost" 
                role="tabpanel" 
                aria-labelledby="book-lost-tab">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Call No.</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Borrower's Name</th>
                                <th>Date Borrowed</th>
                                <th>Date Due</th>
                                <th>Process By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data, index) in book_lost" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>{{ data.call_number }}</td>
                                <td>{{ data.title }}</td>
                                <td>{{ data.author }}</td>
                                <td>{{ data.student_name || data.faculty_name }}</td>
                                <td>{{ data.date_borrowed }}</td>
                                <td>{{ data.due_date }}</td>
                                <td>{{ data.name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" 
                id="book-overdue" 
                role="tabpanel" 
                aria-labelledby="book-overdue-tab">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Call No.</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Borrower's Name</th>
                                <th>Date Borrowed</th>
                                <th>Date Due</th>
                                <th>Process By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data, index) in book_overdue" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>{{ data.call_number }}</td>
                                <td>{{ data.title }}</td>
                                <td>{{ data.author }}</td>
                                <td>{{ data.student_name || data.faculty_name }}</td>
                                <td>{{ data.date_borrowed }}</td>
                                <td>{{ data.due_date }}</td>
                                <td>{{ data.name }}</td>
                                <td><i class="fas fa-undo" @click="bookReturn(data.student_id || data.faculty_id)"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                book_inventory: [],
                book_borrowed: [],
                book_returned: [],
                book_lost: [],
                book_overdue: []
            }
        },
        created() {
            this.fetchInventory()
            this.fetchOverdue()
            this.fetchLost()
            this.fetchReturned()
            this.fetchBorrowed()
        },
        methods: {
            async fetchInventory() {
                this.$Progress.start()
                await axios.post('api/book/inventory')
                    .then(({data}) => {
                        this.book_inventory = data.data
                        this.$Progress.finish()
                    })
                    .catch(error => {
                        error.response.data
                        this.$Progress.fail()
                    })
            },
            async fetchOverdue() {
                this.$Progress.start()
                await axios.post('api/book/overdue')
                    .then(({data}) => {
                        this.book_overdue = data.data
                        this.$Progress.finish()
                    })
                    .catch(error => {
                        error.response.data
                        this.$Progress.fail()
                    })
            },
            async fetchLost() {
                this.$Progress.start()
                await axios.post('api/book/lost')
                    .then(({data}) => {
                        this.book_lost = data.data
                        this.$Progress.finish()
                    })
                    .catch(error => {
                        error.response.data
                        this.$Progress.fail()
                    })
            },
            async fetchReturned() {
                this.$Progress.start()
                await axios.post('api/book/returned')
                    .then(({data}) => {
                        this.book_returned = data.data
                        this.$Progress.finish()
                    })
                    .catch(error => {
                        error.response.data
                        this.$Progress.fail()
                    })
            },
            async fetchBorrowed() {
                this.$Progress.start()
                await axios.post('api/book/borrowed')
                    .then(({data}) => {
                        this.book_borrowed = data.data
                        this.$Progress.finish()
                    })
                    .catch(error => {
                        error.response.data
                        this.$Progress.fail()
                    })
            },

            bookReturn(id) {
                localStorage.setItem('borrower_id', [id, 'book-records'])
                this.$router.push('/issued-return')
            }
        }
    }
</script>