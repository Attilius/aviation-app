<script setup>
import { computed, onMounted, onUpdated, ref, watch } from "vue";
import { Head, useForm } from '@inertiajs/vue3';
import axios from "axios";
import Header from '../../Components/TravelGuide/Destination/Header.vue';
import Navbar from '../../Components/TravelGuide/Navbar.vue';
import VideoBox from '../../Components/TravelGuide/Destination/VideoBox.vue';
import DescriptionOfCity from '../../Components/TravelGuide/Destination/DescriptionOfCity.vue';
import VideoPlayer from '../../Components/TravelGuide/Destination/VideoPlayer.vue';

const props = defineProps({
    destination: Object,
    title: String,
    services: Object,
    favoritePlaces: Array
});

const widthOfNavbar = 100 + '%';
const isPlay = ref(false);
const isClickShadow = ref(false);
const showMore = ref(true);
const currentTime = ref(props.destination.currentTime);
const addresses_all = ref([]);
const addresses_less = ref([]);
const collection_of_favorites = ref([]);
const collection_of_removed_favorites = ref([]);
const addressesPageContent = ref({
    id: 'id',
    label: 'label',
    name: 'name',
    image: 'image',
    title: 'titile',
    description: 'description',
    address: 'address',
    tel: 'tel',
    web: 'web',
    email: 'email'
});
const fav = ref('');
const addFavoriteCollection = [];
const removeFavoriteCollection = [];

const setIsPlay = computed({
    set(val) {
        isPlay.value = val;
    }
});

const setIsClickShadow = computed({
    set(val) {
        isClickShadow.value = val;
    }
});

const setShowMore = computed({
    set(val) {
        showMore.value = val;
    }
});

const setCurrentTime = computed({
    set(val) {
        currentTime.value = val;
    }
});

const form = useForm({
    addressesPageContent: null,
    cityName: props.destination.city.name
});

onMounted(() => {
    const showMoreButton = document.getElementById("show-more");
    showMoreButton.addEventListener("click", () => {
        setShowMore.value = !showMore.value;
    });

    const items = document.querySelectorAll('.destination-menu-item');
    items.forEach((item) => {
        if(item.classList.contains('active')) {
            getDestinationServices(props.destination, item.textContent.toLowerCase());
        }
    });

    changeShadowClickState();
    showAddresses();
});

onUpdated(async () => {
    await getCurrentTime();
})

watch(showMore, (newValue) => {
    const showMoreButton = document.getElementById("show-more");
    showMoreButton.textContent = (newValue) ? 'Show more' : 'Show less';
});

const getCurrentTime = () => {
    axios.get(`/api/time/?area=${props.destination.area}&city=${props.destination.city.name}`)
        .then(function (response) {
            setCurrentTime.value = response.data.time;
        })
        .catch(function (error) {
            console.log(error);
        });
}

const changeShadowClickState = () => {
    document.getElementById("shadow").addEventListener("click", () => {
        setIsClickShadow.value = true;
    });
}

const showAddresses = () => {
    const serviceMenuItems = document.getElementsByClassName("destination-menu-item");

    for (let i = 0; i < serviceMenuItems.length; i++) {
        serviceMenuItems[i].addEventListener("click", () => {
            serviceMenuItems[i].classList.add("active");
            for (let sibling of serviceMenuItems[i].parentNode.children) {
                if (sibling !== serviceMenuItems[i]) {
                    sibling.classList.remove("active");
                } else {
                    const service = serviceMenuItems[i].textContent.toLowerCase();
                    getDestinationServices(props.destination, service);
                }
            }
        });
    }
}

const showAddressesContent = (id) => {
    if (showMore.value) {
        addresses_less.value.forEach(address => {
            setAddressesPageContent(id, address);
        });
    } else {
        addresses_all.value.forEach(address => {
            setAddressesPageContent(id, address);
        });
    }
}

const setAddressesPageContent = (id, address) => {
    if (address.id === id) {
        addressesPageContent.value.id = address.id;
        addressesPageContent.value.label = address.label;
        addressesPageContent.value.name = address.name;
        addressesPageContent.value.image = address.image;
        addressesPageContent.value.title = address.title;
        addressesPageContent.value.description = address.description;
        addressesPageContent.value.address = (address.address) ? address.address : null;
        addressesPageContent.value.tel = (address.tel) ? address.tel : null;
        addressesPageContent.value.web = (address.web) ? address.web : null;
        addressesPageContent.value.email = (address.email) ? address.email : null;

        const city = {
            slug: props.destination.city.name
        }
        const service = {
            slug: address.label
        }
        const place = {
            slug: address.name.replaceAll(' ', '_')
        }

        form.addressesPageContent = addressesPageContent.value;
        form.post(route('show-service', {
            city: city.slug,
            service: service.slug,
            place: place.slug
        }));
    }
}

const showHoverLabel = () => {
    const favorite_markers = document.querySelectorAll(
        ".favorite-marker"
    );
    const hover_label = document.getElementsByClassName("hover-label");

    favorite_markers.forEach((marker, index) => {
        marker.addEventListener("mouseover", () => {
            hover_label[index].style.display = "flex";
        });

        marker.addEventListener("mouseleave", () => {
            hover_label[index].style.display = "none";
        });
    });
}

const getDestinationServices = (data, service = 'see all') => {
    const minimumAmountPerServices = 4;
    const baseValueOfDisplayedServices = 12;

    switch (service) {
        case 'see all': {
            let array_length =
                data.attractions.length +
                data.hotels.length +
                data.restaurants.length;
            addresses_all.value = [];
            addresses_less.value = [];

            array_length <= baseValueOfDisplayedServices
                ? (document.getElementById("show-more").style.visibility = "hidden")
                : (document.getElementById("show-more").style.visibility = "visible");

            for (let i = 0; i < data.attractions.length; i++) {
                addresses_all.value.push(data.attractions[i]);
            }

            for (let l = 0; l < minimumAmountPerServices; l++) {
                addresses_less.value.push(data.attractions[l]);
            }

            for (let i = 0; i < data.hotels.length; i++) {
                addresses_all.value.push(data.hotels[i]);
            }

            for (let l = 0; l < minimumAmountPerServices; l++) {
                addresses_less.value.push(data.hotels[l]);
            }

            for (let i = 0; i < data.restaurants.length; i++) {
                addresses_all.value.push(data.restaurants[i]);
            }

            for (let l = 0; l < minimumAmountPerServices; l++) {
                addresses_less.value.push(data.restaurants[l]);
            }
            break;
        }
        case 'attractions': {
            serviceViewHandling(data.attractions, baseValueOfDisplayedServices);
            break;
        }
        case 'hotels': {
            serviceViewHandling(data.hotels, baseValueOfDisplayedServices);
            break;
        }
        case 'restaurants': {
            serviceViewHandling(data.restaurants, baseValueOfDisplayedServices);
            break;
        }
    }
}

const serviceViewHandling = (data, baseValueOfDisplayedServices) => {
    const array_length = data.length;
    const minArrayLength = (array_length > baseValueOfDisplayedServices)
        ? baseValueOfDisplayedServices
        : array_length;

    addresses_all.value = [];
    addresses_less.value = [];

    array_length <= baseValueOfDisplayedServices
        ? (document.getElementById("show-more").style.visibility = "hidden")
        : (document.getElementById("show-more").style.visibility = "visible");

    for (let i = 0; i < array_length; i++) {
        addresses_all.value.push(data[i]);
    }

    for (let l = 0; l < minArrayLength; l++) {
        addresses_less.value.push(data[l]);
    }
}

const markFavoriteAddress = (obj) => {
    const favorite = document.getElementById(obj.id);

    favorite.textContent = (favorite.textContent === 'favorite_border') ? 'favorite' : 'favorite_border';

    if (favorite.textContent === "favorite") {
        collection_of_favorites.value.push(obj.id + '-' + props.destination.city.name);
        collection_of_favorites.value = [...new Set(collection_of_favorites.value)];
        fav.value += obj.id;
        addFavoriteCollection.push(obj.id + '-' + props.destination.city.name);
    } else {
        const removeIndex = collection_of_favorites.value.indexOf(obj.id + '-' + props.destination.city.name);
        collection_of_favorites.value.splice(removeIndex, 1);
    }
}

const removeMarkFavoriteAddress = (obj) => {
    const favorite = document.getElementById(obj.id);

    favorite.textContent = (favorite.textContent === 'favorite_border') ? 'favorite' : 'favorite_border';
    collection_of_removed_favorites.value.push(obj.id);
    removeFavoriteCollection.push(obj.id);
}

const isFavoritePlace = (id) => {
    let result = false;

   props.favoritePlaces.forEach((favoritePlace) => {
       if(favoritePlace.service_id === id){
           result = true;
       }
   });

    return result;
}

const creationalForm = useForm({
    add_favorite_places: []
});

const removalForm = useForm({
    remove_favorite_places: []
});

const favoriteCollectionHandler = () => {
    if(props.addFavoritePlace.length){
        creationalForm.favorite_places = collection_of_favorites.value;
        creationalForm.post(route('add-favorite'));
    }
    if(props.removeFavoritePlace.length){
        removalForm.remove_favorite_places = collection_of_removed_favorites.value;
        removalForm.post(route('remove-favorite'));
    }
}

// Emit events

function updateIsPlayStatus(status){
    setIsPlay.value = status;
}
</script>

<template>

    <Head>
        <title>{{ title }}</title>
    </Head>

    <div>
        <div id="wrapper" class="wrapper">
            <div id="shadow"></div>

            <VideoPlayer
                :isPlay="isPlay"
                :destination="destination"
                @onChangeIsPlayStatus="updateIsPlayStatus"
            />

            <Navbar
                class="navbar_"
                :width="widthOfNavbar"
                :addFavoritePlace="addFavoriteCollection"
                :removeFavoritePlace="removeFavoriteCollection"
            />

            <Header
                :destination="destination"
                :currentTime="destination.currentTime"
            />

            <div class="content-top">

                <p class="w-9/12 mx-auto my-5 text-rebecca_purple font-bold italic">
                    <a class="text-info hover:text-custom_blue cursor-pointer"
                       @click="favoriteCollectionHandler"
                       :href="route('home')"
                    >Home</a> >
                    <a class="text-info hover:text-custom_blue cursor-pointer"
                       @click="favoriteCollectionHandler"
                       :href="route('travel-guide')"
                    >Travel Guide</a>
                </p>

                <h5 class="text-xl">{{ destination.city.name.replace('-', ' ') }}: {{ destination.adjective }}</h5>
                <div class="w-9/12 mx-auto">
                    <VideoBox
                        :isPlay="isPlay"
                        :destination="destination"
                        @changeIsPlayStatus="updateIsPlayStatus"
                    />
                    <DescriptionOfCity :destination="destination" />
                </div>
            </div>

            <div class="content-bottom">
                <h5 class="text-xl">{{ destination.city.name.replace('-', ' ') }} Addresses</h5>
                <div class="w-9/12 mx-auto">
                    <ul id="addresses-menu">
                        <li class="destination-menu-item active" data-item="all">See all</li>
                        <li class="destination-menu-item" data-item="attractions">Attractions</li>
                        <li class="destination-menu-item" data-item="hotels">Hotels</li>
                        <li class="destination-menu-item" data-item="restaurations">Restaurants</li>
                    </ul>

                    <div class="card-container pt-5" v-if="!showMore">
                        <div
                            class="card_"
                            v-for="address in addresses_all"
                            :key="address.id"
                        >
                            <img
                                class="addresses_img"
                                :src="address.image"
                                alt="image of place"
                                @click="showAddressesContent(address.id)"
                            />
                            <div class="marking-title">

                                <i  v-if="fav.includes(address.id) || isFavoritePlace(address.id)"
                                    :id="address.id"
                                    class="favorite-marker large material-icons favorite"
                                    @click="removeMarkFavoriteAddress(address)"
                                    @mouseover="showHoverLabel"
                                >favorite</i>

                                <i  v-else
                                    :id="address.id"
                                    class="favorite-marker large material-icons favorite"
                                    @click="markFavoriteAddress(address)"
                                    @mouseover="showHoverLabel"
                                >favorite_border</i>

                                <span
                                    class="name"
                                    @click="showAddressesContent(address.id)"
                                >{{ address.name }}</span>

                                <span class="hover-label">
                                    Add into your favorit places
                                </span>

                            </div>
                            <span class="label">
                                {{ address.label }}
                            </span>
                        </div>
                    </div>

                    <div class="card-container pt-5" v-else>
                        <div
                            class="card_"
                            v-for="address in addresses_less"
                            :key="address.id"
                        >
                            <img
                                class="addresses_img"
                                :src="address.image"
                                alt="hotel"
                                @click="showAddressesContent(address.id)"
                            />
                            <div class="marking-title">

                                    <i  v-if="fav.includes(address.id) || isFavoritePlace(address.id)"
                                        :id="address.id"
                                        class="favorite-marker large material-icons favorite"
                                        @click="removeMarkFavoriteAddress(address)"
                                        @mouseover="showHoverLabel"
                                    >favorite</i>

                                    <i  v-else
                                        :id="address.id"
                                        class="favorite-marker large material-icons favorite"
                                        @click="markFavoriteAddress(address)"
                                        @mouseover="showHoverLabel"
                                    >favorite_border</i>

                                <span
                                    class="name"
                                    @click="showAddressesContent(address.id)"
                                >{{ address.name }}</span>

                                <span v-if="fav.includes(address.id) || isFavoritePlace(address.id)" class="hover-label">
                                    Remove from your favorite places
                                </span>

                                <span v-else class="hover-label">
                                    Add into your favorite places
                                </span>

                            </div>
                            <span class="label italic">
                                {{ address.label }}
                            </span>
                        </div>
                    </div>

                    <span id="show-more">Show more</span>

                </div>
            </div>

            <footer>
                <a class="footer-menu" @click="favoriteCollectionHandler" :href="route('home')">Lorem Airlines</a>
                <a class="footer-menu" @click="favoriteCollectionHandler" :href="route('travel-guide')">Travel Guide</a>
            </footer>
        </div>
    </div>
</template>

<style scoped>
#wrapper {
    display: block;
}

.navbar_ {
    position: -webkit-sticky; /* Safari */
    position: sticky;
    top: 0;
    z-index: 2;
}

.wrapper {
    height: auto;
    width: 100%;
}

article {
    text-align: justify;
}

.content-top,
.content-bottom {
    margin-top: 20px;
}

.content-top h5,
.content-bottom h5 {
    text-align: center;
    text-transform: uppercase;
    color: rgb(5, 55, 115);
    text-shadow: 2px 2px 5px silver;
    padding: 25px 0 15px 0;
    font-weight: 600;
}

#addresses-menu {
    display: flex;
    justify-content: space-around;
}

.destination-menu-item {
    background: none;
    border: none;
    outline: none;
    cursor: pointer;
}

@media(max-width: 450px){
    .destination-menu-item{
        font-size: 12px;
    }
}

@media(max-width: 350px){
    .destination-menu-item{
        font-size: 10px;
    }
}

.destination-menu-item:focus {
    background: none !important;
    border: none !important;
    box-shadow: none !important;
    outline: none !important;
}

.active {
    color: #0984e3;
    border-bottom: 1px solid #0984e3;
}

.card-container {
    display: grid;
    grid-gap: 25px;
    grid-template-columns: repeat(4, 4fr);
}

.card_ {
    height: 300px;
    width: 100%;
    border: 1px solid #c4c4c4;
    border-radius: 5px;
    box-shadow: 0 2px 5px #c4c4c4;
    cursor: pointer;
}

.card_:hover {
    box-shadow: 5px 5px 8px #c4c4c4;
}

.hover-label {
    padding: 10px 20px 20px;
    border: 1px solid #c4c4c4;
    border-radius: 5px;
    color: rgb(5, 55, 115);
    display: none;
    position: absolute;
    margin: 5px 0 210px 10px;
    width: 230px;
    height: 50px;
    background: whitesmoke;
    font-size: 14px;
    line-height: 1rem;
    z-index: 1;
    align-items: center;
    text-align: center;
    justify-content: center;
    box-shadow: 1px 1px 2px #c4c4c4;
    -webkit-clip-path: polygon(0 0, 100% 0%, 100% 80%, 3% 70%, 5% 100%, 0 80%, 0 80%);
    clip-path: polygon(0 0, 100% 0%, 100% 80%, 3% 80%, 5% 100%, 0 80%, 0 80%);


}

#show-more {
    color: #0984e3;
    float: right;
    padding: 15px;
    cursor: pointer;
}

#shadow {
    height: 100vh;
    width: 100%;
    position: fixed;
    top: 0;
    left: 0;
    background: rgba(1, 1, 1, 0.6);
    z-index: 1;
    display: none;
}

.addresses_img {
    height: 70%;
    width: 100%;
}

.marking-title {
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin-top: 5px;
}

.favorite-marker {
    padding: 5px;
    margin-bottom: 120px;
    margin-left: 12px;
    border: 1px solid rgb(5, 55, 115);
    border-radius: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    background-color: whitesmoke;
}

.favorite {
    color: red;
    font-size: 25px;
    font-weight: 100;
}

.name {
    width: 100%;
    text-align: center;
    padding: 0 10px;
    font-weight: 600;
    color: rgb(5, 55, 115);
}

.label {
    position: relative;
    left: 10px;
    bottom: -5px;
    color: rgb(5, 55, 115);
}

footer {
    width: 100%;
    height: 60px;
    background: rgb(5, 55, 115);
    margin-top: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.footer-menu {
    color: whitesmoke;
    padding: 0 10px;
}

.footer-menu:hover {
    text-decoration: underline;
}

.footer-menu:first-child {
    border-right: 1px solid whitesmoke;
}

.footer-menu:focus {
    border: none !important;
    box-shadow: none !important;
}

@media(max-width: 1350px){
    .card-container{
        grid-template-columns: repeat(3, 4fr);
    }
}

@media(max-width: 1100px){
    .card-container{
        grid-template-columns: repeat(2, 3fr);
    }
}

@media(max-width: 640px){
    .card-container{
        grid-template-columns: repeat(1, 3fr);
    }
}
</style>
