<template>
    <div>
        <div class="card mb-3">
            <div class="row no-gutters">
                <div class="col-md-4 pt-3 pl-3">
                    <img :src="pizza.image" class="card-img" :alt="pizza.name">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{pizza.name}}</h5>
                        <p class="card-text">{{pizza.hint}}</p>
                        <p class="card-text"><strong>Ingredients:</strong> {{ ingredientsList.join(', ') }}</p>
                        <p class="card-text"><strong>Size:</strong> {{pizza.size}} cm</p>
                        <p class="card-text"><strong>Weight:</strong> {{pizza.weight}} g</p>
                        <p class="card-text">
                            <strong>Base:</strong> <span v-if="pizza.base">Cream</span><span v-else="type">Tomato</span>
                        </p>
                        <p v-if="pizza.vegan" class="card-text"><small class="text-muted">
                            Vegetarian
                        </small></p>
                        <p class="card-text f-18px"><strong>Price:</strong> {{pizza.price}} &euro;</p>
                    </div>
                    <div class="container pb-3">
                        <div class="row">
                            <div class="col-6 f-18px">
                                <like-component :pizzaId="pizza.id" :pizzaLike="pizza.like"></like-component>
                            </div>
                            <div class="col-6 text-right">
                                <a v-on:click="addToCart(pizza)" href="javascript:void(0)" class="btn btn-primary">Add to cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="error" class="alert alert-warning mt-3" role="alert">
            {{ error }}
        </div>
    </div>
</template>

<script>
    import global from "../../global"

    export default {
        name: "PizzaCard",
        mixins: [global],
        props: {
            id: {
                type: [String, Number],
                default: 0
            }
        },
        data() {
            return {
                pizza: {
                    id: 0,
                    name: '',
                    image: 'image/blank.jpg',
                    size: 0,
                    weight: 0,
                    price: 0,
                    base: 0,
                    hint: '',
                    vegan: 0,
                    like: false,
                    ingredients: [],
                },
                error: null,
            };
        },
        created() {
            this.fetchData(this.id)
        },
        computed: {
            ingredientsList: function () {
                const result = [];
                for (let key in this.pizza.ingredients) {
                    result.push(this.pizza.ingredients[key].name);
                }
                return result;
            }
        },
        methods: {
            fetchData(id) {
                this.empty = false;
                this.postRequest('/api/pizza/' + id, {}, this.postCallback, this.errorCallback);
            },
            postCallback(response) {
                this.pizza = response.data.data[0]
            },
            errorCallback(text) {
                this.error = text
            }
        }
    }
</script>
