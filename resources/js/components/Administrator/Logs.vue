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

                                    <b-table-column field="log_type" label="Log Type" sortable v-slot="props">
                                        <span v-if="props.row.log_type">{{ props.row.log_type }}</span>
                                    </b-table-column>
    
                                    <b-table-column field="date_created" label="Date Created" sortable v-slot="props">
                                        {{ props.row.created_at | formatDateTime }}
                                    </b-table-column>
    
                                </b-table>
    
    
                            </div> <!--panel body -->
    
                            <div class="panel-footer">
                                
                            </div>
                        </b-tab-item>
                        
                        <b-tab-item label="Attendance" icon="view-list-outline">
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
    
                                    <b-table-column field="id" label="ID" sortable v-slot="props">
                                        {{ props.row.id }}
                                    </b-table-column>
    
                                    <b-table-column field="user_name" label="Name" sortable v-slot="props">
                                        {{ props.row.user_name }}
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


        }
    },

    methods: {

        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `perpage=${this.perPage}`,
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


    },

    mounted(){
        this.loadAsyncData()
        this.loadAsyncDataAttendance()
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