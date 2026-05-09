<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { loginCustomer } from '../services/authService'

const router = useRouter()

const phone = ref('')
const spk = ref('')
const loading = ref(false)
const error = ref('')

const submitLogin = async () => {
    try {
        loading.value = true
        error.value = ''

        const response = await loginCustomer({
            phone: phone.value,
            spk: spk.value,
        })

        localStorage.setItem(
            'customer_id',
            response.data.data.customer_id
        )

        router.push('/orders')

    } catch (err) {
        error.value = err.response?.data?.message || 'Login gagal'
    } finally {
        loading.value = false
    }
}
</script>

<template>
    <div>
        <h1>Tracking Order</h1>

        <input
            v-model="phone"
            placeholder="Nomor WhatsApp"
        />

        <input
            v-model="spk"
            placeholder="Nomor SPK"
        />

        <button @click="submitLogin">
            {{ loading ? 'Loading...' : 'Masuk' }}
        </button>

        <p v-if="error">
            {{ error }}
        </p>
    </div>
</template>