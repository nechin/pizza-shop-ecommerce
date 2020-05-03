<template>
    <div class="container">
        <div class="row justify-content-between pt-2">
            <div class="col-10">
                <ul class="nav container-nav">
                    <li class="nav-item pr-1">
                        <router-link :to="{ name: 'home' }" active-class="active" class="nav-link text-dark" exact>
                            Home
                        </router-link>
                    </li>
                    <li class="nav-item pr-1">
                        <router-link :to="{ name: 'pizza' }" active-class="active" class="nav-link text-dark">
                            Pizza
                        </router-link>
                    </li>
                    <li class="nav-item pr-1">
                        <router-link :to="{ name: 'bonus' }" active-class="active" class="nav-link text-dark">
                            Bonus
                        </router-link>
                    </li>
                    <li class="nav-item pr-1">
                        <router-link :to="{ name: 'about' }" active-class="active" class="nav-link text-dark">
                            About
                        </router-link>
                    </li>
                </ul>
            </div>
            <div class="col-2 text-right">
                <router-link :to="{ name: 'cart' }" class="btn btn-success font-weight-bold">
                    Cart
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
        name: "App"
    }
</script>

<style scoped>
    .container-nav a {
        font-size: 1rem;
    }
    .container-nav a.active {
        font-weight: bold;
    }
</style>
