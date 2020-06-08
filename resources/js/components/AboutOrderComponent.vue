<template>
    <div>
        <div class="about-order-panel" v-if="dialog">

            <div class="title" style="margin-top: -10px;">
                <h3>{{title}}</h3>
            </div>
            <div>
                <table class="table-container">
                    <tr>
                        <td class="film-prop-title">Дата</td>
                        <td><span>{{date}}</span></td>
                    </tr>
                    <tr>
                        <td class="film-prop-title">Время</td>
                        <td ><span>{{time}}</span></td>
                    </tr>
                    <tr>
                        <td class="film-prop-title">Код заказа</td>
                        <td><span>{{code}}</span></td>
                    </tr>
                    <tr>
                        <td class="film-prop-title" >Места</td>
                        <td style="display:flex; flex-direction: column"><span v-for="(item,index) in places" :key="index" >{{item}}</span></td>
                    </tr>
                </table>
            </div>

            <div class="bottom-menu">
                <div class="menu-item">
                    <a class="btn-edit" @click="printOrder">Печать</a>
                </div>
                <div class="menu-item">
                    <a class="btn-delete" @click="deleteOrder">Отменить</a>
                </div>
            </div>
            <img @click="closePanel" class="btn-close" src="/img/close.png" alt="">

        </div>
        <div class="shadow"></div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import jsPDF from 'jspdf';
    export default {
        props:['dialog','orderId'],
        data(){
            return{
                order:{},
            }

        },
        mounted(){
           this.loadOrder();
        },
        methods:{
            closePanel(){
                this.$emit('close-panel')
            },
            loadOrder(){
                console.log("START_LOAD "+this.orderId);
                axios.get('/reservation/'+this.orderId).then(response=>{

                    this.order = response.data;

                }).catch(error=>{
                    console.log(error)
                });
            },
            deleteOrder(){
                this.$emit('delete-order',this.orderId);
                this.closePanel();
            },
            printOrder(){
                var doc = new jsPDF();

                let ticets = [
                    {
                        id:0,
                        name:'Фильм 1',
                        date:'2020-06-20',
                        time:'09:30',
                        places:[
                            {
                                column:1,
                                row:2,
                            },
                            {
                                column:3,
                                row:4,
                            }
                        ]
                    },
                    {
                        id:1,
                        name:'Фильм 2',
                        date:'2020-06-20',
                        time:'12:30',
                        places:[
                            {
                                column:6,
                                row:7,
                            },
                            {
                                column:8,
                                row:9,
                            }
                        ]
                    }
                ];
                let count = 0;
                for(let i = 0;i< ticets.length;i++){
                    let item = ticets[i];
                    doc.text(item.name, i*20, i*10+count);
                    count+=10;
                    doc.text('ДАТА:'+item.date, i*20, i*20+count);
                    count+=10;
                    doc.text('ВРЕМЯ:'+item.time, i*20, i*20+count);
                }


                doc.save('a4.pdf')
            }
        },
        computed:{
            ...mapGetters(['isAdmin']),
            title(){
                if(this.order.length>0)
                    return this.order[0].name;
                else return  "";
            },
            date(){
                if(this.order.length>0)
                    return this.order[0].date_s;
                return  "";
            },
            time(){
                if(this.order.length>0)
                    return this.order[0].time_start;
                return  "";
            },
            code(){
                if(this.order.length>0)
                    return this.order[0].kod;
                return  "";
            },
            places(){
                let places = [];
                for(let i = 0;i< this.order.length;i++){
                    places.push("Место: "+this.order[i].column+" Ряд: "+this.order[i].row);
                }
                return places;
            },



        }
    }
</script>

<style scoped>
    .about-order-panel{
        position: fixed;
        width: 300px;
        height: 400px;
        background-color: var(--bg-panel);
        z-index: 999;
        margin: auto;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        border-radius: 5px;
        padding: 10px;
    }
</style>
