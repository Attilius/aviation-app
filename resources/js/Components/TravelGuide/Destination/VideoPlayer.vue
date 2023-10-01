<script setup>

const props = defineProps({
    destination: Object,
    isPlay: Boolean
});

const emits = defineEmits(['onChangeIsPlayStatus']);

const closePlayer = () =>{
onChangeIsPlayStatus();
}

const onChangeIsPlayStatus = () => {
    emits('onChangeIsPlayStatus', false);
}

</script>

<template>
    <div>
        <div v-if="isPlay"
             id="video-player"
             class="w-full h-screen bg-whitesmoke fixed top-0 left-0 flex items-center justify-center
                    overflow-hidden z-10">
            <video id="video_"
                   :src="destination.video"
                   autoplay
                   playsinline>
            </video>
            <i id="close_btn"
               class="material-icons"
               @click="closePlayer"
            >
                clear
            </i>
        </div>
        <div id="video-player" class="hidden" v-else></div>
    </div>
</template>

<style scoped>
#video_ {
    height: 70%;
    width: 60%;
}

#close_btn {
    color: rgb(9, 55, 115);
    font-size: 3rem;
    font-weight: 700;
    cursor: pointer;
    position: absolute;
    top: 100px;
    right: 100px;
    transition: all 0.7s ease 0s;
}

#close_btn:hover {
    background: rgb(9, 55, 115);
    border-radius: 50px;
    color: whitesmoke;
    transition: all 0.8s ease 0s;
}
</style>
