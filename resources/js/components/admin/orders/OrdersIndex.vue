<template>
    <div>
        <div class="row">
            <div class="col-md-6">
                <h2>Статусы заказа</h2>
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
            status_id: 0,
            status_name: null,
        }
    },
    computed: {
        orders() {
            return [];
        }
    },
    mounted() {
        this.status_id = this.$route.query.statusId;
        console.log(this.status_id);
    },
    methods: {

    }
}
</script>

