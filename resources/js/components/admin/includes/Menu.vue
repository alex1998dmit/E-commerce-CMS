<template>
    <div>
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Admin panel</h3>
            </div>
            <ul class="list-unstyled components">
                <p>Административая панель</p>
                <li class="active">
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Категория скидок</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <router-link :to="{ name: 'discounts' }">Все скидки</router-link> |
                        </li>
                    </ul>
                </li>
                <li>
                    <router-link :to="{ name: 'users' }">Пользователи</router-link> |
                </li>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Pages</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="#">Page 1</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="list-unstyled CTAs">
            </ul>
        </nav>
    </div>
</template>
<script>
export default {

}
</script>

