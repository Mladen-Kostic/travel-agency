<template>
    <div id="intro" class="rounded">
        <div class="text-center">
            <img width="300" src="./assets/logo.png" alt="logo">
            <h1 class="text-center">Welcome to Paragraf Travel</h1>
            <button @click="$emit('goToTravelInsurance')" class="btn btn-primary btn-lg mt-4">Book a Trip!</button>
        </div>
    </div>
</template>

<script>
export default {
    emits: ['goToTravelInsurance'],
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
    padding: 2rem;
    background-color: #1976d27c;
}
</style>

