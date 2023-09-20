<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { computed, onBeforeMount, onMounted, ref } from "vue";
import { CssClassModifier } from "../../Utils/CssClassModifier.js";
import Navbar from '../../Components/TravelGuide/Navbar.vue';

const form = useForm({
    city: ''
});

const headerTheme = ref({
        id: 10,
        country: 'france',
        city: 'paris',
        price: 100,
        image: ['bg-paris'],
        indicator: 'city of romance'
});

const popupWindow = ref({
    url: "",
    name: "",
    positionAndSize: ""
});

const getHeaderTheme = computed(() => { return headerTheme.value });
const setHeaderTheme = computed({
    set(val) {
        headerTheme.value = val;
    }
});

const destinations = [
    {
        id: 1,
        country: 'greece',
        city: 'Athens',
        price: 150,
        image: ['bg-athens'],
        indicator: 'cradle of democracy'
    },
    {
        id: 2,
        country: 'spain',
        city: 'Barcelona',
        price: 160,
        image: ['bg-barcelona'],
        indicator: 'capital of Catalonia'
    },
    {
        id: 3,
        country: 'egypt',
        city: 'Cairo',
        price: 935,
        image: ['bg-cairo'],
        indicator: 'land of pyramids'
    },
    {
        id: 4,
        country: 'turkey',
        city: 'Istanbul',
        price: 180,
        image: ['bg-istanbul', 'bg-left'],
        indicator: 'jewel of sultans'
    },
    {
        id: 5,
        country: 'portugal',
        city: 'Lisbon',
        price: 160,
        image: ['bg-lisbon', 'bg-left'],
        indicator: 'the sunny capital'
    },
    {
        id: 6,
        country: 'united kingdom',
        city: 'London',
        price: 159,
        image: ['bg-london'],
        indicator: 'capital of britain'
    },
    {
        id: 7,
        country: 'canada',
        city: 'Montreal',
        price: 535,
        image: ['bg-montreal'],
        indicator: 'gem of Quebec'
    },
    {
        id: 8,
        country: 'germany',
        city: 'Munich',
        price: 170,
        image: ['bg-munich'],
        indicator: 'Bavarian capital'
    },
    {
        id: 9,
        country: 'united states of america',
        city: 'New-York',
        price: 497,
        image: ['bg-new_york', 'bg-right'],
        indicator: 'city of empire state'
    },
    {
        id: 10,
        country: 'france',
        city: 'Paris',
        price: 100,
        image: ['bg-paris'],
        indicator: 'city of romance'
    },
    {
        id: 11,
        country: 'italy',
        city: 'Rome',
        price: 160,
        image: ['bg-rome'],
        indicator: 'home of emperors'
    },
    {
        id: 12,
        country: 'switzerland',
        city: 'Zurich',
        price: 165,
        image: ['bg-zurich'],
        indicator: 'jewel box of Alps'
    }
];
let headerBaseCssClasses = `content_ bg-top bg-cover bg-no-repeat w-full h-auto mx-auto`;
let cardBaseCssClasses = `card bg-cover bg-center`;
const cssClassModifier = new CssClassModifier();

onBeforeMount( () => {
    setHeaderTheme.value = setRandomHeaderImage();
})

onMounted(() => {
    const socialIcons = document.querySelectorAll('.social-icon');

    socialIcons.forEach(item => {
        item.addEventListener("click", () => {
            if(item.id === 'facebook') {
                setPopup("https://facebook.com/","Facebook");
                openPopup();
            }
            if(item.id === 'twitter') {
                setPopup("https://twitter.com/","Twitter");
                openPopup();
            }
        });
    });
});

const setPopup = (url, name, settings = "left=500,top=300,width=500,height=320") => {
    popupWindow.url = url;
    popupWindow.name = name;
    popupWindow.positionAndSize = settings;
}

const openPopup = () => {
    window.open(
        popupWindow.url,
        popupWindow.name,
        popupWindow.positionAndSize
    );
}

const goDown = () => {
    let speed = 0.1;
    let interval = speed * 2;
    let id = setInterval(function() {
        window.scrollBy(0, 1);
        if (window.scrollY === window. innerHeight) {
            clearInterval(id);
        }
    }, interval);
}

const setRandomHeaderImage = () => {
    let index = Math.floor(Math.random() * destinations.length);
    return destinations[index];
}

const goDestination = (cityName) => {
    form.city = cityName;
    form.get(route('show-city'));
}

const width = 82 + '%';
</script>

<template>

    <Head>
        <title>Travel Guide</title>
    </Head>

    <div>
        <div class=" h-screen w-full md:w-4/5.2 mx-auto">

            <Navbar class="navbar_" :width="width" />

            <div id="content" :class="cssClassModifier.classAttributeExpander(headerBaseCssClasses, getHeaderTheme.image)">
                <div class="bg-travel-guide-skin w-full h-screen">
                    <div class="head-content">
                        <h2 class="travel-guide-title text-xl md:text-4xl">Explore the world with us</h2>
                        <div class="bottom-line">
                            <a @click="goDestination(getHeaderTheme.city)"
                               class="w-1/15 text-whitesmoke hover:text-info text-xs sm:text-base cursor-pointer"
                            >
                                <strong class="uppercase">{{ getHeaderTheme.city }}</strong>,
                                {{ getHeaderTheme.indicator }}
                            </a>
                            <div class="pointer" @click="goDown">
                                <i class="material-icons">change_history</i>
                            </div>
                            <div class="share">
                                <div id="share" class="social text-xs sm:text-base">
                                    <h6 id="share_">Share</h6>
                                    <font-awesome-icon
                                        id="facebook"
                                        class="social-icon"
                                        :icon="['fab', 'facebook-f']"
                                    />
                                    <font-awesome-icon
                                        id="twitter"
                                        class="social-icon"
                                        :icon="['fab', 'twitter']"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="main-title my-20 pt-20">Discover all over the world with us</h3>

            <div class="main">
                <div v-for="destination in destinations"
                     class="card"
                     :key="destination.id"
                     :id="destination.id"
                     :class="cssClassModifier.classAttributeExpander(cardBaseCssClasses, destination.image)"
                     @click="goDestination(destination.city)"
                >
                    <div class="skin-cover">
                        <h6>{{ destination.country }}</h6>
                        <h5>{{ destination.city.replace('-', ' ') }}</h5>
                    </div>
                </div>
            </div>
            <footer>
                <a class="footer-menu" href="/home"
                >Lorem Airlines</a>
            </footer>
        </div>
    </div>
</template>

<style scoped>
.head-content {
    height: 100vh;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    color: whitesmoke;
    text-shadow: 0 2px black;
}

.travel-guide-title {
    padding-top: 300px;
}

.bottom-line {
    width: 100%;
    padding: 0 60px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

@media(max-width: 900px){
    .bottom-line {
        padding: 0 10px 20px;
    }
}

.share {
    width: 45%;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: flex-end;
}

.social {
    width: 120px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.social-icon {
    font-size: 1.5rem;
    cursor: pointer;
}

.social-icon:hover {
    color: rgb(43, 123, 223);
}

.social-icon:active {
    font-size: 1.4rem;
}

.material-icons {
    font-size: 4rem;
    transform: rotateX(180deg);
}

.pointer {
    animation-name: move;
    animation-duration: 1s;
    animation-iteration-count: infinite;
    animation-direction: alternate;
    cursor: pointer;
}

@keyframes move {
    from {
        transform: translateY(1rem);
    }
    to {
        transform: translateY(0rem);
    }
}

.pointer i {
    color: whitesmoke;
}

.main {
    height: auto;
    width: 100%;
    background: whitesmoke;
    display: grid;
    grid-template-columns: repeat(6, 2fr);
    grid-gap: 20px;
}

@media(max-width: 1350px) {
    .main {
        grid-template-columns: repeat(4, 3fr);
    }

    .card {
        width: 90% !important;
        position: relative;
        left: 5%;
    }
}

@media(max-width: 1090px) {
    .main {
        grid-template-columns: repeat(3, 4fr);
    }
}

@media(max-width: 840px) {
    .main {
        grid-template-columns: repeat(2, 6fr);
    }
}

@media(max-width: 460px) {
    .main {
        grid-template-columns: repeat(1, 12fr);
    }
}

h3 {
    color: rgb(5, 55, 115);
    text-shadow: 2px 2px 5px silver;
    text-align: center;
}

footer {
    width: 100%;
    height: 60px;
    background: rgb(5, 55, 115);
    margin-top: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    bottom: -163px;
}

.footer-menu {
    color: whitesmoke;
    padding: 0 10px;
}

.footer-menu:hover {
    text-decoration: underline;
}

.footer-menu:focus {
    border: none !important;
    box-shadow: none !important;
}

.card {
    height: 200px;
    width: 200px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-end;
    border-radius: 0.5rem;
    overflow: hidden;
    cursor: pointer;
}

.card:hover {
    box-shadow: 5px 5px 10px rgb(5, 55, 115);
}

.card:hover .skin-cover {
    transform: translateY(0rem);
}

.skin-cover h5 {
    margin-top: 0;
    font-weight: 600;
    font-size: 1.2rem;
    padding-bottom: 40px;
    text-transform: uppercase;
}

.skin-cover h6 {
    text-transform: capitalize;
    margin: 0;
}
</style>
