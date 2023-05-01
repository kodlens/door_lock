<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-10">
                    <div class="box">

                        <div class="is-flex mb-2" 
                            style="font-size: 20px; font-weight: bold;">
                                LIST OF ATTENDANCES
                            </div>

                            <div class="columns mt-5">
                                <div class="column">

                                    <div class="columns">
                                        <div class="column">
                                            <b-field label="Page" label-position="on-border">
                                                <b-select v-model="perPage" @input="setPerPage">
                                                    <option value="5">5 per page</option>
                                                    <option value="10">10 per page</option>
                                                    <option value="15">15 per page</option>
                                                    <option value="20">20 per page</option>
                                                </b-select>
                                            </b-field>
                                        </div>
                                    </div>

                                    <div class="columns">
                                        <div class="column">
                                            <b-field label="Search" label-position="on-border">
                                                <b-input type="text"
                                                    v-model="search.remark" 
                                                    placeholder="Search Remark"
                                                    @keyup.native.enter="loadAsyncData"/>
                                                <p class="control">
                                                    <b-tooltip label="Search" type="is-success">
                                                        <b-button type="is-primary" 
                                                            icon-right="account-filter" 
                                                            @click="loadAsyncData"/>
                                                    </b-tooltip>
                                                </p>
                                            </b-field>
                                        </div>
                                    </div>
                                </div>

                                <div class="column">
                                    <b-field label="Academic Year" 
                                        label-position="on-border">
                                        <b-select v-model="search.ay"
                                            placeholder="Academic Year">
                                            <option value="">--ALL--</option>
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


                        <div class="buttons mt-3">
                            <b-button @click="createAttendance" icon-left="plus" class="is-success">New Attendance</b-button>
                            <b-button 
                                icon-left="chart-box-outline" 
                                class="is-info is-outlined"
                                @click="openModalPickDate"
                            >Generate Attendance</b-button>
                        </div>


                        <b-table
                            :data="data"
                            :loading="loading"
                            paginated
                            backend-pagination
                            :total="total"
                            :pagination-rounded="true"
                            :per-page="perPage"
                            @page-change="onPageChange"
                            aria-next-label="Next page"
                            aria-previous-label="Previous page"
                            aria-page-label="Page"
                            aria-current-label="Current page"
                            backend-sorting
                            :default-sort-direction="defaultSortDirection"
                            @sort="onSort">

                            <b-table-column field="schedule_id" label="ID" sortable v-slot="props">
                                {{ props.row.schedule_id }}
                            </b-table-column>

                             <b-table-column field="academic_year" label="A.Y." sortable v-slot="props">
                                {{ props.row.ay.ay_desc }} ({{props.row.ay.ay_code}})
                            </b-table-column>

                            <b-table-column field="attendance_date" label="Schedule" sortable v-slot="props">
                                {{ props.row.attendance_date }}
                            </b-table-column>

                            <b-table-column field="attendance_date" label="Schedule" sortable v-slot="props">
                                {{ props.row.schedule.time_start | formatTime }} - {{ props.row.schedule.time_end | formatTime }}
                            </b-table-column>

                            <b-table-column label="Day" sortable v-slot="props" centered>
                                <span v-if=" props.row.schedule.mon == 1">M</span>
                                <span v-if=" props.row.schedule.tue == 1">T</span>
                                <span v-if=" props.row.schedule.wed == 1">W</span>
                                <span v-if=" props.row.schedule.thu == 1">TH</span>
                                <span v-if=" props.row.schedule.fri == 1">F</span>
                                <span v-if=" props.row.schedule.sat == 1">S</span>
                                <span v-if=" props.row.schedule.sun == 1">SU</span>
                            </b-table-column>

                            <b-table-column field="attendance_remark" label="Remark" sortable v-slot="props">
                                {{ props.row.attendance_remark }}
                            </b-table-column>

                            <b-table-column field="attendance_no" label="Attendance No." centered sortable v-slot="props">
                                {{ props.row.student_attendance.filter(item => item.is_present === 1).length }} 
                                / 
                                {{ props.row.student_attendance.length }}
                            </b-table-column>

                            <b-table-column label="Action" v-slot="props">
                                <div class="is-flex">
                                    <b-tooltip label="Student List" type="is-primary">
                                        <b-button class="button is-small mr-1" tag="a" icon-right="pencil" 
                                            @click="updateAttendance(props.row.attendance_id)">
                                        </b-button>
                                    </b-tooltip>

                                     <!-- <b-tooltip label="Attendance" type="is-primary">
                                        <b-button class="button is-small mr-1" tag="a" icon-right="list-status" 
                                            @click="studentAttendance(props.row.schedule_id)">
                                        </b-button>
                                    </b-tooltip> -->
                                <b-tooltip label="Delete" type="is-danger">
                                    <b-button class="button is-small mr-1 is-danger" 
                                        icon-right="delete" 
                                        @click="confirmDelete(props.row.attendance_id)"></b-button>
                                </b-tooltip>

                                <b-tooltip label="Print Attendance" type="is-info">
                                    <b-button class="button is-small mr-1 is-info" 
                                        icon-right="printer" 
                                        @click="printAttendance(props.row.attendance_id)"></b-button>
                                </b-tooltip>
                                    <!--<b-tooltip label="Reset Password" type="is-info">
                                        <b-button class="button is-small mr-1" icon-right="lock" @click="openModalResetPassword(props.row.user_id)"></b-button>
                                    </b-tooltip> -->
                                </div>
                            </b-table-column>
                        </b-table>



                    </div>
                </div><!--col -->
            </div><!-- cols -->
        </div><!--section div-->



        <!--modal create-->
        <b-modal v-model="modalPickDate" has-modal-card
            trap-focus
            aria-role="dialog"
            aria-label="Modal"
            aria-modal
        >

           
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Pick Date Range</p>
                    <!-- <b-button type="is-primary" @click="debug">
                        debug
                    </b-button> -->
                    <button
                        type="button"
                        class="delete"
                        @click="modalPickDate = false"/>
                </header>

                <section class="modal-card-body">
                    <div class="wrapper">
                        <b-field label="Start Date" 
                            label-position="on-border">
                            <b-datepicker v-model="fields.start_date"
                                inline
                                placeholder="Start Date"></b-datepicker>
                        </b-field>

                        <b-field label="End Date" 
                            label-position="on-border">
                            <b-datepicker
                                inline v-model="fields.end_date"
                                placeholder="End Date"></b-datepicker>
                        </b-field>
                        
                    </div>
                </section>
                <footer class="modal-card-foot">
                    <b-button
                        :class="btnClass"
                        icon-left="magnify"
                        label="Browse"
                        @click="submit"
                        type="is-success"></b-button>
                </footer>
            </div> <!--modal card -->
          
        </b-modal>
        <!--close modal-->

    </div>
</template>

<script>

export default{

    data() {
        return{
            data: [],
            total: 0,
            loading: false,
            sortField: 'user_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 5,
            defaultSortDirection: 'asc',

            academicYears: [],

            global_id : 0,

            search: {
                remark: '',
                ay: '',
            },

            modalPickDate: false,

            fields: {
                start_date: new Date(),
                end_date: new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0)
            },
            errors: {},

            btnClass: {
                'is-success': true,
                'button': true,
                'is-loading':false,
            },

        }

    },

    methods: {
        /*
        * Load async data
        */
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `remark=${this.search.remark}`,
                `ay=${this.search.ay}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-my-attendances?${params}`)
                .then(({ data }) => {
                    this.data = [];
                    let currentTotal = data.total
                    if (data.total / this.perPage > 1000) {
                        currentTotal = this.perPage * 1000
                    }

                    this.total = currentTotal
                    data.data.forEach((item) => {
                        //item.release_date = item.release_date ? item.release_date.replace(/-/g, '/') : null
                        this.data.push(item)
                    })
                    
                    this.loading = false
                })
                .catch((error) => {
                    this.data = []
                    this.total = 0
                    this.loading = false
                    throw error
                })
        },
        /*
        * Handle page-change event
        */
        onPageChange(page) {
            this.page = page
            this.loadAsyncData()
        },

        onSort(field, order) {
            this.sortField = field
            this.sortOrder = order
            this.loadAsyncData()
        },

        setPerPage(){
            this.loadAsyncData()
        },

        createAttendance(){
            window.location = '/my-attendances/create';
        },

        printAttendance(i){
            window.location = '/print-attendance/' + i;
        },

        loadAcademicYears(){
            axios.get('/get-open-academic-years').then(res=>{
                this.academicYears = res.data
            })
        },

    
        openModalPickDate(){
            this.modalPickDate = true;
        },



        submit: function(){
            let dStart = new Date(this.fields.start_date)
            let dEnd = new Date(this.fields.end_date)

            let startDate = dStart.getFullYear() + '-' + (dStart.getMonth() + 1).toString().padStart(2, '0') + '-'
                + (dStart.getDate()).toString().padStart(2, '0')

            let endDate = dEnd.getFullYear() + '-' + (dEnd.getMonth() + 1).toString().padStart(2, '0') + '-'
                + (dEnd.getDate()).toString().padStart(2, '0')

            const params = [
                `start_date=${startDate}`,
                `end_date=${endDate}`
            ].join('&')
            window.location = '/generate-my-attendance?' + params
        },


        //alert box ask for deletion
        confirmDelete(delete_id) {
            this.$buefy.dialog.confirm({
                title: 'DELETE!',
                type: 'is-danger',
                message: 'Are you sure you want to delete this data?',
                cancelText: 'Cancel',
                confirmText: 'Delete?',
                onConfirm: () => this.deleteSubmit(delete_id)
            });
        },
        //execute delete after confirming
        deleteSubmit(delete_id) {
            axios.delete('/my-attendances/' + delete_id).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },

        clearFields(){
            this.rfid.type = '';
            this.rfid.msg = '';

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


        //update code here
        studentList: function(data_id){
            window.location = '/my-schedule-student-list/' + data_id
        },


        studentAttendance(data_id){
            window.location = '/my-schedule-student-attendance/' + data_id
        },

        updateAttendance(data_id){
            window.location = '/my-attendances/' + data_id + '/edit'

        },

        //CHANGE PASSWORD
        openModalResetPassword(dataId){
            this.modalResetPassword = true;
            this.fields = {};
            this.errors = {};
            this.global_id = dataId;
        },
        resetPassword(){
            axios.post('/user-reset-password/' + this.global_id, this.fields).then(res=>{

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
                            this.loadAsyncData()
                        }
                    });
                }

            }).catch(err=>{
                this.errors = err.response.data.errors;
            })
        },

        
        scanQR(){
            this.fields.rfid = "1234";        
        },
        debug(){          
            this.fields.mname = "1234";        
            this.fields.fname = "1234";        
            this.fields.lname = "1234";        
            this.fields.role = "EMPLOYEE";        
            this.fields.sex = "MALE";        
            this.fields.password = "a";  
            this.fields.password_confirmation = "a";  
            this.fields.contact_no = "03287238";
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
