<template>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-primary">Pizza Hot</h5>
            <p class="card-text">You got to the site of the most delicious pizza, in our opinion.<br>
                If this is your first time here, go to the <router-link :to="{ name: 'pizza' }" class="text-primary">
                    section</router-link> of our delicious pizzas and choose.<br>
                However, if you are our frequent visitor, then below is a list of those pizzas that you prefer.</p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Home"
    }
</script>

<style scoped>

</style>
