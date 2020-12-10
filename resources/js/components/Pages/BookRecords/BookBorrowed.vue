<template>
    <div>
        <div class="table-responsive" id="book-borrowed">
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
        <button class="btn btn-sm btn-light" v-show="printing" @click="print">Print <i class="fas fa-print"></i></button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                book_borrowed: [],
                printing: true
            }
        },
        created() {
            this.fetchBorrowed()
        },
        methods: {
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
            print() {
                this.printing = false;
                const options = null;
                this.$htmlToPaper('book-borrowed', options, () => {
                    this.printing = true;
                });
            }
        }
    }
</script>