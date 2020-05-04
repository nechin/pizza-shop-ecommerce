import axios from 'axios';

const global = {
    computed: {
        isAuth: function () {
            return this.$store.state.user_token !== '';
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
        }
    }
};

export default global;
