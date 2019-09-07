<template>
    <b-modal id="bv-modal-change-category" hide-footer title="Редактировать категорию">
        <div class="row">
            <div class="col-md-12">
                <label for="category_name">Название категории</label>
                <input type="text" class="form-control" name="category_name" v-model="updating_category.name">
            </div>
        </div>
        <br>
        <b-button variant="outline-success" @click="updateCategory(); closeModal()">Обновить</b-button>
        <b-button variant="outline-danger" @click="closeModal()">Отмена</b-button>
    </b-modal>
</template>
<script>
export default {
    data: () => {
        return {
            category_id: 0,
            category_index: 0,
        }
    },
    computed: {
        updating_category: {
            get() {
                return this.$store.getters.selectedCategory;
            },
            set(val){}
        },
        selected_category: {
            get() {
                return this.$store.getters.selectedCategory;
            },
            set(val) {}
        },
        categories() {
            return this.$store.getters.categories;
        }
    },
    methods: {
        closeModal() {
            this.$bvModal.hide('bv-modal-change-category');
        },
        updateCategory() {
            this.$store.dispatch('updateCategory', { category_id: this.category_id, updating_category: this.updating_category });
        }
    },
    watch: {
        selected_category(category) {
            this.category_id = category.id;
            this.category_index = this.categories.map((category) => category.id).indexOf(this.category_id);
        }
    }
}
</script>
