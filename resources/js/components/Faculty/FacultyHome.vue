<template>
    <div>
        <div class="columns is-centered">
            <div class="column is-6 mt-4">
                <div class="box">
                    <div style="font-weight: bold; font-size: 1.3em;">FACULTY DASHBOARD</div>


                    <div class="box-body">
                        <div class="welcome-msg">
                            Hello {{ user.lname }}, {{ user.fname }} {{ user.mname }}.
                        </div>

                        <div class="welcome-msg my-3">
                            Schedule Summary
                        </div>

                        <div class="schedule-summary">
                            <div>{{ ay.ay_desc }}</div>
                            <table>
                                <tr>
                                    <th>Description</th>
                                    <th>Schedule Time</th>
                                    <th>Schedule Day</th>
                                </tr>
                                <tr v-for="(item, index) in schedules" :key="index">
                                    <td>{{ item.schedule_description }}</td>
                                    <td>{{ item.time_start | formatTime }} - {{ item.time_end | formatTime }}</td>
                                    <td>
                                        <span v-if=" item.mon == 1">M</span>
                                        <span v-if=" item.tue == 1">T</span>
                                        <span v-if=" item.wed == 1">W</span>
                                        <span v-if=" item.thu == 1">TH</span>
                                        <span v-if=" item.fri == 1">F</span>
                                        <span v-if=" item.sat == 1">S</span>
                                        <span v-if=" item.sun == 1">SU</span>
                                        
                                    </td>
                                </tr>
                            </table>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>

    </div>
</template>


<script>
export default {
    props: {
        propUser: {
            type: String,
            default: ''
        },
        propSchedules: {
            type: String,
            default: ''
        },
        propAy: {
            type: String,
            default: ''
        }
    },


    data(){
        return {
            noRequest: 0,

            user: {},
            schedules: [],
            ay: {},
        }
    },

    methods: {
    
        initData(){
            this.user = JSON.parse(this.propUser);
            this.schedules = JSON.parse(this.propSchedules)
            this.ay = JSON.parse(this.propAy)
        },

        
    },

    mounted() {
        this.initData()
    },

    computed: {
        dateNow(){
            let d = new Date();
            const month = d.toLocaleString('default', { month: 'long' });
            return month + ' ' + d.getDate() + ' ' + d.getFullYear()
        }
    }
}
</script>

<style scoped>

    .no-request{
        font-weight: bold;
        font-size: 3em;
        text-align: center;
    }

    .box-body{
        padding: 25px;
    }

    .welcome-msg{
        font-weight: bold;
    }

    .schedule-summary table > tr > td{
        padding: 10px;
        margin: 5px;
        border: 1px solid rgb(197, 197, 197);
    }
    .schedule-summary table > tr > th{
        padding: 10px;
        margin: 5px;
        border: 1px solid rgb(197, 197, 197);
    }

</style>
