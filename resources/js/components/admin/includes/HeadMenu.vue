<template>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#"></a>
            </li>
            <li class="nav-item">
                <b-button :to="{ name: 'login' }" variant="success">Вход</b-button>
                <b-button :to="{ name: 'register' }" variant="primary">Регистрация</b-button>
                <!-- <router-link :to="{ name: 'login' }">login</router-link> | -->
            </li>
        </ul>
    </div>
</template>
<script>
export default {

}
</script>
