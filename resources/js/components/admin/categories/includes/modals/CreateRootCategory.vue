<template>
    <b-modal id="bv-modal-add-root-category" hide-footer title="Добавить категорию">
        <div class="row">
            <div class="col-md-12">
                <label for="category_name">Название категории</label>
                <input type="text" class="form-control" name="category_name" v-model="category.name">
            </div>
        </div>
        <br>
        <b-button variant="outline-success" @click="createCategory(); closeModal()">Создать</b-button>
        <b-button variant="outline-danger" @click="closeModal()">Отмена</b-button>
    </b-modal>
</template>
<script>
import { crudCategoriesMixin } from '../../mixins/crudCategoriesMixin';

export default {
    mixin: [ crudCategoriesMixin ],
    data() {
        return {
            category: {
                name: "",
                parent_id: 0,
            }
        }
    },
    methods: {
        closeModal() {
            this.$bvModal.hide("bv-modal-add-root-category");
        },
        createCategory() {
            this.$store.dispatch('createCategory', this.category);
        }
    }
}
</script>

