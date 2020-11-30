<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="d-flex align-items-center">
                    <h3 class="card-title">Users</h3>
                </div>
                <div class="float-right">
                    <button class="btn btn-sm btn-primary" @click="addModal" data-title="ADD">
                        ADD NEW <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>User Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" :key="user.id">
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.user_type }}</td>
                            <td>
                                <i class="fas fa-edit" @click="editModal(user)"></i>
                                |
                                <i class="fas fa-trash" @click="deleteUser(user.id)"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            <div class="float-right">
                <!-- pagination here -->
            </div>
        </div>

        <!-- User Modal -->
        <div class="modal fade" id="add_user" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <form @submit.prevent="editMode ? updateUser() : addUser()">
                        <!-- Modal Header -->
                        <div class="modal-header bg-dark text-white">
                            <h5 v-show="!editMode" class="modal-title">Register User</h5>
                            <h5 v-show="editMode" class="modal-title">Update User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span class="text-white" aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- Modal Content -->
                        <div class="modal-body text-muted">
                            <div class="row">
                                <!-- second row -->
                                <div class="col-12">
                                    <div v-for="(item, $index) in items" :key="$index" class="form-group-sm">
                                        <label :for="item.name" class="mt-1">{{ item.label }}</label>
                                        <div v-if="item.type == 'dropdown'">
                                            <select
                                                :name="item.name"
                                                :id="item.name"
                                                v-model="form[item.name]"
                                                class="form-control"
                                                :class="errors[item.name] ? 'is-invalid' : form.errors.has(item.name)"
                                            >
                                                <option value="" disabled selected>Select User Type</option>
                                                <option
                                                    v-for="item in user_types"
                                                    :value="item.name"
                                                    :key="item.id">
                                                    {{ item.name }}
                                                </option>
                                            </select>
                                            <span role="alert" v-if="errors[item.name]" :class="errors[item.name] ? 'invalid-feedback d-block' : ''">
                                                <strong>{{ errors[item.name][0] }}</strong>
                                            </span>
                                        </div>
                                        <div v-else>
                                            <div>
                                                <input
                                                    :disabled="editMode && (item.name == 'password' || item.name == 'confirm_password')"
                                                    :id="item.name"
                                                    :name="item.name"
                                                    :type="item.type"
                                                    v-model="form[item.name]"
                                                    class="form-control"
                                                    :class="errors[item.name] ? 'is-invalid' : form.errors.has(item.name)"
                                                >
                                            </div>
                                            <span role="alert" v-if="errors[item.name]" :class="errors[item.name] ? 'invalid-feedback d-block' : ''">
                                                <strong>{{ errors[item.name][0] }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary p-18" data-dismiss="modal">Cancel</button>
                            <button v-show="!editMode" type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i>Save
                            </button>
                            <button v-show="editMode" type="submit" class="btn btn-primary">
                                <i class="fas fa-pen mr-1"></i>Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                users: {},
                user_types: [
                    {
                        id: 1, 
                        name: 'Administrator'
                    }, 
                    {
                        id:2, 
                        name: 'Librarian'
                    }, 
                    {
                        id: 3, 
                        name: 'Student Assistant'
                    }
                ],
                form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    user_type: '',
                    password: '',
                    confirm_password: '',
                }),
                items: [
                    {
                        label: "Name",
                        name: "name",
                        required: "required",
                        type: "text"
                    },
                    {
                        label: "Email Address",
                        name: "email",
                        required: "required",
                        type: "email"
                    },
                    {
                        label: "User Type",
                        name: "user_type",
                        required: "required",
                        type: "dropdown"
                    },
                    {
                        label: "Password",
                        name: "password",
                        required: "required",
                        type: "password"
                    },   
                    {
                        label: "Confirm Password",
                        name: "confirm_password",
                        required: "required",
                        type: "password"
                    },     
                ],
                errors: [],
                editMode: false,
            }
        },
        created() {
            this.fetchUsers()
            this.$on('refreshUsers', () => {
                this.form.clear()
                this.form.reset()
                this.fetchUsers()
                this.editMode = false
                this.errors = []
            })
        },
        methods: {
            fetchUsers() {
                this.$Progress.start()
                axios.get('api/user')
                    .then(({ data }) => {
                        this.users = data.users
                        this.$Progress.finish()
                    })
                    .catch(error => {
                        error.response.data
                        this.$Progress.fail();
                    })
            },
            addModal() {
                this.form.clear()
                this.form.reset()
                $('#add_user').modal('show')
                this.editMode = false
                this.errors = []
            },
            editModal(user) {
                this.form.clear()
                this.form.reset()
                this.editMode = true
                this.errors = []
                $('#add_user').modal('show')
                this.form.fill(user)
            },
            addUser() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, save it!'
                }).then((result) => {
                    if (result.value) {
                        this.form.post('api/user', this.form)
                            .then(({ data }) => {
                                Toast.fire({
                                    icon: data.status,
                                    title: data.message
                                });
                                this.$emit('refreshUsers')
                                $('#add_user').modal('hide')
                                this.$Progress.finish();
                            })
                            .catch(error => {
                                this.errors = error.response.data.errors;
                                Toast.fire({
                                    icon: 'warning',
                                    title: 'Something went wrong.',
                                });
                                this.$Progress.fail();
                            })
                    }
                })
                
                    
            },
            updateUser() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, update it!'
                }).then((result) => {
                    if (result.value) {
                        this.form.put('api/user/' + this.form.id)
                            .then(({ data }) => {
                                Toast.fire({
                                    icon: data.status,
                                    title: data.message
                                });
                                this.$emit('refreshUsers')
                                $('#add_user').modal('hide')
                                this.$Progress.finish();
                            })
                            .catch(error => {
                                this.errors = error.response.data.errors;
                                Toast.fire({
                                    icon: 'warning',
                                    title: 'Something went wrong.',
                                });
                                this.$Progress.fail();
                            })
                    }
                })
            },
            deleteUser(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        this.form.delete('api/user/' + id)
                            .then(({ data }) => {
                                Toast.fire({
                                    icon: data.status,
                                    title: data.message
                                });
                                this.$emit('refreshUsers')
                                $('#add_user').modal('hide')
                                this.$Progress.finish();
                            })
                            .catch(error => {
                                this.errors = error.response.data.errors;
                                Toast.fire({
                                    icon: 'warning',
                                    title: 'Something went wrong.',
                                });
                                this.$Progress.fail();
                            })
                    }
                })
            }
        }
    }
</script>