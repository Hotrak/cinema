<template>
    <div>
        <div v-if="isAdmin" class="admin-buttons">
            <a class = "btn-enter" v-on:click="showFilmAddPanel">Добавить фильм</a>
        </div>
        <div class="list">
            <list-item-component v-for="item in films" :key="item.id" :item = item @delete="deleteItem" ></list-item-component>
        </div>
        <film-edit-component :editItem="editItem" v-if="isAddFilmShow" @close-panel="closeFilmAddPanel"></film-edit-component>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    export default {
        props:[
            'films'
        ],
        computed:mapGetters(['isAdmin']),
        created() {

        },
        data(){
            return{
                isAddFilmShow:false,
                editItem:{},
            }
        },
        methods:{
            showFilmAddPanel(){
                this.isAddFilmShow = true;
            },
            closeFilmAddPanel(){
                this.isAddFilmShow = false;
            },
            deleteItem(item){

            }
        },




    }
</script>

<style>
    .list{
        padding: 10px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }
    .admin-buttons{
        padding:20px 0;
    }
</style>
