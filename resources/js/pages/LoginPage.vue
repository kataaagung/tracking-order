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
    <div class="min-h-screen bg-slate-100 flex items-center justify-center p-6">
        <div class="bg-white w-full max-w-md rounded-3xl shadow-sm p-8">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold mb-2">Tracking Order</h1>

                <p class="text-slate-500">Lacak pesanan Anda</p>
            </div>

            <div class="space-y-4">
                <input
                    v-model="phone"
                    type="text"
                    placeholder="Nomor WhatsApp"
                    class="w-full border border-slate-300 rounded-2xl px-5 py-4 outline-none focus:ring-2 focus:ring-slate-300"
                />

                <input
                    v-model="spk"
                    type="text"
                    placeholder="Nomor SPK"
                    class="w-full border border-slate-300 rounded-2xl px-5 py-4 outline-none focus:ring-2 focus:ring-slate-300"
                />

                <button
                    @click="submitLogin"
                    :disabled="loading"
                    class="w-full bg-slate-900 hover:bg-slate-800 text-white rounded-2xl py-4 font-semibold transition"
                >
                    {{ loading ? "Loading..." : "Masuk" }}
                </button>

                <p v-if="error" class="text-red-500 text-sm text-center">
                    {{ error }}
                </p>
            </div>
        </div>
    </div>
</template>
