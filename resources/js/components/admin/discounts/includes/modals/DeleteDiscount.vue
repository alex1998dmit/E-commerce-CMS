<template>
    <b-modal id="trash-discount-category" title="Удаление категории скидок" hide-footer>
        <div class="row">
            <div class="col">
                <h3>Удаление: {{ discount.name }}</h3>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="" @submit.prevent="trashDiscount(); closeModal();">
                    <div class="form-group" v-if="users.length > 0">
                        <label for="">Выберить куда переопределить {{ users.length }} пользователей ?</label>
                        <select class="form-control" id="select-discount" v-model="replace_discount_id">
                            <option v-for="discount in discounts" :key="discount.id" v-bind:value="discount.id">
                                {{ discount.name }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-danger" value="Удалить">
                        <b-button variant="light" @click="closeModal">Отмена</b-button>
                    </div>
                </form>
            </div>
        </div>
    </b-modal>
</template>

<script>
export default {
    data() {
        return {
            replace_discount_id: null,
        }
    },
    computed: {
        discounts() {
            return this.$store.getters.discounts
        },
        discount() {
            return this.$store.getters.selectedDiscount
        },
        users() {
            return this.$store.getters.users.filter(user => user.discount_id === this.discount.id)
        }
    },
    methods: {
        closeModal() {
            this.$bvModal.hide("trash-discount-category");
        },
        trashDiscount() {
            const index = this.discounts.map((discount) => discount.id).indexOf(this.discount.id)
            if (confirm("Вы уверены что хотите удалить категорию скидок ?")) {
                this.$store.dispatch('trashDiscount', { discount_id: this.discount.id, index });
            }
        }
    }
}
</script>

<style>

</style>
