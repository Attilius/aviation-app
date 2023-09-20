<script setup>
import { onMounted, ref } from "vue";
import SideMenu from './SideMenu.vue';

const props = defineProps({
    width: String
});

let windowTop = ref(0);

onMounted(() => {
    window.addEventListener("scroll", onScroll);
    document.getElementById('navbar').style.width = props.width;
});

const onScroll = (e) => {
    windowTop.value = e.target.documentElement.scrollTop;
    navbar.style.backgroundColor = (windowTop.value > 0) ? 'rgb(9,55,115)' : 'transparent';
}

const openMenu = () => {
    document.getElementById("menu").style.left = "0px";
};
</script>

<template>
    <div>
        <div id="navbar" class="navbar">
            <div class="left_">
                <font-awesome-icon id="icon-menu" class="icon" :icon="['fas', 'bars']" @click="openMenu" />

                <!-- Side bar menu -->
                <SideMenu />
            </div>

            <div class="w-full sm:w-1/2 text-sm sm:text-base flex justify-center items-center text-whitesmoke">
                <img class="logo"
                     src="/img/logos/lorem-logo.png"
                     alt="logo"
                >
                <p>Travel Guide</p>
            </div>

            <div class="right_"></div>
        </div>
    </div>
</template>

<style scoped>
*,
*::after,
*::before {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    font-family: Poppins, sans-serif;
}

.navbar {
    background: transparent;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 60px;
    height: 8vh;
    z-index: 1;
    transition: all .6s;
    position: fixed;
    top: 0;
}

@media(max-width: 600px){
    .navbar {
        padding: 0 40px;
    }
}

@media(max-width: 767px){
    .navbar {
        width: 100% !important;
    }
}

.logo {
    height: 50px;
    width: 61px;
}

.left_ {
    width: 33%;
    display: flex;
    justify-content: flex-start;
    align-items: center;
}

.right_ {
    width: 33%;
    display: flex;
    align-items: center;
    justify-content: flex-end;
}

.icon {
    color: whitesmoke;
    font-size: 1.2rem;
    background: transparent;
    border: none;
    cursor: pointer;
}

.icon:hover {
    color: lightskyblue;
}
</style>
