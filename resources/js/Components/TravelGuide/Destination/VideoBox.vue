<script setup>

const props = defineProps({
    destination: Object
});

const emits = defineEmits(['changeIsPlayStatus']);

const play_Video = () => {
    changeIsPlayStatus();
}

const changeIsPlayStatus = () => {
    emits('changeIsPlayStatus', true);
}

</script>

<template>
    <div>
        <div id="video-box" class="video-box" @click="play_Video">
            <video id="video2" :poster="destination.poster"></video>
            <div id="skin2" class="skin2">
                <i id="play" class="material-icons">video_library</i>
            </div>
        </div>
    </div>
</template>

<style scoped>
video {
    object-fit: cover;
    width: 100%;
    height: 92vh;
    top: 0;
    left: 0;
}

.video-box {
    height: 300px;
    width: 50%;
    float: right;
    margin: 10px 0 10px 20px;
    cursor: pointer;
}

@media(max-width: 767px) {
    .video-box {
        width: 100%;
    }
}

#play {
    font-size: 3.5rem;
    color: whitesmoke;
}

.skin2 {
    height: 100%;
    width: 100%;
    background: rgba(5, 16, 57, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    top: -100%;
}

#video2 {
    width: 100%;
    height: 100%;
}
</style>
