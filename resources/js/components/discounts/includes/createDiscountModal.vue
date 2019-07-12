<template>
    <div>
        <b-modal id="create-discount-modal" title="Создать скидку" hide-footer>
                <form action="">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Название скидки</label>
                        <input type="text" class="form-control"  v-model="discount.name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Скидка</label>
                        <input type="text" class="form-control" v-model="discount.discount">
                    </div>
                    <b-button class="mt-3" block variant="outline-success" @click="$bvModal.hide('bv-modal-example'); createDiscount()">Сохранить</b-button>
                    <b-button class="mt-3" block variant="outline-danger" @click="$bvModal.hide('bv-modal-example');">Отмена</b-button>
                </form>
            </b-modal>
        </div>
</template>

<script>

export default {
    data: () => {
        return {
            discount: {
                name: "",
                discount: "",
            }
        }
    },
    methods: {
        createDiscount() {
            event.preventDefault();
            var newDiscount = this.discount;
            console.log(newDiscount);
            axios.post('/api/v1/discounts', newDiscount)
                .then(function (resp) {
                     this.$emit('discounts', newDiscount);
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not create your discount");
                });
        }
    }
}
</script>
