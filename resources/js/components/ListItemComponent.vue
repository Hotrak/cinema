<template>
<div class="list-item">
    <h2>{{item.name}}</h2>
    <div class="content">
        <a :href="'films/'+item.id">

            <div class="img-container">
                <img  :src="imagePath" alt="Avatar" class="image">
                <div class="overlay">
                    <div class="text">ПОДРОБНЕЕ</div>
                </div>
            </div>

        </a>
        <div class="description">
            <p>{{ item.description }}</p>
        </div>
        <div class="bottom-menu">
            <div class="menu-item" v-if="isAdmin" @click="deleteFilm">
                <a class="btn-delete">Удалить</a>
            </div>
            <div class="menu-item" v-if="isAdmin" @click="updateItem">
                <a class="btn-edit">Изменить</a>

            </div>
            <div class="menu-item">
                <a :href = "'films/'+item.id" class="btn-enter">Подробние</a>
            </div>
        </div>
    </div>
    <FilmEditComponent v-if="editItemDialog" :editItem="editItem" @close-panel="editItemDialog=false"></FilmEditComponent>

</div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import FilmEditComponent from './FilmEditComponent'
    export default {
        props:['item'],
        computed:mapGetters(['isAdmin']),
        data(){
            return{
                imagePath: '/storage/'+this.item.img,
                editItem:{},
                editItemDialog:false,
            }

        },
        methods:{
            deleteFilm(){
                this.$emit('delete',this.item);
                axios.delete('/films/'+this.item.id).then(response=>{
                    location.reload();
                });
            },
            updateItem(){
                this.editItem = Object.assign({},this.item);
                this.editItemDialog = true;
            },
            onEditItem(){

            }
        },
        components:{
            FilmEditComponent,
        }
    }
</script>

<style scoped>
    .list-item{
        width:47%;
        min-width: 500px;
        background-color: var(--bg-panel);
        border-radius: 5px;
        padding:0 5px;
        margin-bottom: 10px;

    }
    .list-item h2{
        margin-top: -2px;
    }
    .content{
        display: flex;
        position: relative;
    }
    .content .description{
         margin: 5px;
     }
    .content img{
        height: 350px;
    }

    @media only screen and (max-width: 1080px){
        .list-item{
            width: 100%;
        }
    }

    .img-container {
        position: relative;
        /*width: 50%;*/
    }

    .image {
        display: block;
        height: auto;
        max-width: 300px;

    }

    .overlay {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100%;
        width: 100%;
        opacity: 0;
        transition: .7s ease;
        background-color: #000;
    }

    .img-container:hover .overlay {
        opacity: 0.5;
    }

    .text {
        color: white;
        font-size: 20px;
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        text-align: center;
    }


</style>
<style>
    .bottom-menu{
        position: absolute;
        right: 0;
        bottom: 0;
        padding: 10px 0;
        display: flex;
    }
    .bottom-menu .menu-item{
        margin: 0 3px;
    }
    .btn-enter{
        background-color: var(--text-main);
        border-radius: 3px;
        padding:5px 10px;
        text-transform: uppercase;
        font-family: var(--Lexend);
        cursor: pointer;
        color: #000;
    }
    .btn-edit{
        background-color: var(--text-yellow);
        border-radius: 3px;
        padding:5px 10px;
        text-transform: uppercase;
        font-family: var(--Lexend);
        cursor: pointer;
        color: #000;
    }
    .btn-delete{
        background-color: var(--text-red);
        border-radius: 3px;
        padding:5px 10px;
        text-transform: uppercase;
        font-family: var(--Lexend);
        cursor: pointer;
        color: #000;
    }
</style>
