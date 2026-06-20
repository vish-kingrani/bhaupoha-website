<style>
    .home-banner {
        padding-top: 7rem;
    }

    .inner-home-banner {
        display: flex;
        justify-content: space-between;
        gap: 5px;
    }

    .inner-home-banner>div>figure {
        width: 30vw;
    }
    @media(max-width:992px) {
        .home-banner{
            padding-top:11rem;
        }
    }

    @media (max-width:576px) {
        .home-banner {
            padding-top: 8rem;
        }

        .inner-home-banner {
            flex-direction: column;
            justify-content: center;
        }

        .inner-home-banner>div>figure {
            width: 70%;
            margin: 0 auto;
        }
    }
</style>

<section class="home-banner">
    <div class="container">
        <div class="inner-home-banner">
            <div style="display:flex;flex-direction:column;justify-content:center;">
                <div>
                    <h1 style="font-size:4rem;margin-bottom:25px;"><span class="main-site-color">Bhau Poha,</span> <br />Light on tummy.</h1>
                    <h3 style="font-size:2.8rem"><span class="text-primary">From</span> farm to table, nothing extra,<br />nothing artificial.
                    </h3>
                </div>
            </div>

            <div style="display:flex;flex-direction:column;justify-content:center;">
                <figure>
                    <img src="images/bg/home-banner-img.png" alt="" style="width:100%;">
                </figure>
            </div>
        </div>
    </div>
</section>