<template>
    <div>
        <div class="table-responsive" id="book-overdue">
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
        <button class="btn btn-sm btn-light" v-show="printing" @click="print">Print <i class="fas fa-print"></i></button>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                book_overdue: [],
                printing: true
            }
        },
        created() {
            this.fetchOverdue()
        },
        methods: {
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
            bookReturn(id) {
                localStorage.setItem('borrower_id', [id, 'book-records'])
                this.$router.push('/issued-return')
            },
            print() {
                this.printing = false;
                const options = null;
                this.$htmlToPaper('book-overdue', options, () => {
                    this.printing = true;
                });
            }
        }
    }
</script>