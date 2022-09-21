<template>
    <div id="main">
        <navbar
            @activeTabEvent="(msg) => activeTab = msg"
            ref="navbarRef"
            :loggedIn="loggedIn"
            :admin="admin"
        />

        <div class="container">
            <div v-if="success" class="alert alert-success" role="alert">
                {{ this.message }}
            </div>
            <Transition>
                <component
                    :is="activeTab"
                    @goToRegister="this.$refs.navbarRef.mainPageComp('Register')"
                    @goToIntro="this.$refs.navbarRef.mainPageComp('Intro')"
                    @goToLogin="this.$refs.navbarRef.mainPageComp('Login')"
                    @goToTravelInsurance="this.$refs.navbarRef.mainPageComp('TravelInsuranceForm')"
                    @goToAdmin="this.$refs.navbarRef.mainPageComp('Admin')"
                    @successAction="(resData) => successAction(resData)"
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
import Admin from './Admin.vue';
// import ref from 'vue';


export default {
    components: {
        navbar,
        TravelInsuranceForm,
        Intro,
        Register,
        Login,
        Admin
    },
    data() {
        return {
            activeTab: 'Intro',
            success: false,
            error: false,
            message: '',
            method: null,
            loggedIn: false,
            admin: false
        }
    },
    methods: {
        successAction(resData) {
            this.success = resData.success;
            this.message = resData.message;
        

            if (resData.message === "Logged in successfully.") {
                this.loggedIn = true;
            }

            if (resData.auth_user.status === 'admin' || resData.auth_user.status === 'superadmin') {
                this.admin = true;
            }
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

.container {
    margin-bottom: 4rem;
}
</style>