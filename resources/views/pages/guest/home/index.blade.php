<x-guest-layout title="Home">
    <section class="container mx-auto">
        <div class="block space-y-3 p-3">

            {{-- open camera --}}
            <video src="" autoplay playsinline id="video"
                class="block w-full border border-blue-500 h-[300px]"></video>

            {{-- img uploaded preview --}}
            <div class="flex justify-center">
                <div id="image-preview" class="w-full rounded max-w-[500px] bg-white hidden shadow-lg p-4">
                    <img src="" alt="" id="img-preview" class="w-full" style="aspect-ratio: 1;">
                    <h4 class="font-medium text-primary text-center" id="predicted-class">Class Predicted: </h4>
                </div>
            </div>

            {{-- take pic btn --}}
            <div class="flex justify-center gap-3 flex-wrap">

                {{-- take pic btn --}}
                <x-button id="take-pic-btn" button-class="btn-primary" icon="camera">Take Picture</x-button>

                <form action="" class="flex">
                    {{-- upload btn --}}
                    <label id="upload-pic-btn" for="upload-img"
                        class="bg-primary-color text-white p-1 px-2 m-0 rounded cursor-pointer">
                        <x-icon type="upload" />
                        Upload Picture
                    </label>

                    {{-- hidden input --}}
                    <input type="file" name="upload-img" id="upload-img" class="hidden m-0">
                </form>
            </div>
        </div>
    </section>

    <!-- File Input -->
    <div id="label-container" style="margin-top:10px;"></div>

    <!-- TensorFlow & Teachable Machine -->
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@0.8/dist/teachablemachine-image.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", async function() {
            const video = document.getElementById("video");
            const takePicBtn = document.getElementById("take-pic-btn");
            const imgPreview = document.getElementById("image-preview");
            const imgElement = document.getElementById("img-preview");
            const predicted_class = document.getElementById("predicted-class");

            const modelBaseURL = "{{ asset('web_model/') }}/";
            let model, maxPredictions;

            // ✅ Load the Teachable Machine model
            async function loadModel() {
                const modelURL = modelBaseURL + "model.json";
                const metadataURL = modelBaseURL + "metadata.json";
                model = await window.tmImage.load(modelURL, metadataURL);
                maxPredictions = model.getTotalClasses();
            }

            await loadModel();

            // ✅ Open the camera
            async function startCamera() {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: "environment"
                        },
                        audio: false
                    });
                    video.srcObject = stream;
                } catch (err) {
                    console.error("Camera error:", err);
                    alert("Unable to access camera. Please allow permission.");
                }
            }

            // ✅ Stop camera when done
            function stopCamera() {
                const stream = video.srcObject;
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    video.srcObject = null;
                }
            }

            // ✅ Take picture from video and classify
            takePicBtn.addEventListener("click", async () => {
                if (!video.srcObject) {
                    alert("Camera not started yet!");
                    return;
                }

                // Create canvas for snapshot
                const canvas = document.createElement("canvas");
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const ctx = canvas.getContext("2d");
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                // Convert canvas to image preview
                imgPreview.classList.remove("hidden");
                imgElement.src = canvas.toDataURL("image/png");

                // Predict using the model
                await predict(imgElement, predicted_class);
            });

            // ✅ Handle image upload (same as before)
            document.getElementById("upload-img").addEventListener("change", async (event) => {
                const file = event.target.files[0];
                if (!file) {
                    imgPreview.classList.add("hidden");
                    predicted_class.textContent = "Class Predicted: ";
                    return;
                }
                imgPreview.classList.remove("hidden");
                imgElement.src = window.URL.createObjectURL(file);
                imgElement.onload = async () => {
                    await predict(imgElement, predicted_class);
                };
            });

            // ✅ Prediction function (unchanged)
            async function predict(image, predicted_class) {
                const prediction = await model.predict(image);
                let topClass = prediction[0];
                for (let p of prediction) {
                    if (p.probability > topClass.probability) topClass = p;
                }
                predicted_class.textContent = `Class Predicted: ${topClass.className}`;
            }

            // Start camera automatically on page load
            startCamera();

            // Optional: stop camera when leaving page
            window.addEventListener("beforeunload", stopCamera);
        });
    </script>




</x-guest-layout>
