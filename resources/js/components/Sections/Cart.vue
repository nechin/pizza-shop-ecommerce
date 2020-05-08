<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-success">Cart</h5>
                <p class="card-text">
                    Below is what you have selected. Indicate the delivery address and you will have
                    delicious pizza.<br>
                    Delivery cost depends on the total cost of the order without a discount. If the
                    order is more than 15 &euro;, then delivery is free. Otherwise 2 &euro;.<br>
                    If you want to place an order by time, simply indicate the hours and minutes.
                    Delivery takes about an hour. Orders with elapsed time are carried over to the next day.
                </p>
            </div>
        </div>

        <div v-if="confirm" class="alert alert-info mt-3" role="alert">
            Order created. Thank you!
        </div>

        <div class="card mt-4">
            <div class="card-header font-weight-bold">
                Selected pizzas
            </div>
            <div v-if="!isCartEmpty">
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
                        <div v-if="'0' === deliveryType" class="row">
                            <div class="col-8"></div>
                            <div class="col-4 text-right">
                                Delivery: {{deliveryCost}} &euro;
                            </div>
                        </div>
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
                                    <div v-if="errorCoupon" class="invalid-feedback">
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

        <div v-if="error" class="alert alert-danger mt-3" role="alert">
            {{ error }}
        </div>

        <div v-if="!isCartEmpty" class="card mt-3 pl-4 pr-4 pt-4 pb-1">
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
                            <input
                                v-model="email"
                                v-on:keyup="checkEmail"
                                type="email"
                                class="form-control"
                                id="inputEmail"
                                :class="[errorEmail ? 'is-invalid' : '']"
                                required
                            >
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputAddress" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-10">
                        <input
                            v-model="address"
                            v-on:keyup="checkAddress"
                            type="text"
                            class="form-control"
                            id="inputAddress"
                            :class="[errorAddress ? 'is-invalid' : '']"
                            required
                        >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPhone" class="col-sm-2 col-form-label">Phone</label>
                    <div class="col-sm-10">
                        <input
                            v-model="phone"
                            v-on:keyup="checkPhone"
                            type="text"
                            class="form-control"
                            id="inputPhone"
                            :class="[errorPhone ? 'is-invalid' : '']"
                            required
                        >
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
                            <input
                                v-if="byTime"
                                v-model="deliveryTime"
                                type="time"
                                class="form-control"
                                min="09:00"
                                max="21:00"
                                style="width: 100px"
                                placeholder="00:00"
                            >
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
                phone: '',
                email: '',
                address: '',
                errorPhone: false,
                errorAddress: false,
                errorEmail: false,
                note: '',
                byTime: false,
                deliveryTime: '',
                deliveryType: '0',
                deliveryCost: 0,
				total: 0,
                discountValue: false,
                errorCoupon: false,
                error: false,
                confirm: false,
            }
        },
        created() {
            this.setCart()
        },
        computed: {
            isCartEmpty: function () {
                return this.$store.state.cart.count === 0;
            },
            couponApplied: function () {
                return this.$store.state.cart.coupon.value !== 0;
            }
        },
        methods: {
            setCart() {
                if (!this.isCartEmpty) {
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
            moneyFormat(value) {
                value = value * 1;
                return value.toFixed(2) * 1;
            },
			calculateCartTotal() {
                const items = this.getCartItems();
                let pizzaTotal = 0;

                this.total = 0;

                for (let item in items) {
                    if (!items.hasOwnProperty(item)) {
                        continue;
                    }
                    this.total += items[item].price * items[item].count;
                }

                pizzaTotal = this.total;

                if (0 !== this.$store.state.cart.coupon.value) {
                    let coupon = this.$store.state.cart.coupon;
                    this.discountValue = coupon.type ? this.total * coupon.value / 100 : coupon.value;
                    this.discountValue = this.moneyFormat(this.discountValue);
                    this.total -= this.discountValue;
                    if (this.total < 0) {
                        this.total = 0;
                    }
                }

                if ('0' === this.deliveryType) {
                    if (pizzaTotal > 15) {
                        this.deliveryCost = 0;
                    } else {
                        this.deliveryCost = 2;
                        this.total += this.deliveryCost;
                    }
                }

                this.total = this.moneyFormat(this.total);
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
            gerOrderData() {
                return {
                    items: this.getCartItems(),
                    firstName: this.firstName,
                    lastName: this.lastName,
                    phone: this.phone,
                    email: this.email,
                    address: this.address,
                    note: this.note,
                    byTime: this.byTime,
                    deliveryTime: this.deliveryTime,
                    deliveryType: this.deliveryType,
                    discountValue: this.discountValue,
                    total: this.total,
                }
            },
            createOrder() {
                if (this.isCartEmpty) {
                    return false;
                }

                this.checkPhone();
                this.checkAddress();
                this.checkEmail();

                if (!this.isValidAddress()) {
                    return false;
                }

                if (!this.isValidEmail()) {
                    return false;
                }

                this.error = false;
                this.postRequest(
                    '/api/create-order',
                    {
                        data: this.gerOrderData()
                    },
                    this.orderCallback,
                    this.errorOrderCallback
                );
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
                this.confirm = true;
            },
            errorOrderCallback(text) {
                this.error = text;
            },
            checkAddress() {
                this.errorAddress = ('' === this.address);
            },
            isValidAddress() {
                return !this.errorAddress;
            },
            checkPhone() {
                this.errorPhone = ('' === this.phone);
            },
            isValidPhone() {
                return !this.errorPhone;
            },
            checkEmail() {
                if (this.isAuth) {
                    this.errorEmail = false;
                } else {
                    let re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    this.errorEmail = ('' === this.email || !re.test(this.email));
                }
            },
            isValidEmail() {
                return !this.errorEmail;
            }
        },
        watch: {
            deliveryType() {
                if ('1' === this.deliveryType) {
                    this.deliveryCost = 0;
                }
                this.calculateCartTotal();
            }
        }
    }
</script>
