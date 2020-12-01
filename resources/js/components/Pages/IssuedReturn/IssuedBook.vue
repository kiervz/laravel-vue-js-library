<template>
    <div>
        <div class="card">
            <div class="card-header">
                Book Information
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="ISBN" class="col-md-4 col-form-label text-md-left">ISBN</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" v-on:keydown.enter="searchBook(form['isbn'])" v-model="form['isbn']">
                    </div>
                    <button class="btn btn-sm btn-primary">Search Book</button>
                </div>
                <div class="form-group row" v-for="(item, index) in items" :key="index">
                    <label :for="item.label" class="col-md-4 col-form-label text-md-left">{{ item.label }}</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" v-model="form[item.name]" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                form: new Form({
                    isbn: null,
                    call_number: null,
                    title: null,
                    author: null,
                    publisher: null,
                }),
                items: [
                    {
                        label: 'Call Number',
                        name: 'call_number',
                    },
                    {
                        label: 'Title',
                        name: 'title',
                    },
                    {
                        label: 'Author',
                        name: 'author',
                    },
                    {
                        label: 'Publisher',
                        name: 'publisher',
                    },
                ],
            }
        },  
        methods: {
            searchBook(isbn) {
                axios.get('api/book/' + isbn)
                    .then(({data}) => {
                        console.log(data.book);
                        this.form.call_number = data.book[0].call_number
                        this.form.title = data.book[0].title
                        this.form.author = data.book[0].author
                        this.form.publisher = data.book[0].publisher
                    })
                    .catch(error => error.response.data);
            }
        }
    }
</script>