<template>
    <div class="card">
        <img :src="image" class="card-img-top pl-3 pt-3" :alt="name">
        <div class="card-body">
            <h5 v-if="!isAuth" class="card-title">{{name}}</h5>
            <div v-if="isAuth" class="row">
                <div class="col-9 col-sm-9">
                    <h5 class="card-title">{{name}}</h5>
                </div>
                <div class="col-3 col-sm-3">
                    <a href="#" class="btn btn-outline-danger" style="font-size: 10px">Like</a>
                </div>
            </div>
            <p class="card-text"><strong>Ingredients:</strong> {{ ingredients_list.join(', ') }}<br>
            <strong>Size:</strong> {{size}} cm<br>
            <strong>Weight:</strong> {{weight}} g</p>
            <div class="container">
                <div class="row justify-content-md-right">
                    <div class="col-6 col-sm-8 col-md-6" style="font-size: 18px">
                        <strong>{{price}} euro</strong>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary">Add to cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PizzaItem",
        props: {
            name: {
                type: String,
                default: ''
            },
            image: {
                type: String,
                default: ''
            },
            size: {
                type: Number,
                default: 0
            },
            weight: {
                type: Number,
                default: 0
            },
            price: {
                type: Number,
                default: 0
            },
            ingredients: {
                type: Array,
                default: function () {
                    return {}
                }
            }
        },
        computed: {
            ingredients_list: function () {
                const result = [];
                for (let key in this.ingredients) {
                    result.push(this.ingredients[key].name);
                }
                return result;
            },
            isAuth: function () {
                return this.$store.state.user_id !== false;
            }
        }
    }
</script>

<style scoped>

</style>
