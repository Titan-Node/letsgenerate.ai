# Listen Flask API on port 5000
from flask import Flask, request, jsonify, send_from_directory, render_template, Response
from flask_cors import CORS
from waitress import serve
import requests
import json
import os
from werkzeug.utils import secure_filename
from prometheus_client import Counter, generate_latest, REGISTRY

defaultStatsDict = {"i2v_count": 0, "t2i_count": 0}
# Define your counters
i2v_count = Counter('i2v_count', 'Number of i2v operations')
t2i_count = Counter('t2i_count', 'Number of t2i operations')

orchUrl = "http://<your_gateway_ip_address>:8937"
hostedDomain = "your_domain.com"

app = Flask(__name__)
CORS(app)


@app.route('/t2i', methods=['POST'])
def t2i():
    print("Getting job request", json.dumps(request.json))
    cookieNumber = json.dumps(request.json['cookie_number'])

    # Ensure the Content-Type is set to application/json
    headers = {'Content-Type': 'application/json'}

    # http call to local broadcaster
    req = requests.post(orchUrl + "/text-to-image", json=request.json, headers=headers)
    if req.status_code == 200:
        print("Received results,", req.content)
        response_json = json.loads(req.content.decode('utf-8'))
        image_url = response_json['images'][0]['url']
        image_name = os.path.basename(image_url)
        full_image_url = orchUrl + image_url
        image_response = requests.get(full_image_url)
        if image_response.status_code == 200:
            image_data = image_response.content
        else:
            print("Failed to download image")
            # Handle failure appropriately
            return jsonify({"error": "Failed to save image to server"}), 500

        # Ensure the images directory exists
        images_folder = "/var/www/html/images/" + cookieNumber
        if not os.path.exists(images_folder):
            os.makedirs(images_folder)

        # Save the image
        image_filename = os.path.join(images_folder, image_name)
        with open(image_filename, 'wb') as image_file:
            image_file.write(image_data)

        print(f"Image saved to {image_filename}")

        jsonPath = '/var/www/html/stats.json'
        try:
            with open(jsonPath, 'r') as file:
                data = json.load(file)
                data["t2i_count"] += 1
            with open(jsonPath, 'w') as file:
                json.dump(data, file)
        except FileNotFoundError:
            print(f"File not found: {jsonPath}")
            with open(jsonPath, 'w') as file:
                json.dump(defaultStatsDict, file)

        return jsonify({"image_filename": cookieNumber + "/" + image_name}), 200
    else:
        print('request error from broadcaster: ' + req.text)
        return jsonify({"error": "Failed to process image request"}), 500


@app.route('/i2v', methods=['POST'])
def i2v():
    print("Getting job request", json.dumps(request.json))
    data = request.get_json()  # Get JSON data as a Python dictionary
    model_id = data['model_id']  # Directly access the model_id from the dictionary
    cookieNumber = json.dumps(request.json['cookie_number'])
    fps = json.dumps(request.json['fps'])
    width = json.dumps(request.json['width'])
    height = json.dumps(request.json['height'])
    motion_bucket_id = json.dumps(request.json['motion_bucket_id'])
    noise_aug_strength = json.dumps(request.json['noise_aug_strength'])

    # Replace this with the path to your image file
    image_path = '/var/www/html/images/' + cookieNumber + '/' + request.json['image_filename']
    url = orchUrl + '/image-to-video'

    # Open the file in binary mode
    with open(image_path, 'rb') as image_file:
        # Define the multipart/form-data payload
        files = {
            'image': (image_path, image_file),  # Tuple format: (filename, fileobject)
            'model_id': (None, model_id),
            'fps': (None, fps),
            'width': (None, width),
            'height': (None, height),
            'motion_bucket_id': (None, motion_bucket_id),
            'noise_aug_strength': (None, noise_aug_strength)
        }

        # Make the POST request
        req = requests.post(url, files=files)

        # Check if the request was successful
        if req.status_code == 200:
            print("Received results,", req.content)
            response_json = json.loads(req.content.decode('utf-8'))
            video_url = response_json['images'][0]['url']
            video_name = os.path.basename(video_url)
            full_video_url = orchUrl + video_url
            video_response = requests.get(full_video_url, stream=True)

            if video_response.status_code == 200:
                # Ensure the video directory exists
                video_folder = "/var/www/html/videos/" + cookieNumber
                if not os.path.exists(video_folder):
                    os.makedirs(video_folder)

                # Save the video
                video_filename = os.path.join(video_folder, video_name)
                with open(video_filename, 'wb') as video_file:
                    for chunk in video_response.iter_content(chunk_size=8192):
                        video_file.write(chunk)
                print("Video downloaded successfully.")
                print(f"Video saved to {video_filename}")

                jsonPath = '/var/www/html/stats.json'
                try:
                    with open(jsonPath, 'r') as file:
                        data = json.load(file)
                        data["i2v_count"] += 1
                    with open(jsonPath, 'w') as file:
                        json.dump(data, file)
                except FileNotFoundError:
                    print(f"File not found: {jsonPath}")
                    with open(jsonPath, 'w') as file:
                        json.dump(defaultStatsDict, file)

                return jsonify({"video_filename": cookieNumber + "/" + video_name}), 200

            else:
                print("Failed to download video")
                # Handle failure appropriately
                return jsonify({"error": "Failed to save video to server"}), 500
        else:
            print(f"Request failed. Status code: {req.status_code}")
            print(req.text)
            return jsonify({"error": "Failed to process video request"}), 500


@app.route('/metrics')
def metrics():
    # Read your JSON file
    with open('/var/www/html/stats.json', 'r') as f:
        data = json.load(f)

    # Update counters
    i2v_count._value.set(data['i2v_count'])
    t2i_count._value.set(data['t2i_count'])

    # Generate latest metrics
    return Response(generate_latest(REGISTRY), mimetype='text/plain')


@app.route('/upload', methods=['POST'])
def upload_file():
    if 'file' not in request.files:
        return jsonify({"error": "No file found in request"}), 500
    file = request.files['file']
    if file.filename == '':
        return jsonify({"error": "No file name found in request"}), 500
    if file:
        cookieNumber = request.form.get('cookieValue')
        print(f'Uploading file {file.filename} for cookie {cookieNumber}')
        filename = secure_filename(file.filename)
        # Save the file to the server's filesystem

        upload_folder = "/var/www/html/images/" + cookieNumber
        if not os.path.exists(upload_folder):
            os.makedirs(upload_folder)
            print(f"Created folder {upload_folder}")

        try:
            file.save("/var/www/html/images/" + cookieNumber + "/" + filename)
            print(f'File {filename} uploaded successfully.')
        except Exception as e:
            print(f"Failed to save file: {e}")
            return jsonify({"error": "Failed to save file to server"}), 500
        return jsonify({"image_filename": filename}), 200


@app.route('/files/<fileFolder>/<cookieValue>', methods=['GET'])  # Changed to GET for simplicity
def list_files(fileFolder, cookieValue):
    print(f"Listing files in folder {fileFolder} for cookie {cookieValue}")
    # Basic validation example (You should enhance this based on your requirements)
    if '..' in fileFolder or '..' in cookieValue:
        return 400  # Simple validation to prevent directory traversal

    FILES_DIRECTORY = os.path.join('/var/www/html', fileFolder, cookieValue)

    # Ensure the directory exists
    if not os.path.isdir(FILES_DIRECTORY):
        return 404  # Directory not found

    files = [f for f in os.listdir(FILES_DIRECTORY) if os.path.isfile(os.path.join(FILES_DIRECTORY, f))]
    print(f"Files found: {files}")
    return jsonify(files)


if __name__ == '__main__':
    serve(app, host=hostedDomain, port=5000)
