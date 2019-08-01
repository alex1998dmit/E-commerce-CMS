<template>
    <b-modal id="requisites-products-modal" size="xl" title="Информация о продуктах" hide-footer>
        <div class="row">
            <div class="col">
                <h3>Товары с реквизитом {{ requisite.title }}</h3>
            </div>
            <div class="col text-right">
                <b-button variant="success" @click="openAddProductToRequisite">Добавить товар</b-button>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-6">
                <input type="text" class="form-control" v-model="search_param" placeholder="Поиск по товарам ...">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Название</th>
                            <th scope="col">Категория</th>
                            <th scope="col">Стоимость</th>
                            <th scope="col">Описание</th>
                            <th scope="col">Дата добавления</th>
                            <th scope="col">Дата обновления</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products" :key="product.id">
                            <td>{{ product.id }}</td>
                            <td>{{ product.name }}</td>
                            <td>{{ product.category }}</td>
                            <td>{{ product.price }}</td>
                            <td>{{ product.description }}</td>
                            <td>{{ product.created_at }}</td>
                            <td>{{ product.updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <AddProductToRequisite></AddProductToRequisite>
    </b-modal>
</template>

<script>
import AddProductToRequisite from './AddProductToRequisite';

export default {
    data() {
        return {
            search_param: "",
        }
    },
    components: {
        AddProductToRequisite,
    },
    computed: {
        requisite() {
            return this.$store.getters.selectedRequisite;
        },
        index() {
            return this.$store.getters.requisiteIndex;
        },
        products() {
            const requisite_index = this.$store.getters.requisiteIndex;
            if (this.search_param) {
                console.log(this.search_param);
                console.log(this.$store.getters.requisites[requisite_index].products);
                return this.$store.getters.requisites[requisite_index].products.filter((product) => product.name.toLowerCase().includes(this.search_param.toLocaleLowerCase()));
            }
            return this.$store.getters.requisites[requisite_index].products;
        }
    },

    methods: {
        closeModal() {
            this.$bvModal.hide("requisites-products-modal");
        },
        openAddProductToRequisite() {
            this.$bvModal.show("add-product-requisite");
        }
    }
}
</script>

<style>

</style>
