<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Admin Panel</div>

                    <div class="card-body">
                        <button @click="showUserModal()" class="btn btn-success">Add new User</button><br><br>


                        <table class="table">
                            <thead>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Actions</th>

                            </thead>
                            <tbody>
                                <tr v-for="(user, index) in users" :key="user.id">
                                    <td>{{user.id}}</td>
                                    <td>{{user.name}}</td>
                                    <td>{{user.email}}</td>
                                    <td><button @click="showUser(index)" class="btn btn-success">Edit User</button></td>
                                    <td><button @click="deleteUser(index)" class="btn btn-danger">Delete</button></td>
                                    <td><button @click="showContact(user.id)" class="btn btn-sm btn-primary">View Contact Number</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

<!-------------------- Create User Modal ---------------------------------------------->
        <div id="addusermodal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Full name{{name}} </label>
                                <input v-model="name" type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Enter Name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address {{email}} </label>
                                <input v-model="email" type="email" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Enter email">
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with
                                    anyone else.</small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password {{password}} </label>
                                <input v-model="password" type="password" class="form-control"
                                    id="exampleInputPassword1" placeholder="Password">
                                <small id="emailHelp" class="form-text text-muted">Only you and me knows your
                                    password.</small>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button @click="SubmitNewUser()" type="button" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
<!--=------------------------------- Update User Model --------------------------------------------- -->
        <div id="updateusermodal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Full name{{user.name}} </label>
                                <input v-model="user.name" type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Enter Name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address {{user.email}} </label>
                                <input v-model="user.email" type="email" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Enter email">
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with
                                    anyone else.</small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password {{user.password}} </label>
                                <input v-model="user.password" type="password" class="form-control"
                                    id="exampleInputPassword1" placeholder="Password">
                                <small id="emailHelp" class="form-text text-muted">Only you and me knows your
                                    password.</small>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button @click="SubmitUpdateUser()" type="button" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-------------------- addcontact ---------------------------------------------->
        <div id="viewusermodalcontactmodal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       <li v-for="user_contacts in user_contacts" :key="user_contacts.id">
                           {{user_contacts.contact_number}}
                       </li>
                       
                       <br>
                       <br>
                       <label for="text"> Contact Number</label>
                        <input v-model="contactnumber" type="text" class="form-control"> 
                        
                    </div>
                    <div class="modal-footer">
                        <button @click="submitContactNumber()" type="button" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        mounted() {
            this.getUsers();
        },
        data: () => ({
            users: "",
            name: "",
            email: "",
            password: "",
            user: [],
            user_contacts: [],
            contactnumber: '',
            user_contact_id:'',

        }),
        methods: {

            submitContactNumber(){
                
                axios.post('/contacts',{
                    user_id: this.user_contact_id,
                    contactnumber: this.contactnumber
                }).then(response=>{
                    $('#viewusermodalcontactmodal').modal('hide');
                    this.contactnumber = "";
                });
            },
            showContact(id){
                this.user_contact_id = id;
                axios.get('/contacts/' +id, {
                    id: id,
                }).then(response=>{
                    this.user_contacts = response.data.contacts;
                    $('#viewusermodalcontactmodal').modal('show');
                })
            },
           deleteUser(index){
                axios.delete('/users/' + this.users[index].id, {
                    id: this.users[index].id,
                }).then(response =>{
                    this.getUsers();
                    alert(JSON.stringify(response.data.message));
                });
            },
            SubmitUpdateUser(){
                axios.patch('/users/' + this.user.id,{
                    id: this.user.id,
                    name: this.user.name,
                    email: this.user.email,
                    password: this.user.password,
                }).then(response => {
                    //alert(JSON.stringify(response.data.message));
                    this.getUsers();
                    $('#updateusermodal').modal('hide');
                });
            },
            showUser(index) {
                this.user = this.users[index];
                $('#updateusermodal').modal('show');
            },
            SubmitNewUser() {
                axios.post('/users', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                }).then(response => {

                    this.getUsers();
                    $('#addusermodal').modal('hide');
                });
            },
            showUserModal() {
                $('#addusermodal').modal('show');

            },
            getUsers() {
                axios.get('/users/')
                    .then(response => {
                        this.users = response.data.users;

                    })

            },
        },
    }

</script>
