<template>
    <div>
        <div class="user-comment-form" v-if="isAuth">
            <h2>Комментарий</h2>
            <form v-on:submit.prevent="onSubmit" >
                <p><textarea style="width: 95%" v-model="userComment" name="comment" id="" cols="30" rows="10" placeholder="Написать отзыв" required
                             minlength="100"></textarea></p>
                <input class="btn-enter" type="submit" value="Добавить">
            </form>
        </div>
        <div class="comments-block" v-if="comments">
            <div class="comments-list">
                <div class="comment-item" v-for="comment in comments">
                    <img class="comment-img" src="/img/robot.svg" alt="">
                    <div class="comment-content">
                        <h4 class="comment-user-name">{{comment.user.name}}</h4>
                        <p class='user-comment'>{{comment.body}}</p>
                    </div>
                    <img v-if="isAdmin" @click="deleteComment(comment)" height="20px" class="btn-delete-comment" src="/img/close.png" alt="">
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    export default {
        props:['film_id'],
        computed:mapGetters(['isAuth','isAdmin']),
        data(){
            return{
                comments:'',
                userComment:''
            }
        },
        mounted() {
            // console.log("FILM_ID:"+this.film_id);
            this.getComments()
        },
        methods:{
            getComments(){
                axios.get('/comments/'+this.film_id).then(response => {
                    this.comments = response.data;
                    console.log("COM:"+this.comments)
                })
            },
            onSubmit(){
                axios.post('/comments/',{
                    film_id:this.film_id,
                    comment:this.userComment,
                }).then(response=>{
                    this.comments.push(response.data);
                    this.userComment='';
                    // this.getComments();
                })
            },
            deleteComment(item){
                axios.delete('/comments/'+item.id);
                let index = this.comments.indexOf(item);

                this.comments.splice(index,1);
            }
        }
    }
</script>
<style>
    .user-comment-form textarea{
        width: 100%;
        font-size:17px;
        background-color: var(--bg-panel);
        color: #fff;
        padding:10px;
        border: none;
    }
    .user-comment-form input{
        border: none;

    }
    .comments-block{
    }
    .comments-list{

    }
    .comment-item{
        background-color: var(--bg-panel);
        margin-bottom: 5px;
        display: flex;
        position: relative;

    }
    .comment-img{
        height: 100px;
        width: 100px;
    }
    .btn-delete-comment{
        position: absolute;
        top: 0;
        right: 0;
        margin: 5px;
        cursor: pointer;

    }
</style>
