<script setup>
import { ref, onMounted } from "vue";
import { getCustomerOrders } from "../services/orderService";
import { useRouter } from "vue-router";

const orders = ref([]);
const loading = ref(true);
const router = useRouter();

const loadOrders = async () => {
    try {
        const customerId = localStorage.getItem("customer_id");

        const response = await getCustomerOrders(customerId);

        orders.value = response.data.data;
    } catch (error) {
        console.error(error);
    } finally {
        loading.value = false;
    }
};

const statusClass = (status) => {
    switch (status) {
        case "PRINT DONE":
            return "bg-green-100 text-green-700";

        case "QC":
            return "bg-purple-100 text-purple-700";

        case "PACKING":
            return "bg-amber-100 text-amber-700";

        default:
            return "bg-blue-100 text-blue-700";
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
    loadOrders();
});
</script>

<template>
    <div class="min-h-screen bg-slate-100 p-4">
        <div class="max-w-xl mx-auto">
            <div class="mb-6">
                <h1 class="text-3xl font-bold">Pesanan Anda</h1>

                <p class="text-slate-500 mt-1">
                    Tracking progress order customer
                </p>
            </div>

            <div v-if="loading" class="text-center py-10 text-slate-500">
                Loading...
            </div>

            <div v-else class="space-y-4">
                <div
                    v-for="order in orders"
                    :key="order.id"
                    @click="router.push(`/tracking/${order.id}`)"
                    class="bg-white rounded-2xl shadow-sm overflow-hidden transition hover:-translate-y-1 hover:shadow-md"
                >
                    <img
                        v-if="order.capture"
                        :src="order.capture"
                        class="w-full h-48 object-cover"
                    />

                    <div class="p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h2 class="font-bold text-lg">
                                    {{ order.nama_produk }}
                                </h2>

                                <p class="text-slate-500 text-sm mt-1">
                                    SPK {{ order.spk }}
                                </p>
                            </div>

                            <div
                                :class="[
                                    statusClass(order.status),
                                    'text-xs font-medium px-3 py-1 rounded-full whitespace-nowrap',
                                ]"
                            >
                                {{ order.status }}
                            </div>
                        </div>

                        <div
                            class="mt-4 flex items-center justify-between text-sm"
                        >
                            <div>
                                <p class="text-slate-400">Qty</p>

                                <p class="font-semibold">
                                    {{ order.qty }}
                                </p>
                            </div>

                            <div class="text-right">
                                <p class="text-slate-400">Tanggal</p>

                                <p class="font-semibold">
                                    {{ formatDate(order.tgl_app_cs) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
