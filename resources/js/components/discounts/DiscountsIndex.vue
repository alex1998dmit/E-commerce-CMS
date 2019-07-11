<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <br>
                            <h5>Скидки</h5>
                        </div>
                    </div>
                    <div class="card-body" id="fromCartsContent">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <router-link :to="{name: 'createDiscount'}" class="btn btn-success">Создать новую скидку</router-link>
                            </div>
                        </div>
                        <br>
                        <div class="category-table">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th>Скидка</th>
                                    <th>Редактировать</th>
                                    <th>Удалить</th>

                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="discount, index in discounts">
                                        <td>{{ discount.id }}</td>
                                        <td>{{ discount.name }}</td>
                                        <td>{{ discount.discount }}</td>
                                        <td>
                                            <!-- <b-button v-b-modal.modal-1 v-on:click="openModal(discount)">Открыть модалку</b-button> -->
                                            <b-button id="show-btn" variant="outline-info" @click="$bvModal.show('bv-modal-example'); openModal(discount, index)">Редактировать</b-button>
                                        </td>
                                        <td>
                                            <a href="#"
                                            class="btn btn-xs btn-danger"
                                            v-on:click="deleteEntry(discount.id, index)">
                                                Удалить
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modalWindow :discount="updating_data" :index="index"></modalWindow>
    </div>
</template>

<script>
    import modalWindow from './includes/modalWindow'

    export default {
        components: {
            modalWindow
        },
        data: function () {
            return {
                discounts: [],
                updating_data: {},
                index: 0
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/v1/discounts')
                .then(function (resp) {
                    app.discounts = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Возникла проблемма при загрузке");
                });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Вы уверены что хотите удалить?")) {
                    var app = this;
                    axios.delete('/api/v1/discounts/' + id)
                        .then(function (resp) {
                            app.discounts.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Удаление не удалось");
                        });
                }
            },
            openModal(user, index) {
                this.updating_data = user;
                this.index = index;
            },
        },
        watch: {

        }
    }
</script>
