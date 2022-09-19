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
                    <label for="confirm">Confirm Password</label>
                    <input name="confirm" type="password" class="form-control" id="confirm" placeholder="Confirm Password">
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
                    <label for="Status">Status</label>
                    <input name="status" type="text" class="form-control" id="status" placeholder="Enter User Status">
                    <div class="form-group">
                        <label for="exampleSelect">Example select</label>
                        <select class="form-control" id="exampleSelect">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
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
                // if (!document.getElementsByName('departure')[0].value) {
                //     fieldEmpty = true;
                    
                //     this.invalidDeparture = true;
                // } else {
                //     this.invalidDeparture = false;
                //     input.classList.add('is-valid');
                // }

                if (!input.value) {
                    fieldEmpty = true;
                    
                    input.classList.add('is-invalid');
                    input.classList.remove('is-valid');
                } else {
                    input.classList.add('is-valid');
                    input.classList.remove('is-invalid');
                }

            });

            if (!fieldEmpty) {
                let formData = {
                    first_name: e.target.first_name.value,
                    last_name: e.target.last_name.value,
                    email: e.target.email.value,
                    password: e.target.password.value,
                    profile_picture: e.target.profile_picture.value,
                    status: e.target.status.value
                };

                if (filter.test(formData.email)) {
                    document.querySelector('#email').classList.remove('is-invalid');
                } else {
                    document.querySelector('#email').classList.add('is-invalid');
                    document.querySelector('#email').nextSibling.innerText = 'This field has to be valid email.';
                    return;
                }

                if (formData.profile_picture) {
                    const pictureExtension = formData.profile_picture.substring(
                        formData.profile_picture.lastIndexOf('.') + 1
                    ).toLowerCase();
                    
                    if (pictureExtension == 'png' || pictureExtension == 'jpg' || pictureExtension == 'jpeg' || pictureExtension == 'svg') {
                        this.pictureError = false;
                        document.querySelector('#profile_picture').classList.add('is-valid');
                        document.querySelector('#profile_picture').classList.remove('is-invalid');
                    } else {
                        this.pictureError = true;
                        document.querySelector('#profile_picture').classList.add('is-invalid');
                        return;
                    }
                }
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