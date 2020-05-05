<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-primary">About us</h5>
                <p class="card-text">We have been doing what we love for a very long time. Cooking pizza is a pleasure for us. Therefore, here we will talk about how we try to make you happy.</p>
            </div>
        </div>

        <div id="carouselWithSlides" class="carousel slide pt-4" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="image/slide-1.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="image/slide-2.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="image/slide-3.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselWithSlides" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselWithSlides" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        name: "About"
    }
</script>
