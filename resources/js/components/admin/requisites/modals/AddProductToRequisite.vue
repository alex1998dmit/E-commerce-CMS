<template>
    <b-modal id="add-product-requisite" title="Добавить продукт" hide-footer>
        <div class="row">
            <div class="col">
                <h4>{{ requisite.title }}</h4>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <label>Выберите продукт</label>
                <input type="text" class="form-control" v-model="search_param">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <ul>
                    <li v-for="product in products" :key="product.id">
                        {{ product.name }} - {{ product.category.name }}
                        <b-button
                            v-if="!checkRequisiteAtProduct(product)"
                            size="sm"
                            variant="success"
                            @click="addProduct(product)">
                                +
                        </b-button>
                        <b-button
                            v-if="checkRequisiteAtProduct(product)"
                            size="sm"
                            variant="light">
                                ✔
                        </b-button>
                    </li>
                </ul>
            </div>
        </div>
    </b-modal>
</template>

<script>
export default {
    data() {
        return {
            search_param: null,
        }
    },
    computed: {
        index() {
            return this.$store.getters.requisiteIndex;
        },
        products() {
            if (this.search_param) {
                return this.$store.getters.products.filter(product => product.name.toLowerCase().includes(this.search_param.toLocaleLowerCase()));
            }
            return [];
        },
        requisite() {
            return this.$store.getters.selectedRequisite;
        }
    },
    methods: {
        closeModal() {
            this.search_param = null;
            this.$bvModal.hide("add-product-requisite");
        },
        checkRequisiteAtProduct(product) {
            if (product.requisites.filter(requisite => requisite.id === this.requisite.id).length > 0) {
                return true;
            }
            return false;
        },
        addProduct(product) {
            const product_index = this.$store.getters.products.map((el) => el.id).indexOf(product.id);
            this.$store.dispatch('createProductRequisite', { requisite_id: this.requisite.id, product_id: product.id, requsite_index: this.index, product_index });
        }
    }
}
</script>

<style>

</style>
