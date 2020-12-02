<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <issued-to @borrowerID="fetchBorrowerData"></issued-to>
            </div>
            <div class="col-md-6">
                <issued-book @bookISBN="fetchISBN"></issued-book>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="card-header col-md-11">
                    Borrower Information
                </div>
                <div class="col-md-1 align-self-center mx-auto">
                    <button class="btn btn-md btn-primary float-right" @click="create">Borrow</button>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ISBN</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Date Borrowed</th>
                        <th>Due Date</th>
                        <th>Penalty</th>
                        <th>Prepared By</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="data in datas" :key="data.id">
                        <td>{{ data.id }}</td>
                        <td>{{ data.call_number }}</td>
                        <td>{{ data.isbn }}</td>
                        <td>{{ data.title }}</td>
                        <td>{{ data.author }}</td>
                        <td>{{ data.category }}</td>
                        <td>{{ data.total_copies }}</td>
                        <td>{{ data.prepared_by }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
    import IssuedBook from './IssuedBook' 
    import IssuedTo from './IssuedTo' 

    export default {
        components: { IssuedBook, IssuedTo },
        data() {
            return {
                datas: [],
                borrower_id: null,
                book_isbn: null
            }
        },
        methods: {
            fetchBorrowerData(id) {
                this.borrower_id = id
            },
            fetchISBN(isbn) {
                this.book_isbn = isbn
            },
            create() {
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
                        axios.post('api/borrow', { isbn: this.book_isbn, borrower_id: this.borrower_id })
                            .then(({ data }) => {
                                Toast.fire({
                                    icon: data.status,
                                    title: data.message
                                });
                                this.$Progress.finish();
                            })
                            .catch(error => {
                                error.response.data
                                Toast.fire({
                                    icon: 'warning',
                                    title: 'Something went wrong.',
                                });
                                this.$Progress.fail();
                            })
                    }
                });
            }
        }
    }
</script>