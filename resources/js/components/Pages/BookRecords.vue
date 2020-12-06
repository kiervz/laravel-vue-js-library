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
                            <tr v-for="book in book_inventory" :key="book.id">
                                <td>{{ book.id }}</td>
                                <td>{{ book.call_number }}</td>
                                <td>{{ book.isbn }}</td>
                                <td>{{ book.title }}</td>
                                <td>{{ book.author }}</td>
                                <td>{{ book.category }}</td>
                                <td>{{ book.publisher }}</td>
                                <td>{{ book.total_copies }}</td>
                                <td>{{ book.total_borrowers }}</td>
                                <td>{{ book.total_lost }}</td>
                                <td>{{ book.avail_copies }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" 
                id="book-borrowed" 
                role="tabpanel" 
                aria-labelledby="book-borrowed-tab">
                Book Borrowed
            </div>
            <div class="tab-pane fade" 
                id="book-returned" 
                role="tabpanel" 
                aria-labelledby="book-returned-tab">
                Book Returned
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
                book_inventory: []
            }
        },
        created() {
            axios.post('api/book/inventory')
                .then(({data}) => {
                    this.book_inventory = data.data
                })
                .catch(error => error.response.data)
        }
    }
</script>