<template>
    <div class="row">
        <div class="col-md-12">
            <form action="">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" v-model="form.email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="password" v-model="form.password" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" value="login">
                </div>
            </form>
        </div>
    </div>

</template>

<script>
export default {
    name: "login",
    data() {
        return {
            form: {
                email: "",
                password: "",
                grant_type: this.$store.state.welcome,
                client_id: this.$store.state.client_id,
                client_secret: this.$store.state.client_secret,
            }
        }
    },
    mounted() {
        console.log(this.form);
    },
    methods: {
        autheticate() {
            this.$store.dispatch('login');
            axios('oauth/token', this.form)
                .then((resp) => {
                    console.log(resp);
                })
                .catch((resp) => {
                    console.log('error', resp);
                });
        }
    }
}
</script>
