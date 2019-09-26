<template>
<table class="table">
    <thead>
        <tr>
            <th scope="col" class="text-center">ID</th>
            <th scope="col" class="text-center">Название</th>
            <th scope="col" class="text-center">Реквизит</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="(requisite, index) in requisites" :key="index">
            <td class="text-center">{{ requisite.id }}</td>
            <td class="text-center">{{ requisite.title }}</td>
            <td class="text-center">{{ requisite.account_num }}</td>
        </tr>
    </tbody>
</table>
</template>

<script>
export default {
    props: {
        requisites: Array
    }
}
</script>

<style>

</style>
