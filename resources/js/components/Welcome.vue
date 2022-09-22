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
                    :loggedIn="loggedIn"
                    :admin="admin"
                    :auth_user_id="auth_user_id"
                    @goToRegister="this.$refs.navbarRef.mainPageComp('Register')"
                    @goToIntro="this.$refs.navbarRef.mainPageComp('Intro')"
                    @goToLogin="this.$refs.navbarRef.mainPageComp('Login')"
                    @goToTravelInsurance="this.$refs.navbarRef.mainPageComp('TravelInsuranceForm')"
                    @goToAdmin="this.$refs.navbarRef.mainPageComp('Admin')"
                    @goToPosts="this.$refs.navbarRef.mainPageComp('Posts')"
                    @goToCreatePost="this.$refs.navbarRef.mainPageComp('CreatePost')"
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
import Posts from './Posts.vue';
import CreatePost from './CreatePost.vue';
// import ref from 'vue';


export default {
    components: {
        navbar,
        TravelInsuranceForm,
        Intro,
        Register,
        Login,
        Admin,
        Posts,
        CreatePost
    },
    data() {
        return {
            activeTab: 'Intro',
            success: false,
            error: false,
            message: '',
            method: null,
            // loggedIn: false,
            // admin: false,
            // auth_user_id: 0
            loggedIn: true,
            admin: true,
            auth_user_id: 1
        }
    },
    methods: {
        successAction(resData) {
            this.success = resData.success;
            this.message = resData.message;
            this.auth_user_id = resData.auth_user.id;

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