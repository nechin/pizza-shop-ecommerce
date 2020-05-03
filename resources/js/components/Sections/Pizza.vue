<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-primary">Our pizza is for you</h5>
                <p class="card-text">Here is the whole range of our pizza. Choose what you like. And we will gladly deliver it to you.</p>
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

        <div v-if="empty" class="alert alert-info mt-3" role="alert">
            No pizzas found
        </div>

        <div class="row">
            <div v-for="{ name, image, size, weight, price, ingredients } in pizzas" class="col-sm-6 col-md-6 col-lg-4 mt-4">
                <pizza-component
                    :name="name"
                    :image="image"
                    :size="size"
                    :weight="weight"
                    :price="price"
                    :ingredients="ingredients"
                ></pizza-component>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "Pizza",
        data() {
            return {
                loading: false,
                empty: false,
                pizzas: null,
                error: null,
            };
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                this.error = this.pizzas = null;
                this.loading = true;
                this.empty = false;
                axios
                    .get('/api/pizzas')
                    .then(response => {
                        this.loading = false;
                        this.pizzas = response.data.data;
                        this.empty = !this.pizzas.length;
                    }).catch(error => {
                        this.loading = false;
                        this.error = error.response.data.message || error.message;
                    });
            }
        }
    }
</script>

<style scoped>

</style>
