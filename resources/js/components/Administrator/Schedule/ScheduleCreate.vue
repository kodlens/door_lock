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
                                        <b-select v-model="fields.ay_id" expanded>
                                            <option v-for="(item, index) in academic_years"
                                                :key="index" 
                                                :value="item.ay_id">{{ item.ay_code }} - {{ item.ay_desc }}</option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <modal-user
                                        @browseEmployees="emitBrowseEmployee"
                                        :prop-employee="this.employeeFullname"></modal-user>
                                </div>
                                <div class="column">
                                    <modal-door 
                                        @browseDoor="emitBrowseDoor"
                                        :prop-door-name="this.doorName"></modal-door>
                                </div>                                
                            </div>


                            <div class="columns">
                                <div class="column">
                                    <b-field label="Time Start" label-position="on-border">
                                    <b-timepicker
                                        placeholder="Click to select..."
                                        icon="clock"
                                        v-model="fields.time_from"
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
                                        v-model="fields.time_to"
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
                                        <b-checkbox 
                                            :true-value="1"
                                            :false-value="0"
                                            v-model="fields.mon">Mon</b-checkbox>
                                    </b-field>
                                </div>
                                <div class="column">
                                     <b-field>
                                        <b-checkbox
                                            :true-value="1"
                                            :false-value="0"
                                            v-model="fields.tue">Tue</b-checkbox>
                                    </b-field>
                                </div>
                                <div class="column">
                                     <b-field>
                                        <b-checkbox 
                                            :true-value="1"
                                            :false-value="0"
                                            v-model="fields.wed">Wed</b-checkbox>
                                    </b-field>
                                </div>
                                <div class="column">
                                     <b-field>
                                        <b-checkbox
                                            :true-value="1"
                                            :false-value="0"
                                            v-model="fields.thu">Thu</b-checkbox>
                                    </b-field>
                                </div>
                                <div class="column">
                                     <b-field>
                                        <b-checkbox 
                                            :true-value="1"
                                            :false-value="0"
                                            v-model="fields.fri">Fri</b-checkbox>
                                    </b-field>
                                </div>
                                <div class="column">
                                     <b-field>
                                        <b-checkbox 
                                            :true-value="1"
                                            :false-value="0"
                                            v-model="fields.sat">Sat</b-checkbox>
                                    </b-field>
                                </div>
                                <div class="column">
                                     <b-field>
                                        <b-checkbox 
                                            :true-value="1"
                                            :false-value="0"
                                            v-model="fields.sun">Sun</b-checkbox>
                                    </b-field>
                                </div>
                            </div> <!--cols-->

                            <div class="buttons is-right">
                                <b-button @click="submit"
                                    label="Save Schedule"
                                    type="is-primary"></b-button>
                            </div>
                        </div> <!--sections-->
                    </div> <!--box-->

                </div><!--col -->
            </div><!-- cols -->
        </div><!--section div-->

    </div> <!--root-->

</template>

<script>

export default{

    props: ['propAcademicYears'],

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

            hourFormat: undefined, // Browser locale
            enableSeconds: false,
            locale: undefined, // Browser locale


            employee: {},
            employeeFullname: '',
            door: {},
            doorName: '',


            global_id: 0,

            isModalCreate: false,
            modalResetPassword: false,

            fields: {},
            errors: {},

            btnClass: {
                'is-success': true,
                'button': true,
                'is-loading':false,
            },

            academic_years: [],

        }

    },

    methods: {
       
        submit: function(){

            let inputs = {
                door_id: 0,
                ay_id: 0,
                user_id: 0,
                time_from: null,
                time_to: null,
                mon: 0,
                tue: 0,
                wed: 0,
                thu: 0,
                fri: 0,
                sat: 0,
                sun: 0,
            }

            inputs.door_id = this.door.door_id
            inputs.user_id = this.employee.user_id
            inputs.ay_id = this.fields.ay_id
            let time_from = new Date(this.fields.time_from);
            let time_to = new Date(this.fields.time_to);

            inputs.mon = this.fields.mon ? 1 : 0
            inputs.tue = this.fields.tue ? 1 : 0
            inputs.wed = this.fields.wed ? 1 : 0
            inputs.thu = this.fields.thu ? 1 : 0
            inputs.fri = this.fields.fri ? 1 : 0
            inputs.sat = this.fields.sat ? 1 : 0
            inputs.sun = this.fields.sun ? 1 : 0 


            inputs.time_from = '2023-01-01 ' + time_from.getHours().toString().padStart(2, "0") + ':' + time_from.getMinutes().toString().padStart(2, "0")
            inputs.time_to = '2023-01-01 ' + time_to.getHours().toString().padStart(2, "0") + ':' + time_to.getMinutes().toString().padStart(2, "0")

            if(this.global_id > 0){
                //update
                axios.put('/users/'+this.global_id, inputs).then(res=>{
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
                axios.post('/schedules', inputs).then(res=>{
                    if(res.data.status === 'saved'){
                        this.$buefy.dialog.alert({
                            title: 'SAVED!',
                            message: 'Successfully saved.',
                            type: 'is-success',
                            confirmText: 'OK',
                            onConfirm: () => {
                                window.location = '/schedules'
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

        emitBrowseEmployee(row){
            this.employee = row
            this.employeeFullname = row.lname + ', ' + row.fname + ' ' + row.mname
        },

        emitBrowseDoor(row){
            this.door = row
            this.doorName = row.door_name
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


        loadAcademicYears(){
            this.academic_years = JSON.parse(this.propAcademicYears);
        }
        
    },

    mounted() {
        this.loadAcademicYears();
        
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
