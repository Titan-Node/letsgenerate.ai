document.getElementById('generateVideoBtn').addEventListener('click', function() {
  const form = document.getElementById('uploadForm');
  const fileInput = document.getElementById('file');
    if (!fileInput.files.length) {
    alert('Please select a file to upload');
    return;
    }
  const formData = new FormData(form);
  formData.append('file', file);
  formData.append('cookieValue', myAssetsCookie);

  fetch('https://chase.titan-node-orch.com:5000/upload', {
    method: 'POST',
    body: formData,
  })
  .then(response => response.json())
  .then(data => {
    console.log(data);
    var image_filename = data['image_filename'];
    console.log(image_filename);
    image_to_video(image_filename);
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Error uploading file. Please try again later.');
    hideRenderedVideo()
  });
});

function image_to_video(image_filename) {
    let req_data = {};
    req_data["model_id"] = $("#i2v_model_id").val();
    req_data["cookie_number"] = myAssetsCookie;
    req_data["image_filename"] = image_filename;
    req_data["fps"] = parseInt($("#i2v_fps").val(), 10);
    req_data["width"] = parseInt($("#i2v_width").val(), 10);
    req_data["height"] = parseInt($("#i2v_height").val(), 10);
    req_data["motion_bucket_id"] = parseInt($("#i2v_motion_bucket_id").val(), 10);
    req_data["noise_aug_strength"] = parseFloat($("#i2v_noise_aug_strength").val());
    showRenderedVideo()

    $.ajax({
        url: 'https://chase.titan-node-orch.com:5000/i2v',
        type: 'post',
        contentType: "application/json",
        data: JSON.stringify(req_data),
        dataType: "json",
        success: function(data) {
            console.log(data);
            var video_filename = data['video_filename'];
            var video_url = 'https://chase.titan-node-orch.com/videos/' + video_filename;
            showCompletedVideo(video_url);
        },
        error: function(xhr, status, error) {
        // Handle the error
        console.error("Error: " + status + " " + error);
        console.error("Response: ", xhr.responseText);

        // Display a user-friendly error message, for example:
        alert("Server is overloaded. Please try again later.");
        hideRenderedVideo()

        // Optionally, re-enable any form controls or buttons that were disabled
        // $('#yourButtonId').prop('disabled', false);
    }
       });
}


function showRenderedVideo() {
    // Get the button element by its ID
    var genButton = document.getElementById('generateVideoBtn');

    // Disable the button
    genButton.disabled = true;

    // Select the image element by its current ID
    var placeholderElement = document.getElementById("video-placeholder");

    // Replace the HTML of the placeholder with new content
    // For example, inserting a video element
    placeholderElement.innerHTML = `
       <video controls autoplay loop muted style="max-width: 100%; border-radius: 10px;">
         <source src="/assets/videos/rendering.mp4" type="video/mp4">
         Your browser does not support the video tag.
       </video>
    `;
}

function hideRenderedVideo() {
    // Get the button element by its ID
    var genButton = document.getElementById('generateVideoBtn');

    // Disable the button
    genButton.enable = true;

    // Select the image element by its current ID
    var placeholderElement = document.getElementById("video-placeholder");

    // Replace the HTML of the placeholder with new content
    // For example, inserting a video element
    placeholderElement.innerHTML = `
       <video controls autoplay loop muted style="max-width: 100%; border-radius: 10px;">
         <source src="/assets/videos/movie.mp4" type="video/mp4">
         Your browser does not support the video tag.
       </video>
    `;
}

function showCompletedVideo(video_url) {
    // Get the button element by its ID
    var genButton = document.getElementById('generateVideoBtn');
    console.log("Generated Video URL", video_url);
    // Enable the button
    genButton.disabled = false;

    // Select the image element by its current ID
    var placeholderElement = document.getElementById("video-placeholder");

    // Replace the HTML of the placeholder with new content
    // For example, inserting a video element
    placeholderElement.innerHTML = `
       <video controls autoplay loop muted style="max-width: 100%; border-radius: 10px;">
         <source src="${video_url}" type="video/mp4">
         Your browser does not support the video tag.
       </video>
    `;
}

// Upload file automatically from other pages
document.addEventListener('DOMContentLoaded', function() {
    // Function to parse query parameters from the URL
    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    // Get the 'variable' query parameter
    const image_filename = getQueryParam('image_filename');
    console.log(image_filename);
    if (image_filename){
        var placeholderElement = document.getElementById("file-upload-area");
            placeholderElement.innerHTML = `
            <span class="tp_fade_bottom">
                <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.4555 0.0244961C16.2201 0.206689 15.2018 0.523653 14.0862 1.07023C12.6337 1.78153 11.3259 2.7424 10.0056 4.06517C8.07885 5.9969 6.49652 8.40034 5.42334 11.0359C5.33349 11.258 5.25612 11.4427 5.25113 11.4477C5.24863 11.4502 5.22118 11.3304 5.19123 11.1781C4.88425 9.64324 3.79359 8.26307 2.56067 7.84877C2.20128 7.72898 1.8369 7.70152 1.50745 7.77141C1.27784 7.81882 0.920944 8.00102 0.736256 8.16574C0.481686 8.38786 0.204654 8.80716 0.0524114 9.1965L0 9.32378L0.292007 9.34125C0.983338 9.37869 1.43258 9.58584 1.8943 10.0725C2.14388 10.3346 2.32357 10.6041 2.53322 11.0259C2.75534 11.4727 2.89511 11.8395 3.26448 12.9327C3.62887 14.0084 3.77362 14.3877 3.9658 14.7721C4.21288 15.2662 4.52485 15.683 4.80438 15.8952L4.94415 16L5.08391 15.9052C5.30853 15.7504 5.78273 15.2612 6.0348 14.9243C6.53645 14.2455 6.90084 13.6065 7.8717 11.6898C8.97733 9.50348 9.39912 8.71731 10.0231 7.68405C12.0621 4.30227 14.4106 1.90632 17.3157 0.24163C17.5279 0.121832 17.7076 0.0170088 17.7126 0.00952148C17.73 -0.00794792 17.6377 -0.000461578 17.4555 0.0244961Z" fill="currentColor"/>
                </svg>
                File Uploaded Successfully!
            </span>
             <br>
           <button class="theme-btn tp_fade_bottom" type="button" id="generateVideoBtn" hidden>Generate!</button>
        `;


        image_to_video(image_filename);
    }
});
