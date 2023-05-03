<template>
    <div>

        <div class="columns is-centered m-4">

            <div class="column is-8">
                <div class="panel">
                    <b-tabs>
                        <b-tab-item label="Activity Logs" icon="view-list">
                        
                            <div class="panel-body">
                                
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

                                    <div class="is-flex">
                                        <div>
                                            <b-field label="Search" label-position="on-border">
                                                <b-input type="text"
                                                    v-model="search.user" placeholder="Search User"
                                                    @keyup.native.enter="loadAsyncData"/>
                                                <p class="control">
                                                    <b-tooltip label="Search" type="is-success">
                                                        <b-button type="is-primary" icon-right="magnify" @click="loadAsyncData"/>
                                                    </b-tooltip>
                                                </p>
                                            </b-field>
                                        </div>
                                        <div>
                                            <b-button type="is-info"
                                                class="is-outlined ml-2"
                                                icon-left="printer" @click="openWindowPrint"></b-button>
                                        </div>
                                    </div>

                                    <div class="mt-2">
                                        <b-field>
                                            <b-field label="From" label-position="on-border">
                                                <b-datepicker v-model="search.start_date"></b-datepicker>
                                            </b-field>
                                            <b-field label="To" label-position="on-border">
                                                <b-datepicker v-model="search.end_date"></b-datepicker>
                                            </b-field>
                                        </b-field>
                                    </div>
                                    
    
                                    <b-table-column field="id" label="ID" sortable v-slot="props">
                                        {{ props.row.id }}
                                    </b-table-column>
    
                                    <b-table-column field="user" label="User" sortable v-slot="props">
                                        {{ props.row.user }}
                                    </b-table-column>
    
                                    <b-table-column width="400" field="activity" label="Activity" sortable v-slot="props">
                                        {{ props.row.activity }}
                                    </b-table-column>
    
                                    <b-table-column field="role" label="System Role" sortable v-slot="props">
                                        {{ props.row.role }}
                                    </b-table-column>
    
                                    <b-table-column field="door" label="Door" sortable v-slot="props">
                                        <span v-if="props.row.door">{{ props.row.door }}</span>
                                    </b-table-column>

                                    <b-table-column field="date_created" label="Date Created" sortable v-slot="props">
                                        {{ props.row.created_at | formatDateTime }}
                                    </b-table-column>
    
                                </b-table>
    
    
                            </div> <!--panel body -->
    
                            <div class="panel-footer">
                                
                            </div>
                        </b-tab-item>
                        
                        <b-tab-item label="Faculty Attendance" icon="view-list-outline">
                            <div class="panel-body">
                                
                                <b-table
                                    :data="dataAttendance"
                                    :loading="loadingAttendance"
                                    paginated
                                    backend-pagination
                                    :total="totalAttendance"
                                    :pagination-rounded="true"
                                    :per-page="perPageAttendance"
                                    @page-change="onPageChangeAttendance"
                                    aria-next-label="Next page"
                                    aria-previous-label="Previous page"
                                    aria-page-label="Page"
                                    aria-current-label="Current page"
                                    backend-sorting
                                    :default-sort-direction="defaultSortDirectionAttendance"
                                    @sort="onSortAttendance">

                                    


                                    <div class="is-flex">
                                        <div>
                                            <b-field label="Search Faculty" label-position="on-border">
                                                <b-input type="text"
                                                    v-model="facultySearch.faculty" placeholder="Search Faculty"
                                                    @keyup.native.enter="loadAsyncDataAttendance"/>
                                                <p class="control">
                                                    <b-tooltip label="Search" type="is-success">
                                                        <b-button type="is-primary" icon-right="magnify" @click="loadAsyncDataAttendance"/>
                                                    </b-tooltip>
                                                </p>
                                            </b-field>
                                        </div>
                                        <div>
                                            <b-button type="is-info"
                                                class="is-outlined ml-2"
                                                icon-left="printer" @click="openWindowPrintFaculty"></b-button>
                                        </div>
                                    </div>

                                    <div class="mt-2">
                                        <b-field>
                                            <b-field label="From" label-position="on-border">
                                                <b-datepicker v-model="search.start_date"></b-datepicker>
                                            </b-field>
                                            <b-field label="To" label-position="on-border">
                                                <b-datepicker v-model="search.end_date"></b-datepicker>
                                            </b-field>
                                        </b-field>
                                    </div>

    
                                    <b-table-column field="id" label="ID" sortable v-slot="props">
                                        {{ props.row.id }}
                                    </b-table-column>
    
                                    <b-table-column field="user_name" label="Name" sortable v-slot="props">
                                        {{ props.row.user.lname }}, {{ props.row.user.fname}} {{ props.row.user.mname }}
                                    </b-table-column>

                                    <b-table-column field="schedule" label="Schedule" sortable v-slot="props">
                                        <span v-if="props.row.schedule">
                                            {{ props.row.schedule.time_start | formatTime }} -
                                            {{ props.row.schedule.time_end | formatTime}}
                                        </span>
                                    </b-table-column>

                                    <b-table-column field="door" label="Door" sortable v-slot="props">
                                        <span v-if="props.row.door">{{ props.row.door.door_name }} ({{ props.row.door.mac_add }})</span>
                                    </b-table-column>
    
                                    <b-table-column field="role" label="System Role" sortable v-slot="props">
                                        {{ props.row.role }}
                                    </b-table-column>

                                    <b-table-column field="date_created" label="Attendance Date Time" sortable v-slot="props">
                                        {{ props.row.created_at | formatDateTime }}
                                    </b-table-column>
    
                                </b-table>
    
    
                            </div> <!--panel body -->
    
                            <div class="panel-footer">
                                
                            </div>
                        </b-tab-item>
                    </b-tabs>
                </div> <!-- panel -->
            </div> <!-- col -->

        </div> <!-- cols -->

    </div> <!--root div-->
    
</template>

<script>

export default{


    data(){
        return {
            logs: [],

            data: [],
            dataAttendance: [],

            total: 0,
            totalAttendance: 0,

            loadingAttendance: false,
            loading: false,

            sortFieldAttendance: 'id',
            sortField: 'id',

            sortOrderAttendance: 'desc',
            sortOrder: 'desc',

            pageAttendance: 1,
            page: 1,

            perPageAttendance: 20,
            perPage: 20,

            defaultSortDirectionAttendance: 'asc',
            defaultSortDirection: 'asc',


            search: {
                user: '',
               
                start_date: new Date(new Date().getFullYear(), new Date().getMonth(), 1),
                end_date: new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0)
            },

            facultySearch: {
                faculty: '',
                start_date: new Date(new Date().getFullYear(), new Date().getMonth(), 1),
                end_date: new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0)
            }


        }
    },

    methods: {

        loadAsyncData() {

            //console.log(this.$formatDate(this.search.start_date))

            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `perpage=${this.perPage}`,
                `user=${this.search.user}`,
                `start=${this.$formatDate(this.search.start_date)}`,                
                `end=${this.$formatDate(this.search.end_date)}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-logs?${params}`)
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


        //FOR ATTENDANCE ASYNC
        loadAsyncDataAttendance() {
            const params = [
                `sort_by=${this.sortFieldAttendance}.${this.sortOrderAttendance}`,
                `faculty=${this.facultySearch.faculty}`,
                `perpage=${this.perPageAttendance}`,
                `page=${this.pageAttendance}`
            ].join('&')

            this.loadingAttendance = true
            axios.get(`/get-attendance-logs?${params}`)
                .then(({ data }) => {
                    this.dataAttendance = [];
                    let currentTotal = data.totalAttendance
                    if (data.totalAttendance / this.perPageAttendance > 1000) {
                        currentTotal = this.perPageAttendance * 1000
                    }

                    this.totalAttendance = currentTotal
                    data.data.forEach((item) => {
                        //item.release_date = item.release_date ? item.release_date.replace(/-/g, '/') : null
                        this.dataAttendance.push(item)
                    })
                    this.loadingAttendance = false
                })
                .catch((error) => {
                    this.dataAttendance = []
                    this.totalAttendance = 0
                    this.loadingAttendance = false
                    throw error
                })
        },
        /*
        * Handle page-change event
        */
        onPageChangeAttendance(page) {
            this.pageAttendance = page
            this.loadAsyncDataAttendance()
        },

        onSortAttendance(field, order) {
            this.sortFieldAttendance = field
            this.sortOrderAttendance = order
            this.loadAsyncDataAttendance()
        },

        setPerPageAttendance(){
            this.loadAsyncDataAttendance()
        },

        openWindowPrint(){
            window.location = '/logs-print-preview?start=' + this.$formatDate(this.search.start_date) + '&end=' + this.$formatDate(this.search.end_date)
        },

        openWindowPrintFaculty(){
            window.location = '/logs-print-preview-faculty-attendance?start=' 
                + this.$formatDate(this.search.start_date) 
                + '&end=' + this.$formatDate(this.search.end_date)
        }


    },

    mounted(){
        this.loadAsyncData()
        this.loadAsyncDataAttendance()
    },

    computed:{
      
    }
}
</script>

<style scoped>


    .panel-header{
        border-bottom: 1px solid blue;
        padding: 15px;
    }

    .panel-text-header{
        font-weight: bold;
    }
    .panel-body{
        padding: 15px;
    }

    .panel-footer{
        padding: 25px;
        border-top: 1px solid blue;
    }

</style>