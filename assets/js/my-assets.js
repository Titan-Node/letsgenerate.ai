// Display images from the server
var imageList = []; // Initialize an empty array to hold the image file names
console.log(myAssetsCookie);
fetch(`https://chase.titan-node-orch.com:5000/files/images/${myAssetsCookie}`)
    .then(response => response.json())
    .then(images => {
        imageList = images; // Store the fetched file names in the imageList array
        displayImages(); // Call the function to display the images
    });


// Function to generate and append the HTML
function displayImages() {
    console.log(imageList);
    console.log(myAssetsCookie);
    const container = document.getElementById('imageListContainer');
    let htmlContent = '';

    imageList.forEach((imageName) => {
        htmlContent += `
        <div class="col-xl-4 col-lg-4 col-md-6 tp_fade_left" data-fade-from="left">
            <div class="blog-item mb-30">
                <div class="blog-img">
                    <a href="https://chase.titan-node-orch.com/images/${myAssetsCookie}/${imageName}"><img src="https://chase.titan-node-orch.com/images/${myAssetsCookie}/${imageName}" alt="Image Not Found"></a>
                </div>
                <span class="pull-left"><a href="/image-to-video.php?image_filename=${imageName}" ><button type="button" id="getActiveCarouselItemId" class="btn btn-secondary btn-sm d-block" style="width: 100%;">Convert To Video</button></a></span>
            </div>
        </div>`;
    });

    container.innerHTML = htmlContent;
}



// Display videos from the server
var videoList = []; // Initialize an empty array to hold the video file names
fetch(`https://chase.titan-node-orch.com:5000/files/videos/${myAssetsCookie}`)
    .then(response => response.json())
    .then(videos => {
        videoList = videos; // Store the fetched file names in the videoList array
        displayVideos(); // Call the function to display the videos
    }
    );

// Function to generate and append the HTML
function displayVideos() {
    console.log(videoList);
    console.log(myAssetsCookie);
    const container = document.getElementById('videoListContainer');
    let htmlContent = '';

    videoList.forEach((videoName) => {
        htmlContent += `
        <div class="col-6 d-flex justify-content-center" style="padding-top: 20px; padding-bottom: 20px;">
            <video controls autoplay loop muted style="max-width: 100%; border-radius: 10px;">
                    <source src="https://chase.titan-node-orch.com/videos/${myAssetsCookie}/${videoName}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
        <br>`;
    });

    container.innerHTML = htmlContent;
}


