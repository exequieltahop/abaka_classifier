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
            let lastCapturedFile = null;
            let topPrediction = null;

            // Load Teachable Machine model
            async function loadModel() {
                const modelURL = modelBaseURL + "model.json";
                const metadataURL = modelBaseURL + "metadata.json";
                model = await window.tmImage.load(modelURL, metadataURL);
                maxPredictions = model.getTotalClasses();
            }

            await loadModel();

            // ---------- CAMERA FIX ----------
            async function startCamera() {
                try {
                    // Use back camera IF available, fallback if not
                    const stream = await navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: {
                                ideal: "environment"
                            }
                        },
                        audio: false
                    });

                    video.srcObject = stream;
                    await video.play();
                    console.log("Camera started successfully.");
                } catch (err) {
                    console.error("Camera error:", err);

                    if (err.name === "NotReadableError") {
                        alert(
                            "Camera is currently in use by another app. Close Messenger/Zoom/Camera app and try again."
                        );
                    } else if (err.name === "NotAllowedError") {
                        alert("Camera permission denied. Please enable it in browser site settings.");
                    } else if (err.name === "NotFoundError") {
                        alert("No camera detected on this device.");
                    } else if (err.name === "OverconstrainedError") {
                        alert("Requested camera not available. Device has no back camera.");
                    } else {
                        alert("Camera error: " + err.message);
                    }
                }
            }

            function stopCamera() {
                const stream = video.srcObject;
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    video.srcObject = null;
                }
            }

            // -------- TAKE PICTURE FROM CAMERA --------
            takePicBtn.addEventListener("click", async () => {
                if (!video.srcObject) {
                    alert("Camera not started!");
                    return;
                }

                const canvas = document.createElement("canvas");
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const ctx = canvas.getContext("2d");
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                imgPreview.classList.remove("hidden");
                imgElement.src = canvas.toDataURL("image/png");

                // convert canvas to file
                canvas.toBlob(async (blob) => {
                    lastCapturedFile = new File([blob], "captured.png", {
                        type: "image/png"
                    });

                    await predict(imgElement, predicted_class, lastCapturedFile);
                    // await logInferenceImage(lastCapturedFile, topPrediction.className,
                    //     topPrediction.probability);
                }, "image/png");
            });

            // -------- HANDLE UPLOAD IMAGE --------
            document.getElementById("upload-img").addEventListener("change", async (event) => {
                const file = event.target.files[0];
                if (!file) return;

                lastCapturedFile = file;

                imgPreview.classList.remove("hidden");
                imgElement.src = URL.createObjectURL(file);

                imgElement.onload = async () => {
                    await predict(imgElement, predicted_class, lastCapturedFile);
                    // await logInferenceImage(lastCapturedFile, topPrediction.className,
                    //     topPrediction.probability);
                };
            });

            // -------- PREDICTION --------
            async function predict(image, predicted_class_el, lastCapturedFile) {
                const prediction = await model.predict(image);

                topPrediction = prediction.reduce((best, p) =>
                    p.probability > best.probability ? p : best
                );

                if (topPrediction.probability >= 0.5) {
                    predicted_class_el.textContent =
                        `Class Predicted: ${topPrediction.className} - ${(topPrediction.probability * 100).toFixed(2)}%`;

                    await logInferenceImage(lastCapturedFile, topPrediction.className, (topPrediction.probability * 100).toFixed(2));
                } else {
                    predicted_class_el.textContent = "Image Not Abaca";
                    Swal.fire({
                        title: 'Image Not Abaca',
                        icon: 'warning',
                        text: 'Image Class Probability is lower than 90%, image unclassified'
                    });
                }
            }

            // Start camera on page load
            startCamera();
            window.addEventListener("beforeunload", stopCamera);
        });

        // -------- SEND IMAGE & DATA TO SERVER --------
        const logInferenceImage = async (file, className, conf) => {
            try {
                const formData = new FormData();

                formData.append("image", file);
                formData.append("class", className);
                formData.append("probabilities", conf);


                const response = await axios.post("/log-inference-image", formData, {
                    headers: {
                        "X-CSRF-TOKEN": window.token,
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'application/json'
                    }
                });
            } catch (error) {
                console.error(error);
            }
        };
    </script>

</x-guest-layout>
