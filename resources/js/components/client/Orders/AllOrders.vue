<template>
  <div class="row">
    <div class="col-md text-left">
      <h5>Заказы</h5>
    </div>
    <div class="col-md text-right">
      <button class="btn-requisites" data-toggle="modal" data-target="#exampleModalCenter">Реквизиты</button>
    </div>
    <div class="col-12">
      <div class="table-header">
        <div class="row">
          <div class="col-1 text-center">
            <div class="head-order-id">
              Номер заказа
            </div>
          </div>
          <div class="col-2 text-center">
            <div class="head-order-products">
              Товары
            </div>
          </div>
          <div class="col-2 text-center">
            <div class="order-current-status">
              Статус
            </div>
          </div>
          <div class="col-2 text-center">
            <div class="head-order-date">
              Дата
            </div>
          </div>
          <div class="col-2 text-center">
            <div class="head-order-price">
              Стоимость
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="head-order-buttons">
              Управление
            </div>
          </div>
        </div>
      </div>
      <div class="table-body">
        <div class="row" v-for="(order, index) in orders" :key="index">
          <div class="col-1 text-center">
            <div class="order-id">
              {{ order.id }}
            </div>
          </div>
          <div class="col-2 text-center">
            <div class="order-products">
              <ul>
                <li v-for="(item, index) in order.order_items" :key="index">
                  {{ item.product.name }}
                  <span><div class="amount-items">{{ item.amount }}</div></span>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-2 text-center">
            <div class="order-current-status">
              {{ order.status.name }}
            </div>
          </div>
          <div class="col-2 text-center">
            {{ order.created_at }}
          </div>
          <div class="col-2 text-center">
            {{ order.sum }}
          </div>
          <div class="col-3 text-center">
            <div class="order-buttons">
              <button class="btn btn-table-control" @click="changeOrderStatus(order.id, 2, index)" v-if="order.status_id === 1">Оплачено</button>
              <button class="btn btn-table-control" @click="changeOrderStatus(order.id, 7, index)" v-if="order.status_id === 6">Заказ получен</button>
              <div class="progress" v-if="order.status_id !== 1 && order.status_id !== 6">
                <div class="progress-bar bg-info" role="progressbar" v-bind:style="{width: (100/7) * order.status_id + '%'}"></div>
              </div>
            </div>
          </div>
          <hr>
        </div>
      </div>
    </div>
    <!-- modal window -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Реквизиты для оплаты</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="accordion">
                                <div class="card" v-for="(requisite, index) in requisites" :key="index">
                                    <div class="card-header" :id="`card${requisite.id}`">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" data-toggle="collapse" :data-target="`#collapse${index}`" aria-expanded="true" aria-controls="collapseOne">
                                            {{ requisite.title }}
                                            </button>
                                        </h5>
                                    </div>
                                    <div :id="`collapse${index}`" class="collapse" :aria-labelledby="`card${requisite.id}`" data-parent="#accordion">
                                        <div class="card-body">
                                            <h4>{{ requisite.account_num }}</h4>
                                            <p class="requisite-comment">{{ requisite.description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                        </div>
                </div>
            </div>
            </div>
  </div>
</template>

<script>
export default {
  name: 'AllOrders',
  computed: {
    orders () {
      return this.$store.getters.orders
    },
    requisites () {
      return this.$store.getters.requisites
    }
  },
  mounted () {
    this.$store.dispatch('getOrder')
    this.$store.dispatch('getRequisites')
  },
  methods: {
    aboutOrder (orderId, statusId) {
      this.$router.push({name: 'order', params: { id: orderId }})
    },
    changeOrderStatus (orderId, statusId, index) {
      if (confirm('Вы подтверждаете, что оплатили товар ?')) {
        this.$store.dispatch('changeOrderStatus', {orderId, statusId, index})
          .then(resp => {
            this.flash('Заявка принята, идет проверка', 'success', {
                timeout: 2000,
                important: true
            })
          })
          .catch(error => {
            this.flash('Что-то пошло не так, попробуйте позже или позвоните в поддержку', 'danger', {
                timeout: 2000,
                important: true
            })
            console.log('error', error)
          })
      }
    }
  }
}
</script>

<style scoped>
  .order-products ul {
    list-style-type: none;
    padding: 0px;
  }
  .table-header {
    padding: 0;
    padding-top: 5%;
    font-size: 0.9em;
    color: #333;
    font-weight: 600;
    margin-bottom: 3%;
  }
  .table-body {
    font-size: 0.8em;
  }
  .order-buttons button {
    width: 100%;
    height: 40px;
    background-color: white;
    color: #333;
    border: 2px solid #333;
    font-size: 14px;
    border-radius: 0px;
  }
  .amount-items {
    color: white;
    background-color: grey;
    border-radius: 50px;
    font-size: 0.7em;
    padding: 3px;
    display: inline-block;
    width: 20px;
    height: 20px;
  }
  .btn-table-control {
    margin-bottom: 3%;
  }
  .btn-table-requisites {
    color: white;
    background-color: black;
  }
  .btn-table-requisites:hover {
    color: black;
    background-color: white;
  }
  .btn-requisites {
    width: 50%;
    height: 40px;
    background-color: white;
    color: #333;
    border: 2px solid #333;
    font-size: 14px;
    border-radius: 0px;
  }
  .btn-requisites:hover {
    background-color: #333;
    color: white;
    border-color: white;
  }
</style>
