<template>
    <div>
        <div class="orders-block" v-if="orders.length!==0 && getUser">
            <div class="search-input-layout" v-if="isAdmin">
                <input type="text" placeholder="Код заказа" v-model="search">
            </div>
            <div class="order-item" v-for="(item,index) in filteredOrders" :key="index" >
                <a style="display:flex; align-items: center" :href="'/films/'+item.film_id">
                    <img height="150px" :src="'/storage/'+item.img" alt="">
                    <span style="font-size: 20px; margin-left: 10px;">{{item.name}}</span>
                </a>
                <div @click="openAboutOrderPanel(item.id)" style="display:flex; justify-content: space-between;width:50%;">
                    <span>{{item.date_s}}</span>
                    <span>{{item.time_start}}</span>
                    <span>Мест {{item.count_place}}</span>
                </div>

                <img height="20px" style="cursor: pointer" src="/img/close.png" alt="" @click="deleteOrder(item.id)">
            </div>
        </div>
        <div v-else style="display:flex; justify-content: center">
            <span> Вы, нечего не забранировали, пока что ...</span>
        </div>
        <AboutOrderComponent v-if="aboutOrderDialog" :dialog="aboutOrderDialog" :orderId="selectedId" @delete-order="deleteOrder" @close-panel="closeAboutOrderPanel"></AboutOrderComponent>
    </div>
</template>
<script>
    import AboutOrderComponent from "./AboutOrderComponent";
    import {mapGetters} from 'vuex'

    export default {
        data(){
            return{
                userOrders:[],
                aboutOrderDialog:false,
                selectedId:-1,
                search:'',
                orders:[],
            }
        },
        watch:{
            search(){
                console.log(this.search);
            },
        },
        mounted(){
            this.loadOrders();

        },
        computed:{
            ...mapGetters(['getUser','isAdmin']),
            compOrders(){
                return this.orders;
            },
            filteredOrders(){
                return this.filterItems(this.search);
            }
        },
        methods:{
            deleteOrder(id){
                axios.delete('/reservation/'+id);
                let order = this.orders.filter(item=>item.id === id);
                let index = this.orders.indexOf(order);
                this.orders.splice(index,1);
                console.log(this.orders);
            },
            loadOrders(){
                let userId = this.getUser.id;
                axios.get('/orders/'+userId).then(response=>{
                    console.log(response.data);
                    this.orders = response.data;
                }).catch(error=>{
                    console.log(error);
                })
            },
            closeAboutOrderPanel(){
                this.aboutOrderDialog = false;
            },
            openAboutOrderPanel(id){
                this.selectedId = id;
                this.aboutOrderDialog = true;
            },
            filterItems(query) {
                // return  this.orders;
                if(this.orders.length != 0)
                    return this.orders.filter(function(el) {
                        return el.kod.toLowerCase().indexOf(query.toLowerCase()) > -1;
                    })
                else
                    return [];
            }
        },
       created() {
           // console.log(this.orders);
           // this.userOrders =  this.orders;
       },
        components:{
            AboutOrderComponent
        }
    }
</script>

<style scoped>

    .order-item{
        margin-bottom: 5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: var(--bg-panel);
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;

    }
    .order-item:hover{
        background-color: #464A52;
    }

    label {
        width: 100px;
        text-align: left;
        float: left;
        margin-right: 10px;
        line-height: 15px;

    }

    input{
        width: 300px;
        padding: 10px;
        box-shadow: inset 0 1px 5px rgba(0,0,0,0.2);
        border: 1px solid #ccc;
        padding-left: 5px;
        font-size: 20px;
        border-radius: 5px;
    }

    .search-input-layout{
        display:flex;
        justify-content: flex-end;
        width:100%;
        margin: 20px 0;
        padding-right: 20px;
    }

</style>
