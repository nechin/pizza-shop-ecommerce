<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-success">Cart</h5>
                <p class="card-text">Below is what you have selected. Indicate the delivery address and you will have delicious pizza.</p>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header font-weight-bold">
                Selected pizzas
            </div>
            <div v-if="isCartItems">
                <ul v-for="(pizza, key) in pizzas" class="list-group list-group-flush">
                    <li v-if="pizza" class="list-group-item">{{pizza.name}} - {{pizza.count}}</li>
                </ul>
            </div>
            <div v-else>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">No pizzas</li>
                </ul>
            </div>
        </div>

        <div v-if="isCartItems" class="card mt-3 pl-4 pr-4 pt-4 pb-1">
            <form>
                <div v-if="!isAuth">
                    <div class="form-group row">
                        <label for="firstName" class="col-sm-2 col-form-label">First name</label>
                        <div class="col-sm-10">
                            <input v-model="firstName" type="text" class="form-control" id="firstName">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lastName" class="col-sm-2 col-form-label">Last name</label>
                        <div class="col-sm-10">
                            <input v-model="lastName" type="text" class="form-control" id="lastName">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input v-model="email" type="email" class="form-control" id="inputEmail">
                        </div>
                    </div>
                </div>
                <fieldset class="form-group">
                    <div class="row">
                        <legend class="col-form-label col-sm-2 pt-0">Delivery type</legend>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input v-model="deliveryType" class="form-check-input" type="radio" name="deliveryRadios" id="deliveryRadio1" value="0" checked>
                                <label class="form-check-label" for="deliveryRadio1">
                                    Delivery
                                </label>
                            </div>
                            <div class="form-check">
                                <input v-model="deliveryType" class="form-check-input" type="radio" name="deliveryRadios" id="deliveryRadio2" value="1">
                                <label class="form-check-label" for="deliveryRadio2">
                                    Pickup
                                </label>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="form-group row">
                    <div class="col-sm-2">Order by time</div>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input v-model="byTime" class="form-check-input" type="checkbox">
                            <input v-if="byTime" v-model="deliveryTime" type="text" class="form-control" style="width: 100px" placeholder="00:00">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="noteTextarea">Additional information</label>
                    <textarea v-model="note" class="form-control" id="noteTextarea" rows="3"></textarea>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button v-on:click="createOrder" type="button" class="btn btn-primary">Create order</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import global from "../../global";

    export default {
        name: "Cart",
        mixins: [global],
        data() {
            return {
                pizzas: [],
                firstName: '',
                lastName: '',
                email: '',
                note: '',
                byTime: false,
                deliveryTime: '',
                deliveryType: 0
            }
        },
        created() {
            this.setCart()
        },
        computed: {
            isCartItems: function () {
                return this.$store.state.cart.items.length !== 0;
            }
        },
        methods: {
            setCart() {
                if (this.isCartItems) {
                    const items = this.$store.state.cart.items;
                    for (let item in items) {
                        if (!items.hasOwnProperty(item)) {
                            continue;
                        }
                        if (typeof this.pizzas[items[item].id] === 'undefined') {
                            let pizzaItem = items[item];
                            pizzaItem.count = 1;
                            this.pizzas[items[item].id] = pizzaItem;
                        } else {
                            this.pizzas[items[item].id].count++;
                        }
                    }
                }
            },
            createOrder() {

            }
        }
    }
</script>
