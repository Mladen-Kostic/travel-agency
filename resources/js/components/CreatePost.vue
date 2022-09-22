<template>
    <div>
        <h1 class="mb-4 pb-4"><i class="fas fa-plus"></i> Create Post</h1>
        
        <!-- <form id="travelInsuranceForm" @submit.prevent="makeInsurance"> -->
        <form id="createPostForm" @submit.prevent="createPost" enctype="multipart/form-data">
            <div v-if="error" class="alert alert-danger" role="alert">
                {{ this.message }}
            </div>

            <div v-if="success" class="alert alert-success" role="alert">
                {{ this.message }}
            </div>

            <input type="hidden" name="users_id" :value="auth_user_id">
            <!-- Last Insert id on post for post_statuses -->

            <div class="form-group row">
                <div class="col-6">
                    <label for="post_title">Post Title</label>
                    <input name="post_title" type="text" class="form-control" id="post_title" placeholder="Post Title">
                    <div class="invalid-feedback text-right">
                        Post Title field is mandatory.
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-groupmb-0">
                        <label for="post_types">Post Type</label>
                        <select name="post_types" class="form-control" id="post_types">
                            <!-- post_types-news-1 -->
                            <!-- post_types-blog-2 -->
                            <option value="0">Select Post Type</option>
                            <option value="1">News</option>
                            <option value="2">Blog</option>
                        </select>
                    </div>
                    <div id="postTypesError" class="text-right selectInvalid">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    <label>Post Short Description</label>
                    <div>
                        <QuillEditor
                            id="postShortDescription"
                            theme="snow"
                            contentType="text"
                            :toolbar="['bold', 'italic', 'underline', 'link']"
                            v-model:content="postShortDescription"
                        />
                    </div>
                    <div id="postShortDescriptionError" class="selectInvalid text-right">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    <label>Post Content</label>
                    <div>
                        <QuillEditor
                            id="postContent"
                            theme="snow"
                            contentType="html"
                            v-model:content="postContent"
                        />
                    </div>
                    <div id="postContentError" class="selectInvalid text-right">
                        {{ postContent }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <!-- Last Insert id on post for post_statuses -->
                <div class="col-6">
                    <div class="form-group mb-0">
                        <label for="post_statuses">Post Status</label>
                        <select name="post_statuses" class="form-control" id="post_statuses">
                            <option value="0">Select Post Status</option>
                            <option value="published_at">Publish</option>
                            <option value="archived_at">Archive</option>
                            <option value="staging">Stage</option>
                        </select>
                    </div>
                    <div id="postStatusesError" class="text-right selectInvalid">
                    </div>
                </div>

                <div class="col-6">
                    <div class="custom-file">
                        <input @change="showFileName" type="file" name="post_cover_img" class="custom-file-input" id="post_cover_img">
                        <label class="custom-file-label" for="post_cover_img">Choose Post Cover (Optional)</label>
                        <div></div>
                        <div v-if="pictureError" class="text-right pictureError">
                            Cover Photo only allows file types of PNG, JPG, JPEG and SVG.
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Create Post</button>
        </form>
    </div>
</template>

<script>
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';

export default {
    components: {
        QuillEditor
    },
    props: {
        auth_user_id: Number,
    },
    data() {
        return {
            success: false,
            error: false,
            message: '',
            pictureError: false,
            postShortDescription: '',
            postContent: ''
        }
    },
    methods: {
        showFileName(e) {
            
            let fileName = document.getElementById('post_cover_img').files[0].name;
            let nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
    
        },
        createPost(e) {
            let fieldEmpty = true;
            // let fieldEmpty = false;

            // document.querySelectorAll('#createPostForm input').forEach(input => {
            //     if (input.id === 'post_cover_img') {
            //         return;
            //     }

            //     if (!input.value) {
            //         fieldEmpty = true;
                    
            //         input.classList.add('is-invalid');
            //         input.classList.remove('is-valid');
            //     } else {
            //         input.classList.add('is-valid');
            //         input.classList.remove('is-invalid');
            //     }

            // });

            // document.getElementById('status').style.border = '1px solid green';

            const formData1 = {
                post_title: e.target.post_title.value,
                post_types: e.target.post_types.value,
                post_short_description: this.postShortDescription,
                post_content: this.postContent,
                post_statuses: e.target.post_statuses.value,
                post_cover_img: e.target.post_cover_img.value
            }

            if (!formData1.post_title) {
                fieldEmpty = true;

                document.getElementById('post_title').classList.add('is-invalid');
                document.getElementById('post_title').classList.remove('is-valid');
            } else {
                document.getElementById('post_title').classList.add('is-valid');
                document.getElementById('post_title').classList.remove('is-invalid');
            }

            if (formData1.post_types == 0) {
                fieldEmpty = true;

                document.getElementById('post_types').style.border = '1px solid red';
                document.getElementById('postTypesError').innerText = 'Post Type field is mandatory.';
            } else {
                document.getElementById('post_types').style.border = '2px solid green';
            }

            // if (!formData1.post_short_description) {
            //     fieldEmpty = true;

            //     document.getElementById('post_types').style.border = '1px solid red';
            //     document.getElementById('postTypesError').innerText = 'Post Type field is mandatory.';
            // } else {
            //     document.getElementById('post_types').style.border = '2px solid green';
            // }

            if (formData1.post_statuses == 0) {
                fieldEmpty = true;

                document.getElementById('post_statuses').style.border = '1px solid red';
                document.getElementById('postStatusesError').innerText = 'Post Status field is mandatory.';

            } else {
                document.getElementById('post_statuses').style.border = '2px solid green';
            }


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
                    url: '/user/store',
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

#createPostForm {
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

.selectInvalid {
    width: 100%;
    /* margin-top: 0.25rem; */
    font-size: 80%;
}

.ql-toolbar {
    background-color: #fff;
    border-radius: 0.7rem 0.7rem 0 0;
}

.ql-editor {
    background-color: #fff;
    min-height: 90px;
    color: #000;
}

</style>