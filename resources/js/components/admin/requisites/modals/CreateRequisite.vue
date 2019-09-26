<template>
    <b-modal id="create-requisite-modal" title="Добавить реквизит" hide-footer>
        <div class="row">
            <div class="col">
                <form action="" @submit.prevent="createRequisite(); closeModal();">
                    <div class="form-group">
                        <label for="">Название</label>
                        <input type="text" class="form-control" v-model="requisite.title">
                    </div>
                    <div class="form-group">
                        <label for="">Номер реквизита</label>
                        <input type="text" class="form-control" v-model="requisite.account_num">
                    </div>
                    <div class="form-group">
                        <label for="">Комментарий</label>
                        <textarea class="form-control" cols="30" rows="10" v-model="requisite.description"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" value="Создать">
                    </div>
                </form>
            </div>
        </div>
    </b-modal>
</template>

<script>
export default {
    data() {
        return {
            requisite: {
                title: "",
                account_num: "",
                description: "",
            }
        }
    },
    methods: {
        createRequisite() {
            this.$store.dispatch("createRequisite", this.requisite);
        },
        closeModal() {
            this.$bvModal.hide("create-requisite-modal");
        },

    }
}
</script>

<style>

</style>
