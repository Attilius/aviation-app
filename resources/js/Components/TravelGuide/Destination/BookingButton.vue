<script setup>
const props = defineProps({
    city: Object
});
</script>

<template>
    <div class="box">
        <button class="btn rounded-full capitalize">
            <i id="rotate-90deg" class="material-icons">flight</i>
            {{ city.name.replace('-', ' ') }}
            <i id="rotate-90deg" class="material-icons">expand_less</i>
        </button>
    </div>
</template>

<style scoped>
.box {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn {
    background: rebeccapurple;
    height: 50px;
    width: 170px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 50px;
    padding: 20px;
}

.btn:hover {
    color: whitesmoke;
}

.btn i {
    color: whitesmoke;
}

#rotate-90deg {
    transform: rotate(90deg);
}
</style>
