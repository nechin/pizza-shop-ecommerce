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
                <router-link :to="{ name: 'cart' }" class="btn btn-success font-weight-bold">
                    Cart ({{cartItems}})
                </router-link>
            </div>
        </div>

        <div class="pt-2">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        name: "App",
        computed: {
            cartItems: function () {
                return this.$store.state.cart.items.length || 0;
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
</style>
