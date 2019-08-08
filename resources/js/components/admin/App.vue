<template>
    <div class="wrapper">
        <!-- Sidebar  -->
        <Menu></Menu>

        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Свернуть/Развернуть</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>
                    <head-menu></head-menu>
                </div>
            </nav>
            <div class="container">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>
<script>
    import Menu from './includes/Menu.vue'
    import HeadMenu from './includes/HeadMenu'

    export default {
        name: 'app',
        components: {
            Menu, HeadMenu
        },
        mounted() {
            this.$store.dispatch('getOrderNotifications');
        },
        computed: {
            isLoggedIn() {
                return this.$store.getters.isLoggedIn;
            }
        },
    }
</script>
