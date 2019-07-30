<template>
    <b-modal id="add-discount-to-user" title="Добавить пользователе к категории" hide-footer>
        <div class="row">
            <div class="col">
                <h5>{{ discount.name }}</h5>
            </div>
        </div>
        <div class="row">
           <div class="col">
                <input type="text" class="form-control" v-model="search_param">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <ul>
                    <li v-for="user in users" :key="user.id">
                        {{ user.email }}
                        <b-button
                            v-if="user.discount_id != discount.id"
                            size="sm"
                            variant="success"
                            @click="updateUser(user.id)">
                                +
                        </b-button>
                        <b-button
                            v-if="user.discount_id == discount.id"
                            size="sm"
                            variant="light">
                                ✔
                        </b-button>
                    </li>
                </ul>
            </div>
        </div>
    </b-modal>
</template>
<script>
export default {
    data() {
        return {
            search_param: null,
        }
    },
    computed: {
        discount() {
            return this.$store.getters.selectedDiscount;
        },
        users() {
            if (this.search_param) {
                return this.$store.getters.users.filter((user) => user.email.toLowerCase().includes(this.search_param.toLocaleLowerCase()));
            }
            return [];
        },
    },
    methods: {
        updateUser(user_id) {
            const user = {
                discount_id: this.discount.id,
            };
            this.$store.dispatch('updateUser', { user_id, user });
        }
    }
}
</script>

