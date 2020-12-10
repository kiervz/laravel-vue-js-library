<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-baseline">
                    <div class="d-flex align-items-center">
                        <h3 class="card-title">Students</h3>
                    </div>
                    <div class="float-right">
                        <button class="btn btn-sm btn-primary show-book-modal" @click="addModal" data-title="ADD">
                            Student Register <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Major</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="student in students.data" :key="student.id">
                                <td>{{ student.student_id }}</td>
                                <td>{{ student.name }}</td>
                                <td>{{ student.gender }}</td>
                                <td>{{ student.major }}</td>
                                <td>{{ student.phone }}</td>
                                <td>
                                    <i class="fas fa-edit" @click="editModal(student)"></i>
                                    |
                                    <i class="fas fa-trash" @click="deleteStudent(student.id)"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <div class="float-center">
                    <advanced-laravel-vue-paginate 
                        :data="students" 
                        :onEachSide="true"
                        dots="..."
                        @paginateTo="fetchStudents"
                    />
                </div>
            </div>
        </div>

        <!-- User Modal -->
        <div class="modal fade" id="add_student" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <form @submit.prevent="editMode ? updateStudent() : createStudent()">
                        <!-- Modal Header -->
                        <div class="modal-header bg-dark text-white">
                            <h5 v-show="!editMode" class="modal-title">Register Student</h5>
                            <h5 v-show="editMode" class="modal-title">Update Student</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span class="text-white" aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- Modal Content -->
                        <div class="modal-body text-muted">
                            <div class="row">
                                <div class="col-12">
                                    <div v-for="(item, $index) in items" :key="$index" class="form-group-sm">
                                        <label :for="item.name" class="mt-1">{{ item.label }}</label>
                                        <div v-if="item.type == 'dropdown'">
                                            <select
                                                v-model="form[item.name]"
                                                class="form-control"
                                                :class="errors[item.name] ? 'is-invalid' : form.errors.has(item.name)"
                                            >
                                                <option value="" disabled selected>Select Gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                            <span role="alert" v-if="errors[item.name]" :class="errors[item.name] ? 'invalid-feedback d-block' : ''">
                                                <strong>{{ errors[item.name][0] }}</strong>
                                            </span>
                                        </div>
                                        <div v-else>
                                            <div>
                                                <input
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
                form: new Form({
                    id: '',
                    student_id: '',
                    name: '',
                    gender: '',
                    major: '',
                    phone: ''
                }),
                items: [
                    {
                        label: "Student ID",
                        name: "student_id",
                        required: "required",
                        type: "text"
                    },
                    {
                        label: "Name",
                        name: "name",
                        required: "required",
                        type: "text"
                    },
                    {
                        label: "Gender",
                        name: "gender",
                        required: "required",
                        type: "dropdown"
                    },
                    {
                        label: "Major",
                        name: "major",
                        required: "required",
                        type: "text"
                    },
                    {
                        label: "Phone",
                        name: "phone",
                        required: "required",
                        type: "text"
                    },
                ],
                students: [],
                editMode: false,
                errors: []
            }
        },
        created() {
            this.fetchStudents()
            this.$on('refreshStudents', () => {
                this.fetchStudents()
                this.form.clear()
                this.form.reset()
                this.errors = []
                this.editMode = false
            })
        },
        methods: {
            addModal() {
                this.form.clear()
                this.form.reset()
                this.errors = []
                this.editMode = false
                $('#add_student').modal('show')
            },
            editModal(student) {
                this.form.clear()
                this.form.reset()
                this.errors = []
                this.editMode = true
                this.form.fill(student)
                $('#add_student').modal('show')
            },
            deleteStudent(id) {
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
                        this.$Progress.start();
                        this.form.delete('api/student/' + id)
                            .then(({ data }) => {
                                Toast.fire({
                                    icon: data.status,
                                    title: data.message
                                });
                                this.$emit('refreshStudents')
                                $('#add_student').modal('hide')
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
                });
            },
            fetchStudents(page) {
                let url = page ? `api/student?page=${page}` : 'api/student'
                this.$Progress.start()
                axios.get('api/student')
                    .then(({ data }) => {
                        this.students = data.students
                        this.$Progress.finish()
                    })
                    .catch(error => {
                        error.response.data
                        this.$Progress.fail()
                    })
            },
            createStudent() {
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
                        this.form.post('api/student', this.form)
                            .then(({ data }) => {
                                Toast.fire({
                                    icon: data.status,
                                    title: data.message
                                });
                                this.$emit('refreshStudents')
                                $('#add_student').modal('hide')
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
                });
            },
            updateStudent(student) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, update it!'
                }).then((result) => {
                    if (result.value) {
                        this.$Progress.start();
                        this.form.put('api/student/' + this.form.id)
                            .then(({ data }) => {
                                Toast.fire({
                                    icon: data.status,
                                    title: data.message
                                });
                                this.$emit('refreshStudents')
                                $('#add_student').modal('hide')
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
                });
            }
        }
    }
</script>