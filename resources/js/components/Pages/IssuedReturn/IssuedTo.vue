<template>
    <div>
        <div class="card">
            <div class="card-header">
                Borrower Information
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="Borrower ID" class="col-md-4 col-form-label text-md-left">Borrower ID</label>
                    <div class="col-md-5">
                        <input type="text" v-on:keydown.enter="searchBorrower(form['borrower_id'])" class="form-control" v-model="form['borrower_id']">
                    </div>
                    <button ref="id" class="btn btn-sm btn-primary" @click="searchBorrower(form['borrower_id'])  ">Search Borrower</button>
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
                    borrower_id: null,
                    name: null,
                    major: null,
                    type: null,
                    penalty: null,
                }),
                items: [
                    {
                        label: 'Name',
                        name: 'name',
                    },
                    {
                        label: 'Major',
                        name: 'major',
                    },
                    {
                        label: 'Type',
                        name: 'type',
                    },
                    {
                        label: 'Penalty',
                        name: 'penalty',
                    },
                ],
                borrower:[],
                id_from: [],
            }
        },
        created() {
            if (localStorage.getItem('borrower_id') != null) {
                this.id_from = localStorage.getItem('borrower_id').split(',')
                if (this.id_from[1] == 'book-records') {
                    this.form.borrower_id = this.id_from[0]
                    setTimeout(() => { 
                        this.$refs.id.click()
                    }, 100);
                }
                localStorage.removeItem('borrower_id')
            }

        },
        methods: {
            emptyFields() {
                this.form.clear()
                this.form.reset()
                EventBus.$emit('clearData')
            },
            searchBorrower(id) {
                if (!id) {
                    this.emptyFields()
                } else {
                    axios.get('api/borrower/' + id)
                        .then(({data}) => {
                            if (data.borrower.length == 0) {
                                this.showWarning()
                            } else {
                                this.form.name = data.borrower[0].name
                                this.form.major = (data.borrower[0].major != null ? data.borrower[0].major : 'None')
                                this.form.type = (data.borrower[0].major != null ?  'Student' : 'Faculty')
                                this.form.penalty = 0

                                this.$emit('borrowerID', id)
                            }
                        })
                        .catch(error => error.response.data);
                }
            },
            showWarning() {
                Swal.fire({
                    title: 'Borrower Not Found!',
                    text: "Please check the Borrower ID.",
                    icon: 'warning',
                })
                this.emptyFields()
            }
        }
    }
</script>