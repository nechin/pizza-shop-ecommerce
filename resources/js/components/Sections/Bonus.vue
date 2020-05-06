<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-primary">Promotions and bonuses</h5>
                <p class="card-text">We love our customers so much that we are often ready to make pleasant discounts
                    and promotions for them. Visit this section more often and find what suits you best.</p>
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
            No bonuses found
        </div>

        <div class="pt-3" style="width: 400px">
            <ul v-if="bonuses" class="list-group">
                <li v-for="{ value, type, code, user } in bonuses" class="list-group-item">
                    <span class="badge badge-pill mr-2 f-18px" :class="[user ? 'badge-danger' : 'badge-primary']">{{ code }}</span>
                    You will get <strong>{{ value }} <span v-if="type">%</span><span v-else="type">&euro;</span></strong> discount on order
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import global from "../../global";

    export default {
        name: "Bonus",
        mixins: [global],
        data() {
            return {
                loading: false,
                empty: false,
                bonuses: null,
                error: null,
            };
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                this.error = this.bonuses = null;
                this.loading = true;
                this.empty = false;
                this.postRequest('/api/discounts', {}, this.postCallback, this.errorCallback);
            },
            postCallback(response) {
                this.loading = false;
                this.bonuses = response.data.data;
                this.empty = !this.bonuses.length;
            },
            errorCallback(text) {
                this.loading = false;
                this.error = text;
            }
        }
    }
</script>
