<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import AppNavbar from "../components/AppNavbar.vue";
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

const trackingSteps = (order) => {
    const currentStep = getCurrentStep(order);

    return [
        {
            label: "Proses Design",
            state:
                currentStep > 1
                    ? "done"
                    : currentStep === 1
                      ? "current"
                      : "pending",
        },

        {
            label: "Menunggu Pembayaran",
            state:
                currentStep > 2
                    ? "done"
                    : currentStep === 2
                      ? "current"
                      : "pending",
        },

        {
            label: "Produksi",
            state:
                currentStep > 3
                    ? "done"
                    : currentStep === 3
                      ? "current"
                      : "pending",
        },

        {
            label: "Pesanan Selesai",
            state: currentStep === 5 ? "done" : "pending",
        },
    ];
};

const getCurrentStep = (order) => {
    if (order.statusm === "IN PROGRESS") {
        return 1;
    }

    if (order.status === "BELUM" && !order.tgl_app_cs) {
        return 2;
    }

    if (
        [
            "PRINT",
            "PRINT DONE",
            "PRESS",
            "PRESS DONE",
            "CUTTING",
            "CUTTING DONE",
        ].includes(order.status)
    ) {
        return 3;
    }

    if (order.status === "PRESS DONE" || order.status === "CUTTING") {
        return 4;
    }

    if (
        order.status === "CUTTING DONE" ||
        (order.status === "PRESS DONE" &&
            !order.produk?.toLowerCase().includes("cutting"))
    ) {
        return 5;
    }

    return 1;
};

const isFinished = (order) => {
    const produk = order.produk?.toLowerCase() || "";
    const status = order.status?.toLowerCase() || "";

    if (produk.includes("cutting")) {
        return status === "cutting done";
    }

    return status === "press done";
};

onMounted(() => {
    loadDetail();
});
</script>

<template>
    <div>
        <AppNavbar :back="true" title="SMARTONE" />

        <div
            v-if="loading"
            style="
                text-align: center;
                padding: var(--spacing-xxl);
                min-height: 100vh;
            "
        >
            <span class="body-strong" style="color: var(--colors-ink-muted-80)"
                >Loading details...</span
            >
        </div>

        <div v-else-if="order" style="padding-bottom: var(--spacing-section)">
            <!-- Hero Product Section -->
            <div
                class="product-tile-light"
                style="padding-top: 40px; padding-bottom: 40px"
            >
                <div class="content-lock" style="text-align: center">
                    <h1 class="display-lg">{{ order.nama_produk }}</h1>
                    <p
                        class="tagline mt-xs"
                        style="color: var(--colors-ink-muted-80)"
                    >
                        SPK {{ order.spk }}
                    </p>

                    <div style="margin-top: var(--spacing-lg)">
                        <img
                            v-if="order.capture"
                            :src="order.capture"
                            class="hero-image"
                            alt="Product Image"
                        />
                    </div>
                </div>
            </div>

            <!-- Details Section -->
            <div
                class="product-tile-parchment"
                style="padding: var(--spacing-xxl) 0"
            >
                <div class="content-lock details-grid">
                    <!-- Order Specs Card -->
                    <div class="store-utility-card">
                        <h2 class="body-strong">Order Specification</h2>
                        <div
                            style="
                                margin-top: var(--spacing-lg);
                                display: flex;
                                flex-direction: column;
                                gap: 16px;
                            "
                        >
                            <div
                                style="
                                    display: flex;
                                    justify-content: space-between;
                                    border-bottom: 1px solid
                                        var(--colors-hairline);
                                    padding-bottom: 8px;
                                "
                            >
                                <span
                                    class="body"
                                    style="color: var(--colors-ink-muted-80)"
                                    >Status</span
                                >
                                <span
                                    class="body-strong"
                                    style="color: var(--colors-primary)"
                                    >{{ statusLabel(order) }}</span
                                >
                            </div>
                            <div
                                style="
                                    display: flex;
                                    justify-content: space-between;
                                    border-bottom: 1px solid
                                        var(--colors-hairline);
                                    padding-bottom: 8px;
                                "
                            >
                                <span
                                    class="body"
                                    style="color: var(--colors-ink-muted-80)"
                                    >Quantity</span
                                >
                                <span class="body-strong">{{ order.qty }}</span>
                            </div>
                            <div
                                style="
                                    display: flex;
                                    justify-content: space-between;
                                    border-bottom: 1px solid
                                        var(--colors-hairline);
                                    padding-bottom: 8px;
                                "
                            >
                                <span
                                    class="body"
                                    style="color: var(--colors-ink-muted-80)"
                                    >Order Date</span
                                >
                                <span class="body-strong">{{
                                    formatDate(order.tgl_app_cs)
                                }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Tracking Card -->
                    <div class="store-utility-card">
                        <h2 class="body-strong">Progress Tracking</h2>

                        <div
                            style="
                                margin-top: var(--spacing-lg);
                                display: flex;
                                flex-direction: column;
                                gap: 20px;
                            "
                        >
                            <div
                                v-for="(step, index) in trackingSteps(order)"
                                :key="index"
                                class="tracking-step"
                                :class="step.state"
                            >
                                <div class="step-indicator"></div>

                                <span
                                    :class="
                                        step.state === 'current'
                                            ? 'body-strong'
                                            : 'body'
                                    "
                                    :style="
                                        step.state === 'pending'
                                            ? 'color: var(--colors-ink-muted-80)'
                                            : ''
                                    "
                                >
                                    {{ step.label }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.hero-image {
    max-width: 100%;
    width: 600px;
    height: auto;
    object-fit: cover;
    border-radius: var(--rounded-lg);
    box-shadow: var(--shadow-product);
    margin: 0 auto;
}

.details-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 24px;
}
@media (min-width: 834px) {
    .details-grid {
        grid-template-columns: 1fr 1fr;
    }
}

.tracking-step {
    display: flex;
    align-items: center;
    gap: 16px;
    position: relative;
}

/* Vertical line connecting steps */
.tracking-step:not(:last-child)::after {
    content: "";
    position: absolute;
    left: 7px;
    top: 24px;
    bottom: -12px;
    width: 2px;
    background-color: var(--colors-hairline);
}

.step-indicator {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background-color: var(--colors-canvas-parchment);
    border: 2px solid var(--colors-hairline);
    z-index: 2;
}

.tracking-step.active .step-indicator {
    background-color: var(--colors-ink);
    border-color: var(--colors-ink);
}

.tracking-step.current .step-indicator {
    background-color: var(--colors-primary);
    border-color: var(--colors-primary);
    box-shadow: 0 0 0 4px rgba(0, 102, 204, 0.2);
}

.tracking-step.pending .step-indicator {
    background-color: var(--colors-canvas);
    border-color: var(--colors-hairline);
}
</style>
