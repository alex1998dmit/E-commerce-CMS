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
                    <b-button class="mt-3" block variant="outline-success" @click="$bvModal.hide('create-discount-modal'); createDiscount()">Сохранить</b-button>
                    <b-button class="mt-3" block variant="outline-danger" @click="$bvModal.hide('create-discount-modal');">Отмена</b-button>
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
            let app = this;
            var newDiscount = this.discount;
            axios.post('/api/v1/discounts', newDiscount)
                .then(function (resp) {
                     app.$parent.discounts.push(resp.data);
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not create your discount");
                });
        }
    }
}
</script>
