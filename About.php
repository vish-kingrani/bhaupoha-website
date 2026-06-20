<style>
    /* heading-css */
    .about-heading {
        margin-bottom: 3rem;
        width: fit-content;
        cursor:pointer;
    }

    .about-heading::after {
        content: '';
        display: block;
        height: 4px;
        background-color: #a82d49;
        width: 100%;
        margin: 5px auto 0;
        border-radius: 20px;
        transform: scaleX(0.1);
        transform-origin: left;
        transition: transform 0.3s linear;
    }

    .about-heading:hover::after {
        transform: scaleX(1);
        /* expand fully */
    }
</style>


<div class="container">
    <!-- About Section 1 -->
    <div class="intro intro-about2">
        <div class="container">
            <div class="row center-content">
                <div class="col-md-7 ">
                    <img src="images/features/1.png" class="pull-left img-responsive" alt="healthy poha natural poha ">
                </div>
                <div class="col-md-5">
                    <h1 class="about-heading">ABOUT US</h1>

                    <h3 style="font-size: 3rem; line-height:40px;">We pride ourselves on providing <span class="text-primary">finest grains</span> of <span
                            class="text-danger">poha</span> from best available paddy.</h3>
                    <p>“At Mahadev Foods, we have been dedicated to delivering premium quality poha since 2015. With over 700 happy clients, we take pride in being a trusted name in poha manufacturing. Our commitment lies in maintaining consistency, freshness, and authenticity in every batch, ensuring our customers always get the finest product with the same great taste and reliability.”</p>
                    <!-- <a href="#" class="btn btn-lg btn-primary">Learn More <i class="icon-arrow-right"></i></a> -->
                </div>
            </div>
        </div>
    </div>

    <!-- About Section 2 -->
    <div class="intro intro-about2">
        <div class="container">
            <div class="row center-content">
                <div class="col-md-5">
                    <h3>Handmade with Heart. Wholesome by Nature.</h3>
                    <p>“At Bhau Poha, we make everything by hand using the best ingredients to ensure authentic
                        taste and uncompromising quality. Our product is 100% natural with zero additives,
                        resulting in a beautifully soft and fluffy texture. This is wholesome goodness crafted
                        with care, tradition, and trust.”
                    </p>

                    <ul class="list">
                        <li><i class="fa fa-check"></i> 100% natural.</li>
                        <li><i class="fa fa-check"></i> Zero additives.</li>
                        <li><i class="fa fa-check"></i> Soft and fluffy texture.</li>
                    </ul>

                    <!-- <div class="space30"></div>
                            <a href="#" class="btn btn-lg btn-primary">Learn More <i class="icon-arrow-right"></i></a> -->
                </div>
                <div class="col-md-7">
                    <img src="images/features/2.png" class="pull-left img-responsive" alt="best poha">
                </div>
            </div>
        </div>
    </div>
</div>