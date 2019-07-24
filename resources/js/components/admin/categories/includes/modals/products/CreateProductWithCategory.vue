<template>
    <b-modal id="bv-modal-add-product-category" size="xl" hide-footer title="Добавить продукт к категориии">
        <div class="row">
            <div class="col-md-12">
                    <form action="" id="createProductForm">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="product_name">Название</label>
                            <input type="text" class="form-control" id="product_name" v-model="product.name">
                        </div>
                        <br>
                        <div class="col-md-6">
                            <label for="price">Стоимость</label>
                            <input type="text" class="form-control" id="price" v-model="product.price">
                        </div>
                        <br>
                        <div class="col-md-12">
                            <label for="price">Описание</label>
                            <textarea class="form-control" name="product_desc" id="" cols="30" rows="10" v-model="product.description"></textarea>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <label for=""></label>
                            <input type="file" class="form-control" ref="file_input" id="attachments" @change="uploadFiles" multiple>
                        </div>
                        <br>
                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                <br>
                                <b-button class="btn btn-success" @click="createProduct(); $bvModal.hide('bv-modal-add-product-category'); showProductsWithCurCategory()">Создать</b-button>
                                <b-button class="btn btn-danger" @click="$bvModal.hide('bv-modal-add-product-category')">Отмена</b-button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </b-modal>
</template>

<script>
export default {
    data: () => {
        return {
            product: {
                name: "",
                category_id: 0,
                price: 0,
                description: "",
                photos: []
            }
        }
    },
    computed: {
        final_categories() {
            return this.$store.getters.finalCategories;
        },
        selected_category() {
            return this.$store.getters.selectedCategory;
        }
    },
    methods: {
        createProduct(e) {
            let form = new FormData();
            form.append('name',this.product.name);
            form.append('category_id',this.product.category_id);
            form.append('price',this.product.price);
            form.append('description',this.product.description);
            for (let i = 0; i < this.product.photos.length; i++) {
                form.append('photo[]', this.product.photos[i])
            }
            this.$store.dispatch('createProduct', form);
        },
        uploadFiles(e) {
            this.product.photos = e.target.files;
        },
    },
    watch: {
        selected_category(category) {
            this.product.category_id = category.id;
        }
    }
}
</script>

