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
                    <h3 class="card-title">Borrower's Borrowed Book(s)</h3>
                </div>
                <div class="float-right">
                    <button class="btn btn-md btn-primary" @click="create">Borrow</button>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>ISBN</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Date Borrowed</th>
                        <th>Due Date</th>
                        <th>Penalty</th>
                        <th>Prepared By</th>
                        <th>Return</th>
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
                        <td>{{ data.penalty * 20 }}</td>
                        <td>{{ data.name }}</td>
                        <td>
                            <i class="fas fa-undo" @click="returnBook(data.id, data)"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


        <!-- Modal for penalty slip -->
        <div class="modal fade" id="penalty_slip" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="card">
                        <div class="card-body" id="slip">
                            <h2 class="text-center">Penalty Slip</h2>
                            <p>Slip #: {{ penalty_data.id }}</p>
                            <table cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td width="60%">ISBN :</td>
                                        <td>{{ penalty_data.isbn }}</td>
                                    </tr>
                                    <tr>
                                        <td width="60%">Book Title :</td>
                                        <td>{{ penalty_data.title }}</td>
                                    </tr>
                                    <tr>
                                        <td width="60%">Author :</td>
                                        <td>{{ penalty_data.author }}</td>
                                    </tr>
                                    <tr>
                                        <td width="60%">Borrower's ID :</td>
                                        <td>{{ borrower_id }}</td>
                                    </tr>
                                    <tr class="total">
                                        <td width="60%">Penalty :</td>
                                        <td>{{ penalty_data.penalty * 20 }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-sm btn-light" @click="print">Print <i class="fas fa-print"></i></button>
                        </div>
                    </div>
                </div>
            </div>
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
                book_isbn: null,
                penalty_data: [],
            }
        },
        created() {
            EventBus.$on('clearData', () => {
                this.datas = []
            })
        },
        methods: {
            borrowerID(id) {
                this.datas = []
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
                                // Get the borrower id then show his borrowed books
                                this.borrowerID(this.borrower_id) 
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
            },
            returnBook(id, data) {
                Swal.fire({
                    title: 'Do you want to generate penalty slip?',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: `Yes`,
                    denyButtonText: `No`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        //pass the data parameter to penalty_data
                        this.penalty_data = data
                        //show the penalty slip
                        $('#penalty_slip').modal('show')
                    } else if (result.isDenied) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, return it!'
                        }).then((result) => {
                            if (result.value) {
                                this.$Progress.start();
                                axios.put('api/borrow/'+ id)
                                    .then(({ data }) => {
                                        Toast.fire({
                                            icon: data.status,
                                            title: data.message
                                        });
                                        // Get the borrower id then show his borrowed books
                                        this.borrowerID(this.borrower_id) 
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
                })
            },
            print() {
                this.$htmlToPaper('slip')
            }
        }
    }
</script>