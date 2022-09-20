<template>
    <div>
        <h1 class="mb-4"><i class="fas fa-sign-in-alt"></i> Login</h1>
        
        <!-- <form id="travelInsuranceForm" @submit.prevent="makeInsurance"> -->
        <form id="loginForm" @submit.prevent="loginUser">
            <div v-if="error" class="alert alert-danger" role="alert">
                {{ this.message }}
            </div>

            <div v-if="success" class="alert alert-success" role="alert">
                {{ this.message }}
            </div>
            <div class="form-group row">
                <div class="col-6">
                    <label for="email">Email&nbsp;Address</label>
                    <input name="email" type="text" class="form-control" id="email" placeholder="Email Address">
                    <div class="invalid-feedback text-right">
                        Email Address is required for you to log in.
                    </div>
                </div>
                <div class="col-6">
                    <label for="password">Password</label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="Enter Password">
                    <div class="invalid-feedback text-right">
                        Password is required for you to log in.
                    </div>
                </div>
            </div>
            <small><a @click="navbar.mainPageComp('Register')" class="text-white">Don't have an account?</a></small>
            
            <button type="submit" class="btn btn-primary btn-lg">Login</button>
        </form>
    </div>
</template>

<script>
import navbar from './navbar.vue';

export default {
    components: {
        navbar
    },
    data() {
        return {
            success: false,
            error: false,
            message: '',
            test: 'https://tallpad.com/series/vuejs-misc/lessons/component-communication-in-vue3-sibling-parent-and-child-components'
        }
    },
    methods: {
        loginUser(e) {
            let fieldEmpty = false;
            let filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            document.querySelectorAll('#loginForm input').forEach(input => {

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
                    email: e.target.email.value,
                    password: e.target.password.value
                };


                if (filter.test(formData.email)) {
                    document.querySelector('#email').classList.remove('is-invalid');
                } else {
                    document.querySelector('#email').classList.add('is-invalid');
                    document.querySelector('#email').nextSibling.innerText = 'This field has to be valid email.';
                    return;
                }

                if (formData.password.length >= 6) {
                    document.querySelector('#password').classList.remove('is-invalid');
                } else {
                    document.querySelector('#password').classList.add('is-invalid');
                    document.querySelector('#password').nextSibling.innerText = 'Password Invalid.';
                    return;
                }


                axios({
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json',
                        // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    url: '/api/user/login',
                    data: formData
                })
                    .then((res) => {
                        if (res.data.error) {

                            if (res.data.message.hasOwnProperty('email')) {
                                document.querySelector('#email').classList.add('is-invalid');
                                document.querySelector('#email').nextSibling.innerText = res.data.message.email[0];
                            }

                            if (res.data.message.hasOwnProperty('password')) {
                                document.querySelector('#password').classList.add('is-invalid');
                                document.querySelector('#password').nextSibling.innerText = res.data.message.password[0];
                            }

                            setTimeout(function() {
                                this.error = false;
                                this.message = '';
                            }, 5000)
                        }

                        if (res.data.success) {
                            this.success = res.data.success;
                            this.message = res.data.message;

                            document.querySelectorAll('#loginForm input').forEach(input => {
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

#loginForm {
    background-color: #1976d27c;
    padding: 2rem 2rem 4rem 2rem;
    border-radius: 2%;
}

.invalid-feedback {
    color: #fff!important;
}

.pictureError {
    margin-top: 2.5rem;
}

#loginForm button {
    float: right;
}

#loginForm a {
    cursor: pointer;
}
</style>