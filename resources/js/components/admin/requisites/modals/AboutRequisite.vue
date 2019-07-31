<template>
    <b-modal size="xl" id="about-requisite-modal" title="О реквизите" hide-footer>
        <div class="row">
            <div class="col">
                <h3>{{ requisite.title }}</h3>
            </div>
            <div class="col text-right">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <h4>Общая информация</h4>
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
                            <th scope="col">Реквизит</th>
                            <th scope="col">Описание</th>
                            <th scope="col">Товаров</th>
                            <th scope="col">Дата создания</th>
                            <th scope="col">Дата обновления</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ requisite.id }}</td>
                            <td>{{ requisite.title }}</td>
                            <td>{{ requisite.requisite }}</td>
                            <td>{{ requisite.description }}</td>
                            <td>{{ requisite.products.length }}</td>
                            <td>{{ requisite.created_at }}</td>
                            <td>{{ requisite.updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <h4>Продукция:</h4>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-6">
                <input type="text" class="form-control" v-model="search_param" placeholder="Поиск по названию продукта ...">
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
    </b-modal>
</template>

<script>
export default {
    data() {
        return {
            search_param: "",
        }
    },
    computed: {
        requisite() {
            return this.$store.getters.selectedRequisite;
        },
        products() {
            const requisite_index = this.$store.getters.requisiteIndex;
            if (this.search_param) {
                return this.$store.getters.requisites[requisite_index].products.filter((product) => product.name.toLowerCase().includes(this.search_param.toLocaleLowerCase()));
            }
            return this.$store.getters.requisites[requisite_index].products;
        }
    },
}
</script>

<style>

</style>
