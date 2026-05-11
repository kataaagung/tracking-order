<script setup>
import { ref, onMounted } from "vue";
import { getCustomerOrders } from "../services/orderService";
import { useRouter } from "vue-router";
import AppNavbar from "../components/AppNavbar.vue";

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

const formatDate = (date) => {
    if (!date) return "-";
    return new Date(date).toLocaleDateString("id-ID", {
        day: "numeric",
        month: "long",
        year: "numeric",
    });
};

const statusLabel = (order) => {
    if (order.status === "BELUM" && !order.tgl_app_cs) {
        return "Menunggu Pembayaran";
    }
    if (order.status === "BELUM" && order.tgl_app_cs) {
        return "Menunggu Produksi";
    }
    if (order.statusm === "IN PROGRESS") {
        return "Sedang Proses Design";
    }
    switch (order.status) {
        case "PRINT":
            return "Sedang Printing";
        case "PRINT DONE":
            return "Printing Selesai";
        case "PRESS":
            return "Sedang Press";
        case "PRESS DONE":
            return "Press Selesai";
        case "CUTTING":
            return "Sedang Cutting";
        case "CUTTING DONE":
            return "Pesanan Selesai";
        default:
            return order.status;
    }
};

onMounted(() => {
    loadOrders();
});
</script>

<template>
    <div>
        <AppNavbar title="SMARTONE" />

        <div
            class="product-tile-parchment"
            style="min-height: calc(100vh - 96px); padding-top: 40px"
        >
            <div class="content-lock">
                <div
                    style="
                        text-align: center;
                        margin-bottom: var(--spacing-xxl);
                    "
                >
                    <h1 class="display-lg">Your Orders.</h1>
                    <p class="lead" style="color: var(--colors-ink-muted-80)">
                        Track your recent purchases and their journey.
                    </p>
                </div>

                <div
                    v-if="loading"
                    style="
                        text-align: center;
                        padding: var(--spacing-xxl);
                        color: var(--colors-ink-muted-80);
                    "
                >
                    <span class="body-strong">Loading your orders...</span>
                </div>

                <div v-else class="orders-grid">
                    <div
                        v-for="order in orders"
                        :key="order.id"
                        @click="router.push(`/tracking/${order.id}`)"
                        class="store-utility-card clickable-card"
                    >
                        <div class="card-image-wrapper">
                            <img
                                v-if="order.capture"
                                :src="order.capture"
                                class="card-image"
                                alt="Product Render"
                            />
                            <div v-else class="card-image-placeholder"></div>
                        </div>

                        <div style="margin-top: var(--spacing-md)">
                            <div
                                style="
                                    display: flex;
                                    justify-content: space-between;
                                    align-items: flex-start;
                                    gap: 12px;
                                "
                            >
                                <div>
                                    <h2 class="body-strong">
                                        {{ order.nama_produk }}
                                    </h2>
                                    <p
                                        class="caption mt-xs"
                                        style="
                                            color: var(--colors-ink-muted-80);
                                        "
                                    >
                                        SPK {{ order.spk }}
                                    </p>
                                </div>
                                <div style="text-align: right">
                                    <span
                                        class="status-badge"
                                        :class="
                                            order.status === 'CUTTING DONE'
                                                ? 'status-complete'
                                                : 'status-active'
                                        "
                                    >
                                        {{ statusLabel(order) }}
                                    </span>
                                </div>
                            </div>

                            <div
                                style="
                                    margin-top: var(--spacing-lg);
                                    padding-top: var(--spacing-sm);
                                    border-top: 1px solid var(--colors-hairline);
                                    display: flex;
                                    justify-content: space-between;
                                "
                            >
                                <div>
                                    <p
                                        class="caption"
                                        style="
                                            color: var(--colors-ink-muted-80);
                                        "
                                    >
                                        Qty
                                    </p>
                                    <p class="body-strong">{{ order.qty }}</p>
                                </div>
                                <div style="text-align: right">
                                    <p
                                        class="caption"
                                        style="
                                            color: var(--colors-ink-muted-80);
                                        "
                                    >
                                        Date
                                    </p>
                                    <p class="body-strong">
                                        {{ formatDate(order.tgl_app_cs) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    v-if="!loading && orders.length === 0"
                    style="
                        text-align: center;
                        padding: var(--spacing-xxl);
                        color: var(--colors-ink-muted-80);
                    "
                >
                    <span class="body-strong">No orders found.</span>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.orders-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
}

.clickable-card {
    cursor: pointer;
    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease;
}
.clickable-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-product);
}

.card-image-wrapper {
    width: 100%;
    aspect-ratio: 1 / 1;
    border-radius: var(--rounded-sm);
    overflow: hidden;
    background-color: var(--colors-canvas-parchment);
    display: flex;
    align-items: center;
    justify-content: center;
}

.card-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.card-image-placeholder {
    width: 100%;
    height: 100%;
    background-color: #e5e5ea;
}

.status-badge {
    font-size: 12px;
    font-weight: 600;
    letter-spacing: -0.12px;
    color: var(--colors-primary);
}
.status-complete {
    color: var(--colors-ink);
}
</style>
