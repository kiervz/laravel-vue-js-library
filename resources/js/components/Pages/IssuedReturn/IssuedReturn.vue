<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <issued-to></issued-to>
            </div>
            <div class="col-md-6">
                <issued-book></issued-book>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="card-header col-md-11">
                    Borrower Information
                </div>
                <div class="col-md-1 align-self-center mx-auto">
                    <button class="btn btn-md btn-primary float-right">Borrow</button>
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
            }
        },
    }
</script>