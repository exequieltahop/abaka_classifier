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
            // ✅ Rename variable to avoid overriding window.URL
            const modelBaseURL = "{{ asset('web_model/') }}/";

            let model, labelContainer, maxPredictions;

            // Load model
            async function loadModel() {
                const modelURL = modelBaseURL + "model.json";
                const metadataURL = modelBaseURL + "metadata.json";
                model = await window.tmImage.load(modelURL, metadataURL);
                maxPredictions = model.getTotalClasses();

                labelContainer = document.getElementById("label-container");
                labelContainer.innerHTML = "";
                for (let i = 0; i < maxPredictions; i++) {
                    labelContainer.appendChild(document.createElement("div"));
                }
            }

            await loadModel();

            // Handle file input
            document.getElementById("upload-img").addEventListener("change", async (event) => {
                const imgPreview = document.getElementById("image-preview");
                const file = event.target.files[0];
                const predicted_class = document.getElementById('predicted-class');

                if (!file) {
                    imgPreview.classList.add('hidden');
                    predicted_class.textContent = 'Class Predicted: ';
                    return;
                }

                // Show image preview

                imgPreview.classList.remove('hidden');

                // ✅ use window.URL here
                let imgElement = document.getElementById('img-preview');

                console.log(imgElement);

                imgElement.src = window.URL.createObjectURL(file);

                imgElement.onload = async () => {
                    await predict(imgElement, predicted_class);
                };
            });

            // Predict
            async function predict(image, predicted_class) {
                const prediction = await model.predict(image);

                // Find the class with the highest probability
                let topClass = prediction[0];
                for (let p of prediction) {
                    if (p.probability > topClass.probability) topClass = p;
                }

                // Display only the class name of the highest probability
                predicted_class.textContent = `Class Predicted: ${topClass.className}`;
            }

        });
    </script>



</x-guest-layout>
