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

                        <div class="mt-3" style="font-weight: bold; font-size: 1em;">Academic Year: 
                            <span style="font-weight: bold; font-style: italic;">
                                {{ academicYear.ay_code }} {{ academicYear.ay_desc }}
                            </span>
                        </div>
                        <div class="mb-4" style="font-weight: bold; font-size: 1em;">Semester: 
                            <span style="font-weight: bold; font-style: italic;">
                                {{ academicYear.semester }}
                            </span>
                        </div>

                        <!-- <div class="columns mt-4">
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
                        </div> -->

                        <div class="columns">
                            <div class="column">
                                <b-field label="Schedule" label-position="on-border">
                                    <b-select v-model="fields.schedule_id"
                                        placeholder="Schedule" @input="loadAsyncData">
                                        <option 
                                            v-for="(iSched, schedX) in schedules"
                                            :key="schedX"
                                            :value="iSched.schedule_id">
                                                {{  iSched.schedule_description }}
                                                ({{ iSched.time_start | formatTime}} - {{ iSched.time_end | formatTime }})
                                                <span v-if=" iSched.mon == 1">M</span>
                                                <span v-if=" iSched.tue == 1">T</span>
                                                <span v-if=" iSched.wed == 1">W</span>
                                                <span v-if=" iSched.thu == 1">TH</span>
                                                <span v-if=" iSched.fri == 1">F</span>
                                                <span v-if=" iSched.sat == 1">S</span>
                                                <span v-if=" iSched.sun == 1">SU</span>
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
                                :data="students"
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

                        <div class="buttons is-right mt-4">
                            <b-button label="Save Attendance" 
                                icon-left="save"
                                type="is-primary"
                                @click="submit"></b-button>
                        </div>

                    </div><!--box-->
                </div><!--col -->
            </div><!-- cols -->
        </div><!--section div-->


    </div>
</template>

<script>

export default{
    props: ['propAcademicYear', 'propSchedules'],

    data() {
        return{

            data: [],
            loading: false,
            checkedRows: [],

            attendance_datetime: new Date(),
            fields: {},
            errors: {},

            btnClass: {
                'is-success': true,
                'button': true,
                'is-loading':false,
            },

            academicYear: {},
            schedules: [],
            students: [],
        }
    },

    methods: {
       
        loadAsyncData() {

            const params = [
                `scheduleid=${this.fields.schedule_id}`,
            ].join('&')

            this.loading = true
            axios.get(`/get-my-attendance-student-list?${params}`)
                .then(res=> {
                    this.students = []
                   
                    this.students = res.data
                    this.loading = false
                    
                })
                .catch((error) => {
                    this.loading = false
                    throw error
                })
        },



        initData(){
            this.academicYear = JSON.parse(this.propAcademicYear)
            this.schedules = JSON.parse(this.propSchedules)

            console.log(this.schedules);

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
        this.initData();
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
