<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Table</h3>

                <div class="card-tools">
                  <button class="btn btn-success" @click="newModal">Add New 
                      <i class="fas fa-user-plus fa-fw"></i> 
                    </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Level</th>
                    <th>Registration Date</th>
                    <th>Modify</th>
                    
                  </tr>
                  <tr v-for="user in users" :key="user.id">
                    <td>{{user.id}}</td>
                    <td>{{user.name}}</td>
                    <td>{{user.email}}</td>
                    <td>{{user.level | upText}}</td>
                    <td>{{user.created_at | myDate}}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" @click="editModal(user)">
                            Edit</button>
                        <button class="btn btn-danger btn-sm" @click="deleteUser(user.id)">
                            Delete</button>
                    </td>
                  </tr>
                         
                </tbody>
                </table>
              </div> 
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div> 


        <!-- Modal -->
    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New</h5>
            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <form @submit.prevent="editmode ? updateUser() : createUser()">
        <div class="modal-body">
            <div class="form-group">
                <input v-model="form.name" type="text" name="name"
                 placeholder="Name"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                <has-error :form="form" field="name"></has-error>
            </div>

            <div class="form-group">
                <input v-model="form.email" type="email" name="email"
                 placeholder="Email"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                <has-error :form="form" field="email"></has-error>
            </div>

            <div class="form-group">
                <input v-model="form.password" type="password" name="password" id="password"
                 placeholder="Password"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                <has-error :form="form" field="password"></has-error>
            </div>

            <div class="form-group">
                <select id="level" name="level" v-model="form.level" 
                class="form-control" :class="{ 'is-invalid': form.errors.has('level') }">
                <option value="">Select User Role</option>
                <option value="admin">Admin</option>
                <option value="moderator">Moderator</option>
                <option value="user">User</option>
                </select>
            </div>

             <div class="form-group">
                <textarea v-model="form.bio" type="text" name="bio"
                 placeholder="User bio (Optional)"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                <has-error :form="form" field="bio"></has-error>
            </div>

        </div>
       

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
            <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
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
                editmode: false,
                users : {},
                form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    level: '',
                    bio: '',
                    photo: ''
                })
            }
        },
        methods: {
            updateUser() {
                this.$Progress.start();
                this.form.put('api/user/'+this.form.id)
                .then(() => {
                    //success
                    swal(
                        'Updated!',
                        'User updated successfully.',
                        'success'
                    )
                    Fire.$emit('AfterCreation');
                    $('#addNew').modal('hide');
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                });
            },
            editModal(user) {
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(user);
            },
            newModal() { 
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deleteUser(id) {
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'    
                    }).then((result) => {
                        
                        //send request to the server
                        if (result.value) {
                            this.form.delete('api/user/'+id).then(()=> {
                                swal(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                    )
                                Fire.$emit('AfterCreation');
                            }).catch(()=> {
                                swal("Failed!", "Something went wrong", "warning");
                            });
                        }
                })
            },
            loadUsers() {
                axios.get("api/user").then(({ data }) => (this.users = data.data));
            },
            createUser() {
                this.$Progress.start();
                this.form.post('api/user')
                .then(()=>{
                    Fire.$emit('AfterCreation');
                    $('#addNew').modal('hide');
                    toast({
                    type: 'success',
                    title: 'User created successfully'
                    });
                    this.$Progress.finish();
                })
                .catch(()=>{

                });
            }
        },
        mounted() {
            this.loadUsers();
            Fire.$on('AfterCreation', () => {
                this.loadUsers();
            });
        }
    }
</script>
