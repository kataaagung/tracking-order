<script setup>
import { ref, onMounted } from 'vue'
import { getCustomerOrders } from '../services/orderService'

const orders = ref([])
const loading = ref(true)

const loadOrders = async () => {
    try {
        const customerId = localStorage.getItem('customer_id')

        const response = await getCustomerOrders(customerId)

        orders.value = response.data.data

    } catch (error) {
        console.error(error)
    } finally {
        loading.value = false
    }
}

onMounted(() => {
    loadOrders()
})
</script>

<template>
    <div>
        <h1>Orders Page</h1>

        <div v-if="loading">
            Loading...
        </div>

        <div v-else>

            <div
                v-for="order in orders"
                :key="order.id"
                style="
                    border:1px solid #ddd;
                    padding:16px;
                    margin-bottom:12px;
                "
            >
                <h3>{{ order.nama_produk }}</h3>

                <p>SPK: {{ order.spk }}</p>

                <p>Status: {{ order.status }}</p>

                <p>Qty: {{ order.qty }}</p>

            </div>

        </div>
    </div>
</template>