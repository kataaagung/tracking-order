<script setup>
import { useRouter } from "vue-router";

const router = useRouter();

defineProps({
    title: {
        type: String,
        default: "OrderFlow",
    },

    back: {
        type: Boolean,
        default: false,
    },
});
const logo = "http://127.0.0.1:8000/logo.png";
</script>

<template>
    <div class="simple-nav">
        <div class="nav-container">
            <button v-if="back" @click="router.back()" class="back-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>
            <div v-else class="back-btn-placeholder"></div>

            <div class="center-brand">
                <img :src="logo" class="brand-logo" />
                <span class="brand-text">{{ title }}</span>
            </div>

            <div class="right-placeholder"></div>
        </div>
    </div>
</template>

<style scoped>
.simple-nav {
    background-color: var(--colors-canvas);
    border-bottom: 1px solid var(--colors-hairline);
    position: sticky;
    top: 0;
    z-index: 100;
}

.nav-container {
    max-width: 980px;
    margin: 0 auto;
    height: 56px;
    padding: 0 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
}

.back-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--colors-ink);
    width: 32px;
    height: 32px;
    padding: 0;
}

.back-btn-placeholder, .right-placeholder {
    width: 32px;
}

.center-brand {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
}

.brand-logo {
    width: 24px;
    height: 24px;
    object-fit: contain;
}

.brand-text {
    font-family: var(--font-display);
    font-size: 17px;
    font-weight: 600;
    color: var(--colors-ink);
}
</style>
