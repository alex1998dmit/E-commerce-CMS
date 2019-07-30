<template>
    <b-modal id="change-user-discount" hide-footer title="Изменить скидочную категорию пользователя">
        <div class="row">
            <div class="col">
                <h5>{{ user.email }}</h5>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="" @submit.prevent="updateDiscount(); closeModal();">
                    <div class="form-group">
                        <label for="select-discount">Выберите скидочную категорию</label>
                        <select class="form-control" id="select-discount" v-model="user.discount_id">
                            <option v-for="discount in discounts" :key="discount.id" v-bind:value="discount.id">
                                {{ discount.name }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" value="Изменить">
                    </div>
                </form>
            </div>
        </div>
    </b-modal>
</template>

<script>
export default {
    computed: {
        user:{
            get() {
                return this.$store.getters.selectedUser;
            }
        },
        discounts() {
            return this.$store.getters.discounts;
        }
    },
    methods: {
        updateDiscount(){
            this.$store.dispatch('updateUser', { user_id: this.user.id, user: { discount_id: this.user.discount_id} });
        },
        closeModal() {
            this.$bvModal.hide("change-user-discount");
        }
    }
}
</script>

<style>

</style>
