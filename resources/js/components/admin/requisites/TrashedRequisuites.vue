<template>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-6">
                    <h2>Удаленные реквизиты</h2>
                </div>
                <div class="col-6 text-right">
                    <router-link class="btn btn-primary" :to="{ name: 'dashboard' }">Главная</router-link>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-6 text-left">
                    <input type="text" class="form-control" placeholder="Поиск по удаленным реквизитам ..." v-model="search_param">
                </div>
                <div class="col-6 text-right">
                    <router-link class="btn btn-primary" :to="{ name: 'requisites' }">Все реквизиты</router-link>
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
                                <th scope="col">Восстановить</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(requisite, index) in requisites" :key="requisite.id">
                                <td>{{ requisite.id }}</td>
                                <td>{{ requisite.title }}</td>
                                <td>{{ requisite.requisite }}</td>
                                <td>
                                    <b-button
                                        variant="success"
                                        @click="restoreRequisite(requisite, index)">
                                            Восстановить
                                    </b-button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            search_param: null,
        }
    },
    computed: {
        requisites: {
            get() {
                return this.$store.getters.trashedRequisites;
            },
            set(val) {}
        },
    },
    mounted() {
        this.$store.dispatch('getTrashedRequisites');
    },
    methods: {
        restoreRequisite(requisite, index) {
            if (confirm("Вы уверены что хотите восстанавить реквизит ?")) {
                this.$store.dispatch("restoreTrashedRequisite", { requisite_id: requisite.id, index });
            }
        }
    }
}
</script>

<style>

</style>
