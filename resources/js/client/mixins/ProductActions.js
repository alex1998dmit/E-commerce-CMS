export const ProductActions = {
    methods: {
      addToShoppingCart (productId) {
        this.$store.dispatch('addToShoppingCart', { product_id: productId })
          .then((resp) => {
            this.flash('Товар добавлен в корзину', 'success', {
              timeout: 2000,
              important: true
            })
          })
          .catch((error) => {
            this.flash('Что-то пошло не так, попробуйте перезагрузить страницу или обратитесь в поддержку', 'danger')
            console.log(error)
          })
      },
      addToWishList (productId) {
        this.$store.dispatch('addToWishList', { product_id: productId })
          .then(resp => {
            this.flash('Товар добавлен в избранное', 'success', {
              timeout: 2000,
              important: true
            })
          })
          .catch((error) => {
            this.flash('Что-то пошло не так, попробуйте перезагрузить страницу или обратитесь в поддержку', 'danger')
            console.log(error)
          })
      },
      removeFromWishList (wishListId, index) {
        this.$store.dispatch('removeFromWishList', { wishListId, index })
          .then((resp) => {
            this.flash('Убрано с избранных', 'warning', {
              timeout: 2000,
              important: true
            })
          })
          .catch(error => {
            this.flash('Что-то пошло не так, попробуйте перезагрузить страницу или обратитесь в поддержку\'', 'danger', {
              important: true
            })
            console.log(error)
          })
      },
      removeFromShoppingCart (cartId, index) {
        this.$store.dispatch('removeFromShoppingCart', { cartId, index })
          .then((resp) => {
            this.flash('Убрано с корзины', 'warning', {
              timeout: 2000,
              important: true
            })
          })
          .catch(error => {
            this.flash('Что-то пошло не так, попробуйте перезагрузить страницу или обратитесь в поддержку\'', 'danger', {
              important: true
            })
            console.log(error)
          })
      },
      isAddedToCart (productId) {
        let productsAtCart = this.$store.getters.shoppingCartItems.map(item => item.product_id)
        return productsAtCart.includes(productId)
      },
      isAddedToWishList (productId) {
        let productsAtList = this.$store.getters.wishListItems.map(item => item.product_id)
        return productsAtList.includes(productId)
      }
    }
  }
