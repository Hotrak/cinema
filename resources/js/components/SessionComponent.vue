<template>
    <div class="test-table"  v-if="isAdmin || schedule.length>0">
        <div class="title">
            <h2>Расписание</h2>
            <div class="menu-item" v-if="isAdmin"><a class="btn-enter" @click="isFormShow=true">Добавить</a></div>
        </div>
        <table class="table-container" v-if="datat !== null">
            <tbody>
                <tr v-for="(item,index) in schedule" :key="index" height="30px">
                    <td style="text-align: left;width: 260px">{{item.date_s}}</td>
                    <td class="schedule-item" v-for="info in item.info" v-if="info.time_start" v-on:click="showPanel(item.date_s,info.time_start,info.id)"><a>{{info.time_start}}</a></td>
                    <td v-else>-</td>
                </tr>
            </tbody>
        </table>
        <session-panel-component @close-panel="closePanel" v-if="isShow"  :dialog="isShow" :film="film" :date ="date" :time ="time" :scheduleId ="scheduleId">></session-panel-component>
        <schedule-form-component @close-form="closeForm" v-if="isFormShow" :film="film"> </schedule-form-component>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    export default {
        props:[
            'datat','film','films'
        ],
        data(){
            return {
                isShow:false,
                isFormShow:false,
                date:'',
                time:'',
                scheduleId:0,
            }
        },
        computed:{
            ...mapGetters(['isAdmin']),
            schedule(){
                let date = new Date();
                let filtered = this.datat.data.filter((item)=>{
                    // console.log(item.date_unform+" | "+date.toISOString().substr(0, 10));
                    if(item.date_unform>= date.toISOString().substr(0, 10)){
                        if(item.date_unform=== date.toISOString().substr(0, 10))
                        item.info = item.info.filter((inf)=>{
                            let time1 =inf.time_start+':00';
                            let time2 = date.getHours() + ':'+ date.getMinutes()+':00';//date.getHours()

                            if(time1>time2)
                                return inf;
                        });
                        let length =  item.info.filter((item=>item.time_start)).length;

                        if(length !==0) return item;
                    }
                });

                return filtered;
            }
        },
        created() {
            console.log("DATA: "+this.datat);
        },
        methods:{
            showPanel(date,time,id){
                this.date = date;
                this.time = time;
                this.scheduleId = id;
                this.isShow = true;
            },
            closePanel(){
                this.isShow = false;
            },
            closeForm(){
                this.isFormShow = false;
            }
        }
    }
</script>
<style scoped>
    .title{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .test-table{
        margin-top: 10px;
        background-color: var(--bg-panel);
        padding:0 10px;
    }
    .table-container th h1 {
        font-weight: bold;
        font-size: 1em;
        text-align: left;
        color: #185875;
    }

    .table-container td {
        font-weight: normal;
        font-size: 1em;
        -webkit-box-shadow: 0 2px 2px -2px #0E1119;
        -moz-box-shadow: 0 2px 2px -2px #0E1119;
        box-shadow: 0 2px 2px -2px #0E1119;
    }

    .table-container{
        text-align: center;
        overflow: hidden;
        width: 100%;
        margin: 0 auto;
        display: table;
        padding-bottom: 10px;
    }
    .table-container-small{
        text-align: center;
        overflow: hidden;
        width: 20%;
        margin: 0 auto;
        display: table;
        padding: 0 0 8em 0;
    }


    .table-container td, .container th {
        padding-bottom: 2%;
        padding-top: 2%;
        padding-left:2%;
    }

    /* Background-color of the odd rows */
    .table-container tr:nth-child(odd) {
        background-color: #323C50;
    }

    /* Background-color of the even rows */
    .table-container tr:nth-child(even) {
        background-color: #2C3446;
    }

    .table-container th {
        background-color: #1F2739;
    }

    .table-container td:first-child { color: #FB667A; }

    .table-container tr:hover {
        background-color: #464A52;
        -webkit-box-shadow: 0 6px 6px -6px #0E1119;
        -moz-box-shadow: 0 6px 6px -6px #0E1119;
        box-shadow: 0 6px 6px -6px #0E1119;
    }

    .add-container{
        position: absolute;
        top: 50%;
        left: 50%;
        margin-right: -50%;
        transform: translate(-50%, -50%);
        width: 300px;
        height: 150px;
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: center;
    }


    .select-box {
        cursor: pointer;
        position: relative;
        max-width: 20em;
        width: 100%;
    }
    .schedule-item{
        font-family: var(--Lexend);
        cursor:pointer;
    }
    .schedule-item:hover{
        background-color: var(--text-yellow);
        color:#000;
    }
</style>
