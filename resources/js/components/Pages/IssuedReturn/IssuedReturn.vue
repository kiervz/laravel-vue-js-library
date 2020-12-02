<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <issued-to @borrowerID="borrowerID"></issued-to>
            </div>
            <div class="col-md-6">
                <issued-book @bookISBN="bookISBN"></issued-book>
            </div>
        </div>
        <div class="card-header col-md-12">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="d-flex align-items-center">
                    <h3 class="card-title">Books</h3>
                </div>
                <div class="float-right">
                    <button class="btn btn-md btn-primary" @click="create">Borrow</button>
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
                        <td>{{ data.isbn }}</td>
                        <td>{{ data.title }}</td>
                        <td>{{ data.author }}</td>
                        <td>{{ data.date_borrowed }}</td>
                        <td>{{ data.due_date }}</td>
                        <td>{{ data.penalty }}</td>
                        <td>{{ data.name }}</td>
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
            borrowerID(id) {
                this.borrower_id = id
                this.showData(id)
            },
            bookISBN(isbn) {
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
            },
            showData(id) {
                axios.get('api/borrow/'+ id) 
                    .then(({data}) => {
                        this.datas = data.data
                    })
                    .catch(error => error.response.data)
            }
        }
    }
</script>