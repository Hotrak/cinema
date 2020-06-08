<template>
    <div class="errors-block">
        <div class="errors">
            <div v-for="item in validationErrors" class="errors-item">
                <span>{{item}}</span>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props:['errors'],
        computed: {
            validationErrors(){
                let errors = Object.values(this.errors);
                errors = errors.flat();
                return errors;
            }
        },


    }
</script>
<style scoped>
    .errors-block{
        position: fixed;
        z-index: 5;
        top: 0;
        margin: 0 auto;
        width: 100%;

    }
    .errors-block .errors{
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .errors-block .errors-item{
        margin-bottom: 5px;
        width: 100%;
        border-radius: 5px;
        height: 40px;
        background-color: var(--text-red);
        display: flex;
        align-items: center;
        justify-content: center;

    }
</style>
