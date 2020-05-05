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

        <div class="row pt-2 pl-4">
            <div v-if="pizzas" class="form-check">
                <input
                    v-on:change="showVeganPizza()"
                    v-model="veganCheckbox"
                    class="form-check-input"
                    type="checkbox"
                    value=""
                    id="veganCheckbox"
                >
                <label class="form-check-label" for="veganCheckbox">
                    Show only vegan pizza
                </label>
            </div>
        </div>
        <div class="row">
            <div v-for="pizza in pizzas" class="col-sm-6 col-md-6 col-lg-4 mt-3">
                <pizza-component :pizza="pizza"></pizza-component>
            </div>
        </div>
    </div>
</template>

<script>
    import global from "../../global";

    export default {
        name: "Pizza",
        mixins: [global],
        data() {
            return {
                loading: false,
                empty: false,
                pizzas: null,
                error: null,
                veganCheckbox: false,
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
                this.postRequest('/api/pizzas', {vegan: this.veganCheckbox}, this.postCallback, this.errorCallback);
            },
            postCallback(response) {
                this.loading = false;
                this.pizzas = response.data.data;
                this.empty = !this.pizzas.length;
            },
            errorCallback(text) {
                this.loading = false;
                this.error = text;
            },
            showVeganPizza() {
                this.$nextTick(function () {
                    this.postRequest('/api/pizzas', {vegan: this.veganCheckbox}, this.postCallback, this.errorCallback);
                })
            }
        }
    }
</script>
