<template>
    <div>
        <h1 class="mb-4"><i class="fas fa-edit"></i> Edit Post</h1>
        <!-- <form id="travelInsuranceForm" @submit.prevent="makeInsurance"> -->
        <form id="editPostForm" @submit.prevent="editPost" enctype="multipart/form-data">

            <input type="hidden" name="id" id="id" v-if="postEditData" :value="postEditData.id">

            <div class="form-group row">
                <div class="col-6">
                    <label for="post_title">Post Title</label>
                    <input
                        name="post_title"
                        type="text"
                        class="form-control"
                        id="post_title"
                        placeholder="Post Title"
                        v-if="postEditData"
                        :value="postEditData.post_title"
                    >
                    <div class="invalid-feedback text-right">
                        Post Title field is mandatory.
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-groupmb-0">
                        <label for="post_types">Post Type</label>
                        <select name="post_types" class="form-control" id="post_types" v-if="postEditData">
                            <!-- post_types-news-1 -->
                            <!-- post_types-blog-2 -->
                            <option value="0">Select Post Type</option>
                            <option value="1" :selected="postEditData.post_type == 'news'">News</option>
                            <option value="2" :selected="postEditData.post_type == 'blog'">Blog</option>
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
                            v-if="postEditData"
                            id="postShortDescription"
                            theme="snow"
                            contentType="text"
                            :toolbar="['bold', 'italic', 'underline', 'link']"
                            :content="postEditData.post_short_description"
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
                            v-if="postEditData"
                            id="postContent"
                            theme="snow"
                            contentType="html"
                            :content="postEditData.post_content"
                        />
                    </div>
                    <div id="postContentError" class="selectInvalid text-right">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <!-- Last Insert id on post for post_statuses -->
                <div class="col-12">
                    <div class="form-group mb-0">
                        <label for="post_statuses">Post Status</label>
                        <select name="post_statuses" class="form-control" id="post_statuses" v-if="postEditData">
                            <option value="0">Select Post Status</option>
                            <option value="published_at" :selected="postEditData.published_at">Publish</option>
                            <option value="archived_at" :selected="postEditData.archived_at">Archive</option>
                            <option value="staging" :selected="postEditData.staging">Stage</option>
                        </select>
                    </div>
                    <div id="postStatusesError" class="text-right selectInvalid">
                    </div>
                </div>

                <div class="col-6">
                    <div id="customFile" class="custom-file">
                        <input @change="showFileName" type="file" name="post_cover_img" class="custom-file-input" id="post_cover_img">
                        <label class="custom-file-label" for="post_cover_img">Choose Post Cover (Optional)</label>
                        <div></div>
                        <div v-if="pictureError" class="text-right pictureError">
                            Cover Photo only allows file types of PNG, JPG, JPEG and SVG.
                        </div>
                    </div>
                </div>

                <div class="col-6 row">
                    <img id="existingImg" class="col-12 mt-4" v-if="postEditData" :src="'/post_images/' + postEditData.post_cover_img" alt="post-image">
                    <small>Existing Image</small>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Post</button>
        </form>
    </div>
</template>

<script scoped>
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';

export default {
    props: {
        postEditData: Object,
    },
    emits: ['goToPosts'],
    components: {
        QuillEditor
    },
    data() {
        return {
            pictureError: false,
            postShortDescription: '',
            postContent: '',
        }
    },
    methods: {
        showFileName(e) {
            
            let fileName = document.getElementById('post_cover_img').files[0].name;
            let nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
    
        },
        editPost(e) {
            // console.log(document.querySelectorAll('.ql-editor')[1].innerHTML);
            // console.log(document.querySelectorAll('.ql-editor')[0].firstChild.innerText);
            let fieldEmpty = false;

            const formData1 = {
                id: e.target.id.value,
                post_title: e.target.post_title.value,
                post_types: e.target.post_types.value,
                post_short_description: document.querySelectorAll('.ql-editor')[0].firstChild.innerText,
                post_content: document.querySelectorAll('.ql-editor')[1].innerHTML,
                post_statuses: e.target.post_statuses.value,
                post_cover_img: e.target.post_cover_img.files[0]
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
                document.getElementById('post_types').style.border = '1px solid green';
            }

            if (!formData1.post_short_description) {
                fieldEmpty = true;

                document.getElementById('postShortDescription').style.border = '1px solid red';
                document.getElementById('postShortDescriptionError').innerText = 'Post Short Description field is mandatory.';
            } else {
                document.getElementById('postShortDescription').style.border = '1px solid green';
            }

            if (!formData1.post_content) {
                fieldEmpty = true;

                document.getElementById('postContent').style.border = '1px solid red';
                document.getElementById('postContentError').innerText = 'Post Content field is mandatory.';
            } else {
                document.getElementById('postContent').style.border = '1px solid green';
            }

            if (formData1.post_statuses == 0) {
                fieldEmpty = true;

                document.getElementById('post_statuses').style.border = '1px solid red';
                document.getElementById('postStatusesError').innerText = 'Post Status field is mandatory.';

            } else {
                document.getElementById('post_statuses').style.border = '1px solid green';
            }
            
            const formData = new FormData();

            // FORMDATA APPEND
            if (!fieldEmpty) {

                formData.append('id', formData1.id);
                formData.append('post_title', formData1.post_title);
                formData.append('post_types', formData1.post_types);
                formData.append('post_short_description', formData1.post_short_description);
                formData.append('post_content', formData1.post_content);
                formData.append('post_statuses', formData1.post_statuses);

                if (formData1.post_cover_img) {
                    const pictureExtension = formData1.post_cover_img.name.substring(
                        formData1.post_cover_img.name.lastIndexOf('.') + 1
                    ).toLowerCase();
                    
                    if (pictureExtension == 'png' || pictureExtension == 'jpg' || pictureExtension == 'jpeg' || pictureExtension == 'svg') {
                        this.pictureError = false;

                        document.querySelector('#post_cover_img').classList.add('is-valid');
                        document.querySelector('#post_cover_img').classList.remove('is-invalid');
                        
                        formData.append('post_cover_img_name', formData1.post_cover_img.name);
                        formData.append('post_cover_img_delete', this.postEditData.post_cover_img);
                        formData.append('post_cover_img', document.getElementById('post_cover_img').files[0]);
                    } else {
                        this.pictureError = true;
                        
                        document.querySelector('#post_cover_img').classList.add('is-invalid');
                        return;
                    }
                }

            }


            if (!fieldEmpty) {
                axios({
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    url: '/post-update',
                    data: formData
                })
                    // .then((res) => console.log(res))
                    .then((res) => {
                        if (res.data.error) {
                            let toast = true;

                            if (res.data.message.hasOwnProperty('post_cover_img')) {
                                document.querySelector('#post_cover_img').classList.add('is-invalid');
                                document.querySelector('#post_cover_img').nextSibling.innerText = res.data.message.post_cover_img[0];

                                iziToast.error({
                                    title: 'Error',
                                    position: 'topCenter',
                                    message: res.data.message.message.post_cover_img[0]
                                });

                                toast = false;
                            }

                            if (res.data.message.hasOwnProperty('post_short_description')) {
                                document.getElementById('postShortDescription').style.border = '1px solid red';
                                document.getElementById('postShortDescriptionError').innerText = res.data.message.post_short_description[0];
                                iziToast.error({
                                    title: 'Error',
                                    position: 'topCenter',
                                    message: res.data.message.post_short_description[0]
                                });
                                toast = false;
                            }

                            if (toast) {

                                iziToast.error({
                                    title: 'Error',
                                    position: 'topCenter',
                                    message: res.data.message,
                                });

                            }

                        }

                        if (res.data.success) {

                            document.querySelectorAll('#editPostForm input').forEach(input => {
                                input.value = '';
                                input.classList.remove('is-valid');
                            });

                                document.getElementById('post_types').style.border = null;
                                document.getElementById('postShortDescription').style.border = null;
                                document.getElementById('postContent').style.border = null;
                                document.getElementById('post_statuses').style.border = null;


                                document.getElementById('post_cover_img').value = '';
                                document.getElementById('post_cover_img').nextSibling.innerText = 'Choose Post Cover (Optional)';
                                

                            iziToast.success({
                                title: 'Success',
                                message: res.data.message,
                                position: 'topCenter'
                            });
                            this.$emit('goToPosts');

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

#editPostForm {
    background-color: #1976d27c;
    padding: 2rem;
    border-radius: 0.4rem;
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
    border-radius: 0.4rem 0.4rem 0 0;
}

.ql-editor {
    background-color: #fff;
    min-height: 90px;
    color: #000;
}

#existingImg {
    border-radius: 0.4rem;
    border: 2px solid rgba(255, 255, 255, 0.281);
    height: 12rem;
    padding: 1rem;
}

#customFile {
    margin-top: 5rem;
}
</style>