<template>
    <div>
        <b-modal id="bv-modal-example" title="Редактирование" hide-footer>
                <form action="">
                    <div class="form-group">
                        <label for="exampleInputEmail1">ID</label>
                        <input type="text" class="form-control" v-model="updating_discount.discount.id" disabled>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Название скидки</label>
                        <input type="text" class="form-control"  v-model="updating_discount.discount.name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Скидка</label>
                        <input type="text" class="form-control" v-model="updating_discount.discount.discount">
                    </div>
                    <b-button class="mt-3" block variant="outline-success" @click="updateDiscount(); $bvModal.hide('bv-modal-example');">Сохранить</b-button>
                    <b-button class="mt-3" block variant="outline-danger" @click="$bvModal.hide('bv-modal-example'); deleteDiscount()">Удалить</b-button>
                </form>
            </b-modal>
        </div>
</template>

<script>

export default {
    computed: {
        updating_discount:{
            get() {
                return this.$store.getters.updatingDiscount;
            },
        }
    },
    methods: {
        updateDiscount() {
            this.$store.dispatch('updateDiscount');
        },
        deleteDiscount() {
            this.$store.dispatch('removeDiscount', this.updating_discount.discount.id);
        },
    }
}
</script>
