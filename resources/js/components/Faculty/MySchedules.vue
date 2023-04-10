<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-8">
                    <div class="box">

                        <div class="is-flex mb-2" 
                            style="font-size: 20px; font-weight: bold;">
                                LIST OF SCHEDULES
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
                                </div>

                                <div class="column">
                                    <b-field label="Search" label-position="on-border">
                                        <b-input type="text"
                                            v-model="search.door" 
                                            placeholder="Search Door"
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

                            

                            

                        <!-- <div class="buttons mt-3">
                            <b-button @click="openModal" icon-left="plus" class="is-success">NEW</b-button>
                        </div> -->


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

                            <b-table-column field="schedule_time" label="Schedule" sortable v-slot="props">
                                {{ props.row.time_start | formatTime }} - {{ props.row.time_end | formatTime }}
                            </b-table-column>

                            <b-table-column label="Day" sortable v-slot="props" centered>
                                <span v-if=" props.row.mon == 1">M</span>
                                <span v-if=" props.row.tue == 1">T</span>
                                <span v-if=" props.row.wed == 1">W</span>
                                <span v-if=" props.row.thu == 1">TH</span>
                                <span v-if=" props.row.fri == 1">F</span>
                                <span v-if=" props.row.sat == 1">S</span>
                                <span v-if=" props.row.sun == 1">SU</span>
                            </b-table-column>

                            <!-- <b-table-column label="Action" v-slot="props">
                                <div class="is-flex">
                                    <b-tooltip label="Edit" type="is-warning">
                                        <b-button class="button is-small mr-1" tag="a" icon-right="pencil" @click="getData(props.row.user_id)"></b-button>
                                    </b-tooltip>
                                    <b-tooltip label="Delete" type="is-danger">
                                        <b-button class="button is-small mr-1" icon-right="delete" @click="confirmDelete(props.row.user_id)"></b-button>
                                    </b-tooltip>
                                    <b-tooltip label="Reset Password" type="is-info">
                                        <b-button class="button is-small mr-1" icon-right="lock" @click="openModalResetPassword(props.row.user_id)"></b-button>
                                    </b-tooltip>
                                </div>
                            </b-table-column> -->
                        </b-table>



                    </div>
                </div><!--col -->
            </div><!-- cols -->
        </div><!--section div-->



        <!--modal create-->
        <b-modal v-model="isModalCreate" has-modal-card
                 trap-focus
                 :width="640"
                 aria-role="dialog"
                 aria-label="Modal"
                 aria-modal>

            <form @submit.prevent="submit">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Student Information</p>
                        <!-- <b-button type="is-primary" @click="debug">
                            debug
                        </b-button> -->
                        <button
                            type="button"
                            class="delete"
                            @click="isModalCreate = false"/>
                    </header>

                    <section class="modal-card-body">
                        <div class="wrapper">

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Academic Year" 
                                        label-position="on-border"
                                        :type="errors.ay ? 'is-danger':''"
                                        :message="errors.ay ? errors.ay[0] : ''">
                                        <b-select v-model="fields.ay"
                                            placeholder="Academic Year" required>
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
                                    <b-field label="Last Name" label-position="on-border"
                                        :type="errors.student_lname ? 'is-danger':''"
                                        :message="errors.student_lname ? errors.student_lname[0] : ''">
                                        <b-input v-model="fields.student_lname"
                                            placeholder="Last Name" required>
                                        </b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="First Name" label-position="on-border"
                                        :type="errors.student_fname ? 'is-danger':''"
                                        :message="errors.student_fname ? errors.student_fname[0] : ''">
                                        <b-input v-model="fields.student_fname"
                                            placeholder="First Name" required>
                                        </b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Middle Name" label-position="on-border"
                                        :type="errors.student_mname ? 'is-danger':''"
                                        :message="errors.student_mname ? errors.student_mname[0] : ''">
                                        <b-input v-model="fields.student_mname"
                                            placeholder="Middle Name">
                                        </b-input>
                                    </b-field>
                                </div>

                                <div class="column">
                                    <b-field label="Suffix" label-position="on-border"
                                        :type="errors.student_suffix ? 'is-danger':''"
                                        :message="errors.student_suffix ? errors.student_suffix[0] : ''">
                                        <b-input type="text" v-model="fields.student_suffix"
                                            placeholder="Suffix">
                                        </b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Sex" label-position="on-border" expanded
                                        :type="errors.sex ? 'is-danger':''"
                                        :message="errors.sex ? errors.sex[0] : ''"
                                    >
                                        <b-select v-model="fields.sex" expanded>
                                            <option value="MALE">MALE</option>
                                            <option value="FEMALE">FEMALE</option>
                                        </b-select>
                                    </b-field>
                                </div>

                                <div class="column">
                                    <b-field label="Contact No" label-position="on-border"
                                        :type="errors.contact_no ? 'is-danger':''"
                                        :message="errors.contact_no ? errors.contact_no[0] : ''">
                                        <b-input type="number" v-model="fields.contact_no"
                                            placeholder="Contact No" required>
                                        </b-input>
                                    </b-field>
                                </div>
                            </div>


                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <b-button
                            label="Close"
                            @click="isModalCreate=false"/>
                        <button
                            :class="btnClass"
                            label="Save"
                            type="is-success">SAVE</button>
                    </footer>
                </div>
            </form><!--close form-->
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
                door: '',
                ay: '',
            },

            isModalCreate: false,
            modalResetPassword: false,

            fields: {
                rfid: '',
                username: '',
                lname: '', fname: '', mname: '',
                password: '', password_confirmation : '',
                sex : '', role: '', contact_no : '',
            },
            errors: {},

            btnClass: {
                'is-success': true,
                'button': true,
                'is-loading':false,
            },

            rfid: {
                type:'',
                msg: '',
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
                `door=${this.search.door}`,
                `ay=${this.search.ay}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-my-schedules?${params}`)
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

        openModal(){
            this.isModalCreate=true;
            this.clearFields()
            this.errors = {};
        },


        loadAcademicYears(){
            axios.get('/get-open-academic-years').then(res=>{
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


        //alert box ask for deletion
        confirmDelete(delete_id) {
            this.$buefy.dialog.confirm({
                title: 'DELETE!',
                type: 'is-danger',
                message: 'Are you sure you want to delete this data?',
                cancelText: 'Cancel',
                confirmText: 'Delete user account?',
                onConfirm: () => this.deleteSubmit(delete_id)
            });
        },
        //execute delete after confirming
        deleteSubmit(delete_id) {
            axios.delete('/users/' + delete_id).then(res => {
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
        getData: function(data_id){
            this.clearFields();
            this.global_id = data_id;
            this.isModalCreate = true;


            //nested axios for getting the address 1 by 1 or request by request
            axios.get('/users/'+data_id).then(res=>{
                this.fields = res.data;
            });
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
        }
        
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
