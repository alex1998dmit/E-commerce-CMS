<template>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <h2>Добавить продукт</h2>
                    <br>
                </div>
                <div class="col-md-6 text-right">
                    <router-link :to="{ name: 'products' }">
                        <button class="btn navigate-button">Назад</button>
                    </router-link>
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                  <form action="" id="createProductForm" @submit.prevent="createProduct">
                        <div class="form-row">
                            <div class="col-md-4">
                                <label for="product_name">Название</label>
                                <input type="text" class="form-control" id="product_name" v-model="product.name">
                            </div>
                            <br>
                            <div class="col-md-4">
                                <label for="exampleInputEmail1">Категория</label>
                                <select name="category_id" id="category" class="form-control" v-model="product.category_id">
                                    <option v-for="category in final_categories" :key="category.id" v-bind:value="category.id">
                                        {{ category.name }}
                                    </option>
                                </select>
                            </div>
                            <br>
                            <div class="col-md-4">
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
                            <div class="offset-md-4 col-md-4">
                                <br>
                                <input type="submit" class="btn btn-block btn-outline-success" value="Создать">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: () => {
        return {
            product: {
                name: "",
                category_id:0,
                price: 10000,
                description: "",
                photos: []
            },
            attachments: [],
        }
    },
    computed: {
        final_categories() {
            return this.$store.getters.finalCategories;
        }
    },
    mounted() {
        this.$store.dispatch('getFinalCategories');
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
            this.$store.dispatch('createProduct', form)
            this.$router.push({ name: "products" })
        },
        uploadFiles(e) {
            this.product.photos = e.target.files;
        },
    }
}
</script>
<style scoped>
    .navigate-button {
        border-radius: 0px;
        border: 0px;
        border-bottom: 2px solid lightblue;
    }
    .navigate-button:hover {
        border-color: blue;
    }
</style>
