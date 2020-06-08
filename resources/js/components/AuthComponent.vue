<template>
    <div>
        <div v-if="isLogin" class="auth-panel">
            <h2>Вход</h2>
            <span>{{loginError}}</span>
            <form class="auth-form" action="" v-on:submit.prevent="onSubmitLogin">
                <div class="form-item">
                    <input v-model="email" type="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-item">
                    <input v-model="password" type="password" name="password" placeholder="Пароль" required>
                </div>
                <input class="btn-enter" type="submit" value="Войти"/>
            </form>
            <span v-on:click="showRegister">Регистрация</span>
        </div>
        <div v-else class="auth-panel" style="height: 550px">
            <h2>Регистрация</h2>
            <form class="auth-form" action="" v-on:submit.prevent="onSubmitRegister">
                <div class="form-item">
                    <input v-model="email" type="email" placeholder="Email" >
                </div>
                <div class="form-item">
                    <input v-model="phone" type="text" name="phone" placeholder="Телефон" >
                </div>
                <div class="form-item">
                    <input v-model="name" type="text" name="name" placeholder="Имя" >
                </div>
                <div class="form-item">
                    <input v-model="password" type="password" name="password" placeholder="Пароль"  minlength="6">
                </div>
                <div class="form-item">
                    <input v-model="password_c" type="password" name="password_confirmation" placeholder="Пароль" minlength="6">
                </div>
                <input class="btn-enter" type="submit" value="Зарегистрироваться"/>
            </form>
            <span v-on:click="showLogin">Войти</span>
        </div>
        <div class="shadow"></div>
        <img v-on:click="close" class="btn-close" src="/img/close.png" alt="">
        <errors-component :errors="errorsV" v-if="errorsV"></errors-component>
    </div>
</template>
<script>
    import {mapActions} from 'vuex'

    export default {
        data(){
            return{
                isLogin:true,
                email:'',
                phone:'',
                name:'',
                password:'',
                password_c:'',
                errorsV:'',
                loginError:''

            }
        },
        methods:{
            ...mapActions(['login']),
            close(){
                this.$emit('close-auth');
                console.log('AUTH_CLOSE');
            },
            showLogin(){
                this.isLogin = true;
            },
            showRegister(){
                this.isLogin = false;
            },
            onSubmitRegister(){
                axios.post('/register',{
                    email: this.email,
                    name: this.name,
                    phone: this.phone,
                    password: this.password,
                    password_confirmation: this.password_c,

                }).then(response => {
                    this.close();
                    this.login(response.data);
                    console.log("FROM SERVER:"+response.data);
                }).catch(error => {
                    console.log(error);
                    if(error.response.status == 422){
                        let errors = Object.values(error.response.data.errors);
                        errors = errors.flat();
                        console.log(errors);
                        this.errorsV = errors;
                    }

                });
            },
            onSubmitLogin(){
                axios.post('/login',{
                    email: this.email,
                    password: this.password,
                }).then(response => {
                    this.login(response.data);
                    this.close();
                    console.log("FROM SERVER:"+response.data);
                }).catch(error => {
                    // this.loginError = error.response.data;
                    this.errorsV = [error.response.data];
                    console.log(error.response.data);
                });


            }
        }
    }
</script>
<style>
    .auth-panel{
        width: 320px;
        height: 350px;
        display: flex;
        flex-direction: column;
        position: fixed;
        margin: auto;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        align-items: center;
        z-index: 50;
        background-color: var(--bg-panel);
        border-radius: 5px;
    }
    .auth-panel span{
        cursor: pointer;
    }

    .auth-panel h2{
        font-size: 40px;
    }
    .auth-form{
        display: flex;
        flex-direction: column;

    }
    .auth-form .form-item{
        margin-bottom: 10px;
    }


    .auth-form input{
        height: 50px;
        border-radius: 5px;
        width: 250px;
        padding-left: 4px;
        font-size:20px;
    }
    .auth-form input[type='submit']{
        border: none;
    }
</style>
