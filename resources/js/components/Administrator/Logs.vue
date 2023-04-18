<template>
    <div>

        <div class="panel-container">
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-text-header">
                        Acitivy Logs
                    </div>
                </div>
    
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

                            <b-table-column field="activity" label="Activity" sortable v-slot="props">
                                {{ props.row.activity }}
                            </b-table-column>

                            <b-table-column field="role" label="System Role" sortable v-slot="props">
                                {{ props.row.role }}
                            </b-table-column>

                            <b-table-column field="date_created" label="Date Created" sortable v-slot="props">
                                {{ props.row.created_at | formatDateTime }}
                            </b-table-column>

                        </b-table>


                </div> <!--panel body -->

                <div class="panel-footer">
                    
                </div>
    
            </div><!-- panel -->

        </div> <!--panel-container-->



    </div> <!--root div-->
    
</template>

<script>

export default{


    data(){
        return {
            logs: [],

            data: [],
            total: 0,
            loading: false,
            sortField: 'id',
            sortOrder: 'desc',
            page: 1,
            perPage: 20,
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


    },

    mounted(){
        this.loadAsyncData()
    }
}
</script>

<style scoped>
    .panel-container{
        max-width: 720px;
        margin: 30px auto;
    }

    .panel-header{
        border-bottom: 1px solid blue;
        padding: 15px;
    }

    .panel-text-header{
        font-weight: bold;
    }
    .panel-body{
        padding: 25px;
    }

    .panel-footer{
        padding: 25px;
        border-top: 1px solid blue;
    }

</style>