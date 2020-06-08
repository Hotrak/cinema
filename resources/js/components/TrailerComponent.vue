<template>
    <div class="film-trailer-block">
        <div class="player-wrap">
            <iframe width="100%" height="100%" :src="url" frameborder="0"
                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
        </div>
    </div>
</template>
<script>
    export default {
        props:['url'],
        mounted() {
            console.log("VIDEO_URL:"+this.url);
        }
    }
</script>
<style scoped>
    .film-trailer-block{
        background-color: var(--bg-panel);
        margin-top: 10px;
        padding: 10px;
        /*padding-bottom: 10px;*/
    }
    .player-wrap{
        height: 400px;
    }

</style>
