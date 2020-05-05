<template>
    <div class="like">
        <a v-if="isAuth" v-on:click="like()" href="javascript: void(0)" :class="likeClass">{{likeText}}</a>
    </div>
</template>

<script>
    import global from "../../global"

    export default {
        name: "Like",
        mixins: [global],
        props: {
            pizzaId: {
                type: [String, Number],
                default: 0
            },
            pizzaLike: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                isLike: this.pizzaLike
            }
        },
        computed: {
            likeClass: function () {
                return 'btn ' + (this.isLike ? 'btn-danger' : 'btn-outline-danger');
            },
            likeText: function () {
                return this.isLike ? 'Dislike' : 'Like';
            },
        },
        methods: {
            like() {
                this.postRequest('/api/like/' + this.pizzaId, {}, this.likeCallback, this.errorCallback);
            },
            likeCallback(response) {
                this.isLike = response.data.like;
            }
        },
        watch: {
            pizzaLike() {
                this.isLike = this.pizzaLike
            }
        }
    }
</script>

<style scoped>
    .like a {
        font-size: 10px;
    }
</style>
