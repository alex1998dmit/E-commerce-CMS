<template>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-6">
                    <h2>Реквизиты</h2>
                </div>
                <div class="col-6 text-right">
                    <!-- <router-link class="btn btn-back" :to="{ name: 'dashboard' }">Главная</router-link> -->
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-6 text-left">
                    <!-- <input type="text" class="form-control" placeholder="Поиск по названию реквизита ..." v-model="search_param"> -->
                </div>
                <div class="col-6 text-right">
                    <button class="btn btn-add" @click="openCreateModal()">Добавить реквизит</button>
                    <router-link class="btn btn-trashed" :to="{ name: 'trashedRequisuites' }">Удаленные реквизиты</router-link>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">ID</th>
                                <th scope="col" class="text-center">Название</th>
                                <th scope="col" class="text-center">Реквизит</th>
                                <th scope="col">Отображать</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(requisite, index) in requisites" :key="requisite.id">
                                <td class="text-center">{{ requisite.id }}</td>
                                <td class="text-center">{{ requisite.title }}</td>
                                <td class="text-center">{{ requisite.account_num }}</td>
                                <td class="text-center">
                                    <input type="checkbox" class="form-control" v-model="requisite.is_selected" @change="checkRequisite(requisite.is_selected, requisite.id, index)">
                                </td>

                                <td class="text-center" colspan="1">
                                    <a
                                        class="view-icon"
                                        @click="openAboutModal(requisite, index)">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td class="text-center" colspan="1">
                                    <a class="edit-icon" @click="openEditModal(requisite, index)">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td class="text-center trash-icon" colspan="1">
                                    <a
                                        class="trash-icon"
                                        @click="deleteRequisite(requisite, index)">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <AboutRequisite v-if="this.requisites.length > 0"></AboutRequisite>
    <EditRequisite></EditRequisite>
    <CreateRequisite></CreateRequisite>
</div>
</template>

<script>
import AboutRequisite from './modals/AboutRequisite';
import EditRequisite from './modals/EditRequisite';
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
        this.$store.commit("SET_SELECTED_REQUISITE", requisite);
        this.$bvModal.show("edit-requisite-modal");
    },
    openAboutModal(requisite, index) {
        this.$store.commit("SET_SELECTED_REQUISITE", requisite);
        this.$bvModal.show("about-requisite-modal");
    },
    checkRequisite (is_selected, requisite_id, index) {
        this.$store.dispatch('updateRequisite', { requisite: { is_selected }, requisite_id, index })
    }
}
}
</script>

<style scoped>
.trash-icon {
    color: red;
}
.btn-add, .btn-trashed {
    background-color: transparent;
    border: 0px;
    border-radius: 0px;
    border-bottom: 2px solid lightgrey;
}
.btn-add {
    border-color: lightgreen;
}
.btn-trashed {
    border-color: lightcoral;
}
.btn-add:hover {
    border-color: green;
}
.btn-trashed:hover {
    border-color: red;
}
</style>
