<template>
    <b-modal id="create-discount" title="Созадать новую скидочную категорию" hide-footer>
        <div class="row">
            <div class="col">
                <form action="" @submit.prevent="updateDiscount(discount.id, discount); closeModal();">
                    <div class="form-group">
                        <label for="">Название</label>
                        <input type="text" class="form-control" v-model="discount.name">
                    </div>
                    <div class="form-group">
                        <label for="">Размер скидки</label>
                        <input type="text" class="form-control" v-model="discount.discount">
                    </div>
                    <div class="form-group">
                        <label for="">Описание</label>
                        <textarea class="form-control" cols="30" rows="10" v-model="discount.description"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" value="Обновить">
                    </div>
                </form>
            </div>
        </div>
    </b-modal>
</template>

<script>
import { crudDiscountMixin } from '../../mixins/crudDiscountMixin';

export default {
    mixins: [crudDiscountMixin],
    computed: {
        discount: {
            get() {
                return this.$store.getters.selectedDiscount;
            },
            set(val) {

            }
        }
    },
    methods: {
        closeModal() {
            this.$bvModal.hide("create-discount");
        },
        updateDiscount(discount_id, discount) {
            this.$store.dispatch('updateDiscount', { discount, discount_id });
        },
    }
}
</script>

<style>

</style>
