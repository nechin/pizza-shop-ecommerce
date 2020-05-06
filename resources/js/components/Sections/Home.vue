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

        <div v-if="pizzas" class="row">
            <div v-for="pizza in pizzas" class="col-sm-6 col-md-6 col-lg-4 mt-4">
                <pizza-component :pizza="pizza"></pizza-component>
            </div>
        </div>
        <div v-if="!pizzas.length" class="pt-4">
            <div class="card">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        There could be pizzas that you like. To do this, log in to your account, go to
                        <router-link :to="{ name: 'pizza' }" class="text-primary">
                            pizza section
                        </router-link>
                        and like at least one pizza.
                    </li>
                </ul>
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
                pizzas: []
            };
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                this.$nextTick(function () {
                    if (this.isAuth) {
                        this.pizzas = [];
                        this.postRequest('/api/my-pizzas', {}, this.postCallback, this.errorCallback);
                    }
                });
            },
            postCallback(response) {
                this.pizzas = response.data.data;
            },
            errorCallback(text) {
            }
        }
    }
</script>
