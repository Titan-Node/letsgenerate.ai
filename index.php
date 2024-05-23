<?php include 'header.php'; ?>
    <style>
        .hidden {
            display: none;
        }

                /* Style for disabled button */
        .disabled {
            background-color: #cccccc; /* Grey background */
            color: #666666; /* Darker grey text */
        }

         /* Banner single */
         #banner-area .banner-single{
          padding-top:0px;
          padding-bottom:0px;
         }

         #banner-area .banner-single .h3_banner-content{
         padding-top:120px;
         padding-bottom:0px;
        }



    </style>
                    <!-- banner area start -->
                    <section class="h3_banner-area" id="banner-area">
                        <div class="container custom-container-1">
                            <div class="banner-single">
                                <div class="h3_banner-content">
                                    <span class="h3_banner-content-subtitle tp_fade_left">Lets Generate!</span>
                                    <h1 class="h3_banner-content-title tp_title_anim">Generate intelligent
                                        <span>images!</span></h1>

                                <div class="h4_banner-bottom">
                                    <img src="assets/images/banner/home2/form_shape.png" alt="" class="h2_banner-bottom-shape tp_fade_right">
                                    <div class="h2_banner-form tp_fade_bottom">
                                        <h5 class="h2_banner-form-title">PROMPT</h5>
                                        <div class="contact-form-item mb-25">
                                                            <textarea name="message" id="t2i_prompt" placeholder="Start with a detailed description"></textarea>
                                                        </div>
                                        <form action="#">
                                            <button type="submit" id="submit_t2i">Generate!</button>
                                            <div class="d-flex align-items-center">
                                                <p style="font-size: 12px;" class="mb-0 me-10" id="fillButton"><a href="#">Try Example!</a></p>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                    <div class="h3_banner-form tp_fade_bottom">

                                        <div class="h2_faq-content">
                                            <div class="accordion" id="Expp">
                                                <div class="accordion-item mb-30">
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><small>SETTINGS</small>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#Expp">
                                                        <div class="accordion-body">

                                                            <h5 class="h2_banner-form-title">MODEL</h5>
                                                            <form action="#">
                                                                <select class="h4_banner-form-option has-nice-select" id="t2i_model_id">
                                                                    <option selected>SG161222/RealVisXL_V4.0_Lightning</option>
                                                                <option>ByteDance/SDXL-Lightning</option>
                                                                </select>
                                                            </form>

                                                            <br>
                                                            <br>
                                                            <h5 class="h2_banner-form-title">NEGATIVE PROMPT</h5>
                                                            <form action="#">
                                                                <div class="col-12">
                                                                    <div class="contact-form-item mb-25">
                                                                        <textarea id="t2i_neg_prompt"></textarea>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <br>
                                                            <h5 class="h2_banner-form-title">SEED</h5>
                                                            <form action="#">
                                                                <input  type="number" value=0 id="t2i_seed">
                                                            </form>
                                                            <br>
                                                            <h5 class="h2_banner-form-title">IMAGE WIDTH</h5>
                                                            <form action="#">
                                                                    <input class="form-control" type="number" value=1024 min=256 max=1024 step=1 id="t2i_width">
                                                            </form>
                                                            <br>
                                                            <h5 class="h2_banner-form-title">IMAGE HEIGHT</h5>
                                                            <form action="#">
                                                                    <input class="form-control" type="number" value=1024 min=256 max=1024 step=1 id="t2i_height">
                                                            </form>
                                                            <br>
                                                            <h5 class="h2_banner-form-title">GUIDANCE SCALE</h5>
                                                            <form action="#">
                                                                    <input class="form-control" type="number" value=7 min=0 max=100 step=1 id="t2i_guidance_scale">
                                                            </form>
                                                            <br>
                                                            <h5 class="h2_banner-form-title">NUMBER OF IMAGES</h5>
                                                            <form action="#">
                                                                    <input class="form-control" type="number" value=1 min=1 max=10 step=1 id="t2i_num_images" disabled>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="div1" class="hidden">
                                    <div class="banner-img tp_fade_left">
                                        <div id="t2i-carousel" class="carousel slide" >
                                          <div id="t2i-carousel-indicators" class="carousel-indicators">
                                            <!-- dynamically added with request -->
                                            <button type="button" data-bs-target="#t2i-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                          </div>
                                          <div id="t2i-carousel-inner" class="carousel-inner">
                                            <!-- dynamically added with request -->
                                            <div class="carousel-item active">
                                              <img src="assets/images/loading.gif" class="d-block w-100" alt="text-to-image result" id="loading-image" width="515" height="515">
                                            </div>
                                          </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#t2i-carousel" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                          </button>
                                          <button class="carousel-control-next" type="button" data-bs-target="#t2i-carousel" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                          </button>
                                        </div>
                                        <div>
                                            <span class="pull-left"><a href="#" ><button type="button" id="getActiveCarouselItemId" class="btn btn-secondary" style="width: 100%;" hidden>Convert To Video!</button></a></span>
                                        </div>
                                    </div>
                                </div>
                                <div id="div2" class="hidden">
                                    <div class="h3_banner-right d-none d-lg-flex">
                                        <div class="inner-item">
                                            <div class="swiper h3_banner-active">
                                                <div class="swiper-wrapper ">
                                                    <div class="swiper-slide">
                                                        <div class="h3_banner-img">
                                                            <img src="assets/images/banner/home3/1.png" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="swiper-slide">
                                                        <div class="h3_banner-img">
                                                            <img src="assets/images/banner/home3/2.png" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="swiper-slide">
                                                        <div class="h3_banner-img">
                                                            <img src="assets/images/banner/home3/3.png" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="inner-item">
                                            <div class="swiper h3_banner-active-2">
                                                <div class="swiper-wrapper ">
                                                    <div class="swiper-slide">
                                                        <div class="h3_banner-img">
                                                            <img src="assets/images/banner/home3/4.png" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="swiper-slide">
                                                        <div class="h3_banner-img">
                                                            <img src="assets/images/banner/home3/5.png" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="swiper-slide">
                                                        <div class="h3_banner-img">
                                                            <img src="assets/images/banner/home3/6.png" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                            </div>
                        </div>
                        <div class="h3_banner-shape d-none d-sm-block">
                            <img src="assets/images/banner/home3/shape-1.png" alt="Image Not Found" class="h3_banner-shape-1" data-speed="0.8">
                            <img src="assets/images/banner/home3/shape-2.png" alt="Image Not Found" class="h3_banner-shape-2" data-speed="0.7">
                            <img src="assets/images/banner/home3/shape-3.png" alt="Image Not Found" class="h3_banner-shape-3" data-speed="0.9">
                        </div>
                    </section>
                    <!-- banner area end -->



<?php include 'footer.php'; ?>
<script src="assets/js/livepeer-ai-api-t2i.js"></script>


  <script>
          // Show/hide divs based on the existence of an image and enable generate button
        // Function to be re-run
        function reRunFunction() {
            // Check if the image with a specific ID exists
            var image = document.getElementById("t2i_result_0");

            // IDs of the divs to show/hide
            var divToShowIfImageExists = document.getElementById("div1");
            var divToShowIfImageDoesNotExist = document.getElementById("div2");

            if (image) {
                // If the image exists, show the first div and hide the second
                divToShowIfImageExists.classList.remove("hidden");
                divToShowIfImageDoesNotExist.classList.add("hidden");
            } else {
                // If the image does not exist, show the second div and hide the first
                divToShowIfImageDoesNotExist.classList.remove("hidden");
                divToShowIfImageExists.classList.add("hidden");
            }
            var button = document.getElementById('submit_t2i');
            button.disabled = false; // Remove disabled state
        }

        // Options for the observer (which mutations to observe)
        const config = { attributes: true, childList: true, subtree: true };

        // Callback function to execute when mutations are observed
        const callback = function(mutationsList, observer) {
          for(const mutation of mutationsList) {
            if (mutation.type === 'childList') {
              // Call reRunFunction on specific changes
              reRunFunction();
            }
          }
        };

        // Create an observer instance linked to the callback function
        const observer = new MutationObserver(callback);

        // Start observing the target node for configured mutations
        observer.observe(document.body, config);

        // Later, you can stop observing
        // observer.disconnect();


  </script>

  <script>
// Find the button by its ID
var button = document.getElementById('submit_t2i');

// Add a click event listener to the button
button.addEventListener('click', function() {
    // Disable the button
    this.disabled = true;

    // Select the image element by its current ID
    var imageElement = document.getElementById("loading-image");

    // Set a new ID for the image element
    imageElement.id = "t2i_result_0";

     // Check if the image with a specific ID exists
    var image = document.getElementById("t2i_result_0");

    // IDs of the divs to show/hide
    var divToShowIfImageExists = document.getElementById("div1");
    var divToShowIfImageDoesNotExist = document.getElementById("div2");

    if (image) {
        // If the image exists, show the first div and hide the second
        divToShowIfImageExists.classList.remove("hidden");
        divToShowIfImageDoesNotExist.classList.add("hidden");
    } else {
        // If the image does not exist, show the second div and hide the first
        divToShowIfImageDoesNotExist.classList.remove("hidden");
        divToShowIfImageExists.classList.add("hidden");
    }

    // Check if the screen width is 768px or less
    if(window.innerWidth <= 768) {
        window.scrollTo({
            top: document.body.scrollHeight,
            behavior: 'smooth' // Optional: adds animation
    });
}

});
</script>

<script type="text/javascript">
    // Carousel for rendered images, using slick.js because bootstrap carousel conflicts with the one on the homepage
  $(document).ready(function(){
    $('.carousel-inner').slick({
      setting-name: 'setting-value'
    });
  });
</script>

  <script>
    // Button to fill the input field with example text
     document.addEventListener('DOMContentLoaded', function () {
    // Get references to the input field and the button
    var myInput = document.getElementById('t2i_prompt');
    var fillButton = document.getElementById('fillButton');

    // Function to fill the input field
    function fillInput() {
        myInput.value = "A astronaut, colorful, low-poly, cyan and orange eyes, poly-hd, 3d, low-poly game art, polygon mesh, jagged, blocky, wireframe edges, centered composition.";
    }

    // Add click event listener to the button
    fillButton.addEventListener('click', fillInput);
});
  </script>


  </body>
</html>