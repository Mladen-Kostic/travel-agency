<template>
    <div id="main">
        <navbar
            @activeTabEvent="(msg) => activeTab = msg"
            ref="navbarRef"
            :loggedIn="loggedIn"
            :admin="admin"
        />
        
        <div class="container">
            
            <Transition>
                <component
                    :is="activeTab"
                    :loggedIn="loggedIn"
                    :admin="admin"
                    :auth_user_id="auth_user_id"
                    :success="success"
                    :error="error"
                    :message="message"
                    :postEditData="postEditData"
                    @goToRegister="this.$refs.navbarRef.mainPageComp('Register')"
                    @goToIntro="this.$refs.navbarRef.mainPageComp('Intro')"
                    @goToLogin="this.$refs.navbarRef.mainPageComp('Login')"
                    @goToTravelInsurance="this.$refs.navbarRef.mainPageComp('TravelInsuranceForm')"
                    @goToAdmin="this.$refs.navbarRef.mainPageComp('Admin')"
                    @goToPosts="this.$refs.navbarRef.mainPageComp('Posts')"
                    @goToCreatePost="this.$refs.navbarRef.mainPageComp('CreatePost')"
                    @goToPostEdit="this.$refs.navbarRef.mainPageComp('PostEdit')"
                    @postEditData="(data) => this.postEditDataMethod(data)"
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
import PostEdit from './PostEdit.vue';
// import ref from 'vue';
import { isProxy, toRaw } from 'vue';


export default {
    components: {
        navbar,
        TravelInsuranceForm,
        Intro,
        Register,
        Login,
        Admin,
        Posts,
        CreatePost,
        PostEdit
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
            auth_user_id: 1,
            postEditData: null,
        }
    },
    // watch: {
    //     activeTab: function() {
    //         this.error = false;
    //         this.success = false;
    //         this.message = '';
    //     }
    // },
    methods: {
        successAction(resData) {

            iziToast.success({
                title: 'Success',
                message: resData.message,
                position: 'topCenter'
            });
            

            if (resData.message === "Logged in successfully.") {
                this.loggedIn = true;
                this.auth_user_id = resData.auth_user.id;

                if (resData.auth_user.status === 'admin' || resData.auth_user.status === 'superadmin') {
                    this.admin = true;
                }
            }
            
        },
        errorAction(resData) {

            iziToast.error({
                title: 'Error',
                message: resData.message,
                position: 'topCenter'
            });
            
        },
        postEditDataMethod(id) {

            axios.get('/post-edit/' + id)
                .then((res) => {
                    this.postEditData = res.data;
                })
                .catch((error) => console.log(error));

            this.activeTab = 'PostEdit';
            
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

.invisible {
    visibility: hidden;
}
</style>