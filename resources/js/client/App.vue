<template>
  <div id="app">
    <div class="container">
      <Head></Head>
      <div class="ecommerce-content">
          <div class="row">
          <div class="col-md-6 text-left">
            <div class="head-title">
              <h2>Интернет-магазин</h2>
            </div>
          </div>
            <div class="col-md-6">
              <div class="message">
                <flash-message class="myCustomClass"></flash-message>
              </div>
            </div>
        </div>
          <div class="row">
            <!-- Left Menu -->
            <div class="col-md-3 text-left">
              <LeftMenu></LeftMenu>
            </div>
            <!--  Products -->
          <div class="col-md-9">
            <div class="content">
              <hr>
              <router-view/>
            </div>
          </div>
        </div>
          <hr>
          <div class="row">
            <Footer></Footer>
          </div>
      </div>
    </div>
  </div>
</template>

<script>
import Head from '../components/client/Menu/Head'
import LeftMenu from '../components/client/Menu/LeftMenu'
import Footer from '../components/client/Menu/Footer'

export default {
  name: 'App',
  components: {
    Head, LeftMenu, Footer
  },
  mounted () {
    this.$store.dispatch('getCategories')
    if (this.$store.getters.isLoggedIn) {
      this.$store.dispatch('getShoppingCart')
      this.$store.dispatch('getWishList')
    }
  }
}
</script>

<style scoped>
  .content {
    margin-top: -16px;
  }
  .message {
    padding-top: 5%;
  }
  .products-content {
  padding-top: 3%;
  }

  /* Head */
  .navbar-head {
    border-bottom: 1px solid #e8e8e8;
  }

  .search input {
    background: transparent;
    border: 0;
    padding: 8px;
    border-radius: 0;
    font-size: 0.9rem;
    font-weight: 400;
    line-height: 1.5;
    padding-left: 10%;
  }

  .search button {
    font-size: 0.8rem;
  }

  .logout-sign {
    color: #333;
    font-size: 0.9rem;
    font-weight: 400;
  }

  .head-nav-icon-sign {
    font-size: 0.8em;
    padding-left: 10%;
    font-family: Arial, Helvetica, Verdana, sans-serif;
  }

  /* Head Titel*/

  .head-title {
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 100px;
    padding-left: 40px;
  }

  /* Left Nav*/

  .nav-left-menu ul {
    list-style-type: none;
  }

  .nav-left-menu-item {
    border-top: 1px solid #e8e8e8;
    border-bottom: 1px solid #e8e8e8;
  }
  .nav-link {
    padding: 12px 0;
    display: block;
    width: 100%;
    padding: 9px 0;
    font-size: 16px;
    color: #333;
  }

  /* Products */

  .products-content {
    margin-top: -16px;
  }

  .categories-path-sign {
    padding: 0;
    margin: -10px 0 10px;
    font-size: 13.5px;
    line-height: 24px;
  }

  .product-filter select {
    -webkit-appearance: none;
    appearance: none;
    background-image: url(//cdn.shopify.com/s/files/1/0037/5472/t/18/assets/ico-select.svg?8);
    background-repeat: no-repeat;
    background-position: right 10px center;
    padding-right: 28px;
    text-indent: 0.01px;
    text-overflow: '';
    cursor: pointer;
    border-radius: 0;
    background-color: #f4f4f4;
    border: 0;
    font-size: 15px;
    font-style: normal;
    font-weight: 400;
    color: #333;
    line-height: 1.6;
    padding: 5px 39px 5px 15px;
  }

  .image img {
    width: 80%;
    heigt: auto;
  }

  .product-card {
    padding-top: 5%;
  }

  .product-card .description a {
    color: #333;
    text-decoration: none;
    font-size: 15px;
    font-family: Helvetica,"Helvetica Neue",Arial,"Lucida Grande",sans-serif;
    font-style: normal;
    font-weight: 400;
  }

  .product-menu-price {
    font-family: "Times New Roman",Times,serif;
    font-weight: 400;
    font-style: normal;
    text-rendering: optimizeLegibility;
    font-size: 15px;
  }

  .product-info-card {
    padding-top: 10%;
  }

  .show-all-products-button {
    border-radius: 0;
    background-color: #f4f4f4;
    border: 0;
    font-size: 15px;
    font-style: normal;
    font-weight: 400;
    color: #333;
    line-height: 1.6;
  }

  .show-all-products-button:hover {
    color: white;
    background-color: #333;
  }

  .show-all-products {
    padding-top: 3%;
  }

  .category-products-block {
    padding-top: 5%;
  }

  .pagination-block {
    padding-top: 10%;
  }

  /* FOTTER */

  footer ul {
    list-style-type: none;
    margin: 0;
    padding-top: 3%;
    padding-left: 0;
  }

  footer li a {
    color: #333;
    text-decoration: none;
    font-size: 13px;
  }

  .copyright a {
    color: #333;
    font-size: 10px;
  }

</style>
