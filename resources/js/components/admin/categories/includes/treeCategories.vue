<template>
    <div>
        <b-modal id="modal-xl" size="xl" title="Дерево категорий">
            <div class="row" v-if="inputField">
                <div class="col-md-12">
                     <!-- <h5>Добавить категорию к </h5> -->
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" v-model="new_category.name" :placeholder="parent_category_name">
                </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-success" @click="addCategory()">Добавить</button>
                    <button type="button" class="btn btn-danger" @click="hideInput()">Отмена</button>
                </div>
            </div>
            <br>
            <li v-for="category in categoryTree">
                {{ category.name }}
                <button type="button" class="btn btn-success btn-sm" @click="updateCategories(category)">+</button>
                <button type="button" class="btn btn-warning btn-sm">+ продукт</button>
                <childCategories v-if="category.childs.length > 0" :childs="category.childs" @update="updateCategories"></childCategories>
            </li>
        </b-modal>
    </div>
</template>
<script>

import childCategories from './childCategories.vue';

export default {
    components: {
        childCategories
    },
    props: {
        categories: Array,
    },
    data: () => {
        return {
            categoryTree: [],
            allCategories: [],
            inputField: false,
            parent_category_name: "",
            new_category: {
                parent_id: 0,
                name: "",
            }
        }
    },
    mounted() {
        this.buildTree();
    },
    methods: {
        buildTree() {
            this.allCategories = this.categories;
            let categories = this.allCategories;
            let categoriesWithChilds = categories.map(el => {
                el.childs = this.findChildsWithId(el.id);
                return el;
            });
            let sortedCategoriesWithChilds = categoriesWithChilds.filter(el => {
                if (el.parent_id === 0) {
                    return el;
                }
            })
            this.categoryTree = sortedCategoriesWithChilds;
        },
        addNewCategoryToTreeState() {

        },
        hideInput() {
            this.inputField = !this.inputField;
            this.new_category.name = "";
            this.new_category.parent_id = 0;
        },
        addCategory() {
            let app = this;
            axios.post('/api/v1/categories', this.new_category)
                .then((resp) => {
                    this.allCategories.push(resp.data);
                    app.buildTree();
                    this.hideInput();
                })
                .catch((resp) => {
                })
        },
        // utils
        findChildsWithId (id) {
            return this.categories.filter(el => {
                if (el.parent_id === id) {
                    return el;
                }
            })
        },
        updateCategories(category) {
            this.inputField = true;
            this.new_category.parent_id = category.id;
            this.parent_category_name = category.name;
        },
    }
}
</script>
