<template>
    <div>
        <header id="headerMain">
            <nav class="nav">
                <div class="nav-menu flex-row">
                    <div class="nav-brand">
                        <a href="/" style="margin-left: 10px;font-weight: bold">КИНОТЕАТР</a>
                    </div>
                    <div>
                        <ul class="nav-items">
                            <li class="nav-link">
                                <a href="/">АФИША</a>
                            </li>
                            <li class="nav-link" v-if="getUser!==null">
                                <a href="/reservation" >БРОНИРОВАНИЕ</a>
                            </li>
                            <li class="nav-link">
                                <a href="#">КОТАКТЫ</a>
                            </li>
                            <li class="nav-link">
<!--                                <a v-if="getUser !== null" v-on:click="showAuth" href="#">Вход</a>-->
<!--                                <a  v-else v-on:click="logoutUser" href="#">Выход</a>-->
                                    <a v-if="getUser!==null" v-on:click="logoutUser" >ВЫХОД</a>
                                    <a v-else  v-on:click="showAuth" >ВХОД</a>

                            </li>
                        </ul>
                    </div>

                </div>
            </nav>
        </header>
        <auth-component v-if="isAuthShow" @close-auth="closeAuth"></auth-component>
    </div>
</template>


<script>
    import {mapGetters,mapActions} from 'vuex'
    export default {
        props:['user'],
        data(){
            return{
                isAuthShow:false,
            }
        },
        computed:mapGetters(['getUser']),
        mounted() {
            // console.log('USER:'+JSON.stringify(this.user));
            // if(this.user === null)
            //     this.$store.dispatch('login',{});
            // else
            this.$store.dispatch('login',this.user);
        },
        methods:{
            ...mapActions(['logout']),
            showAuth(){
                this.isAuthShow = true;
            },
            closeAuth(){
                this.isAuthShow = false;
            },
            logoutUser(){
                axios.post('/logout').then(response => {
                    this.logout();
                    console.log("FROM SERVER:"+response.data);
                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });
            }


        }
    }
</script>

<style>
    #headerMain {
        width:100%;
        height: 195px;
        margin:0px auto;
        z-index:0;
    }
    .nav{
        background-color: #30384d;

        /*padding: 0 2rem;*/
        height: 70px;
        overflow: hidden;
        transition: height 1s ease-in-out;
        position: fixed;
        top: 0;
        z-index: 20;
        width:100%;
        -moz-box-shadow:0 5px 5px rgba(0, 0, 0, 0.75);
        -webkit-box-shadow: 0 5px 5px rgba(0, 0, 0, 0.75);
        box-shadow: 0 5px 5px rgba(0, 0, 0, 0.75);
    }
    .nav-brand{
        color: var(--text-main);
    }

    .nav-brand:hover{
        color: var(--text-yellow);
    }
    .nav .nav-menu{
        justify-content: space-between;
        height: 50px;
    }

    .nav .nav-items{
        display: flex;
        margin: 0;
        color: #8eacd0;
    }

    .nav .nav-items .nav-link{
        padding: 1.6rem 1.5rem;
        position: relative;
        font-size: 1.2rem;
        /*border-right: 1px solid #8eacd0;*/
    }
    /*.nav .nav-items .nav-link:first-child{*/
    /*    border-left: 1px solid #8eacd0;*/
    /*}*/


    .nav .nav-items .nav-link:hover{
        background-color: var(--text-yellow);
        color: #000000;
        cursor: pointer;
    }

    .nav .nav-items .nav-link:hover a{
        color: var(--white);
    }

    .nav .nav-brand a{
        font-size: 1.6rem;
        padding: 1rem 0;
        display: block;
        font-family: var(--Lexend);
        font-size: 1.6rem;
    }


</style>
