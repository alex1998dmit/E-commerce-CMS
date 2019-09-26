<template>
    <b-modal id="update-user-at-order" title="Обновить пользователя" hide-footer>
        <div class="col">
            <div class="row">
                <div class="col">
                    <p>Текущий пользователь: {{ order.user.name }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" v-model="search_param" placeholder="Поиск по названию продукта ...">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <ul>
                        <li v-for="(user, user_index) in users" :key="user.id">{{ user.email }}
                            <b-button
                                size="sm"
                                variant="success"
                                @click="updateUser(user.id, user_index); closeModal()">
                                    Выбрать
                            </b-button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </b-modal>
</template>
<script>
// update-user-at-order
export default {
    data() {
        return {
            search_param: null,
        }
    },
    computed: {
        order() {
            return this.$store.getters.selectedOrder;
        },
        orders() {
            return this.$store.getters.orders;
        },
        users: {
            get() {
                if (this.search_param) {
                    return this.$store.getters.users.filter((user) => user.email.toLowerCase().includes(this.search_param.toLocaleLowerCase()));
                }
                return [];
            }
        }
    },
    mounted() {
        this.$store.dispatch('getUsers');
    },
    methods: {
        closeModal() {
            this.$bvModal.hide("update-user-at-order");
        },
        updateUser(user_id, user_index) {
            const order_id = this.order.id;
            const user = this.users[user_index];
            this.order.user_id = user_id;
            this.order.user = user;
            this.$store.dispatch('updateOrder', { order_id, order: this.order });
        }
    },
}
</script>

