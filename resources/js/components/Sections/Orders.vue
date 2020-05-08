<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-primary">My orders</h5>
                <p class="card-text">Below is a list of your orders</p>
            </div>
        </div>

        <div v-if="loading" class="d-flex justify-content-center m-4">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div v-if="error" class="alert alert-warning mt-3" role="alert">
            {{ error }}
        </div>

        <div v-if="!loading" class="card mt-4">
            <div class="card-header font-weight-bold">
                Orders
            </div>
            <div v-if="orders">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="row font-weight-bold">
                            <div class="col-2">#</div>
                            <div class="col-8">Pizzas</div>
                            <div class="col-2">Total</div>
                        </div>
                    </li>
                </ul>
                <ul v-for="order in orders" class="list-group list-group-flush">
                    <li v-if="order.pizzas" class="list-group-item">
                        <div class="row">
                            <div class="col-2">{{order.id}}</div>
                            <div class="col-8">
                                <div v-for="pizza in order.pizzas">
                                    <router-link :to="{ name: 'PizzaCard', params: { id: pizza.id } }">
                                        {{pizza.name}}
                                    </router-link> ({{pizza.count}})
                                </div>
                            </div>
                            <div class="col-2">
                                <p>{{order.total}} &euro;</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div v-else>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">No orders</li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import global from "../../global"

    export default {
        name: "Orders",
        mixins: [global],
        data() {
            return {
                loading: false,
                error: null,
                orders: null
            };
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                this.$nextTick(function () {
                    this.error = null;
                    this.loading = true;
                    this.postRequest('/api/orders', {}, this.postCallback, this.errorCallback);
                });
            },
            postCallback(response) {
                this.orders = response.data.data;
                this.loading = false;
            },
            errorCallback(text) {
                this.error = text;
                this.loading = false;
            }
        }
    }
</script>
