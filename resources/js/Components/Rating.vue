<script setup>

const props = defineProps({
    ratingNumber: String
});

const maxRating = 5.0;
const star = ['fas', 'star'];
const starHalfStroke = ['far', 'star-half-stroke'];
const starStroke = ['far', 'star'];
const ratingIcons = [];
const result = maxRating - parseFloat(props.ratingNumber);

const arrayFill = (full, half, empty) => {
    if (full) {
        for (let i = 0; i < full; i++) {
            ratingIcons.push(star);
        }
    }

    if (half) {
       ratingIcons.push(starHalfStroke);
    }

    if (empty) {
        for (let j = 0; j < empty; j++) {
            ratingIcons.push(starStroke);
        }
    }
};

switch (result) {
    case 0: {
        arrayFill(5,0,0);
    }
        break;
    case 0.5: {
        arrayFill(4,1,0);
    }
        break;
    case 1.0: {
        arrayFill(4,0,1);
    }
        break;
    case 1.5: {
        arrayFill(3,1,1);
    }
        break;
    case 2.0: {
        arrayFill(3,0,2);
    }
        break;
    case 2.5: {
        arrayFill(2,1,2);
    }
        break;
    case 3.0: {
        arrayFill(2,0,3);
    }
        break;
    case 3.5: {
        arrayFill(1,1,3);
    }
        break;
    case 4.0: {
        arrayFill(1,0,4);
    }
        break;
    case 4.5: {
        arrayFill(0,1,4);
    }
        break;
    case 5.0: {
        arrayFill(0,0,5);
    }
        break;
    default:{}
}

</script>

<template>
    <div class="flex text-yellow-400 my-3">
        <font-awesome-icon v-for="icon in ratingIcons" :icon=icon class="pr-2" />
        <p class="text-whitesmoke text-sm">{{ ratingNumber }}</p>
    </div>
</template>

