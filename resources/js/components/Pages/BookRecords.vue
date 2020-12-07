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
                        <thead>
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
                        <thead>
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
                <table class="table table-hover">
                    <thead>
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
                            <td>{{ index=+1 }}</td>
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
            <div class="tab-pane fade" 
                id="book-lost" 
                role="tabpanel" 
                aria-labelledby="book-lost-tab">
                Book Lost
            </div>
            <div class="tab-pane fade" 
                id="book-overdue" 
                role="tabpanel" 
                aria-labelledby="book-overdue-tab">
                Book Overdue
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
                book_returned: []
            }
        },
        created() {
            axios.post('api/book/inventory')
                .then(({data}) => {
                    this.book_inventory = data.data
                })
                .catch(error => error.response.data)

            axios.post('api/book/borrowed')
                .then(({data}) => {
                    this.book_borrowed = data.data
                    console.log(this.book_borrowed);
                })
                .catch(error => error.response.data)

            axios.post('api/book/returned')
                .then(({data}) => {
                    this.book_returned = data.data
                })
                .catch(error => error.response.data)
        }
    }
</script>