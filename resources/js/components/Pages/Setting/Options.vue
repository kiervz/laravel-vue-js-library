<template>
    <div class="container-fluid">
        <div class="card mx-auto">
            <div class="card-body">
                <div class="form-group row">
                    <label for="" class="col-md-4 col-form-label text-md-right">Penalty Per Day</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" v-model="form['penalty']">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-4 col-form-label text-md-right">Books Allowed To Borrow</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" v-model="form['books_allowed']">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-4 col-form-label text-md-right">Days Allowed To Borrow</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" v-model="form['days_allowed']">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-4"></div>
                    <div class="col-md-6">
                        <button class="btn btn-primary btn-md form-control" @click="updateOption">Update</button>
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
                    id: '',
                    penalty: '',
                    books_allowed: '',
                    days_allowed: ''
                }),
            }
        },
        created() {
            this.fetchOption()
        },
        methods: {
            fetchOption() {
                axios.post('api/option')
                    .then(({data}) => {
                        this.form = data.options[0]
                    })
                    .catch(error => error.response.data)
            },
            updateOption() {
                axios.put('api/option/1', this.form)
                    .then(({data}) => {
                        Toast.fire({
                            icon: data.status,
                            title: data.message
                        });
                    })
                    .catch(error => error.response.data)
            }
        }
    }
</script>