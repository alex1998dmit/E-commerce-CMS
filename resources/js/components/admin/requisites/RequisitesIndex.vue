<template>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-6">
                    <h2>Реквизиты</h2>
                </div>
                <div class="col-6 text-right">
                    <router-link class="btn btn-primary" :to="{ name: 'dashboard' }">Главная</router-link>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-6 text-left">
                    <input type="text" class="form-control" placeholder="Поиск по названию реквизита ..." v-model="search_param">
                </div>
                <div class="col-6 text-right">
                    <b-button class="btn btn-success" @click="openCreateModal()">Добавить реквизит</b-button>
                    <router-link class="btn btn-warning" :to="{ name: 'trashedRequisuites' }">Удаленные реквизиты</router-link>
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
                                <th scope="col">Номер реквизита</th>
                                <th scope="col">Подробнее</th>
                                <th scope="col">Редактировать</th>
                                <th scope="col">Товары</th>
                                <th scope="col">Удалить</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(requisite, index) in requisites" :key="requisite.id">
                                <td>{{ requisite.id }}</td>
                                <td>{{ requisite.title }}</td>
                                <td>{{ requisite.requisite }}</td>
                                <td>
                                    <b-button variant="info" @click="openAboutModal(requisite, index)">
                                        Подробнее
                                    </b-button>
                                </td>
                                <td>
                                    <b-button id="show-btn"
                                        variant="primary"
                                        @click="openEditModal(requisite, index)">
                                            Редактировать
                                    </b-button>
                                </td>
                                <td>
                                    <b-button id="users"
                                        variant="success"
                                        @click="openProductsModal(requisite, index)">
                                            Товары
                                    </b-button>
                                </td>
                                <td>
                                    <b-button
                                    variant="danger"
                                    @click="deleteRequisite(requisite, index)">
                                        Удалить
                                    </b-button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <AboutRequisite v-if="this.requisites.length > 0"></AboutRequisite>
    <EditRequisite></EditRequisite>
    <ProductsRequisite v-if="this.requisites.length > 0"></ProductsRequisite>
    <CreateRequisite></CreateRequisite>
</div>
</template>

<script>
import AboutRequisite from './modals/AboutRequisite';
import EditRequisite from './modals/EditRequisite';
import ProductsRequisite from './modals/ProductsRequisite';
import CreateRequisite from './modals/CreateRequisite';

export default {
data() {
    return {
        search_param: null,
    }
},
components: {
    AboutRequisite,
    EditRequisite,
    ProductsRequisite,
    CreateRequisite,
},
computed: {
    requisites: {
        get() {
            return this.$store.getters.requisites;
        },
        set(val) {}
    },
    requisite() {
        return this.$store.getters.seletctedRequisite;
    }
},
mounted() {
    this.$store.dispatch('getRequisites');
    this.$store.dispatch('getProducts');
},
methods: {
    openProductsModal(requisite, index) {
        this.$store.commit("SET_REQUISITE_INDEX", index);
        this.$store.commit("SET_SELECTED_REQUISITE", requisite);
        this.$bvModal.show("requisites-products-modal");
    },
    deleteRequisite(requisite, index) {
        if (confirm("Удалить реквизит и все его упоминания в реквизитах ?")) {
            this.$store.dispatch('trashRequisite', { requisite_id: requisite.id, index })
        }
    },
    openCreateModal(requisite) {
        this.$bvModal.show("create-requisite-modal");
    },
    openEditModal(requisite, index) {
        this.$store.commit("SET_REQUISITE_INDEX", index);
        this.$store.commit("SET_SELECTED_REQUISITE", requisite);
        this.$bvModal.show("edit-requisite-modal");
    },
    openAboutModal(requisite, index) {
        this.$store.commit("SET_REQUISITE_INDEX", index);
        this.$store.commit("SET_SELECTED_REQUISITE", requisite);
        this.$bvModal.show("about-requisite-modal");
    },
}
}
</script>

<style>

</style>
