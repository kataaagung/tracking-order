import api from './api'

export const loginCustomer = (payload) => {
    return api.post('/api/customer/login', payload)
}