<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-10">
                    <div class="box">

                        <div class="is-flex mb-2" style="font-size: 20px; font-weight: bold;">Add New Schedule</div>

                        <div class="section">
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Academic Year" label-position="on-border"
                                             :type="errors.ay ? 'is-danger':''"
                                             :message="errors.ay ? errors.ay[0] : ''">
                                        <b-select v-model="fields.ay" expanded>
                                            <option value="fields.ay">{{fields.ay}}</option>
                                        </b-select>
                                    </b-field>
                                </div>

                            </div>


                            <div class="columns">
                                <div class="column">
                                    <modal-user></modal-user>
                                </div>
                                <div class="column">
                                    <modal-door></modal-door>
                                </div>                                
                            </div>


                            <div class="columns">
                                <div class="column">
                                    <b-field label="Time Start" label-position="on-border">
                                    <b-timepicker
                                        placeholder="Click to select..."
                                        icon="clock"
                                        :enable-seconds="enableSeconds"
                                        :hour-format="hourFormat"
                                        :locale="locale">
                                    </b-timepicker>
                                </b-field>

                                </div>
                                <div class="column">
                                    <b-field label="Time End " label-position="on-border">
                                    <b-timepicker
                                        placeholder="Click to select..."
                                        icon="clock"
                                        :enable-seconds="enableSeconds"
                                        :hour-format="hourFormat"
                                        :locale="locale">
                                    </b-timepicker>
                                </b-field>

                                </div>
                            </div>

                    <!--  Days -->
                            <div class="m-5 has-text-centered has-text-weight-bold">Select Day</div>

                            <div class="columns">
                                <div class="column">
                                     <b-field>
                                        <b-checkbox>Mon</b-checkbox>
                                    </b-field>
                                </div>
                                <div class="column">
                                     <b-field>
                                        <b-checkbox>Tue</b-checkbox>
                                    </b-field>
                                </div>
                                <div class="column">
                                     <b-field>
                                        <b-checkbox>Wed</b-checkbox>
                                    </b-field>
                                </div>
                                <div class="column">
                                     <b-field>
                                        <b-checkbox>Thu</b-checkbox>
                                    </b-field>
                                </div>
                                <div class="column">
                                     <b-field>
                                        <b-checkbox>Fri</b-checkbox>
                                    </b-field>
                                </div>
                                <div class="column">
                                     <b-field>
                                        <b-checkbox>Sat</b-checkbox>
                                    </b-field>
                                </div>
                                <div class="column">
                                     <b-field>
                                        <b-checkbox>Sun</b-checkbox>
                                    </b-field>
                                </div>
                            </div>
                        </div>
                        <!-- End of Days -->






                    </div>
                </div><!--col -->
            </div><!-- cols -->
        </div><!--section div-->









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


            global_id : 0,

            search: {
                lname: '',
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

        }

    },

    methods: {
        /*
        * Load async data
        */
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `lname=${this.search.lname}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-users?${params}`)
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
                this.fields.office = res.data.office_id;
                let tempData = res.data;
                //load city first
                axios.get('/load-cities?prov=' + this.fields.province).then(res=>{
                    //load barangay
                    this.cities = res.data;
                    axios.get('/load-barangays?prov=' + this.fields.province + '&city_code='+this.fields.city).then(res=>{
                        this.barangays = res.data;
                        this.fields = tempData;
                    });
                });
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
        //this.loadOffices();
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
        margin: 100px;
    }

</style>
