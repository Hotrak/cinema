<template>
    <div v-if="dialog">
        <div  class="dialog">
            <div class="dialog-title">
                {{title}}
            </div>
            <div class="dialog-text">
                {{message}}
            </div>
            <div class="dialog-actions">
                <template v-if="type==='error'">
                    <div class="bottom-menu">
                        <div class="menu-item">
                            <a class="btn-enter" @click="close">ОК</a>
                        </div>
                    </div>
                </template>
                <template v-else-if="type==='info'">
                    <div class="bottom-menu">
                        <div class="menu-item">
                            <a class="btn-enter" @click="close">Нет</a>
                        </div>
                    </div>
                    <div class="bottom-menu">
                        <div class="menu-item">
                            <a class="btn-enter" @click="success">Да</a>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        <div class="shadow"></div>
    </div>

</template>
<script>
    export default {
        props:['dialog','title','message','type'],
        methods:{
            close(){
                this.$emit('close');
            },
            success(){
                this.$emit('success');
            }

        }
    }
</script>
<style scoped>
    .dialog{
        width: 700px;
        height: 150px;
        position: fixed;
        margin: auto;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        z-index: 50;
        background-color: var(--bg);
        border-radius: 5px;
        padding: 10px;
    }

    .dialog-title{
        /*height: 100px;*/
        font-size: 25px;
    }

    .dialog-text{
        margin: 10px 0;
        font-size: 18px;
    }
</style>
