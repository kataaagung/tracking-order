<script setup>
import { ref, onMounted, onBeforeUnmount, computed, watch } from "vue";
import { getCustomerOrders } from "../services/orderService";
import { useRouter } from "vue-router";
import AppNavbar from "../components/AppNavbar.vue";

const orders = ref([]);
const loading = ref(true);
const activeTab = ref("active");
const searchInput = ref("");
const searchQuery = ref("");
const router = useRouter();
let searchDebounceTimer = null;

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
            return "Selesai Printing";
        case "PRESS":
            return "Sedang Press";
        case "PRESS DONE":
            return "Selesai Press";
        case "CUTTING":
            return "Sedang Cutting";
        case "CUTTING DONE":
            return "Pesanan Selesai";
        case "DTF DONE":
            return "Pesanan Selesai";
        case "DISERAHKAN":
            return "Pesanan Selesai";
        default:
            return order.status;
    }
};

const isCompleted = (order) => {
    const produk = (order.produk || "").toLowerCase();
    const status = (order.status || "").toLowerCase();

    if (status === "cancel" || status === "diserahkan") {
        return true;
    }

    if (produk.includes("cutting")) {
        return status === "cutting done";
    }

    if (produk.includes("dtf")) {
        return status === "dtf done";
    }

    return status === "press done";
};

const activeOrders = computed(() =>
    orders.value.filter((order) => !isCompleted(order)),
);

const historyOrders = computed(() =>
    orders.value.filter((order) => isCompleted(order)),
);

const customerName = computed(() => orders.value[0]?.customer_nama);

const filteredOrders = computed(() => {
    const source =
        activeTab.value === "history"
            ? historyOrders.value
            : activeOrders.value;
    const query = searchQuery.value.trim().toLowerCase();

    if (!query) {
        return source;
    }

    return source.filter((order) => {
        const spk = String(order.spk || "").toLowerCase();
        const productName = String(order.nama_produk || "").toLowerCase();

        return spk.includes(query) || productName.includes(query);
    });
});

const currentSectionTitle = computed(() =>
    activeTab.value === "history" ? "Order History" : "Active Orders",
);

const currentSectionSubtitle = computed(() =>
    activeTab.value === "history"
        ? "Completed and archived orders."
        : "Orders currently in progress.",
);

watch(searchInput, (value) => {
    window.clearTimeout(searchDebounceTimer);

    searchDebounceTimer = window.setTimeout(() => {
        searchQuery.value = value;
    }, 250);
});

onMounted(() => {
    loadOrders();
});

onBeforeUnmount(() => {
    window.clearTimeout(searchDebounceTimer);
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
                    style="text-align: left; margin-bottom: var(--spacing-xxl)"
                >
                    <h1 class="orders-greeting">Welcome, {{ customerName }}</h1>
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

                <div v-else-if="orders.length">
                    <div class="orders-toolbar" aria-label="Order filters">
                        <div class="search-shell">
                            <svg
                                class="search-icon"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"
                                />
                            </svg>

                            <input
                                v-model="searchInput"
                                class="orders-search"
                                type="search"
                                placeholder="Search SPK"
                                autocomplete="off"
                            />
                        </div>

                        <div class="segmented-tabs" role="tablist">
                            <button
                                type="button"
                                class="segment-tab"
                                :class="{
                                    'segment-tab-active':
                                        activeTab === 'active',
                                }"
                                role="tab"
                                :aria-selected="activeTab === 'active'"
                                @click="activeTab = 'active'"
                            >
                                Active
                                <span class="tab-count">{{
                                    activeOrders.length
                                }}</span>
                            </button>

                            <button
                                type="button"
                                class="segment-tab"
                                :class="{
                                    'segment-tab-active':
                                        activeTab === 'history',
                                }"
                                role="tab"
                                :aria-selected="activeTab === 'history'"
                                @click="activeTab = 'history'"
                            >
                                History
                            </button>
                        </div>
                    </div>

                    <div>
                        <div class="section-header">
                            <h2 class="section-title">
                                {{ currentSectionTitle }}
                            </h2>

                            <p class="section-subtitle">
                                {{ currentSectionSubtitle }}
                            </p>
                        </div>

                        <div v-if="filteredOrders.length" class="orders-grid">
                            <div
                                v-for="order in filteredOrders"
                                :key="order.id"
                                @click="router.push(`/tracking/${order.id}`)"
                                class="store-utility-card clickable-card"
                                :class="{
                                    'history-card': activeTab === 'history',
                                }"
                            >
                                <div class="card-image-wrapper">
                                    <img
                                        v-if="order.capture"
                                        :src="order.capture"
                                        class="card-image"
                                        alt="Product Render"
                                    />
                                    <div
                                        v-else
                                        class="card-image-placeholder"
                                    ></div>
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
                                                    color: var(
                                                        --colors-ink-muted-80
                                                    );
                                                "
                                            >
                                                SPK {{ order.spk }}
                                            </p>
                                        </div>

                                        <div style="text-align: right">
                                            <span
                                                class="status-badge"
                                                :class="
                                                    isCompleted(order)
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
                                            border-top: 1px solid
                                                var(--colors-hairline);
                                            display: flex;
                                            justify-content: space-between;
                                        "
                                    >
                                        <div>
                                            <p
                                                class="caption"
                                                style="
                                                    color: var(
                                                        --colors-ink-muted-80
                                                    );
                                                "
                                            >
                                                Qty
                                            </p>

                                            <p class="body-strong">
                                                {{ order.qty }}
                                            </p>
                                        </div>

                                        <div style="text-align: right">
                                            <p
                                                class="caption"
                                                style="
                                                    color: var(
                                                        --colors-ink-muted-80
                                                    );
                                                "
                                            >
                                                Date
                                            </p>

                                            <p class="body-strong">
                                                {{
                                                    formatDate(order.tgl_app_cs)
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-else class="orders-empty-state">
                            <span class="body-strong">No matching orders.</span>
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

.orders-greeting {
    font-size: 28px;
    font-weight: 600;
    line-height: 1.15;
    letter-spacing: -0.4px;
}

.orders-toolbar {
    position: sticky;
    top: 68px;
    z-index: 90;
    display: grid;
    gap: 10px;
    margin-bottom: 28px;
    padding: 10px;
    border: 1px solid rgba(0, 0, 0, 0.08);
    border-radius: 18px;
    background: rgba(255, 255, 255, 0.78);
    box-shadow: 0 18px 48px rgba(15, 23, 42, 0.08);
    backdrop-filter: blur(22px);
}

.search-shell {
    position: relative;
    display: flex;
    align-items: center;
}

.search-icon {
    position: absolute;
    left: 14px;
    width: 18px;
    height: 18px;
    fill: none;
    stroke: var(--colors-ink-muted-80);
    stroke-linecap: round;
    stroke-linejoin: round;
    stroke-width: 2;
    pointer-events: none;
}

.orders-search {
    width: 100%;
    min-height: 46px;
    padding: 0 14px 0 42px;
    border: 1px solid var(--colors-hairline);
    border-radius: 13px;
    background: rgba(255, 255, 255, 0.72);
    color: var(--colors-ink);
    font: inherit;
    outline: none;
    transition:
        border-color 0.2s ease,
        box-shadow 0.2s ease,
        background-color 0.2s ease;
}

.orders-search::placeholder {
    color: var(--colors-ink-muted-80);
}

.orders-search:focus {
    border-color: rgba(0, 122, 255, 0.45);
    background: rgba(255, 255, 255, 0.92);
    box-shadow: 0 0 0 4px rgba(0, 122, 255, 0.12);
}

.segmented-tabs {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 4px;
    padding: 4px;
    border-radius: 14px;
    background: rgba(120, 120, 128, 0.12);
}

.segment-tab {
    display: flex;
    min-height: 40px;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border: 0;
    border-radius: 11px;
    background: transparent;
    color: var(--colors-ink-muted-80);
    font: inherit;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition:
        background-color 0.2s ease,
        box-shadow 0.2s ease,
        color 0.2s ease;
}

.segment-tab-active {
    background: rgba(255, 255, 255, 0.94);
    color: var(--colors-ink);
    box-shadow:
        0 1px 2px rgba(0, 0, 0, 0.06),
        0 8px 20px rgba(15, 23, 42, 0.08);
}

.tab-count {
    min-width: 22px;
    padding: 2px 7px;
    border-radius: 999px;
    background: rgba(120, 120, 128, 0.14);
    font-size: 12px;
    line-height: 1.35;
}

.history-card {
    opacity: 0.72;
}

.orders-empty-state {
    padding: var(--spacing-xxl);
    text-align: center;
    color: var(--colors-ink-muted-80);
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

.section-header {
    margin-bottom: 24px;
}

.section-title {
    font-size: 28px;
    font-weight: 600;
    letter-spacing: -0.6px;
}

.section-subtitle {
    margin-top: 6px;
    color: var(--colors-ink-muted-80);
}

@media (min-width: 720px) {
    .orders-toolbar {
        grid-template-columns: minmax(260px, 1fr) minmax(280px, 360px);
        align-items: center;
    }
}

@media (max-width: 420px) {
    .orders-grid {
        grid-template-columns: 1fr;
    }

    .orders-toolbar {
        top: 64px;
        border-radius: 16px;
    }
}
</style>
