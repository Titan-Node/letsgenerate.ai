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
         .banner-area .banner-single{
          padding-top:100px;
          padding-bottom:0px;
         }

        @media (max-width:991px){

         /* Column 6/12 */
         #smooth-wrapper #smooth-content main .banner-area .container .banner-single .d-flex{
          width:100% !important;
          }
        }

    </style>

                    <!-- banner area start -->
                    <section class="banner-area">
                        <div class="container custom-container-1">
                            <div class="banner-single">
                                <div class="banner-content">
                                    <span class="banner-content-subtitle tp_fade_left">Lets Generate!</span>
                                    <h1 class="banner-content-title tp_has_text_reveal_anim">Create Beautiful Videos</h1>
                                    <p class="tp_desc_anim">Upload an image and get a video version</p>

                                    <div class="banner-content-btn">
                                        <form id="uploadForm" enctype="multipart/form-data">
                                        <div class="input-group">
                                            <div class="custom-file" id="file-upload-area">
                                                <input type="file" class="form-control" id="file" name="file" >
                                                <br>
                                                <button class="theme-btn tp_fade_bottom" type="button" id="generateVideoBtn">Generate!</button>
                                            </div>

                                        </div>
                                    </form>
                                    </div>

                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
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
                                                            <select class="h4_banner-form-option has-nice-select" id="i2v_model_id">
                                                            <option selected>stabilityai/stable-video-diffusion-img2vid-xt-1-1</option>
                                                            </select>
                                                        </form>

                                                        <br>
                                                        <br>

                                                        <h5 class="h2_banner-form-title">FPS</h5>
                                                        <form action="#">
                                                            <input  class="form-control" type="number" value=25 max=25 id="i2v_fps">
                                                        </form>
                                                        <br>
                                                        <h5 class="h2_banner-form-title">VIDEO WIDTH</h5>
                                                        <form action="#">
                                                                <input class="form-control" type="number" value=1024 min=256 max=1024 step=1 id="i2v_width">
                                                        </form>
                                                        <br>
                                                        <h5 class="h2_banner-form-title">VIDEO HEIGHT</h5>
                                                        <form action="#">
                                                                <input class="form-control" type="number" value=576 min=256 max=576 step=1 id="i2v_height">
                                                        </form>
                                                        <br>
                                                        <h5 class="h2_banner-form-title">MOTION BUCKET ID</h5>
                                                        <form action="#">
                                                                <input class="form-control" type="number" value=127 min=0 max=100 step=1 id="i2v_motion_bucket_id">
                                                        </form>
                                                        <br>
                                                        <h5 class="h2_banner-form-title">NOISE AUG STRENGTH</h5>
                                                        <form action="#">
                                                                <input class="form-control" type="number" value=0.2 min=0 max=1 step=1 id="i2v_noise_aug_strength">
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                                <div class="col-6 d-flex justify-content-center" style="padding-top: 20px; padding-bottom: 20px;" id="video-placeholder">
                                  <video controls autoplay loop muted style="max-width: 100%; border-radius: 10px;">
                                    <source src="/assets/videos/movie.mp4" type="video/mp4">
                                    Your browser does not support the video tag.
                                  </video>
                                </div>
                            </div>
                        </div>
                        <div class="banner-shape d-none d-lg-block">
                            <img src="assets/images/banner/home1/shape-2.png" alt="Image Not Found" class="banner-shape-2" data-speed="0.8">
                            <img src="assets/images/banner/home1/shape-3.png" alt="Image Not Found" class="banner-shape-3" data-speed="0.8">
                            <img src="assets/images/banner/home1/shape-4.png" alt="Image Not Found" class="banner-shape-4" data-speed="0.7">
                            <img src="assets/images/banner/home1/shape-5.png" alt="Image Not Found" class="banner-shape-5">
                        </div>
                    </section>
                    <!-- banner area end -->






<?php include 'footer.php'; ?>
<script src="assets/js/livepeer-ai-api-i2v.js"></script>

  </body>
</html>