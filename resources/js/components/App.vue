<template>
    <div class="container">
        <div class="row justify-content-between pt-2">
            <div class="col-8">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <router-link :to="{ name: 'home' }" active-class="active" class="nav-item nav-link text-dark pr-3" exact>
                                Home
                            </router-link>
                            <router-link :to="{ name: 'pizza' }" active-class="active" class="nav-item nav-link text-dark pr-3">
                                Pizza
                            </router-link>
                            <router-link v-if="isAuth" :to="{ name: 'orders' }" active-class="active" class="nav-item nav-link text-dark">
                                My orders
                            </router-link>
                            <router-link :to="{ name: 'bonus' }" active-class="active" class="nav-item nav-link text-dark pr-3">
                                Bonus
                            </router-link>
                            <router-link :to="{ name: 'about' }" active-class="active" class="nav-item nav-link text-dark">
                                About
                            </router-link>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="col-4 text-right">
                <transition name="fade">
                    <span v-if="added" class="added-success" v-html="lastItemName"></span>
                </transition>
                <router-link :to="{ name: 'cart' }" class="btn btn-success font-weight-bold">
                    Cart ({{cartCount}})
                </router-link>
            </div>
        </div>

        <div class="pt-2">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import global from "../global";
    import Orders from "./Sections/Orders";

    export default {
        name: "App",
        mixins: [global],
        data() {
            return {
                added: false,
                timeout: null
            }
        },
        created() {
            if (this.isAuth) {
                this.$router.addRoutes(
                    [{
                        path: '/orders',
                        name: 'orders',
                        component: Orders,
                    }]
                );
            }
        },
        computed: {
            cartCount: function () {
                return this.$store.state.cart.count;
            },
            lastItem: function () {
                return this.$store.state.cart.lastItem;
            },
            lastItemName: function () {
                return 'Added:<br><strong>' + this.lastItem.name + '</strong>';
            }
        },
        watch: {
            lastItem (newValue, oldValue) {
                if (!(Object.keys(newValue).length === 0 && newValue.constructor === Object)) {
                    this.added = true;
                    const self = this;

                    if (this.timeout) {
                        clearTimeout(this.timeout);
                    }
                    this.timeout = setTimeout(function () {
                        self.added = false;
                    }, 3000);
                }
            }
        }
    }
</script>

<style scoped>
    .navbar-nav a {
        font-size: 1rem;
    }
    .navbar-nav a.active {
        font-weight: bold;
    }
    .added-success {
        position: fixed;
        background-color: #a4dfb5;
        width: 200px;
        height: 60px;
        padding: 5px;
        text-align: center;
        border-radius: 3px;
        border: 1px solid #0ab00a;
        opacity: 0.9;
        color: black;
        margin: 1% auto; /* Will not center vertically and won't work in IE6/7. */
        left: 0;
        right: 0;
        z-index: 1;
    }
    .fade-enter-active, .fade-leave-active {
        transition: opacity .3s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
        opacity: 0;
    }
</style>
