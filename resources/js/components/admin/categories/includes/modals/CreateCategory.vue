<template>
    <div class="modal-create">
        <b-modal id="bv-modal-create-category" hide-footer title="Добавить новую категорию">
            <br>
            <div class="row">
                <div class="col-md-12">
                    <label for="category_name">Название новой категории</label>
                    <input type="text" class="form-control" name="category_name" v-model="new_category.name">
                </div>
            </div>
            <br>
            <b-button variant="outline-success" @click="createCategory(); closeModal()">Добавить</b-button>
            <b-button variant="outline-danger" @click="closeModal();">Отмена</b-button>
        </b-modal>
    </div>
</template>

<script>
export default {
    data: () => {
        return {
            new_category: {
                name: "",
                parent_id: 0,
            }
        }
    },
    computed: {
        selected_category() {
            return this.$store.getters.selectedCategory;
        }
    },
    methods: {
        closeModal() {
            this.$bvModal.hide('bv-modal-create-category');
        },
        createCategory() {
            this.$store.dispatch('createCategory', this.new_category);
        }
    },
    watch: {
        selected_category(category) {
            this.new_category.parent_id = category.id;
        }
    }
}
</script>

