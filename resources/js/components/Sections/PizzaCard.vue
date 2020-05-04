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
                        <p class="card-text" style="font-size: 18px"><strong>Price:</strong> {{pizza.price}} &euro;</p>
                    </div>
                    <div class="container pb-3">
                        <div class="row">
                            <div class="col-6" style="font-size: 18px">
                                <a v-if="isAuth" v-on:click="like()" href="#" :class="likeClass()" style="font-size: 10px">Like</a>
                            </div>
                            <div class="col-6 text-right">
                                <a v-on:click="addToCart(pizza)" href="#" class="btn btn-primary">Add to cart</a>
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
    import axios from 'axios';
    import global from "../../global";

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
                    name: '',
                    image: 'image/blank.jpg',
                    size: 0,
                    weight: 0,
                    price: 0,
                    base: 0,
                    hint: '',
                    vegan: 0,
                    like: 0,
                    ingredients: [],
                },
                error: null,
            };
        },
        created() {
            this.fetchData(this.id);
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
                this.$nextTick(function () {
                    this.setAuthHeader();
                    axios
                        .get('/api/pizza/' + id)
                        .then(response => {
                            this.pizza = response.data.data[0];
                        }).catch(error => {
                            this.error = error.response.data.message || error.message;
                        });
                });
            },
            likeClass() {
                return 'btn ' + (this.pizza.like ? 'btn-danger' : 'btn-outline-danger');
            },
            like() {
                this.pizza.like = !this.pizza.like;
            }
        }
    }
</script>

<style scoped>

</style>
