<template>
    <div>
        <b-modal id="bv-modal-example" title="Редактирование" hide-footer>
                <form action="">
                    <div class="form-group">
                        <label for="exampleInputEmail1">ID</label>
                        <input type="text" class="form-control" v-model="discount.id" disabled>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Название скидки</label>
                        <input type="text" class="form-control"  v-model="discount.name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Скидка</label>
                        <input type="text" class="form-control" v-model="discount.discount">
                    </div>
                    <b-button class="mt-3" block variant="outline-success" @click="$bvModal.hide('bv-modal-example'); updateDiscount()">Сохранить</b-button>
                    <b-button class="mt-3" block variant="outline-danger" @click="$bvModal.hide('bv-modal-example'); $parent.deleteEntry(discount.id, index)">Удалить</b-button>
                </form>
            </b-modal>
        </div>
</template>

<script>

export default {
    props: {
        discount: Object,
        index: Number
    },
    methods: {
        updateDiscount() {
            event.preventDefault();
            axios.put('/api/v1/discounts/' + this.discount.id, this.discount)
            .then((resp) => {
                console.log(resp);
            })
            .catch((resp)=>{
                alert('something gone wrong');
                console.log(resp);
            })
        },
        deleteDiscount(id, index) {

        },
    }
}
</script>
