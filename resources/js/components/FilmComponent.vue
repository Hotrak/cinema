<template>
    <div class="film-block">
        <h2>{{film.name}}</h2>
        <div class="film-content">
            <img :src="'/storage/'+film.img" alt="">
            <div class="film-description">
                <table class="table-container">
                    <tr>
                        <td class="film-prop-title">Год</td>
                        <td><span>{{film.year}} г.</span></td>
                    </tr>
                    <tr>
                        <td class="film-prop-title">Жанр</td>
                        <td ><span>{{getTypes}}</span></td>
                    </tr>
                    <tr>
                        <td class="film-prop-title">Длительность</td>
                        <td><span>{{film.time}} мин.</span></td>
                    </tr>
                </table>
<!--                text-indent: 1em-->
                <div><h2 style="font-size: 25px">Про что фильм «{{film.name}}»</h2> <p align="justify" style="; font-family: var(--Lexend); font-size: 18px">{{film.description}}</p></div>
            </div>
        </div>
        <div class="bottom-menu" v-if="isAdmin">
            <div class="menu-item" @click="deleteFilm">
                <a class="btn-delete">Удалить</a>
            </div>
            <div class="menu-item" @click="isEditFilmShow = true">
                <a class="btn-edit">Изменить</a>
            </div>
        </div>
        <film-edit-component v-if="isEditFilmShow" :editItem="film" @close-panel="isEditFilmShow = false"></film-edit-component>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    export default {
        props:['film',],
        computed:{
            ...mapGetters(['isAdmin']),
            getTypes(){
                let types = '';
                for(let i = 0;i< this.film.types.length;i++){
                    types+=this.film.types[i].name;
                    if(this.film.types.length!== i+1 )
                        types+=', ';
                }

                return types;
            }
        },
        methods:{
            deleteFilm(){
                this.$emit('delete',this.film);
                axios.delete('/films/'+this.film.id).then(response=>{
                    document.location.replace('/');
                });
            }
        },
        data(){
            return{
                isEditFilmShow:false,
            }
        }
    }
</script>
<style>
    .film-block{
        background-color: var(--bg-panel);
        padding:0 10px;
        position: relative;
    }
    .film-block h2{
        padding-top: 10px;
        font-size: 30px;
    }
    .film-content{
        display: flex;
    }
    .film-content img{
        height: 350px;
    }
    .film-description{
        margin-left: 10px;
    }
    .film-description{
    }
    .table-container{
        overflow: hidden;
        display: table;
        padding-bottom: 10px;
    }
    .table-container td{
        font-size: 20px;
    }
    .film-prop-title{
        padding-right: 10px;
        padding-bottom: 10px;
    }

</style>
