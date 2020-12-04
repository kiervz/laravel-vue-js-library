<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="small-box bg-info"> 
                    <div class="inner">
                        <h3>{{ total_books }}</h3>

                        <p>Books</p>
                    </div>
                    <div class="icon">
                        <i class='fa-5x mt-3 fas fa-swatchbook'></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="small-box bg-danger"> 
                    <div class="inner">
                        <h3>{{ total_books_lost }}</h3>

                        <p>Books Lost</p>
                    </div>
                    <div class="icon">
                        <i class='fa-5x mt-3 fas fa-book'></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="small-box bg-success"> 
                    <div class="inner">
                        <h3>{{ total_books_overdue }}</h3>

                        <p>Books Overdue</p>
                    </div>
                    <div class="icon">
                        <i class='fa-5x mt-3 fas fa-exclamation-triangle'></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="small-box bg-secondary"> 
                    <div class="inner">
                        <h3>{{ total_books_borrowed }}</h3>

                        <p>Borrowed Books</p>
                    </div>
                    <div class="icon">
                        <i class='fa-5x mt-3 fas fa-book-reader'></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="small-box bg-warning"> 
                    <div class="inner">
                        <h3>{{ total_students }}</h3>

                        <p>Students</p>
                    </div>
                    <div class="icon">
                        <i class='fa-5x mt-3 fas fa-users'></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="small-box bg-primary"> 
                    <div class="inner">
                        <h3>{{ total_faculties }}</h3>

                        <p>Faculties</p>
                    </div>
                    <div class="icon">
                        <i class='fa-5x mt-3 fas fa-user-tie'></i>
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
                total_books_lost: 0,
                total_books: 0,
                total_books_overdue: 0,
                total_books_borrowed: 0,
                total_students: 0,
                total_faculties: 0,
            }
        },
        created() {
            this.getTotalBooks()
            this.getTotalBooksLost()
            this.getTotalStudents()
            this.getTotalFaculties()
            this.getTotalBooksBorrowed()
        },
        methods: {
            getTotalBooks() {
                axios.post('api/dashboard/books')
                    .then(({data}) => {
                        this.total_books = data.books
                    })
                    .catch(error => error.response.data)
            },
            getTotalBooksLost() {
                axios.post('api/dashboard/books-lost')
                    .then(({data}) => {
                        this.total_books_lost = data.books_lost
                    })
                    .catch(error => error.response.data)
            },
            getTotalStudents() {
                axios.post('api/dashboard/total-students')
                    .then(({data}) => {
                        this.total_students = data.students
                    })
                    .catch(error => error.response.data)
            },
            getTotalFaculties() {
                axios.post('api/dashboard/total-faculties')
                    .then(({data}) => {
                        this.total_faculties = data.faculties
                    })
                    .catch(error => error.response.data)
            },
            getTotalBooksBorrowed() {
                axios.post('api/dashboard/books-borrowed')
                    .then(({data}) => {
                        this.total_books_borrowed = data.books_borrowed
                    })
                    .catch(error => error.response.data)
            },
        }
    }
</script>