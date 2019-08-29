<template>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 text-left">
                    <h2>Редактирование продукта</h2>
                    <h5>{{ updating_product.name }}</h5>
                </div>
                <div class="col-md-6 text-right">
                    <router-link :to="{ name: 'products' }">
                        <button class="btn navigate-button">Назад</button>
                    </router-link>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <form action="" @submit.prevent="updateProduct">
                        <div class="form-row">
                            <div class="col-md-4">
                                <label for="product_name">Название</label>
                                <input type="text" class="form-control" id="product_name" v-model="updating_product.name">
                            </div>
                            <br>
                            <div class="col-md-4">
                                <label for="exampleInputEmail1">Категория</label>
                                <select name="category_id" id="category" class="form-control" v-model="updating_product.category_id">
                                    <!-- <option value="{{ $product->category->id }}" selected>{{ $product->category->name }}</option> -->
                                    <option v-for="category in final_categories" :key="category.id" v-bind:value="category.id">
                                        {{ category.name }}
                                    </option>
                                </select>
                            </div>
                            <br>
                            <div class="col-md-4">
                                <label for="price">Стоимость</label>
                                <input type="text" class="form-control" id="price" v-model="updating_product.price">
                            </div>
                            <br>
                            <div class="col-md-12">
                                <label for="price">Описание</label>
                                <textarea class="form-control" name="product_desc" id="" cols="30" rows="10" v-model="updating_product.description" ></textarea>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <div class="photo-delete" v-for="(photo) in updating_product.photo" :key="photo.id">
                                    <div
                                        class="image"
                                        :style="{ backgroundImage: 'url(http://passportapi/upload/products/' + photo.path + ')', width: '300px', height: '200px' }"
                                    ><b-button size="sm" variant="danger" @click="removePhoto(photo)">x</b-button></div>
                                </div>
                                <input type="file" class="form-control" ref="file_input" id="attachments" @change="uploadPhotos" multiple>
                            </div>
                            <br>
                            <div class="offset-md-4 col-md-4">
                                <br>
                                <input type="submit" class="btn btn-block btn-success" value="Обновить">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex';
import { deleteProduct } from './mixins/deleteProduct.js';


export default {
    mixins: ["deleteProduct"],
    data: () => {
        return {
            photos : null,
        }
    },
    computed: {
        updating_product: {
            get() {
                return this.$store.getters.updatingProduct;
            },
        },
        final_categories: {
            get() {
                return this.$store.getters.finalCategories;
            }
        },
        product_page () {
            return this.$store.getters.currentProductPage
        },
        products() {
            return this.$store.getters.products
        }
    },
    mounted() {
        const id = this.$route.params.id
        this.getUpdatingProduct(id)
        this.getFinalCategories()
    },
    methods: {
        getUpdatingProduct (id) {
            this.$store.dispatch('getUpdatingProduct', id)
        },
        getFinalCategories() {
            this.$store.dispatch('getFinalCategories')
        },
        addPhoto(path, id) {
            this.photo.push({ path, id });
        },
        addAllPhotoFromStoreToData(photos) {
            this.$data.photos = photos.map((photo) => {
                return { "id": photo.id, "path": photo.path, "product_id": photo.product_id, "checked": true }
            });
        },
        removePhoto(photo) {
            if (confirm("Вы уверены что хотите удалить фото ?")) {
                this.$store.dispatch('removePhotoFromUpdatingProduct', photo.id);
            }
        },
        updateProduct() {
            const id = this.$route.params.id
            const index = this.products.map((product) => product.id).indexOf(id)
            let product = new FormData();
            product.append('name',this.updating_product.name);
            product.append('category_id',this.updating_product.category_id);
            product.append('price',this.updating_product.price);
            product.append('description',this.updating_product.description);
            for (let i = 0; i < this.photos.length; i++) {
                product.append('photo[]', this.photos[i])
            }
            this.$store.dispatch('updateProduct', { id, product, index });
            this.$router.push({ name: 'products', query: { page: this.product_page }});
        },
        uploadPhotos(e) {
            this.photos = e.target.files;
        },
    },
    watch: {
        updating_product(val) {
            this.addAllPhotoFromStoreToData(val.photo);
        },
    }
}
</script>

<style>
    .image {
        float: left;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        border: 1px solid #ebebeb;
        margin: 5px;
    }
    .navigate-button {
        border-radius: 0px;
        border: 0px;
        border-bottom: 2px solid lightblue;
    }
    .navigate-button:hover {
        border-color: blue;
    }
</style>

