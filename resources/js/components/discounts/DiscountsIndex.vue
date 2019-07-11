<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'createDiscount'}" class="btn btn-success">Создать новую скидку</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Discounts list</div>
            <div class="panel-body">
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
                                <router-link :to="{name: 'editDiscount', params: {id: discount.id}}" class="btn btn-xs btn-info">
                                    Редактировать
                                </router-link>
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
</template>

<script>
    export default {
        data: function () {
            return {
                discounts: []
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
                    alert("Could not load discount");
                });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/v1/discounts/' + id)
                        .then(function (resp) {
                            app.discounts.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete discount");
                        });
                }
            }
        }
    }
</script>
