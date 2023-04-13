<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-8">
                    <div class="box">

                        <div class="is-flex" 
                            style="font-size: 20px; font-weight: bold;">LIST OF STUDENT</div>
                        <div class="has-text-weight-bold" v-if="schedule.ay">
                            Academic Year: 
                            {{ schedule.ay.ay_desc }}
                        </div>

                        <div class="has-text-weight-bold" v-if="schedule.time_start">
                            Schedule: 
                            {{ schedule.time_start | formatTime }} -  {{ schedule.time_end | formatTime }}
                        </div>
                        <div class="has-text-weight-bold mb-2">
                            Day: 
                            <span v-if=" schedule.mon == 1">M</span>
                            <span v-if=" schedule.tue == 1">T</span>
                            <span v-if=" schedule.wed == 1">W</span>
                            <span v-if=" schedule.thu == 1">TH</span>
                            <span v-if=" schedule.fri == 1">F</span>
                            <span v-if=" schedule.sat == 1">S</span>
                            <span v-if=" schedule.sun == 1">SU</span>
                        </div>

                        <div class="columns">
                            <div class="column">
                                <b-field label=""></b-field>
                            </div>
                            <div class="column">

                            </div>
                        </div>

                        <b-table
                            :data="data"
                            :loading="loading"
                            :checked-rows.sync="checkedRows"
                            checkable>

                            <b-table-column field="schedule_student_list_id" label="ID" sortable v-slot="props">
                                {{ props.row.schedule_student_list_id }}
                            </b-table-column>

                            <b-table-column field="student_name" label="Name" sortable v-slot="props">
                                {{ props.row.student_lname }}, {{ props.row.student_fname }} {{ props.row.student_mname}} 
                            </b-table-column>

                            <b-table-column field="student_sex" label="Sex" sortable v-slot="props">
                                {{ props.row.student_sex }}
                            </b-table-column>

                            <b-table-column field="student_contact_no" label="Contact No." sortable v-slot="props">
                                {{ props.row.student_contact_no }}
                            </b-table-column>

                        </b-table>
                        <div class="buttons is-right mt-4">
                            <b-button label="Save Attendance" @click="submit">
                            </b-button>
                        </div>


                    </div>
                </div><!--col -->
            </div><!-- cols -->
        </div><!--section div-->

    </div>
</template>

<script>

export default{
    props:{
        propSchedule:{
            type: String,
            default: ""
        }
    },


    data() {
        return{
            data: [],
            loading: false,
            checkedRows: [],
            
            fields: {},
            errors: {},

            btnClass: {
                'is-success': true,
                'button': true,
                'is-loading':false,
            },

            schedule: {},

        }

    },

    methods: {
        /*
        * Load async data
        */
        loadAsyncData() {
            const params = [
                `scheduleid=${this.schedule.schedule_id}`,
            ].join('&')

            this.loading = true
            axios.get(`/get-my-schedule-student-list-for-attendance?${params}`)
                .then(res=> {
                   
                    this.data = res.data
                    this.loading = false
                    
                })
                .catch((error) => {
                    this.data = []
                    this.total = 0
                    this.loading = false
                    throw error
                })
        },

        
       

        submit: function(){

            this.fields.schedule_id = this.schedule.schedule_id;

            if(this.global_id > 0){
                //update
                axios.put('/my-schedule-student-list-update/'+this.global_id, this.fields).then(res=>{
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
                axios.post('/my-schedule-student-list', this.fields).then(res=>{
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


        initData(){
            this.schedule = JSON.parse(this.propSchedule)
        }

    },

    mounted() {
        //this.loadOffices();
        this.initData();
        this.loadAsyncData();
        
    },


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
