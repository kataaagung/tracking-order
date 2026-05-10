<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";

import { getOrderDetail } from "../services/orderService";

const route = useRoute();

const order = ref(null);
const loading = ref(true);

const loadDetail = async () => {
    try {
        const response = await getOrderDetail(route.params.id);

        order.value = response.data.data;
    } catch (error) {
        console.error(error);
    } finally {
        loading.value = false;
    }
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString("id-ID", {
        day: "numeric",
        month: "long",
        year: "numeric",
    });
};

onMounted(() => {
    loadDetail();
});
</script>

<template>
    <div class="min-h-screen bg-slate-100 p-4">
        <div class="max-w-xl mx-auto">
            <div v-if="loading" class="text-center py-10">Loading...</div>

            <div v-else-if="order" class="space-y-4">
                <div class="bg-white rounded-3xl shadow-sm overflow-hidden">
                    <img
                        v-if="order.capture"
                        :src="order.capture"
                        class="w-full h-64 object-cover bg-slate-200"
                    />

                    <div class="p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h1 class="text-2xl font-bold">
                                    {{ order.nama_produk }}
                                </h1>

                                <p class="text-slate-500 mt-1">
                                    SPK {{ order.spk }}
                                </p>
                            </div>

                            <div
                                class="bg-blue-100 text-blue-700 text-xs font-medium px-3 py-1 rounded-full whitespace-nowrap"
                            >
                                {{ order.status }}
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mt-6">
                            <div>
                                <p class="text-slate-400 text-sm">Qty</p>

                                <p class="font-semibold text-lg">
                                    {{ order.qty }}
                                </p>
                            </div>

                            <div class="text-right">
                                <p class="text-slate-400 text-sm">
                                    Tanggal Order
                                </p>

                                <p class="font-semibold">
                                    {{ formatDate(order.tgl_app_cs) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm p-6">
                    <h2 class="font-bold text-lg mb-4">Progress Tracking</h2>

                    <div class="space-y-5">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-4 h-4 rounded-full bg-green-500"
                            ></div>

                            <p>Order diterima</p>
                        </div>

                        <div class="flex items-center gap-4">
                            <div
                                class="w-4 h-4 rounded-full bg-green-500"
                            ></div>

                            <p>Design diproses</p>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="w-4 h-4 rounded-full bg-blue-500"></div>

                            <p>Produksi berjalan</p>
                        </div>

                        <div class="flex items-center gap-4 opacity-40">
                            <div
                                class="w-4 h-4 rounded-full bg-slate-400"
                            ></div>

                            <p>Packing</p>
                        </div>

                        <div class="flex items-center gap-4 opacity-40">
                            <div
                                class="w-4 h-4 rounded-full bg-slate-400"
                            ></div>

                            <p>Selesai</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
