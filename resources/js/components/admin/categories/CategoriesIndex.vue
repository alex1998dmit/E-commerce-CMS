<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <b-button v-b-modal.modal-xl variant="primary">Открыть дерево категорий</b-button>
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
                    <tr>
                        <!-- <td>{{ $category->id }}</td> -->
                        <!-- <td>{{ $category->name }}</td> -->
                        <td>
                            <!-- @foreach($category->childs as $sub_category) -->
                                <!-- {{ $sub_category->name }} -->
                            <!-- @endforeach -->
                        </td>
                        <!-- <td><a href="{{ route('category.edit', ['id' => $category->id]) }}" class="btn btn-xs btn-info">Edit</a></td></td> -->
                        <!-- <td><a href="{{ route('category.trash', ['id' => $category->id]) }}" class="btn btn-xs btn-danger">Trash</a></td> -->
                        <!-- <td><a href="" class="btn btn-xs btn-info">Добавить продукт</a></td> -->
                    </tr>
                </tbody>
            </table>
        </div>
        <treeCategories v-if="categories.length > 0" :categories="this.categories"></treeCategories>
    </div>
</template>
<script>
import treeCategories from './includes/treeCategories';

export default {
    components: {
        treeCategories
    },
    data: () => {
        return {
            categories: [],
        }
    },
    mounted() {
        let app = this;
        axios.get('/api/v1/categories')
            .then((resp) => {
                app.categories = resp.data;
                app.buildTree(resp.data);
            })
            .catch((resp) => {
                console.log(resp);
                alert("Возникла проблемма при загрузке");
            });
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
        }
    }
}
</script>
