<template>
    <b-modal id="change-user-discount" title="Добавить пользователя" hide-footer>
        <div class="row">
            <div class="col-md-12">
                <h5>Добавить пользователя к новой категории</h5>
            </div>
            <div class="col-md-12">
                <h6>{{ discount.name }}</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="" @submit.prevent="findUsers">
                    <div class="form-group">
                        <label for=""></label>
                        <input type="text" class="form-control" v-model="email" placeholder="Введите email пользователя">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="find-users" value="Найти">
                    </div>
                </form>
            </div>
            <div class="col-md-12">
                <ul>
                    <li v-for="(user, index) in filtered_users" :key="user.id">
                        <a class="chose-product-button">
                            {{ user.name }} - {{ user.email }}
                            <button class="chose-user-button" v-if="user.discount_id !== discount.id" @click="updateUserDiscount(user.id, discount.id, index)"><i class="fa fa-plus" aria-hidden="true"></i></button>
                            <button class="chose-user-button" v-else><i class="fa fa-check-circle" aria-hidden="true"></i></button>
                        </a>
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
            email: null
        }
    },
    computed: {
        filtered_users: {
            get() {
                return this.$store.getters.findedUsers
            },
            set(val) {

            }
        },
        discount () {
            return this.$store.getters.selectedDiscount
        }
    },
    methods: {
        findUsers () {
            this.$store.dispatch('findUsers', this.email)
        },
        updateUserDiscount (user_id, discount_id, user_index) {
            this.$store.dispatch('updateUser', { user_id, user: { discount_id } })
                .then(resp => {
                    this.filtered_users = this.filtered_users.splice(user_index, 1, resp)
                })
        }
    }
}
</script>

<style>
    .find-users {
        border: 0px;
        border-radius: 0px;
        border-bottom: 2px solid lightblue;
        font-size: 0.9em;
    }
    .find-users:hover {
        border-color: blue;
    }
    .chose-user-button {
        border: 0px;
        border-radius: 0px;
        border-bottom: 2px solid lightgreen;
        font-size: 0.9em;
    }
    .chose-user-button:hover {
        border-color: green;
    }
</style>
