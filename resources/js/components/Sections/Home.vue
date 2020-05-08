<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-primary">Pizza Hot</h5>
                <p class="card-text">You got to the site of the most delicious pizza, in our opinion.<br>
                    If this is your first time here, go to the
                    <router-link :to="{ name: 'pizza' }" class="text-primary">
                        section
                    </router-link>
                    of our delicious pizzas and choose.<br>
                    However, if you are our frequent visitor, then below is a list of those pizzas that you like.
                </p>
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

        <div v-if="pizzas.like" class="card mt-3">
            <div class="card-body">
                <h5 class="card-title font-weight-bold">Your favorite pizza</h5>
                <div class="row">
                    <div v-for="pizza_like in pizzas.like" class="col-sm-4 mt-4">
                        <pizza-component :pizza="pizza_like"></pizza-component>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="pizzas.best" class="card mt-3">
            <div class="card-body">
                <h5 class="card-title font-weight-bold">Our best pizza</h5>
                <div class="row">
                    <div v-for="pizza_best in pizzas.best" class="col-sm-4 mt-4">
                        <pizza-component :pizza="pizza_best"></pizza-component>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="pizzas.vegan" class="card mt-3">
            <div class="card-body">
                <h5 class="card-title font-weight-bold">Best vegan pizza</h5>
                <div class="row">
                    <div v-for="pizza_vegan in pizzas.vegan" class="col-sm-4 mt-4">
                        <pizza-component :pizza="pizza_vegan"></pizza-component>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="pizzas.tomato" class="card mt-3">
            <div class="card-body">
                <h5 class="card-title font-weight-bold">Best tomato pizza</h5>
                <div class="row">
                    <div v-for="pizza_tomato in pizzas.tomato" class="col-sm-4 mt-4">
                        <pizza-component :pizza="pizza_tomato"></pizza-component>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="pizzas.cream" class="card mt-3">
            <div class="card-body">
                <h5 class="card-title font-weight-bold">Best cream pizza</h5>
                <div class="row">
                    <div v-for="pizza_cream in pizzas.cream" class="col-sm-4 mt-4">
                        <pizza-component :pizza="pizza_cream"></pizza-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import global from "../../global";

    export default {
        name: "Home",
        mixins: [global],
        data() {
            return {
                loading: false,
                error: null,
                pizzas: {
                    like: false,
                    best: false,
                    vegan: false,
                    tomato: false,
                    cream: false,
                }
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
                    this.postRequest('/api/home', {}, this.postCallback, this.errorCallback);
                });
            },
            postCallback(response) {
                this.pizzas = response.data;
                this.loading = false;
            },
            errorCallback(text) {
                this.error = text;
                this.loading = false;
            }
        }
    }
</script>
