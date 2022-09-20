<template>
    <div>
        <h1 class="mb-4"><i class="fas fa-user-plus"></i> Register</h1>
        
        <!-- <form id="travelInsuranceForm" @submit.prevent="makeInsurance"> -->
        <form id="registerForm" @submit.prevent="registerUser" enctype="multipart/form-data">
            <div v-if="error" class="alert alert-danger" role="alert">
                {{ this.message }}
            </div>

            <div v-if="success" class="alert alert-success" role="alert">
                {{ this.message }}
            </div>

            <div class="form-group row">
                <div class="col-6">
                    <label for="first_name">First Name</label>
                    <input name="first_name" type="text" class="form-control" id="first_name" placeholder="First Name">
                    <div class="invalid-feedback text-right">
                        First Name field is mandatory.
                    </div>
                </div>
                <div class="col-6">
                    <label for="last_name">Last Name</label>
                    <input name="last_name" type="text" class="form-control" id="last_name" placeholder="Last Name">
                    <div class="invalid-feedback text-right">
                        Last Name field is mandatory.
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input name="email" type="text" class="form-control" id="email" placeholder="Email Address">
                <div class="invalid-feedback text-right">
                    Email Addres field is mandatory.
                </div>
            </div>
            <div class="form-group row">
                <div class="col-6">
                    <label for="password">Password</label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="Enter Password">
                    <div class="invalid-feedback text-right">
                        Password field is mandatory.
                    </div>
                </div>
                <div class="col-6">
                    <label for="confirm">Confirm&nbsp;Password</label>
                    <input name="password_confirmation" type="password" class="form-control" id="confirm" placeholder="Confirm Password">
                    <div class="invalid-feedback text-right">
                        Confirm Password field is mandatory.
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-6">
                    <div class="custom-file">
                        <input @change="showFileName" type="file" name="profile_picture" class="custom-file-input" id="profile_picture">
                        <label class="custom-file-label" for="profile_picture">Choose picture (Optional)</label>
                        <div></div>
                        <div v-if="pictureError" class="text-right pictureError">
                            Photo only allows file types of PNG, JPG, JPEG and SVG.
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control" id="status">
                            <option value="user" selected>User (default)</option>
                            <option value="admin">Admin</option>
                            <option value="superadmin">Super Admin</option>
                        </select>
                    </div>
                    <div class="invalid-feedback text-right">
                        Status field is mandatory.
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</template>

<script>

export default {
    data() {
        return {
            success: false,
            error: false,
            message: '',
            invalidDob: false,
            birthDate: null,
            pictureError: false
        }
    },
    methods: {
        showFileName(e) {
            
            let fileName = document.getElementById('profile_picture').files[0].name;
            let nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
    
        },
        registerUser(e) {
            let fieldEmpty = false;
            let filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            document.querySelectorAll('#registerForm input').forEach(input => {
                if (input.id === 'profile_picture') {
                    return;
                }

                if (!input.value) {
                    fieldEmpty = true;
                    
                    input.classList.add('is-invalid');
                    input.classList.remove('is-valid');
                } else {
                    input.classList.add('is-valid');
                    input.classList.remove('is-invalid');
                }

            });

            document.getElementById('status').style.border = '1px solid green';

            if (!fieldEmpty) {
                
                let formData1 = {
                    first_name: e.target.first_name.value,
                    last_name: e.target.last_name.value,
                    email: e.target.email.value,
                    password: e.target.password.value,
                    password_confirmation: e.target.password_confirmation.value,
                    profile_picture_name: e.target.profile_picture.value,
                    profile_picture: document.getElementById('profile_picture').files[0],
                    status: e.target.status.value
                };


                const formData = new FormData();
                formData.append('first_name', e.target.first_name.value);
                formData.append('last_name', e.target.last_name.value);
                formData.append('email', e.target.email.value);
                formData.append('password', e.target.password.value);
                formData.append('password_confirmation', e.target.password_confirmation.value);

                // formData.append('profile_picture_name', e.target.profile_picture.value);
                // formData.append('profile_picture', document.getElementById('profile_picture').files[0]);

                formData.append('status', e.target.status.value);


                if (filter.test(formData1.email)) {
                    document.querySelector('#email').classList.remove('is-invalid');
                } else {
                    document.querySelector('#email').classList.add('is-invalid');
                    document.querySelector('#email').nextSibling.innerText = 'This field has to be valid email.';
                    return;
                }

                if (formData1.password.length >= 6) {
                    document.querySelector('#password').classList.remove('is-invalid');
                } else {
                    document.querySelector('#password').classList.add('is-invalid');
                    document.querySelector('#password').nextSibling.innerText = 'Password has to be at least 6 characters long.';
                    return;
                }

                if (formData1.password === e.target.password_confirmation.value) {
                    document.querySelector('#password').classList.remove('is-invalid');
                } else {
                    document.querySelector('#password').classList.add('is-invalid');
                    document.querySelector('#confirm').classList.add('is-invalid');
                    document.querySelector('#password').nextSibling.innerText = 'Passwords need to match.';
                    document.querySelector('#confirm').nextSibling.innerText = 'Passwords need to match.';
                    return;
                }

                // if (document.getElementById('profile_picture').files[0]) {
                //     const pictureExtension = document.getElementById('profile_picture').files[0].name.substring(
                //         document.getElementById('profile_picture').files[0].name.lastIndexOf('.') + 1
                //     ).toLowerCase();
                    
                //     if (pictureExtension == 'png' || pictureExtension == 'jpg' || pictureExtension == 'jpeg' || pictureExtension == 'svg') {
                //         this.pictureError = false;
                //         formData.profile_picture = document.getElementById('profile_picture').files[0];
                //         document.querySelector('#profile_picture').classList.add('is-valid');
                //         document.querySelector('#profile_picture').classList.remove('is-invalid');
                //     } else {
                //         this.pictureError = true;
                //         fieldEmpty = true;
                //         document.querySelector('#profile_picture').classList.add('is-invalid');
                //         return;
                //     }
                // }

                if (formData1.profile_picture_name) {
                    const pictureExtension = formData1.profile_picture_name.substring(
                        formData1.profile_picture_name.lastIndexOf('.') + 1
                    ).toLowerCase();
                    
                    if (pictureExtension == 'png' || pictureExtension == 'jpg' || pictureExtension == 'jpeg' || pictureExtension == 'svg') {
                        this.pictureError = false;
                        document.querySelector('#profile_picture').classList.add('is-valid');
                        document.querySelector('#profile_picture').classList.remove('is-invalid');
                        formData.append('profile_picture_name', e.target.profile_picture.value);
                        formData.append('profile_picture', document.getElementById('profile_picture').files[0]);
                    } else {
                        this.pictureError = true;
                        
                        document.querySelector('#profile_picture').classList.add('is-invalid');
                        return;
                    }
                }

                axios({
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    url: '/api/user/store',
                    data: formData
                })
                    .then((res) => {
                        if (res.data.error) {
                            // console.log(res.data.message.password[0], Object.keys(res.data.message), res.data.message)

                            if (res.data.message.hasOwnProperty('first_name')) {
                                document.querySelector('#first_name').classList.add('is-invalid');
                                document.querySelector('#first_name').nextSibling.innerText = res.data.message.first_name[0];
                            }

                            if (res.data.message.hasOwnProperty('last_name')) {
                                document.querySelector('#last_name').classList.add('is-invalid');
                                document.querySelector('#last_name').nextSibling.innerText = res.data.message.last_name[0];
                            }

                            if (res.data.message.hasOwnProperty('email')) {
                                document.querySelector('#email').classList.add('is-invalid');
                                document.querySelector('#email').nextSibling.innerText = res.data.message.email[0];
                            }

                            if (res.data.message.hasOwnProperty('password')) {
                                document.querySelector('#password').classList.add('is-invalid');
                                document.querySelector('#password').nextSibling.innerText = res.data.message.password[0];
                                if (res.data.message.password[0] === 'The password confirmation does not match.') {
                                    document.querySelector('#password_confirmation').classList.add('is-invalid');
                                }
                            }

                            if (res.data.message.hasOwnProperty('password_confirmation')) {
                                document.querySelector('#password_confirmation').classList.add('is-invalid');
                                document.querySelector('#password_confirmation').nextSibling.innerText = res.data.message.password_confirmation[0];
                            }

                            if (res.data.message.hasOwnProperty('profile_picture')) {
                                document.querySelector('#profile_picture').classList.add('is-invalid');
                                document.querySelector('#profile_picture').nextSibling.innerText = res.data.message.profile_picture[0];
                            }

                            if (res.data.message.hasOwnProperty('status')) {
                                document.querySelector('#status').classList.add('is-invalid');
                                document.querySelector('#status').nextSibling.innerText = res.data.message.status[0];
                            }

                            setTimeout(function() {
                                this.error = false;
                                this.message = '';
                            }, 5000)
                        }

                        if (res.data.success) {
                            this.success = res.data.success;
                            this.message = res.data.message;

                            document.querySelectorAll('#registerForm input').forEach(input => {
                                input.value = '';
                                input.classList.remove('is-valid');
                                document.getElementById('status').style.border = null;
                            });

                            setTimeout(function() {
                                this.success = false;
                                this.message = '';

                            }, 5000);
                        }
                    })
                    .catch((error) => console.log(error));
            }
                
        }
    }
}
</script>

<style>
label.custom-file-label {
    margin-top: 2rem;
}

#registerForm {
    background-color: #1976d27c;
    padding: 2rem;
    border-radius: 2%;
}

.invalid-feedback {
    color: #fff!important;
}

.pictureError {
    margin-top: 2.5rem;
}
</style>