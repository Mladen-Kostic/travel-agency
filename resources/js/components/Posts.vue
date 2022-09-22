<template>
    <div>
        <h1 class="mb-4"><i class="fas fa-rss-square"></i> Posts</h1>
        <a @click="$emit('goToCreatePost')" class="goToCreatePost"><i class="fas fa-plus"></i> Create Post</a>
        <div id="posts" class="text-center pt-5" v-if="posts">
            
        </div>
        <div id="noPosts" class="text-center pt-5" v-else>
            <h3>Could not find any Posts...</h3>
            <h3>¯\_(ツ)_/¯</h3>
        </div>

    </div>
</template>

<script>
export default {
    props: {
        loggedIn: Boolean,
        admin: Boolean
    },
    data() {
        return {
            posts: null,
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
</style>