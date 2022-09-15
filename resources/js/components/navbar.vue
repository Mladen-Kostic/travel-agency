<template>
    <div id="main">

        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand" @click="this.Intro"><img src="./assets/logo.png" alt="logo"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-4">
                        
                    <li class="nav-item">
                        <a :class="{'active': travelInsuranceNav, 'nav-link': nav_linkNav}" @click="this.TravelInsuranceForm"><i class="fas fa-user-shield"></i> Travel Insurance</a>
                    </li>

                </ul>
            </div>
        </nav>
        
    </div>
</template>

<script>
export default {
    emits: ['activeTabEvent'],
    data() {
        return {
            travelInsuranceNav: true,
            nav_linkNav: true
        }
    },
    methods: {
        TravelInsuranceForm() {
            this.$emit('activeTabEvent', 'TravelInsuranceForm');
        },
        Intro() {
            this.$emit('activeTabEvent', 'Intro');
        }
    }
}
</script>

<style>
.nav-item {
    cursor: pointer;
}

.navbar-brand {
    cursor: pointer;
}
</style>

