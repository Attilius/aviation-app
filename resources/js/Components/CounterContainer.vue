<script setup>
import Vue3autocounter from 'vue3-autocounter';

const props = defineProps({
    icon: Array,
    title: String,
    target: Number
});

</script>

<template>
    <div class="counter-box">
        <font-awesome-icon class="icon" :icon="icon" />
        <div class="counter">
            <Vue3autocounter :startAmount='0' :endAmount='props.target' :duration='3' suffix='+' :autoinit='true' />
        </div>
        <h3>{{ title }}</h3>
    </div>
</template>

<style scoped>
.counter-box {
    width: 250px;
    max-height: 180px;
}
.counter {
    margin: 10px 20px;
    background: transparent !important;
}

.icon {
    font-size: 2.5rem;
    background-color: transparent;
    border: none;
    margin: 0 auto;
}

.counter {
    font-size: 2rem;
}

.counters .container h3 {
    color: whitesmoke;
    font-size: 1.2rem;
    padding: 0;
}
</style>

