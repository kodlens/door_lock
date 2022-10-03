<template>
    <div class="whole-page">
        
        <div class="login-panel">
            <form @submit.prevent="submit">
                <div class="login-panel-heading">
                    LOGIN
                </div>
                <div class="login-panel-body">
                    <form action="">
                        <b-field label="Username">
                            <b-input type="text" v-model="fields.username" placeholder="Username"></b-input>
                        </b-field>
    
                        <b-field label="Password">
                            <b-input type="password" v-model="fields.password" placeholder="Password"></b-input>
                        </b-field>
                    </form>
                </div>
                <div class="error" v-if="errors.username">{{ errors.username[0] }}</div>
                <hr>
                <div class="login-panel-footer">
                    <div class="buttons">
                        <button class="button is-primary">LOGIN</button>
                    </div>
                </div>
            </form>
        </div>

    </div> <!--root div-->
</template>

<script>
export default {
    props: ['propUser'],
    data(){
        return{
            locale: undefined,
            isModalActive: false,

            errors: {},
            fields: {},
        }

    },

    methods: {
        submit: function(){
            axios.post('/cpanel/login', this.fields).then(res=>{
                if(res.data.role === 'ADMINISTRATOR' || res.data.role === 'STAFF'){
                    window.location = '/cpanel/home';
                }
            }).catch(err=>{
                if(err.response.status === 422){
                    this.errors = err.response.data.errors;
                }
            });
        }
    },

    mounted() {


    },


}
</script>

<style scoped>

    @media only screen and (max-width: 1024px) {

    }

    @media only screen and (max-width: 768px) {
        .main-text-container{
            top: 230px;
            width: 100%;
            margin: 0;
        }
    }

    @media only screen and (max-width: 480px) {
        .main-text-container{
            padding: 15px;
        }
        .main-title{
            font-size: 1.2em;
        }

        .main-subtitle{
            font-size: .8em;
        }

    }

    .whole-page{
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;

        background-image: linear-gradient(rgba(255,255,255,0.5), rgba(255,255,255,0.5)), url('/img/background-img.png');
        background-repeat: no-repeat;
        background-size: cover;
   }



    .login-panel{
        padding: 25px;
        background: white;
        width: 400px;
    }
    .login-panel-heading{
        font-weight: bold;
        padding: 15px 0;
    }

    .error{
        color: red;
        font-weight: bold;
    }


</style>
