<template>
    <div id="main">
        <navbar @activeTabEvent="(msg) => activeTab = msg" />

        <div class="container">
            <Transition>
                <component
                    :is="activeTab"
                />
            </Transition>
            <!-- <TravelInsuranceForm v-if="activeTab === 'TravelInsuranceForm'" /> -->
            
        </div>
    </div>
</template>

<script>
import navbar from './navbar.vue';
import TravelInsuranceForm from './TravelInsuranceForm.vue';
import Intro from './Intro.vue';
import Register from './Register.vue';
import Login from './Login.vue';

export default {
    components: {
        navbar,
        TravelInsuranceForm,
        Intro,
        Register,
        Login
    },
    data() {
        return {
            activeTab: 'Intro'
        }
    }
}
</script>

<style>
#main {
    padding-bottom: 2rem;
}

.v-enter-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>