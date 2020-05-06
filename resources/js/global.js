import axios from 'axios';

const global = {
    computed: {
        isAuth: function () {
            return this.$store.state.user_token !== false;
        }
    },
    methods: {
        addToCart(item) {
            if (typeof this.$store.state.cart.items[item.id] === 'undefined') {
                let pizzaItem = item;
                pizzaItem.count = 1;
                this.$store.state.cart.items[item.id] = pizzaItem;
            } else {
                this.$store.state.cart.items[item.id].count++;
            }
            this.$store.state.cart.lastItem = item;
            this.$store.state.cart.count++;
        },
        setAuthHeader() {
            if (this.$store.state.user_token) {
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.$store.state.user_token;
            }
        },
        postRequest(url, data, callback, errorCallback) {
            this.setAuthHeader();
            axios
                .post(url, data)
                .then(response => {
                    callback(response);
                }).catch(error => {
                    const errorText = error.response.data.message || error.message;
                    errorCallback(errorText);
                });
        }
    }
};

export default global;
