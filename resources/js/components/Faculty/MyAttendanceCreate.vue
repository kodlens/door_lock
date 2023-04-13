<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-8">
                    <div class="box">

                        <div class="is-flex mb-2" 
                            style="font-size: 20px; font-weight: bold;">
                                CREATE ATTENDANCE
                        </div>

                        <div class="columns mt-4">
                            <div class="column">
                                <b-select v-model="fields.ay"
                                    placeholder="Academic Year">
                                    <option value="">--ALL--</option>
                                    <option 
                                        v-for="(item, index) in academicYears"
                                        :key="index"
                                        :value="item.ay_id">
                                            {{  item.ay_code }} - {{ item.ay_desc }}
                                        </option>
                                </b-select>
                            </div>
                        </div>


                    </div>
                </div><!--col -->
            </div><!-- cols -->
        </div><!--section div-->


    </div>
</template>

<script>

export default{
    props: ['propAcademicYears'],
    data() {
        return{
           fields: {},
           errors: {},

            btnClass: {
                'is-success': true,
                'button': true,
                'is-loading':false,
            },

            academicYears: [],

        }

    },

    methods: {
       
        loadAcademicYears(){
            // axios.get('/get-open-academic-years').then(res=>{
            //     this.academicYears = res.data
            // })
            this.academicYears = JSON.parse(this.propAcademicYears)
        },

        loadUserSchedules(){
            const params = [
                `ay=${this.fields.ay}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

              axios.get('/get-my-schedules').then(res=>{
                this.academicYears = res.data
            })
        },

    
        submit: function(){
            if(this.global_id > 0){
                //update
                axios.put('/users/'+this.global_id, this.fields).then(res=>{
                    if(res.data.status === 'updated'){
                        this.$buefy.dialog.alert({
                            title: 'UPDATED!',
                            message: 'Successfully updated.',
                            type: 'is-success',
                            onConfirm: () => {
                                this.loadAsyncData();
                                this.clearFields();
                                this.global_id = 0;
                                this.isModalCreate = false;
                            }
                        })
                    }
                }).catch(err=>{
                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;

                        if(this.errors.rfid){
                            this.rfid.type = 'is-danger'
                            this.rfid.msg = this.errors.rfid[0]
                        }
                    }
                })
            }else{
                //INSERT HERE
                axios.post('/users', this.fields).then(res=>{
                    if(res.data.status === 'saved'){
                        this.$buefy.dialog.alert({
                            title: 'SAVED!',
                            message: 'Successfully saved.',
                            type: 'is-success',
                            confirmText: 'OK',
                            onConfirm: () => {
                                this.isModalCreate = false;
                                this.loadAsyncData();
                                this.clearFields();
                                this.global_id = 0;
                            }
                        })
                    }
                }).catch(err=>{
                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;

                        if(this.errors.rfid){
                            this.rfid.type = 'is-danger'
                            this.rfid.msg = this.errors.rfid[0]
                        }
                    }
                });
            }
        },


      

        clearFields(){

            this.fields.rfid = ''
            this.fields.username = ''
            this.fields.lname = ''
            this.fields.fname = ''
            this.fields.mname = ''
            this.fields.sex = ''
            this.fields.password = ''
            this.fields.password_confirmation = ''
            this.fields.contact_no = ''
            this.fields.role = ''
 
        },


    },

    mounted() {
        this.loadAcademicYears();
        this.loadAsyncData();
    }
}
</script>


<style>

    .table > tbody > tr {
        /* background-color: blue; */
        transition: background-color 0.5s ease;
    }

    .table > tbody > tr:hover {
        background-color: rgb(233, 233, 233);

    }
    .wrapper{
        margin: 0px 20px 20px 20px;
    }

</style>
