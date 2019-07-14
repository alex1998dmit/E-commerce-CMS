<template>
    <div>
        <b-modal id="modal-xl" size="xl" title="Дерево категорий">
            <li v-for="category in categoryTree">
                {{ category.name }}
                <childCategories v-if="category.childs.length > 0" :childs="category.childs"></childCategories>
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
            categoryTree: Array,
        }
    },
    mounted() {
        let categories = this.categories;
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
    methods: {
        findChildsWithId (id) {
            return this.categories.filter(el => {
                if (el.parent_id === id) {
                    return el;
                }
            })
        }
    }
}
</script>
