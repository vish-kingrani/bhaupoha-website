<style>
    .home-product {
        margin-bottom: 4rem;
    }

    .inner-home-product {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        gap: 20px;
    }

    .product-card {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 240px;
        margin: 0 auto;
    }

    .product-card:hover .image-side figure {
        transform: scale(0.9);
    }

    .product-card>.image-side {
        /* padding: 20px; */
        background-color: white;
        border-radius: 10px;
        box-shadow: 0px 0px 10px #ddd;
        height: 300px;
    }

    .product-card>.image-side figure {
        position: relative;
        transform: scale(0.8);
        transition: all .3s ease-in-out;
    }

    /* heading-css */
    .hover-heading {
        margin-bottom: 4rem;
        width: fit-content;
        margin-inline: auto;
        cursor:pointer;
    }

    .hover-heading::after {
        content: '';
        display: block;
        height: 4px;
        background-color: #a82d49;
        width: 100%;
        margin: 5px auto 0;
        border-radius: 20px;
        transform: scaleX(0.1);
        transform-origin: center;
        transition: transform 0.3s linear;
    }

    .hover-heading:hover::after {
        transform: scaleX(1);
        /* expand fully */
    }

     @media (max-width:1200px) {
        .inner-home-product {
            grid-template-columns: 1fr 1fr 1fr;
        }
    }

    @media (max-width:1024px) {
        .inner-home-product {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width:576px) {
        .inner-home-product {
            grid-template-columns: 1fr;
        }
    }
</style>


<section class="home-product">
    <h1 class="hover-heading">OUR PRODUCTS</h1>
    <div class="container">
        <div class="inner-home-product">
            <!-- card design -->
            <div class="product-card">
                <div class="image-side">
                    <figure>
                        <img src="./images/products/1.png" alt="mahadev foods    " style="width:100%; height:100%;">
                    </figure>
                </div>

                <div style="display:flex;flex-direction:column;gap:5px;align-items:center;">
                    <div style="display:flex;gap:10px;align-items:center;">
                        <p style="padding:3px 6px; border-radius:3px; background-color:#a82d49;color:white;">
                            Size
                        </p>
                        <p style="font-size: 1.3rem;"><strong>30KG (Bag)</strong></p>
                        <p style="font-size: 1.3rem;"><strong>,</strong></p>
                        <p style="font-size: 1.3rem;"><strong>1KG (Packet)</strong></p>
                    </div>

                    <h4>BHAU POHA</h4>
                </div>
            </div>

            <!-- card design -->
            <div class="product-card">
                <div class="image-side">
                    <figure>
                        <img src="./images/products/2.png" alt="" style="width:100%; height:100%;">
                    </figure>
                </div>

                <div style="display:flex;flex-direction:column;gap:5px;align-items:center;">
                    <div style="display:flex;gap:10px;align-items:center;">
                        <p style="padding:3px 6px; border-radius:3px; background-color:#a82d49;color:white;">
                            Size
                        </p>
                        <p style="font-size: 1.3rem;"><strong>30KG (Bag)</strong></p>
                        <!-- <p style="font-size: 1.3rem;"><strong>1KG (Packet)</strong></p> -->
                    </div>

                    <h4>KIWI POHA</h4>
                </div>
            </div>

            <!-- card design -->
            <div class="product-card">
                <div class="image-side">
                    <figure>
                        <img src="./images/products/3.png" alt="" style="width:100%; height:100%;">
                    </figure>
                </div>

                <div style="display:flex;flex-direction:column;gap:5px;align-items:center;">
                    <div style="display:flex;gap:10px;align-items:center;">
                        <p style="padding:3px 6px; border-radius:3px; background-color:#a82d49;color:white;">
                            Size
                        </p>
                        <p style="font-size: 1.3rem;"><strong>30KG (Bag)</strong></p>
                        <!-- <p style="font-size: 1.3rem;"><strong>1KG (Packet)</strong></p> -->
                    </div>

                    <h4>VD POHA </h4>
                </div>
            </div>

            <!-- card design -->
            <div class="product-card">
                <div class="image-side">
                    <figure>
                        <img src="./images/products/4.png" alt="" style="width:100%; height:100%;">
                    </figure>
                </div>

                <div style="display:flex;flex-direction:column;gap:5px;align-items:center;">
                    <div style="display:flex;gap:10px;align-items:center;">
                        <p style="padding:3px 6px; border-radius:3px; background-color:#a82d49;color:white;">
                            Size
                        </p>
                        <p style="font-size: 1.3rem;"><strong>30KG (Bag)</strong></p>
                        <!-- <p style="font-size: 1.3rem;"><strong>1KG (Packet)</strong></p> -->
                    </div>

                    <h4>KAWERI POHA</h4>
                </div>
            </div>
        </div>
    </div>
</section>