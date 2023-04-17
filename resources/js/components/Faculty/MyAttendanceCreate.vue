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
                                    <b-datepicker v-model="attendance_date">
                                    </b-datepicker>
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
                                checkable
                                :checked-rows.sync="checkedRows"
                            >

                                <b-table-column field="student_id" label="Student ID" sortable v-slot="props">
                                    {{ props.row.student_id }}
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
                            <b-button label="Add New Student" 
                                icon-left="account"
                                class="is-info is-outlined"
                                @click="newStudent"></b-button>
                            <b-button label="Save Attendance" 
                                icon-left="content-save-all"
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
    props: {
        propAcademicYear:{
            type: String,
            default: '',
        },
        propSchedules: {
            type: String,
            default: ''
        },
        propAttendance: {
            type: String,
            default: ''
        },
        propIsUpdate: {
            type: Number,
            default: 0
        }
    },
    //props: ['propAcademicYear', 'propSchedules'],

    data() {
        return{

            loading: false,
            checkedRows: [],

            attendance_date: new Date(),
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
            if(this.propIsUpdate < 1){
                const params = [
                    `scheduleid=${this.fields.schedule_id}`,
                ].join('&')
    
                this.loading = true
                axios.get(`/get-my-attendance-student-list?${params}`)
                    .then(res=> {
                        this.students = []
                        
                        this.students = res.data
                        this.loading = false
    
                        // if(this.propIsUpdate > 0){
                        //     this.students.forEach(row => {
                        //         if(row.is_present === 1){
                        //             this.checkedRows.push(row)
                        //         }
                        //     });
                        // }
                    })
                    .catch((error) => {
                        this.loading = false
                        throw error
                    })
            }
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

        initData(){
            this.academicYear = JSON.parse(this.propAcademicYear)

            this.schedules = JSON.parse(this.propSchedules)

            if(this.propIsUpdate > 0){
                this.getData();
            }

        },

        
        getData(){
            let data = JSON.parse(this.propAttendance);
            this.fields.schedule_id = data.schedule_id;
            this.attendance_date = new Date(data.attendance_date);
            this.fields.remark = data.attendance_remark;
            this.global_id = data.attendance_id;
            this.students = data.student_attendance;
           
            this.students.forEach(row => {
                if(row.is_present === 1){
                    this.checkedRows.push(row);
                }
            });

             

            //console.log(this.students)
            //this.checkedRows = data.student_attendance.filter(item => item.is_present === 1);
            //console.log(this.checkedRows)
        },

    
        submit: function(){
            if(this.students.length < 1){
                this.$buefy.dialog.alert({
                    title: 'No Schedule.',
                    message: 'Please select schedule.',
                    type: 'is-danger'
                });

                return;
            }

            if(this.checkedRows.length < 1){
                this.$buefy.dialog.alert({
                    title: 'No Student.',
                    message: 'Please select student.',
                    type: 'is-danger'
                });

                return;
            }

            let ndate = new Date(this.attendance_date);

            this.fields.attendance_date = ndate.getFullYear() + '-' + (ndate.getMonth() + 1) + '-' + ndate.getDate();
            this.fields.students = this.students;
            this.fields.checkedRows = this.checkedRows

            if(this.propIsUpdate > 0){
                //update
                axios.put('/my-attendances/' + this.global_id, this.fields).then(res=>{
                    if(res.data.status === 'updated'){
                        this.$buefy.dialog.alert({
                            title: 'UPDATED!',
                            message: 'Successfully updated.',
                            type: 'is-success',
                            onConfirm: () => {
                                window.location = '/my-attendances';
                            }
                        })
                    }
                }).catch(err=>{
                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;

                        if(this.errors.duplicate_attendance){
                            this.$buefy.dialog.alert({
                                title: 'Duplicate Attendance.',
                                message: this.errors.duplicate_attendance,
                                type: 'is-danger'
                            })
                        }
                    }
                })
            }else{
                //INSERT HERE
                axios.post('/my-attendances', this.fields).then(res=>{
                    if(res.data.status === 'saved'){
                        this.$buefy.dialog.alert({
                            title: 'SAVED!',
                            message: 'Successfully saved.',
                            type: 'is-success',
                            confirmText: 'OK',
                            onConfirm: () => {
                                this.clearFields();
                            }
                        })
                    }
                }).catch(err=>{
                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;

                        if(this.errors.duplicate_attendance){
                            this.$buefy.dialog.alert({
                                title: 'Duplicate Attendance.',
                                message: this.errors.duplicate_attendance,
                                type: 'is-danger'
                            })
                        }
                    }
                });
            }
        },

        newStudent(){
            if(this.students.length < 1){
                this.$buefy.dialog.alert({
                    title: 'No Schedule.',
                    message: 'Please select schedule.',
                    type: 'is-danger'
                });

                return;
            }
            window.location = '/my-schedule-student-list/' + this.fields.schedule_id
        },


      

        clearFields(){

            this.students = []
            this.fields.schedule_id = null
            this.fields.attendance_remark = ''
 
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
