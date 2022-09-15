<template>
    <div id="intro">
        <div class="text-center">
            <img width="300" src="./assets/logo.png" alt="logo">
            <h1 class="text-center">Welcome to Paragraf Travel</h1>
            <button class="btn btn-primary btn-lg mt-4">Book a Trip!</button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Intro',
    emits: ['activeTabEvent'],
    methods: {
        intro() {
            this.$emit('activeTabEvent', 'Intro');
        }
    }
}
</script>

<style>
#intro {
    padding-top: 12rem;
}

</style>

