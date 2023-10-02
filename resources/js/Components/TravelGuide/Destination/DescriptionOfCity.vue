<script setup>

const props = defineProps({
    destination: Object,
});

const readMore = (e) => {
    const current = e.target;
    const currentText = e.target.parentNode.querySelector(".read-more-text");

    currentText.classList.toggle("read-more-text--show");
    current.textContent = current.textContent.includes("Read more")
        ? "Read less..."
        : "Read more...";
}
</script>

<template>
    <div>
        <p id="quotes" class="text-justify md:mt-0">
            <i>
                <strong>{{ destination.quotes }}</strong>
                {{ destination.author }}
            </i>
        </p>
        <article>
            {{ destination.article }}
            <span class="read-more-text">
                {{ destination.article_continue }}
            </span>
        </article>
        <span class="read-more-btn" @click="readMore">Read more...</span>
    </div>
</template>

<style scoped>
#quotes {
    padding: 5px 10px 10px 0;
}

.read-more-btn {
    color: #0984e3;
    cursor: pointer;
}

.read-more-text {
    display: none;
}
</style>
