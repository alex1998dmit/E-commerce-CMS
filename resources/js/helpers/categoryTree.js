export function generateArrayOfCategoriesTree(categories) {
    let categoriesWithChilds = categories.map(el => {
        el.childs = findChildsWithId(el.id, categories);
        return el;
    });
    let sortedCategoriesWithChilds = categoriesWithChilds.filter(el => {
        if (el.parent_id === 0) {
            return el;
        }
    })
    return sortedCategoriesWithChilds;
}

function findChildsWithId(id, categories) {
    return categories.filter(el => {
        if (el.parent_id === id) {
            return el;
        }
    })
}
