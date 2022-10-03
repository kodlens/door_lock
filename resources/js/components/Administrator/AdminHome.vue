<template>
    <div>
        <div class="section">

        </div>

        <!-- <div class="section">
            <div class="buttons">
                <b-button type="is-info" @click="sendSMS" label="Send"></b-button>
            </div>
        </div> -->


    </div>
</template>

<script>
export default {
	data(){
		return{
            info: {},

		}
	},

	methods:{
        getDashboardInfo(){
            axios.get('/get-dashboard-info').then(res=>{
                this.info = res.data;
            })
        },

        sendSMS: function(){
            axios.post('http://192.168.88.231:1688/services/api/messaging?Message=smaple&To=09167789585&Slot=1',{},{
                headers: {
                    'Content-Type': 'text/plain' //void COR error
                }
            }).then(res=>{
                console.log(res.data);
            })
        }
	},

    mounted() {
        this.getDashboardInfo();
    }
}
</script>

<style scoped>
    .w-head-title{
        font-weight: bold;
    }
    .w-content{
        text-align: center;
        font-weight: bold;
        font-size: 2em;
    }
</style>
