import api from "./api";

export const getCustomerOrders = (customerId) => {
    return api.get(`/api/customer/orders/${customerId}`);
};
export const getOrderDetail = (id) => {
    return api.get(`/api/customer/order/${id}`);
};
