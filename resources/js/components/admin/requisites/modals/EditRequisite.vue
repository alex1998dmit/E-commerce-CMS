<template>
    <b-modal id="edit-requisite-modal" title="Редактировать реквизит" hide-footer>
        <div class="row">
            <div class="col">
                <form action="" @submit.prevent="updateRequisite(); closeModal();">
                    <div class="form-group">
                        <label for="">Название</label>
                        <input type="text" class="form-control" v-model="requisite.title">
                    </div>
                    <div class="form-group">
                        <label for="">Номер реквизита</label>
                        <input type="text" class="form-control" v-model="requisite.account_num">
                    </div>
                    <div class="form-group">
                        <label for="">Описание</label>
                        <textarea class="form-control" cols="30" rows="10" v-model="requisite.description"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" value="Обновить">
                    </div>
                </form>
            </div>
        </div>
    </b-modal>
</template>

<script>

export default {
    computed: {
        requisite() {
            return this.$store.getters.selectedRequisite
        },
        requisites () {
            return this.$store.getters.requisites
        }
    },
    methods: {
        closeModal() {
            this.$bvModal.hide("edit-requisite-modal");
        },
        updateRequisite() {
            const index = this.requisites.map((requisite) => requisite.id).indexOf(this.requisite.id)
            const updating_requisite = {
                title: this.requisite.title,
                account_num: this.requisite.account_num,
                description: this.requisite.description
            };
            this.$store.dispatch('updateRequisite', { requisite: updating_requisite, requisite_id: this.requisite.id, index });
        },
    }
}
</script>

<style>

</style>
