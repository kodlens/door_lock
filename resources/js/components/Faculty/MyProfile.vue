<template>
    <div>

        <div class="panel-container">
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-text-header">
                        My Profile
                    </div>
                </div>
    
                <div class="panel-body">
                    
                    <div class="columns">
                        <div class="column">
                            <b-field label="Last Name" label-position="on-border"
                                :type="errors.lname ? 'is-danger':''"
                                :message="errors.lname ? errors.lname[0] : ''">
                                <b-input type="text" placeholder="Last Name" v-model="fields.lname"></b-input>
                            </b-field>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <b-field label="First Name" label-position="on-border"
                                :type="errors.fname ? 'is-danger':''"
                                :message="errors.fname ? errors.fname[0] : ''">
                                <b-input type="text" placeholder="First Name" v-model="fields.fname"></b-input>
                            </b-field>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <b-field label="Middle Name" label-position="on-border">
                                <b-input type="text" placeholder="Middle Name" v-model="fields.mname"></b-input>
                            </b-field>
                        </div>

                        <div class="column">
                            <b-field label="Suffix" label-position="on-border">
                                <b-input type="text" placeholder="Suffix" v-model="fields.suffix"></b-input>
                            </b-field>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <b-field label="Sex" label-position="on-border" expanded
                                :type="errors.sex ? 'is-danger':''"
                                :message="errors.sex ? errors.sex[0] : ''">
                                <b-select expanded placeholder="Sex" v-model="fields.sex">
                                    <option value="MALE">MALE</option>
                                    <option value="FEMALE">FEMALE</option>
                                </b-select>
                            </b-field>
                        </div>
                        <div class="column">
                            <b-field label="Contact No." label-position="on-border">
                                <b-input type="text" placeholder="Contact No." v-model="fields.contact_no"></b-input>
                            </b-field>
                        </div>
                    </div>
                </div> <!--panel body -->

                <div class="panel-footer">
                    <div class="buttons">
                        <b-button label="Change Password" 
                            @click="openModalResetPassword"
                            icon-left="lock-reset"
                            type="is-primary" outlined></b-button>
                        <b-button label="Submit Changes" 
                            @click="submit"
                            icon-left="content-save-all-outline"
                            type="is-success"></b-button>
                    </div>
                </div>
    
            </div><!-- panel -->

        </div> <!--panel-container-->



        <!--modal reset password-->
        <b-modal v-model="modalResetPassword" has-modal-card
            trap-focus
            :width="640"
            aria-role="dialog"
            aria-label="Modal"
            aria-modal>

            <form @submit.prevent="resetPassword">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Change Password</p>
                        <button
                            type="button"
                            class="delete"
                            @click="modalResetPassword = false"/>
                    </header>

                    <section class="modal-card-body">
                        <div class="">
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Password" label-position="on-border"
                                            :type="errors.password ? 'is-danger':''"
                                            :message="errors.password ? errors.password[0] : ''">
                                        <b-input type="password" v-model="fields.password" password-reveal
                                                 placeholder="Password" required>
                                        </b-input>
                                    </b-field>
                                    <b-field label="Confirm Password" label-position="on-border"
                                            :type="errors.password_confirmation ? 'is-danger':''"
                                            :message="errors.password_confirmation ? errors.password_confirmation[0] : ''">
                                        <b-input type="password" v-model="fields.password_confirmation"
                                                password-reveal
                                                placeholder="Confirm Password" required>
                                        </b-input>
                                    </b-field>
                                </div>
                            </div>
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <b-button
                            label="Close"
                            @click="modalResetPassword=false"/>
                        <button
                            :class="btnClass"
                            label="Save"
                            type="is-success">SAVE</button>
                    </footer>
                </div>
            </form><!--close form-->
        </b-modal>
        <!--close modal-->



    </div> <!--root div-->
    
</template>

<script>

export default{

    props: {
        propUser: {
            type: String,
            default: ''
        }
    },

    data(){
        return {
            fields: {},
            errors: {},

            modalResetPassword: false,

            btnClass: {
                'is-success': true,
                'button': true,
                'is-loading':false,
            },
        }
    },

    methods: {

        submit(){

            axios.post('/update-my-profile', this.fields).then(res=>{
                this.$buefy.dialog.alert({
                    title: 'UPDATED!',
                    type: 'is-success',
                    message: 'Profile updated successfully.',
                    confirmText: 'OK',
                    onConfirm: () => {
                        window.location = '/my-profile'
                        //this.loadAsyncData()
                    }
                });
            }).catch(err=>{
                if(err.response.status === 422){
                    this.errors = res.response.data.errors;
                }
            })
        },


        //CHANGE PASSWORD
        openModalResetPassword(){
            this.modalResetPassword = true;
            this.fields.password = '';
            this.fields.password_confirmation = '';
            this.errors = {};
        },
        resetPassword(){
            axios.post('/reset-my-password/', this.fields).then(res=>{

                if(res.data.status === 'changed'){
                    this.$buefy.dialog.alert({
                        title: 'PASSWORD CHANGED',
                        type: 'is-success',
                        message: 'Password changed successfully.',
                        confirmText: 'OK',
                        onConfirm: () => {
                            this.modalResetPassword = false;
                            this.fields = {};
                            this.errors = {};
                            //this.loadAsyncData()
                        }
                    });
                }

            }).catch(err=>{
                this.errors = err.response.data.errors;
            })
        },



        initData(){
            this.user = JSON.parse(this.propUser)

            this.fields = this.user;
        }
    },

    mounted(){
        this.initData()
    }
}
</script>

<style scoped>
    .panel-container{
        max-width: 600px;
        margin: 30px auto;
    }

    .panel-header{
        border-bottom: 1px solid blue;
        padding: 15px;
    }

    .panel-text-header{
        font-weight: bold;
    }
    .panel-body{
        padding: 25px;
    }

    .panel-footer{
        padding: 25px;
        border-top: 1px solid blue;
    }

</style>