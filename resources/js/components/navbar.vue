<template>
    <div>

        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand" @click="this.mainPageComp('Intro')"><img src="./assets/logo.png" alt="logo"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-4">
                        
                    <li class="nav-item">
                        <a :class="{'active': activeObj.TravelInsuranceForm, 'nav-link': nav_linkNav}" @click="this.mainPageComp('TravelInsuranceForm')"><i class="fas fa-user-shield"></i> Travel Insurance</a>
                    </li>

                    <li class="nav-item ml-4">
                        <a :class="{'active': activeObj.Posts, 'nav-link': nav_linkNav}" @click="this.mainPageComp('Posts')"><i class="fas fa-rss-square"></i> Posts</a>
                    </li>

                    <li v-if="!loggedIn" class="nav-item ml-4">
                        <a :class="{'active': activeObj.Register, 'nav-link': nav_linkNav}" @click="this.mainPageComp('Register')"><i class="fas fa-user-plus"></i> Register</a>
                    </li>

                    <li v-if="!loggedIn" class="nav-item ml-4">
                        <a :class="{'active': activeObj.Login, 'nav-link': nav_linkNav}" @click="this.mainPageComp('Login')"><i class="fas fa-sign-in-alt"></i> Login</a>
                    </li>

                    <li v-if="admin" class="nav-item ml-4">
                        <a :class="{'active': activeObj.Admin, 'nav-link': nav_linkNav}" @click="this.mainPageComp('Admin')"><i class="fas fa-user-cog"></i> Admin</a>
                    </li>

                    <li v-if="loggedIn" class="nav-item ml-4">
                        <a :class="{'active': activeObj.Logout, 'nav-link': nav_linkNav}" @click="this.mainPageComp('Intro')"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>

                </ul>
            </div>
        </nav>
        
    </div>
</template>

<script>
export default {
    props: {
        loggedIn: Boolean,
        admin: Boolean
    },
    emits: ['activeTabEvent'],
    data() {
        return {
            travelInsuranceNav: true,
            nav_linkNav: true,
            activeObj: {
                TravelInsuranceForm: false,
                Register: false,
                Login: false,
                Logout: false,
                Admin: false,
                Posts: false
            }
        }
    },
    expose: ['mainPageComp'],
    methods: {
        mainPageComp(comp) {
            this.$emit('activeTabEvent', comp);

            Object.keys(this.activeObj).forEach((key) => {
                if (key == comp) {
                    this.activeObj[key] = true;

                } else {
                    this.activeObj[key] = false;
                }
            });

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

