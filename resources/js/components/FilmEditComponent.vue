<template>
    <div>
        <div class="film-edit-panel">
            <form class="update-film-form" v-on:submit.prevent="onSubmit" enctype="multipart/form-data">
                <div>
                    <div style="display:flex; justify-content: center">
                        <img id="film_img2" style="cursor:pointer; margin-bottom: 10px;" class="b-img" @click="pickerDialog2" :src="imgUrlB" alt="">
                    </div>

                    <div style="display:flex; justify-content: center; ">
                        <div class="inputs-block">
                            <div class="input-wrap">
                                <label for="title"><span>Название</span></label>
                                <input v-model="editItem.name" id="title" type="text" name="title">
                            </div>
                            <div class="input-wrap">
                                <label for="year"><span>Год</span></label>
                                <input v-model="editItem.year" id="year" type="text" name="year">
                            </div>
                            <div class="input-wrap">
                                <label for="time"><span>Длительность</span></label>
                                <input v-model="editItem.time" id='time' type="text" name="time">
                            </div>
                            <div class="input-wrap">
                                <label for="video_url"><span>Ссылка на трейлер</span></label>
                                <input v-model="editItem.video_url" id="video_url" type="text" name="video_url" >
                            </div>
                            <div class="input-wrap">
                                <label for="disc"><span>Описание</span></label>
                                <textarea  v-model="editItem.description" style="width: 310px" id="disc" rows="4" cols="50" name="disc" ></textarea>
                            </div>

                            <div class="input-submit-wrap">
                                <input type="submit" :value="isUpdate? 'Изменить':'Добавить'">
                                <div class ='btn-enter' style="display:flex;align-items: center;justify-content: center">
                                    <SPAN  v-on:click="showTypesPanel" >Жанр</SPAN>
                                </div>
                            </div>

                        </div>
                        <div class="image-block" style="cursor:pointer; max-width: 220px">
                            <img id="film_img" style="cursor:pointer;" class="s-img"  @click="pickerDialog" :src="imgUrlL" alt="">
                            <input ref="fileInput" v-on:change="updateImg" id="files" type="file" style="visibility:hidden;" name="image" >
                            <input ref="fileInput2" v-on:change="updateImg2"  type="file" style="visibility:hidden;" name="image_b" >

                        </div>
                    </div>
                </div>
            </form>
        </div>
        <img v-on:click="closePanel" class="btn-close" src="/img/close.png" alt="">
        <div class="shadow"></div>
        <div class="types-panel" v-if="isTypesPanelShow">
            <img v-on:click="closeTypesPanel" class="btn-close-panel" src="/img/close.png" alt="">
            <div class="type-list">
                <div class="type-list-item" v-for="(item,index) in types">
                    <label :for="item.id" ><span>{{item.name}}</span></label>
                    <input :id="item.id" :value="item.id" type="checkbox" v-model="checkedTypes" v-on:change="checkboxChange">
                </div>

            </div>
        </div>
        <div v-if="isTypesPanelShow" style="z-index:26" class="shadow"></div>
    </div>
</template>

<script>
    export default {
        props:['editItem'],
        data(){
            return {
                isTypesPanelShow:false,
                name:'',
                time:'',
                description:'',
                year:'',
                videoUrl:'',
                types:'',
                img:'',
                img2:'',
                imgUrl:'',
                imgUrl2:'',
                types:'',
                checkedTypes:[],
                isNewImgB:false,
                isNewImgL:false,
            }
        },
        mounted() {
            axios.get('/types').then(response=>{
                this.types = response.data;
            });
            // this.checkedTypes = [1, 2, 3];

            if(this.isUpdate){
                axios.get('/films/'+this.editItem.id+'/types').then(response=>{
                    this.checkedTypes = response.data.map((item)=>{
                        return item.id;
                    });
                }).catch(error=>{
                    console.log(error);
                });
            }
        },
        computed:{
            isUpdate(){
                if(this.editItem.id)
                    return true;
                return  false;
            },
            imgUrlB:{
                get(){
                    if(this.isUpdate){
                        if(this.isNewImgB)
                            return this.imgUrl2;
                        else
                            return '/storage/'+this.editItem.img_b;

                    }
                    else{
                        if(this.imgUrl2 === '')
                            return 'https://748073e22e8db794416a-cc51ef6b37841580002827d4d94d19b6.ssl.cf3.rackcdn.com/not-found.png';
                        return this.imgUrl2;
                    }
                },
                set(e){
                    this.item.img = e;
                }
            },
            imgUrlL:{
                get(){
                    if(this.isUpdate){
                        if(this.isNewImgL)
                            return this.imgUrl;
                        else
                            return '/storage/'+this.editItem.img;

                    }
                    else{
                        if(this.imgUrl === '')
                            return 'https://748073e22e8db794416a-cc51ef6b37841580002827d4d94d19b6.ssl.cf3.rackcdn.com/not-found.png';

                        return this.imgUrl;
                    }
                },
                set(e){
                    this.item.img = e;
                }
            }
        },
        methods:{
            checkboxChange(){
               console.log(this.checkedTypes);
            },
            closePanel(){
                this.$emit('close-panel');
            },
            closeTypesPanel(){
                this.isTypesPanelShow = false;
            },
            showTypesPanel(){
                this.isTypesPanelShow = true;
            },
            onSubmit(){
                let formData = new FormData();

                formData.append('name', this.editItem.name);
                formData.append('time', this.editItem.time);
                formData.append('videoUrl', this.editItem.video_url);
                formData.append('year', this.editItem.year);
                formData.append('types', JSON.stringify(this.checkedTypes));
                formData.append('img', this.img);
                formData.append('img_b', this.img2);

                if(this.isUpdate){
                    formData.append('is_new_img', this.isNewImgL);
                    formData.append('is_new_img_b', this.isNewImgB);
                }

                formData.append('description', this.editItem.description);

                if(this.isUpdate)
                    this.update(formData);
                else
                    this.store(formData)

            },
            store(formData){
                axios.post('/films',formData,  {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response=> {
                    location.reload();
                    console.log("MESSAGE_FROM_SERVE:"+response.data);
                }).catch(error=> {
                    console.log("ERRORS_FROM_SERVER:"+error)
                })
            },
            update(formData){

                axios({
                    method: 'post',
                    url: '/films/'+this.editItem.id+'?_method=put',
                    data: formData,
                    headers: {'Content-Type': 'multipart/form-data' }
                }).then(response=>{
                    location.reload();
                    console.log(response);
                }).catch(error=>{
                    console.log(error);
                });

            },
            updateImg(e){
                if (e.target.files && e.target.files[0]) {
                    this.imgUrl = URL.createObjectURL(e.target.files[0]);
                    this.img = e.target.files[0];
                    this.isNewImgL = true;
                    console.log("UPLOAD_IMG_URL:"+this.imgUrl);

                }
                console.log("UPLOAD_IMG");
            },
            updateImg2(e){
                if (e.target.files && e.target.files[0]) {
                    this.imgUrl2 = URL.createObjectURL(e.target.files[0]);
                    this.img2 = e.target.files[0];
                    this.isNewImgB = true;

                }
            },
            pickerDialog(){
                this.$refs.fileInput.click();
            },
            pickerDialog2(){
                this.$refs.fileInput2.click();
            }
        }
    }
</script>


<style scoped>

    .film-edit-panel{
        width: 650px;
        height: 720px;

        position: fixed;
        margin: auto;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        z-index: 25;

        display: flex;
        flex-direction: column;


    }


    .update-film-form{
        display: flex;
        justify-content: center;
        background-color: var(--bg-panel);
        border-radius: 5px;
        padding: 10px;


    }
    .input-wrap{
        width: 400px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }
    .input-wrap span{
        width: 110px;

    }
    .input-submit-wrap{
        margin-top: 10px;
        display: flex;
        justify-content: flex-end;
    }
    .update-film-form input{
        width: 300px;
        padding: 10px;
        box-shadow: inset 0 1px 5px rgba(0,0,0,0.2);
        border: 1px solid #ccc;
        padding-left: 5px;
        font-size: 20px;
        border-radius: 5px;
    }
    .update-film-form input[type = 'submit']{
        width: 100px;
    }
    .update-film-form label {
        width: 120px;
        text-align: left;
        float: left;
        margin-right: 10px;
        line-height: 15px;

    }

    .add-film-form .s-img{
        height: auto;
        width: 200px;
    }
    .update-film-form .b-img{
        height: auto;
        max-width: 500px;
    }
    .update-film-form .s-img{
        height: auto;
        width: 220px;
    }
    a{
        text-decoration: none;
        color: #8a9bd6;
    }
    .image-block{
        margin-left: 20px;
    }
    .inputs-block{
        display: flex;
        flex-direction: column;
    }
    .choice-img-btn{
        background-color: #4DC3FA;
        padding: 10px;
        color: white;
        width: 400px;
        text-align: center;
    }
</style>

<style>
    .types-panel{
        width: 700px;
        height: 400px;
        position: fixed;
        margin: auto;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        z-index: 30;
        background-color: var(--bg);
        border-radius: 5px;


    }
    .type-list{
        padding: 10px;
        display: flex;
        flex-wrap: wrap;
    }
    .type-list .type-list-item{
        width: 200px;
        background-color: var(--bg-panel);
        height: 30px;
        margin-bottom: 5px;
        margin-right: 5px;
        display: flex;
        align-items: center;
        justify-content:space-between;
        padding:5px;
        border-radius: 5px;
    }
    .btn-close-panel{
        position: absolute;
        right: 0;
        top: 0;
        margin: 10px;
        width: 20px;
        height: 20px;
        cursor: pointer;
    }
</style>
