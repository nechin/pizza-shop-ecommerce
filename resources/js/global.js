import axios from 'axios';

const global = {
    computed: {
        isAuth: function () {
            return this.$store.state.user_token !== false;
        },
        isCartItems() {
            return this.$store.state.cart.items.length !== 0;
        },
        cartItems() {
            return this.$store.state.cart.items;
        }
    },
    methods: {
        addToCart(item) {
            this.$store.state.cart.items.push(item);
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
