$(document).ready(function() {
    $("#submit_t2i").click(function(e) {
        text_to_image();
    });

    $("#reset-t2i-images").click(function(e) {
        e.preventDefault();

        reset_t2i_images();
    });

    let items = $("#t2i-carousel-inner img");
});

var first_t2i_img_processed = false;
var total_t2i_images = -1;

document.getElementById('getActiveCarouselItemId').addEventListener('click', function() {
    var activeItem = document.querySelector('.carousel-item.active');
    if (activeItem) {
        var itemId = activeItem.id.split('/').pop();
        window.location.href = 'image-to-video.php?image_filename=' + itemId; // Navigate to the new URL
        console.log(activeItem.id); // Logs the id of the active carousel item
        // If you need to do something with the id, you can do it here
    } else {
        console.log('No active carousel item found.');
    }
});


function reset_t2i_images() {
    let indicators = $("#t2i-carousel-indicators");
    let items = $("#t2i-carousel-inner");
    indicators.empty();
    items.empty();
    first_t2i_img_processed = false;
    total_t2i_images = -1;

    let default_indicator = `<button type="button" data-bs-target="#t2i-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>`
    let default_item = `<div class="carousel-item active">
                          <img src="https://via.placeholder.com/600x300?text=Image+1" class="d-block w-100" alt="text-to-image result">
                        </div>`
    indicators.append(default_indicator);
    items.append(default_item);
}

function text_to_image() {
    let req_data = {};
    req_data["model_id"] = $("#t2i_model_id").val();
    req_data["prompt"] = $("#t2i_prompt").val();
    req_data["negative_prompt"] = $("#t2i_neg_prompt").val();
    req_data["width"] = parseInt($("#t2i_width").val());
    req_data["height"] = parseInt($("#t2i_height").val());
    if ($("#t2i_seed").val() > 0) {
        req_data["seed"] = parseInt($("#t2i_seed").val());
    }
    req_data["guidance_scale"] = parseInt($("#t2i_guidance_scale").val());
    req_data["num_images_per_prompt"] = parseInt($("#t2i_num_images").val());
    req_data["cookie_number"] = myAssetsCookie;


    
    $.ajax({
        url: 'https://chase.titan-node-orch.com:5000/t2i',
        type: 'post',
        contentType: "application/json",
        data: JSON.stringify(req_data),
        dataType: "json",
        statusCode: {
            200: function(data, status) {
                let indicators = $("#t2i-carousel-indicators");
                let items = $("#t2i-carousel-inner");

                //reset carousel with first image, append all images after
                if (!first_t2i_img_processed) {
                    indicators.empty();
                    items.empty();
                    first_t2i_img_processed = true;
                }

                $("#t2i-carousel-indicators button").each(function(index) {
                    $(this).removeClass("active");
                });
                $("#t2i-carousel-inner .carousel-item").each(function(index) {
                    $(this).removeClass("active");
                });
                
                let numberOfImages = 1;

                for (let i = 0; i < numberOfImages; i++) {
                    total_t2i_images++;
                    let is_active = (i ==0) ? "active" : "";

                    let indicator_tmpl = `<button data-bs-target="#t2i-carousel" data-bs-slide-to="${total_t2i_images}" class="${is_active}"></button>`

                    let image_filename = data['image_filename'];
                    let img_id = "Image "+(total_t2i_images+1);
                    let img_src = "https://chase.titan-node-orch.com/images/"+data['image_filename'];
                    let img_caption = "Image "+(total_t2i_images+1);
                    let item_tmpl = `<div class="carousel-item ${is_active}" id="${image_filename}">
                                        <a href=${img_src} download="${img_caption}.png"><img id="t2i_result_0" class="d-block w-100" src="${img_src}" alt="text-to-image result not available"></a>
                                    </div>`;

                    indicators.append(indicator_tmpl);
                    items.append(item_tmpl);
                    document.getElementById('getActiveCarouselItemId').removeAttribute('hidden');
                }
                //alert(data);
            },
            400: function(data, status) {
                alert("error with request: "+data);
            },
            500: function(data, status) {
                alert("error from server: "+data);
            },
        }
    });
};