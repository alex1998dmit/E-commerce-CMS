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
                            <th scope="col">Дата создания</th>
                            <th scope="col">Дата обновления</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ requisite.id }}</td>
                            <td>{{ requisite.title }}</td>
                            <td>{{ requisite.account_num }}</td>
                            <td>{{ requisite.description }}</td>
                            <td>{{ requisite.created_at }}</td>
                            <td>{{ requisite.updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
    </b-modal>
</template>

<script>
export default {
    computed: {
        requisite() {
            return this.$store.getters.selectedRequisite;
        }
    }
}
</script>

<style>

</style>
