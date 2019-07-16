<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <b-button v-b-modal.modal-xl variant="primary">Открыть дерево категорий</b-button>
                <b-button v-b-modal.modal-1>Создать категорию</b-button>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-">
                <ul id="level-0">

                </ul>
            </div>
        </div>
        <div class="category-table">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Название</th>
                        <th scope="col">Подкатегории</th>
                        <th scope="col">Удалить</th>
                        <th scope="col">Редактировать</th>
                        <th scope="col">Добавить товар</th>
                    </tr>
                </thead>
                <tbody class="categories_list" id="categories_list">
                    <!-- @foreach ($allCategories  as $category) -->
                    <tr v-for="category in categories" :key="category.id">
                        <td>{{ category.id }}</td>
                        <td>{{ category.name }}</td>
                        <td>
                            <tr v-for="subcategory in category.childs" :key="subcategory.id">
                                <td>{{ subcategory.name }}</td>
                            </tr>
                        </td>
                        <!-- <td><a href="{{ route('category.edit', ['id' => $category->id]) }}" class="btn btn-xs btn-info">Edit</a></td></td> -->
                        <!-- <td><a href="{{ route('category.trash', ['id' => $category->id]) }}" class="btn btn-xs btn-danger">Trash</a></td> -->
                        <!-- <td><a href="" class="btn btn-xs btn-info">Добавить продукт</a></td> -->
                    </tr>
                </tbody>
            </table>
        </div>
        <treeCategories v-if="categories.length > 0" :categories="this.categories"></treeCategories>
        <b-modal id="modal-1" title="Создать категорию">
            <p class="my-4">Новая категория</p>
            <input type="text" v-model="new_category_data.name">
            <input type="text" v-model="new_category_data.parent_id">
            <input type="submit" value="создать" @click="createCategory();">
        </b-modal>
    </div>
</template>
<script>
import treeCategories from './includes/treeCategories';

export default {
    components: {
        treeCategories,
    },
    data: () => {
        return {
            new_category_data: {
                name: "",
                parent_id: 0
            }
        }
    },
    mounted() {
        this.$store.dispatch('getCategories');
    },
    computed: {
        categories() {
            return this.$store.getters.categories;
        }
    },
    methods: {
        buildTree(categories){
            let tag;
            let parent_category;
            let menu = document.getElementById('level-0');
            let add_category_button = "<b-button variant='outline-success'>+</b-button>";
            categories.map(el => {
                parent_category = document.getElementById(`level-${el.parent_id}`);
                tag = (el.childs) ?  `<ul id="level-${el.id}">${el.name} ${add_category_button}</ul>` : `<li id="level-${el.id}">${el.name} ${add_category_button}</li>`;
                parent_category.insertAdjacentHTML('beforeend', `${tag}`);
            });
        },
        createCategory() {
            this.$store.dispatch('createCategories', this.new_category_data);
        }
    }
}
</script>
