<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

import { loginCustomer } from "../services/authService";

const router = useRouter();

const phone = ref("");
const spk = ref("");

const loading = ref(false);
const error = ref("");

const submitLogin = async () => {
    try {
        loading.value = true;
        error.value = "";

        const response = await loginCustomer({
            phone: phone.value,
            spk: spk.value,
        });

        localStorage.setItem("customer_id", response.data.data.customer_id);

        router.push("/orders");
    } catch (err) {
        error.value = err.response?.data?.message || "Login gagal";
    } finally {
        loading.value = false;
    }
};
</script>

<template>
    <div class="product-tile-parchment" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
        <div style="background-color: var(--colors-canvas); width: 100%; max-width: 440px; border-radius: var(--rounded-lg); padding: var(--spacing-xxl); border: 1px solid var(--colors-hairline);">
            <div style="text-align: center; margin-bottom: var(--spacing-xl);">
                <img
                    src="http://127.0.0.1:8000/logo.png"
                    alt="Logo"
                    style="width: 60px; margin: 0 auto var(--spacing-sm); display: block;"
                />
                <h1 class="display-md">Tracking Order</h1>
                <p class="body-muted mt-xs">Sign in to track your deliveries.</p>
            </div>

            <div style="display: flex; flex-direction: column; gap: var(--spacing-md);">
                <input
                    v-model="phone"
                    type="text"
                    placeholder="WhatsApp Number"
                    class="apple-input"
                />

                <input
                    v-model="spk"
                    type="text"
                    placeholder="SPK Number"
                    class="apple-input"
                />

                <button
                    @click="submitLogin"
                    :disabled="loading"
                    class="button-primary mt-sm"
                    style="width: 100%;"
                >
                    {{ loading ? "Loading..." : "Sign In" }}
                </button>

                <p v-if="error" style="color: var(--colors-primary); font-size: 14px; text-align: center; margin-top: 8px;">
                    {{ error }}
                </p>
            </div>
        </div>
    </div>
</template>

<style scoped>
.apple-input {
    background-color: var(--colors-canvas);
    color: var(--colors-ink);
    font-size: 17px;
    font-family: var(--font-body);
    border: 1px solid rgba(0, 0, 0, 0.08);
    border-radius: var(--rounded-sm);
    padding: 14px 16px;
    width: 100%;
    outline: none;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.apple-input:focus {
    border-color: var(--colors-primary-focus);
    box-shadow: 0 0 0 2px rgba(0, 113, 227, 0.2);
}
</style>
