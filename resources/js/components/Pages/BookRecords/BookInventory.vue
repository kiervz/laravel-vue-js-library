<template>
    <div>
        <div class="table-responsive" id="book-inventory">
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
        <button class="btn btn-sm btn-light" v-show="printing" @click="print">Print <i class="fas fa-print"></i></button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                book_inventory: [],
                printing: true
            }
        },
        created() {
            this.fetchInventory()
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
            print() {
                this.printing = false;
                const options = null;
                this.$htmlToPaper('book-inventory', options, () => {
                    this.printing = true;
                });
            }
        }
    }
</script>