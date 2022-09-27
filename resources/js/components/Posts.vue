<template>
    <div>
        <h1 class="mb-4"><i class="fas fa-rss-square"></i> Posts</h1>
        <a @click="$emit('goToCreatePost')" class="goToCreatePost"><i class="fas fa-plus"></i> Create Post</a>

        <div id="posts" class="tableResponsive pt-5">
            <table v-if="posts" class="table mr-2">
                <thead>
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Created&nbsp;At</th>
                    <th scope="col">Post&nbsp;Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Status</th>
                    <th scope="col">Publised&nbsp;At</th>
                    <th scope="col">Author</th>
                    <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in posts" :key="item.id">
                        <td :id="'ID' + item.id">{{ item.id }}</td>
                        <td>{{ formatDate(item.created_at) }}</td>
                        <td>{{ item.post_title.length > 20 ? item.post_title.slice(0, 20) + '...' : item.post_title }}</td>

                        <td>
                            <div class="dropdown show">
                                <a class="btn btn-primary dropdown-toggle bg-transparent dropdownBorder" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ item.post_short_description.slice(0, 7) + '...' }}
                                </a>

                                <div class="dropdown-menu p-2" aria-labelledby="dropdownMenuLink">
                                    {{ item.post_short_description }}
                                </div>
                            </div>
                        </td>

                        <td :id="'postStatus' + item.id" v-if="item.published_at">{{ 'Published' }}</td>
                        <td :id="'postStatus' + item.id" v-if="item.archived_at">{{ 'Archived' }}</td>
                        <td :id="'postStatus' + item.id" v-if="item.staging">{{ 'Staged' }}</td>
                        <td :id="'notPublished' + item.id">{{ item.published_at ? formatDate(item.published_at) : 'Not Published' }}</td>
                        <td>{{ item.first_name }}</td>
                        
                        <td>
                            <div class="dropdown show">
                                <a class="btn btn-primary dropdown-toggle bg-transparent dropdownBorder" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    ...
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <!-- Button trigger modal -->
                                        <button @click="showPost(item.id)" type="button" class="btn btn-outline-light btn-block" data-toggle="modal" data-target="#exampleModal1">
                                            <i class="far fa-eye"></i> Preview
                                        </button>

                                        
                                    <button @click="postEdit(item.id)" class="btn btn-outline-light btn-block"><i class="fas fa-edit"></i> Edit <span class="ml-4"></span></button>
                                    <button :id="'archiveBtn' + item.id" v-if="!item.archived_at" @click="postArchive(item.id, item.archived_at)" class="btn btn-outline-light btn-block"><i class="fas fa-folder-plus"></i> Archive</button>
                                    <button @click="postRemove(item.id)" class="btn btn-outline-light btn-block"><i class="fas fa-trash"></i> Delete <span class="ml-2"></span></button>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModal1Label" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row p-4" v-if="singlePost">
                                            <img v-if="singlePost.post_cover_img" class="col-12" :src="img" alt="post_cover_image">

                                            <h1 class="col-12 text-center mt-4">{{ singlePost.post_title }}</h1>

                                            <div class="mt-2 mb-5 col-12 row">
                                                <p class="col-10">{{ singlePost.first_name + ' ' + singlePost.last_name }}</p>
                                                <p class="col-2">{{ formatDate(singlePost.created_at) }}</p>
                                            </div>
                                            
                                            <p v-html="singlePost.post_content"></p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </td>

                    </tr>
                </tbody>
            </table>

            <div id="noPosts" class="text-center pt-5" v-else>
                <h3>Could not find any Posts...</h3>
                <h3>¯\_(ツ)_/¯</h3>
            </div>
            
        </div>

    </div>
</template>

<script>
export default {
    emits: ['postEditData', 'goToCreatePost'],
    props: {
        loggedIn: Boolean,
        admin: Boolean,
        success: Boolean,
        error: Boolean,
        message: String
    },
    data() {
        return {
            posts: null,
            singlePost: null,
            img: null,
        }
    },
    mounted() {
        
        axios.get('/post-all')
            // .then((res) => console.log(res))
            .then((res) => {
                
                if (res.data.length) {
                    this.posts = res.data;
                } else {
                    this.posts = false;
                }

            })
            .catch((error) => console.log(error));

    },
    methods: {
        postRemove(id) {
            if (id) {
                axios.post('/post-remove', {id})
                    .then((res) => {
                        if (res.data.success) {
                            document.getElementById('ID' + id).parentElement.remove();
                            this.posts = false;

                            iziToast.success({
                                title: 'Success',
                                message: res.data.message,
                                position: 'topCenter'
                            });

                        }

                        if (res.data.error) {
                            iziToast.error({
                                title: 'Error',
                                message: res.data.message,
                                position: 'topCenter'
                            });
                        }
                    })
                    .catch((error) => console.log(error));
            } else {
                iziToast.error({
                    title: 'Error',
                    position: 'topCenter'
                });
            }
        },
        formatDate(d) {
            const date = new Date(d);

            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();

            return `${day}.${month}.${year}`;
        },
        showPost(id) {
            axios.get('/post/' + id)
                .then((res) => {
                    this.singlePost = res.data;

                    this.img = '/post_images/' + res.data.post_cover_img;
                })
                .catch((error) => console.log(error));
        },
        postEdit(id) {
            // axios.get('/post-edit/' + id)
            //     .then((res) => {
            //         this.$emit('postEditData', res.data)
            //     })
            //     // $emit('goToPostEdit')
            //     .catch((error) => console.log(error));
            this.$emit('postEditData', id);
        },
        postArchive(id, archived_at) {

            if (!archived_at) {

                axios.post('/post-archive', {id})
                    .then((res) => {
                        iziToast.success({
                            title: 'Success',
                            message: res.data.message,
                            position: 'topCenter'
                        });

                        document.getElementById('postStatus' + id).innerText = 'Archived';
                        document.getElementById('notPublished' + id).innerText = 'Not published';
                        document.getElementById('archiveBtn' + id).remove();

                    })
                    .catch((error) => console.log(error));

            } else {
                iziToast.warning({
                    title: 'Archive',
                    message: 'Post is already archived.',
                    position: 'topCenter'
                });
            }

        }
    }
}
</script>

<style>
.goToCreatePost {
    font-size: x-large;
    opacity: 0.5;
}

.goToCreatePost:hover {
    opacity: 1;
    cursor: pointer;
}

#posts, #noPosts {
    border-top: 1px solid rgba(255, 255, 255, 0.295);
}

.tableResponsive {
    display: block;
    width: 100%;
    
    -webkit-overflow-scrolling: touch;
}

@media (max-width: 800px) {
    .tableResponsive {
        overflow-x: auto;
    }
}

.dropdownBorder {
    border-color:#fff!important;
}

.btn-outline-light {
    border: none!important;
    outline: none!important;
}
</style>