<template>
    <div class="slide-wrapper" :style="imgUrl">
        <div class="next-session">
            <div style="height: 100%; position: relative; ">
                <h3 class="next-film-name">{{item.name}}</h3>
                <div class="next-film-date">
                    <span>Ближайший сеанс: </span><a href="#" @click="openReservation" style="color: var(--text-yellow)">{{date}}</a>
                </div>
                <span class="next-film-time">{{item.time_start}}</span>
            </div>
        </div>
        <!--        <SessionPanelComponent v-if="dialog" :dialog="dialog" :film="{name:item.name}" :date="item.date_s"  :time="item.time_start" :scheduleId="item.id" @close-panel="dialog=false"></SessionPanelComponent>-->
    </div>
</template>

<script>
    import SessionPanelComponent from "./SessionPanelComponent";
    export default {
        props:['item'],
        data:(vm)=>({

            dialog:false,
            // styleVal: "background-image: url('/storage/"+this.item.img+"');",

        }),
        computed:{
            imgUrl(){
                return  "background: url('/storage/"+this.item.img_b+"') no-repeat; background-size: 100%; border-radius:10px;";
            },
            date(){
                let date = new Date();
                let dateText = this.item.date_s;
                let tomorrow = new Date(date.getTime() + (24 * 60 * 60 * 1000)).toISOString().substr(0, 10);
                if(date.toISOString().substr(0, 10)=== this.item.date_s)
                    dateText = 'Сегодня';
                if(tomorrow === this.item.date_s)
                    dateText = 'Завтра';

                return dateText;
            }
        },
        methods:{
            closeDialog(){
                this.dialog = false;
            },
            openReservation(){
                this.$emit('reservation-panel',this.item);
            }
        },
        components:{
            SessionPanelComponent
        }
    }
</script>

<style scoped>
    .slide-wrapper{
        /*height: 585px;*/
        height: 100%;
        width: 100%;
        position: relative;
    }
    .next-session{
        background-color: #000;
        width: 300px;
        border-radius: 5px;
        opacity: 70%;
        position: absolute;
        bottom: 0;
        left: 0;
        margin: 40px;
        padding: 10px;
    }
    .next-session h3{
        margin-top: -5px;
    }
    .next-session .next-film-time{
        font-size: 40px;
    }

</style>
