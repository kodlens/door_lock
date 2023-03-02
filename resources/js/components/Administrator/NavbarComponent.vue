<template>
    <div>
        <b-navbar>
            <template #brand>
                <b-navbar-item>
                    <h1 class="title is-4">ADMINISTRATOR</h1>
                </b-navbar-item>
            </template>

            <template #start>


            </template>

            <template #end>
                <b-navbar-item href="/home">
                    Home
                </b-navbar-item>

                <b-navbar-item href="/academic-years">
                    Academic Year
                </b-navbar-item>

                <b-navbar-item href="/doors">
                    Door
                </b-navbar-item>

                <b-navbar-item href="/users">
                    Users
                </b-navbar-item>

                <b-navbar-item href="/schedules" class="active">
                    Schedule
                </b-navbar-item>
                
                <!-- <b-navbar-item href="/about">
                    ABOUT
                </b-navbar-item> -->

                <b-navbar-item tag="div">

                    <div class="buttons">
                        <b-button label="LOGOUT" icon-left="logout" @click="logout">
                        </b-button>
                    </div>
                </b-navbar-item>
            </template>
        </b-navbar>

    </div>


</template>

<script>
export default {
    data(){
        return{
            open: false,
            overlay: false,
            fullheight: true,
            fullwidth: false,
            right: true,
            expandOnHover: true,
            reduce: false,
            mobile: "reduce",

            user: {
                role: '',
                lname: '',
                fname: '',
                mname: '',
            },
        }
    },
    methods: {
        logout(){
            axios.post('/logout').then(()=>{
                window.location = '/';
            })
        },

        loadUser(){
            axios.get('/load-user').then(res=>{
                this.user = res.data;
            })
        }
    },

    mounted(){
        this.loadUser();
    },

    computed: {
        userRole(){
            return this.user.role.toUpperCase();
        }
    }
}
</script>

<style scoped>


    .logo{
        padding: 0 30px 0 30px;
        height: 90px;
    }

    .burger-div{
        width: 20px;
        height: 3px;
        background-color: #696969;
        margin: 0 0 3px 0;
        margin-left: auto;
        border-radius: 10px;
    }

    .burger-button{
        display: flex;
        flex-direction: column;
        margin-left: auto;
    }

    .mynav{
        padding: 25px;
        border-bottom: 2px solid rgba(196, 196, 196, 0.53);
        display: flex;
    }

    .mynav-brand{
        font-weight: bold;
        font-size: 1.2em;
    }

  /* .hero{
        background-image: url("/img/bg-hero.jpg");
        background-repeat: no-repeat;
        background-size: cover;
    } */


</style>
