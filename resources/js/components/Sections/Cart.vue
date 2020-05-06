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
            <div v-if="isCartNotEmpty">
                <ul v-for="(pizza, key) in $store.state.cart.items" class="list-group list-group-flush">
                    <li v-if="pizza" class="list-group-item">
                        <div class="row">
                            <div class="col-4">
                                <router-link :to="{ name: 'PizzaCard', params: { id: pizza.id } }">
                                    <span class="f-18px">{{pizza.name}}</span>
                                </router-link> ({{pizza.price}} &euro;)
                            </div>
                            <div class="col-4 col-sm-3">
                                <select v-model="pizza.base" class="form-control" title="Base">
                                    <option value="0">Tomato base</option>
                                    <option value="1">Cream base</option>
                                </select>
                            </div>
                            <div class="col-4 col-sm-5 text-right">
                                <a v-on:click="decreasePizza(key)" href="javascript:void(0)">
                                    <span class="font-weight-bold" style="font-size: 20px">-</span>
                                </a>
                                <span style="font-size: 16px">{{pizza.count}}</span>
                                <a v-on:click="increasePizza(key)" href="javascript:void(0)">
                                    <span class="font-weight-bold" style="font-size: 20px">+</span>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-8">
                                <div class="input-group mb-3" style="width: 150px">
                                    <input
                                        v-model="$store.state.cart.coupon.code"
                                        type="text"
                                        class="form-control"
                                        :class="[errorCoupon ? 'is-invalid' : '', couponApplied ? 'is-valid' : '']"
                                        placeholder="Coupon"
                                        aria-describedby="button-coupon"
                                    >
                                    <div class="input-group-append">
                                        <button v-on:click="applyCoupon()" class="btn btn-outline-secondary"
                                                type="button" id="button-coupon">OK
                                        </button>
                                    </div>
                                    <div v-if="errorCoupon" class="invalid-coupon">
                                        Invalid coupon
                                    </div>
                                    <div v-if="couponApplied" class="valid-feedback">
                                        Coupon applied
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 text-right">
                                <span v-if="discountValue">(Discount: {{ discountValue }} &euro;)</span>
                                <strong>Total: </strong><span class="font-weight-bold f-18px">{{total}} &euro;</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div v-else>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">No pizzas</li>
                </ul>
            </div>
        </div>

        <div v-if="isCartNotEmpty" class="card mt-3 pl-4 pr-4 pt-4 pb-1">
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
                                <input v-model="deliveryType" class="form-check-input" type="radio"
                                       name="deliveryRadios" id="deliveryRadio1" value="0" checked>
                                <label class="form-check-label" for="deliveryRadio1">
                                    Delivery
                                </label>
                            </div>
                            <div class="form-check">
                                <input v-model="deliveryType" class="form-check-input" type="radio"
                                       name="deliveryRadios" id="deliveryRadio2" value="1">
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
                            <input v-if="byTime" v-model="deliveryTime" type="text" class="form-control"
                                   style="width: 100px" placeholder="00:00">
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
                firstName: '',
                lastName: '',
                email: '',
                note: '',
                byTime: false,
                deliveryTime: '',
                deliveryType: 0,
				total: 0,
                discountValue: false,
                errorCoupon: false,
            }
        },
        created() {
            this.setCart()
        },
        computed: {
            isCartNotEmpty: function () {
                return this.$store.state.cart.count !== 0;
            },
            couponApplied: function () {
                return this.$store.state.cart.coupon.value !== 0;
            }
        },
        methods: {
            setCart() {
                if (this.isCartNotEmpty) {
                    this.calculateCartTotal();
                }
            },
            getCartItems() {
                return this.$store.state.cart.items;
            },
			increasePizza(id) {
                this.$store.state.cart.items[id].count++;
                this.$store.state.cart.count++;
                this.calculateCartTotal();
			},
			decreasePizza(id) {
                this.$store.state.cart.items[id].count--;
				if (0 === this.$store.state.cart.items[id].count) {
                    this.$store.state.cart.items.splice(id, 1);
				}
                this.$store.state.cart.count--;
                this.calculateCartTotal();
			},
			calculateCartTotal() {
                const items = this.getCartItems();
                this.total = 0;
                for (let item in items) {
                    if (!items.hasOwnProperty(item)) {
                        continue;
                    }
                    this.total += items[item].price * items[item].count;
                }

                if (0 !== this.$store.state.cart.coupon.value) {
                    let coupon = this.$store.state.cart.coupon;
                    this.discountValue = coupon.type ? this.total * coupon.value / 100 : coupon.value;
                    this.total -= this.discountValue;
                    if (this.total < 0) {
                        this.total = 0;
                    }
                }
			},
            clearCoupon() {
                this.discountValue = false;
                this.$store.state.cart.coupon = {
                    value: 0,
                    type: 0,
                    code: '',
                    user: 0,
                };
            },
            applyCoupon() {
                this.errorCoupon = false;
                if ('' !== this.$store.state.cart.coupon.code) {
                    this.postRequest(
                        '/api/apply-discount',
                        {
                            code: this.$store.state.cart.coupon.code
                        },
                        this.discountCallback,
                        this.errorDiscountCallback
                    );
                } else {
                    this.clearCoupon();
                    this.calculateCartTotal();
                }
            },
            discountCallback(response) {
                this.$store.state.cart.coupon = response.data.data[0];
                this.calculateCartTotal();
            },
            errorDiscountCallback(text) {
                this.clearCoupon();
                this.errorCoupon = true;
                this.calculateCartTotal();
            },
            createOrder() {
                if (this.isCartNotEmpty) {
                    this.postRequest(
                        '/api/create-order',
                        {
                            items: this.getCartItems(),
                            coupon: this.$store.state.cart.coupon
                        },
                        this.orderCallback,
                        this.errorOrderCallback
                    );
                }
            },
            orderCallback(response) {
                this.$store.state.cart = {
                    items: [],
                    lastItem: {},
                    count: 0,
                    coupon: {
                        value: 0,
                        type: 0,
                        code: '',
                        user: 0,
                    },
                };
                this.total = 0;
            },
            errorOrderCallback(text) {

            }
        }
    }
</script>
