import api from './api'

export const getCustomerOrders = (customerId) => {
    return api.get(`/api/customer/orders/${customerId}`)
}