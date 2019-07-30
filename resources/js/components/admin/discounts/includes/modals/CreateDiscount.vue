<template>
    <b-modal id="create-discount-modal" title="Создать новую категорию скидок" hide-footer>
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <form action="" @submit.prevent="create(); closeModal()">
                            <div class="form-group">
                                <label for="">Название</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Размер скидки</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Описание</label>
                                <textarea name="" id="" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" value="Создать">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </b-modal>
</template>

<script>
export default {
    data() {
        return {
            name: "",
            discount: 0,
            description: "",
        }
    },
    methods: {
        create() {

        },
        closeModal() {

        }
    }
}
</script>

<style>

</style>
