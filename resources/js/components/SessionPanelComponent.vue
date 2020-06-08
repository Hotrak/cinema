<template>
    <div >
        <div class="panel1 center" v-if="showPanel1">
            <h2>{{film.name}}</h2>
            <span>{{date}}</span>
            <span>{{time}}</span>
            <div class="screen">
                <span>экран</span><hr><span>экран</span>
            </div>
            <div class="places">
                <table class="table-container">
                    <tbody>
                        <tr v-for="(i,indexI) in places">
                            <td>{{indexI+1}}</td>
                            <td v-for="(j,indexJ) in i" v-if="!places[indexI][indexJ]['blocked']" class="place" :class="places[indexI][indexJ]['select']?'select':'empty'" v-on:click="selectPlace(indexI,indexJ)" >{{indexJ+1}}</td>
                            <td v-else class="place blocked"></td>
                            <td>{{indexI+1}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="bottom-menu">
                <div class="menu-item">
                    <span style="margin-right:50px; font-size:20px ;">Мест {{getSelectedlength}} шт</span>
                </div>
                <div class="menu-item">
                    <span style="margin-right:50px; font-size:20px ;">Стоимость {{price*getSelectedlength}} р</span>
                </div>
                <div class="menu-item" v-if="isAdmin">
                    <div class = "btn-delete" v-on:click="deleteSchedule">Удалить</div>
                </div>
                <div class="menu-item">
                    <div class = "btn-enter" v-on:click="nextStep">Далее</div>
                </div>
            </div>
            <img v-on:click="closePanel" class="btn-close" src="/img/close.png" alt="">
        </div>
        <div class="panel2" v-if="showPanel2">
            <div class="reservation-info">
                <h2>{{film.name}}</h2>
                <span>{{date}}</span>
                <span>{{time}}</span>
                <div style="display:flex;flex-direction: column; margin-top: 20px;">
                    <div v-for="(item,index) in getPlacesString" :key="index">
                        <span >{{item}}</span>
                    </div>
                </div>
            </div>
            <div class="user-info">
                <p><input v-model="email" type="email" placeholder="E-mail" ></p>
                <p style="margin-top: -10px"><input v-model="phone" type="text"  placeholder="Телефон"></p>
            </div>
            <div class="bottom-menu">
                <div class="menu-item">
                    <div class = "btn-delete" v-on:click="back">Назад</div>
                </div>
                <div class="menu-item">
                    <div class = "btn-enter" v-on:click="reservation">Забронировать</div>
                </div>
            </div>
            <img v-on:click="closePanel" class="btn-close" src="/img/close.png" alt="">
        </div>
        <div class="panel3" v-if="showPanel3">
            <span style="font-size: 25px; margin-bottom: 20px;">Код заказа: {{orderKod}}</span>
            <div class="btn-enter" @click="closePanel">ОК</div>
        </div>

        <div class="shadow"></div>
        <div style="display:flex;justify-content: center">
            <errors-component :errors="errorsV" v-if="errorsV"></errors-component>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    export default {
        props:['film','date','time','scheduleId','dialog'],
        data(){
            return{
                rows:8,
                columns:20,
                showPanel1:true,
                showPanel2:false,
                showPanel3:false,
                email:'',
                maxCountPlaces:5,
                phone:'',
                orderKod:'',
                price:'',
                errorsV:[],

                places:[]
            }
        },
        created() {
            this.getPlaces();
            this.email = this.compEmail;
            this.phone = this.compPhone;

            if(this.isAdmin){
                this.maxCountPlaces = 999;
            }
        },
        watch:{
            dialog(){
                console.log(this.dialog);

            },
            isAdmin(){
                if(this.isAdmin){
                    this.maxCountPlaces = 999;
                }
            }
        },
        computed:{
            ...mapGetters(['isAdmin','getUser']),
            getPlacesString(){
                let rows = this.getRows();
                let columns = this.getColumns();
                let text = [];
                for(let i = 0;i< this.getSelectedlength;i++){
                    text.push('Ряд: '+rows[i]+' Место: '+ columns[i]);
                }
                return text;
            },
            getSelectedlength(){
                return this.getRows().length;
            },
            compEmail(){
                if(this.getUser)
                    return this.getUser.email;
                else
                    return '';
            },
            compPhone(){
                if(this.getUser)
                    return this.getUser.phone;
                else
                    return '';
            }
        },
        methods:{
            getPlaces(){
                axios.get('/films/schedule/reservation',{
                    params: {
                        id_schedule: this.scheduleId
                    }
                }).then(response => {
                    console.log(response.data);
                    this.places = response.data['places'];
                    this.price = response.data['price']['price'];
                });
            },
            selectPlace(i,j){
                console.log(this.places[i][j]['select']);
                if(this.getSelectedlength< this.maxCountPlaces || this.places[i][j]['select']){
                    this.places[i][j]['select'] = !this.places[i][j]['select'];
                }
            },
            getRows(){
                let rows = [];
                for(let i = 0; i< this.places.length; i++){
                    for(let j = 0; j< this.places[0].length; j++){
                        if(this.places[i][j]['select'] === true){
                            rows.push(i+1);
                        }

                    }
                }
                return rows;
            },
            getColumns(){
                let columns = [];
                for(let i = 0; i< this.places.length; i++){
                    for(let j = 0; j< this.places[0].length; j++){
                        if(this.places[i][j]['select'] === true){
                            columns.push(j+1);
                        }

                    }
                }
                return columns;
            },
            reservation(){
                let rows = this.getRows();
                let columns = this.getColumns();

                for(let i = 0; i< this.places.length; i++){
                    for(let j = 0; j< this.places[0].length; j++){
                        if(this.places[i][j]['select'] === true){
                            rows.push(i+1);
                            columns.push(j+1);
                        }

                    }
                }
                let json_rows = JSON.stringify(rows);
                let json_columns = JSON.stringify(columns);
                let user_id = 0;
                if(this.getUser){
                    let user_id = this.getUser.id
                }
                // console.log("COLUMNS:"+columns);
                axios.post('/films/schedule/reservation',{
                    id_schedule: this.scheduleId,
                    rows: json_rows,
                    columns: json_columns,
                    email: this.email,
                    user_id: user_id,
                    phone: this.phone,
                }).then(response => {
                    console.log("FROM SERVER:"+response.data);
                    this.orderKod = response.data;
                    this.showPanel2 = false;
                    this.showPanel3 = true;
                    // this.places = response.data;
                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },

            back(){
                this.showPanel2 = false;
                this.showPanel1 = true;
            },
            nextStep(){
                if(this.showPanel2){
                    this.reservation();
                }else if(this.showPanel1){
                    if(this.getSelectedlength!==0){
                        this.showPanel2 = true;
                        this.showPanel1 = false;
                        this.errorsV = [];
                    }else {
                        this.errorsV.push("Необходимо выбрать хотябы одно место");
                    }
                }else
                    this.showPanel1 = true;
            },
            closePanel(){
                this.$emit('close-panel');
                this.showPanel1 = true;
                this.showPanel2 = false;
                this.showPanel3 = false;
            },
            deleteSchedule(){
                axios.delete('/schedule/'+this.scheduleId).then(response => {
                    location.reload();
                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });
            }
        }
    }
</script>
<style scoped>

    .panel1{
        position: fixed;
        width: 1300px;
        height: 600px;
        background-color: var(--bg-panel);
        z-index: 999;
        margin: auto;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        border-radius: 5px;
    }

    .center{
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .screen{
        display: flex;
        justify-content: center;
        align-items: center;
        width: 70%;
    }
    .screen hr{
        width:100%;
        margin: 0 3px;
    }
    .places{
        width: 90%;
        margin-top: 20px;
    }
    .place{
        width: 40px;
        border-radius: 3px;
        cursor: pointer;
    }
    .empty{
        background-color: #303849;
    }
    .empty:hover{
        background-color: var(--text-main);
        color: #000000;
    }
    .select{
        background-color: var(--text-yellow);
        color: #000000;
        font-weight: bold;
    }
    .blocked{
        background-color: #2c2b2c;
    }

    .table-container{
        text-align: center;
        overflow: hidden;
        width: 100%;
        margin: 0 auto;
        display: table;
        padding-bottom: 10px;

    }

    .table-container td {
        font-weight: normal;
        font-size: 1em;
        text-align: center;
        /*-webkit-box-shadow: 0 2px 2px -2px #0E1119;*/
        /*-moz-box-shadow: 0 2px 2px -2px #0E1119;*/
        /*box-shadow: 0 2px 2px -2px #0E1119;*/
    }

    .table-container td, .container th {
        padding-bottom: 1%;
        padding-top: 1%;
        padding-left:1%;
        padding-right:1%;
    }

    .table-container td:first-child { color: #FB667A;margin-right: 10px; }
    .table-container td:last-child { color: #FB667A;margin-left: 10px; }

    .panel2{
        position: fixed;
        width: 500px;
        height: 300px;
        background-color: var(--bg-panel);
        z-index: 999;
        margin: auto;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        border-radius: 5px;
        display: flex;
        justify-content: space-between;
        padding: 5px;

    }
    .user-info{
        display: flex;
        flex-direction: column;
        align-items:center;
        padding: 10px;
    }
    .user-info input{
        height: 40px;
        padding-left: 3px;
        font-size: 19px;
        border-radius:5px;

    }

    .panel3{
        position: fixed;
        width: 400px;
        height: 100px;
        background-color: var(--bg-panel);
        z-index: 999;
        margin: auto;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        border-radius: 5px;
        padding: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;

    }
    .reservation-info{
        display: flex;
        align-items: center;
        flex-direction: column;
    }

</style>
<style>
    .btn-close{
        position: fixed;
        top: 0;
        right: 0;
        height: 25px;
        margin: 10px;
        z-index: 100;
        cursor: pointer;
    }
    .shadow{
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        width: 100%;
        height: 100%;
        z-index: 20;
        background-color: Black;
        opacity: .5;
    }
</style>
