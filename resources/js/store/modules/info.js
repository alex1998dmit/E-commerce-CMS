import axios from 'axios'

const state = {
    host: process.env.MIX_APP_URL,
    product_images_folder: 'upload/products'
}

const getters = {
    host (state) {
        return state.host
    }
}

export default {
    namespaced: true,
    state,
    getters
}
