<template>
    <div style="margin-bottom: 20px">
        <hooper :settings="hooperSettings">
            <slide  v-for="(item,index) in filteredFilms" :key="index">
                <slider-item-component :item = "item" @reservation-panel="showPanel"></slider-item-component>
            </slide>
            <hooper-navigation slot="hooper-addons"></hooper-navigation>
        </hooper>
        <SessionPanelComponent v-if="panelDialog" :dialog="panelDialog" :film="{name:editItem.name}" :date="editItem.date_s"  :time="editItem.time_start" :scheduleId="editItem.id" @close-panel="closePanel"></SessionPanelComponent>
    </div>

</template>

<script>
    import {Hooper, Slide, Navigation as HooperNavigation,} from 'hooper';
    import 'hooper/dist/hooper.css';
    // import 'hooper/dist/hooper.css';
    import SessionPanelComponent from "./SessionPanelComponent";

    export default {
        props:[
            'films'
        ],
        data() {
            return {
                hooperSettings: {
                    infiniteScroll: true,
                    autoPlay: true,
                    playSpeed: 3500,
                    centerMode: true,
                    wheelControl:false,


                },
                panelDialog : false,
                editItem:{},
            }
        },
        methods:{
            showPanel(item){
                console.log('SHOW');
                this.editItem = item;
                this.panelDialog = true;


            },
            closePanel(){
                this.panelDialog = false;
            }
        },
        computed:{
            filteredFilms(){

                let date = new Date();
                return this.films.filter(item=>{
                    console.log(item.date_s+" D|D "+date.toISOString().substr(0, 10));
                    if(item.date_s>= date.toISOString().substr(0, 10)){
                        if(item.date_s=== date.toISOString().substr(0, 10)){
                            let time1 =item.time_start+':00';
                            let time2 = date.getHours() + ':'+ date.getMinutes()+':00';//date.getHours()

                            console.log(time1+" | "+time2 +" "+(time1>time2?1:0));
                            if(time1>time2)
                                return item;
                        }else
                        return item;
                    }
                });


            }
        },
        components: {
            Hooper,
            Slide,
            HooperNavigation,SessionPanelComponent
        }
    }
</script>

<style scoped>
    .hooper {
        height: 60vh;
        position: relative;
        margin: auto;
    }
</style>

