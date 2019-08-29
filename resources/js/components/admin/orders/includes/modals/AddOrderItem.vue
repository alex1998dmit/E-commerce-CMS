<template>
    <b-modal id="add-order-item-module" title="Добавить продукт к заказу" hide-footer>
        <div class="row">
            <div class="col-12">
                <form action="" @submit.prevent="findProducts">
                    <div class="row">
                        <div class="col-5">
                            <input type="text" class="form-control" v-model="search_param" placeholder="Название товара">
                        </div>
                        <div class="col-3">
                            <input type="number" class="form-control" v-model="product.amount" placeholder="Количества товара" min="1">
                        </div>
                        <div class="col-4">
                            <input type="submit" class="btn btn-search" value="Найти" @click="findProducts">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12 text-center" v-if="show_final_switch">
                <h5 class="new-product-sign">{{ product.name }} ({{ product.amount}})</h5>
            </div>
            <div class="col-12">
                <div class="filtered-products" v-if="show_search_results">
                    Выберите продукты:
                    <ul>
                        <li v-for="product in filtered_products" :key="product.id">
                            <a class="chose-product-button" @click="selectProduct(product.id, product.name)">
                                {{ product.name }}
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12">
                <div class="col">
                    <input type="submit" class="btn btn-save" value="Добавить" @click="createOrderItem">
                    <input type="submit" class="btn btn-cancel" value="Отмена" @click="closeModal">
                </div>
            </div>
        </div>
    </b-modal>
</template>

<script>
export default {
    data () {
        return {
            search_param: null,
            product_amount: 0,
            show_search_results: false,
            show_final_switch: false,
            product: {
                id: null,
                name: null,
                amount: 0
            },
            new_product_id: null,
            new_amount_value: null
        }
    },
    props: ['order_index', 'id', 'item_index'],
    computed: {
        filtered_products() {
            return this.$store.getters.filtered_products.byName
        },
        order () {
            return this.$store.getters.selectedOrder
        }
    },
    methods: {
        findProducts () {
            if (this.search_param.length > 3) {
                this.$store.dispatch('getFilteredProducts', this.search_param)
                this.show_final_switch = false
                this.show_search_results = true
            } else {
                alert('Введите больше 3 символов')
                this.show_search_results = false
            }
        },
        selectProduct (product_id, product_name) {
            this.product.id = product_id
            this.product.name = product_name

            this.show_search_results = false
            this.show_final_switch = true
        },
        createOrderItem () {
            this.$store.dispatch('createOrderItem', { order_id: this.order.id, product_id: this.product.id, amount: Number(this.product.amount) })
                .then(resp => {
                    // this.updateInfoAboutOrder()
                    this.closeModal()
                })
                .catch(error => {
                    console.log(error)
                })
        },
        closeModal() {
            this.$bvModal.show('add-order-item-module')
        }
    }
}
</script>

<style scoped>
    ul {
        padding-top: 2%;
    }
    input {
        font-size: 0.8em;
    }
    form {
        padding-bottom: 5%;
    }
    .btn-search {
        border: 0px;
        border-bottom: 2px solid blue;
        border-radius: 0px;
        font-size: 0.9em;
        width: 100%;
    }
    .btn-search:hover {
        border-color: lightblue;
    }
    .btn-save {
        border-radius: 0px;
        border: 0px;
        border-bottom: 2px solid green;
        font-size: 0.9em;
    }
    .btn-save:hover {
        border-color: lightgreen;
    }
    .btn-cancel {
        border: 0px;
        border-radius: 0px;
        border-bottom: 2px solid red;
        font-size: 0.9em;
    }
    .btn-cancel:hover {
        border-color: brown;
    }
    .filtered-products {
        padding-left: 1%;
        padding-top: 2%;
        font-size: 0.9em;
    }
    .new-product-sign {
        padding-top: 3%;
        font-size: 0.9em;
    }
</style>
