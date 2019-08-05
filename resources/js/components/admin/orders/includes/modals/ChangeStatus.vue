<template>
    <b-modal id="change-status-at-order" title="Изменить статус заказа" hide-footer>
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <p>Заказ в статусе: <b>{{ order.status.name }}</b></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <form action="">
                            <select name="status_id" id="status_id" class="form-control" v-model="order.status_id">
                                <option v-for="status in statuses" :key="status.id" v-bind:value="status.id">
                                    {{ status.name }}
                                </option>
                            </select>
                        </form>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <b-button variant="outline-success" @click="updateStatus(); redirectToOrders();">Обновить статус</b-button>
                    </div>
                </div>
            </div>
        </div>
    </b-modal>
</template>
<script>
export default {
    computed: {
        statuses() {
            return this.$store.getters.orderStatuses;
        },
        order() {
            return this.$store.getters.selectedOrder;
        }
    },
    mounted() {
        this.$store.dispatch("getOrderStatuses");
    },
    methods: {
        redirectToOrders() {
            this.$bvModal.hide("change-status-at-order");
            // this.$router.push({ name: 'OrdersWithStatus', params: {statusId: this.order.status_id }});
        },
        updateStatus() {
            const status_index = this.statuses.map((status) => status.id).indexOf(this.order.status_id);
            const status = this.statuses[status_index];
            this.order.status = status;
            this.$store.dispatch("updateOrder", { order_id: this.order.id, order: { status_id: this.order.status_id }});
        },
    }
}
</script>

