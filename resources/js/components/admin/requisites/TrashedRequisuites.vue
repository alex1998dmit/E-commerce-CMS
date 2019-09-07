<template>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-6">
                    <h2>Удаленные реквизиты</h2>
                </div>
                <div class="col-6 text-right">
                    <!-- <router-link class="btn btn-primary" :to="{ name: 'dashboard' }">Главная</router-link> -->
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-6 text-left">
                    <!-- <input type="text" class="form-control" placeholder="Поиск по удаленным реквизитам ..." v-model="search_param"> -->
                </div>
                <div class="col-6 text-right">
                    <router-link class="btn btn-requisites" :to="{ name: 'requisites' }">Все реквизиты</router-link>
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
                                <th scope="col" class="text-center">Номер реквизита</th>
                                <th scope="col" class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(requisite, index) in requisites" :key="requisite.id">
                                <td class="text-center">{{ requisite.id }}</td>
                                <td class="text-center">{{ requisite.title }}</td>
                                <td class="text-center">{{ requisite.account_num }}</td>
                                <td class="text-center restore-icon">
                                    <button class="btn btn-restore" @click="restoreRequisite(requisite, index)">Восстанавить</button>
                                    <!-- <i class="fa fa-floppy-o" aria-hidden="true"></i> -->
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

<style scoped>
.btn-requisites {
    border: 0px;
    border-radius: 0px;
    border-bottom: 2px solid lightblue;
}
.btn-requisites:hover {
    border-color: blue;
}
.btn-restore {
    /* border: 0px; */
    border-radius: 0px;
    border: 2px solid lightgreen;
    font-size: 0.8em;
}
.btn-restore:hover {
    border-color: green;
}
</style>
