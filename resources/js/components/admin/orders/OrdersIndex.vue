<template>
    <div>
        <div class="row">
            <div class="col-md-6">
                <h2>Статусы заказа</h2>
                <h5>{{ order_status.name }}</h5>
            </div>
            <div class="col-md-6">

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            status: {
                name: "",
                descripton: "",
            }
        }
    },
    computed: {
        order_status() {
            return this.$store.getters.selectedOrderStatus;
        },
        orders() {

        }
    },
    mounted() {
        const status_id = this.$route.query.statusId;
        if (status_id) {
            this.$store.dispatch("getSelectedOrderStatus", status_id);
        }
    },
    created() {
    },
    methods: {
        update(status_id) {
            this.$store.dispatch("getSelectedOrderStatus", status_id);
        }
    },
    wathc: {
        '$route'(new_val) {
            console.log(new_val);
            alert(new_val);
            update(query.new_val.statusId);
        }
    }
}
</script>

