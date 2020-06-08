<template>
    <form @submit.prevent="onSubmit">
        <input hidden type="text" name = 'film_id' :value="film.id" >
        <div class="input-wrap">
            <label for='date'>Дата</label><input v-model="sesDate" type="date" min="2020-03-31" id='date' name = 'date'   required>
        </div>
        <div class="input-wrap">
            <label for='start'>Нчало</label><input v-model="sesStart" type="time" id='start' name = 'time_start' required>
        </div>
        <div class="input-wrap">
            <label for='end'>Конец</label><input v-model="sesEnd"  type="time" id='end' name = 'time_end' required>
        </div>
        <div class="input-wrap">
            <label for='price'>Стоимость</label><input v-model="sesPrice" type="number" id='price' name = 'price' required>
        </div>
        <div class="input-submit-wrap">
            <input type="submit" value="Добавить" >
        </div>
        <error-dialog
            :dialog="errorDialog"
            :title="'Зал занят'"
            :message="'В данное время в зале прохот другой сеанс.'"
            type="error"
            @close="errorDialog = false"
        ></error-dialog>
    </form>
</template>
<script>

    import ErrorDialog from "./ErrorDialog";
    export default {
        components: {ErrorDialog},
        props:['film'],
        data:()=>({
            sesDate:'',
            sesPrice:'',
            sesStart:'',
            sesEnd:'',
            error:'',
            errorDialog:false,
        }),
        methods:{
            onSubmit(){
                this.store();
            },
            store(){

                let data = {
                    film_id:this.film.id,
                    date:this.sesDate,
                    price:this.sesPrice,
                    time_start:this.sesStart,
                    time_end:this.sesEnd,
                };

                axios.post('/schedule/',data).then(response=>{
                    console.log(response);
                    location.reload();
                }).catch(error=>{
                    console.log(error);
                    console.log(error.response.message);
                    console.log(error.response.status);
                    console.log(error.response.data);
                    if(error.response.status === 422){
                        this.error = error.response.message;
                        this.errorDialog = true;
                        // console.log(error.message);
                    }
                });
            }
        },


    }
</script>
<style scoped>
    .input-wrap{
        width: 400px;
        margin-top: 10px;
        display: flex;
        align-items: center;
    }
    .input-wrap span{
        width: 110px;

    }
    .input-submit-wrap{
        margin-top: 10px;
        display: flex;
        /*align-items: end;*/
        /*justify-content: flex-end;*/

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
    input[type = 'submit']{
        width: 100px;
    }
    label {
        width: 100px;
        text-align: left;
        float: left;
        margin-right: 10px;
        line-height: 15px;

    }

    .add-film-form img{
        height: auto;
        width: 200px;
    }
    .update-film-form img{
        height: auto;
        width: 220px;
    }


</style>
