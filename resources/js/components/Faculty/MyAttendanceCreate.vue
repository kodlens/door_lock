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
                                <b-field label="Academic Year" label-position="on-border">
                                    <b-select v-model="fields.ay"
                                        placeholder="Academic Year">
                                        <option 
                                            v-for="(item, index) in academicYears"
                                            :key="index"
                                            :value="item.ay_id">
                                                {{  item.ay_code }} - {{ item.ay_desc }}
                                            </option>
                                    </b-select>
                                </b-field>
                            </div>
                        </div>

                        <div class="columns">
                            <div class="column">
                                <b-field label="Schedule" label-position="on-border">
                                    <b-select v-model="fields.schedule"
                                        placeholder="Schedule">
                                        <option 
                                            v-for="(iSched, schedX) in schedules"
                                            :key="schedX"
                                            :value="iSched.schedule_id">
                                                {{  iSched.schedule_desc }}
                                            </option>
                                    </b-select>
                                </b-field>
                            </div>

                            <div class="column">
                                <b-field label="Attendance Date & Time" label-position="on-border">
                                    <b-datetimepicker v-model="attendance_datetime">
                                    </b-datetimepicker>
                                </b-field>
                            </div>
                        </div>

                        <div class="columns">
                            <div class="column">
                                <b-field label="Remark" label-position="on-border">
                                    <b-input type="textarea" v-model="fields.attendance_remark"></b-input>
                                </b-field>
                            </div>
                        </div>

                        <hr>
                        
                        <div class="is-flex mb-2" 
                            style="font-size: 18px; font-weight: bold;">
                                STUDENT LIST
                        </div>

                        <div>
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
                        </div>
                    </div>
                </div><!--col -->
            </div><!-- cols -->
        </div><!--section div-->


    </div>
</template>

<script>

export default{
    props: ['propAcademicYears', 'propSchedules'],

    data() {
        return{

            attendance_datetime: new Date(),
            fields: {},
            errors: {},

            btnClass: {
                'is-success': true,
                'button': true,
                'is-loading':false,
            },

            academicYears: [],
            schedules: [],
        }
    },

    methods: {
       
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
