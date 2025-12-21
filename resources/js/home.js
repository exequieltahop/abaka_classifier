import * as tf from "@tensorflow/tfjs";
import * as tmImage from "@teachablemachine/image";
import axios from "axios";
import Swal from "sweetalert2";

// Read CSRF token
window.token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

/* ---------------------------------------
    FILE → BASE64
-----------------------------------------*/
function fileToBase64(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = error => reject(error);
    });
}

/* ---------------------------------------
    BASE64 → FILE
-----------------------------------------*/
async function base64ToFile(base64, filename = "offline.png") {
    const response = await fetch(base64);
    const blob = await response.blob();
    return new File([blob], filename, { type: blob.type });
}

/* ---------------------------------------
   LOG IMAGE (ONLINE + OFFLINE MODE)
-----------------------------------------*/
export const logInferenceImage = async (file, className, conf) => {
    // const isOnline = navigator.onLine;

    // if (!isOnline) {

    //     const fileBase64 = await fileToBase64(file);

    //     const data = {
    //         image: fileBase64,
    //         class: className,
    //         confidence: conf,
    //         timestamp: new Date().toISOString(),
    //     };

    //     const pending = JSON.parse(localStorage.getItem("pending_inferences")) || [];
    //     pending.push(data);
    //     localStorage.setItem("pending_inferences", JSON.stringify(pending));

    //     return;
    // }

    // IF ONLINE — UPLOAD DIRECTLY
    try {
        const formData = new FormData();
        formData.append("image", file);
        formData.append("class", className);
        formData.append("probabilities", conf);

        await axios.post("/log-inference-image", formData, {
            headers: {
                "X-CSRF-TOKEN": window.token,
                "Content-Type": "multipart/form-data",
                "Accept": "application/json",
            }
        });

        Toastify({
            text: "Successfully Grade Image",
            duration: 2000,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "left",
            stopOnFocus: true,
            style: {
                background: "rgb(100, 225, 100)",
            },
        }).showToast();

    } catch (error) {
        console.error(error);
        Toastify({
            text: "Server Error, Something went wrong",
            duration: 2000,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "left",
            stopOnFocus: true,
            style: {
                background: "rgb(225, 100, 100)",
            },
        }).showToast();
    }
};

/* ---------------------------------------
    MAIN PAGE FUNCTIONALITY
-----------------------------------------*/
document.addEventListener("DOMContentLoaded", async function () {

    const video = document.getElementById("video");
    const takePicBtn = document.getElementById("take-pic-btn");
    const imgPreview = document.getElementById("image-preview");
    const imgElement = document.getElementById("img-preview");
    const predicted_class = document.getElementById("predicted-class");

    const modelBaseURL = "/web_model/";
    let model, maxPredictions;
    let lastCapturedFile = null;
    let topPrediction = null;

    /* ---------------------------------------
       LOAD MODEL
    -----------------------------------------*/
    async function loadModel() {
        const modelURL = modelBaseURL + "model.json";
        const metadataURL = modelBaseURL + "metadata.json";
        model = await tmImage.load(modelURL, metadataURL);
        maxPredictions = model.getTotalClasses();
        console.log("✔ Model loaded");
    }

    await loadModel();

    /* ---------------------------------------
        START CAMERA
    -----------------------------------------*/
    async function startCamera() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: { ideal: "environment" } },
                audio: false
            });

            video.srcObject = stream;
            await video.play();

        } catch (err) {
            console.error("Camera error:", err);
        }
    }

    function stopCamera() {
        const stream = video.srcObject;
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            video.srcObject = null;
        }
    }

    /* ---------------------------------------
        TAKE PICTURE
    -----------------------------------------*/
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

        canvas.toBlob(async (blob) => {
            lastCapturedFile = new File([blob], "captured.png", { type: "image/png" });
            await predict(imgElement, predicted_class, lastCapturedFile);
        }, "image/png");
    });

    /* ---------------------------------------
        UPLOAD IMAGE
    -----------------------------------------*/
    document.getElementById("upload-img").addEventListener("change", async (event) => {
        const file = event.target.files[0];
        if (!file) return;

        lastCapturedFile = file;

        imgPreview.classList.remove("hidden");
        imgElement.src = URL.createObjectURL(file);

        imgElement.onload = async () => {
            await predict(imgElement, predicted_class, lastCapturedFile);
        };
    });

    /* ---------------------------------------
        PREDICT
    -----------------------------------------*/
    async function predict(image, predicted_class_el, lastCapturedFile) {
        const prediction = await model.predict(image);

        topPrediction = prediction.reduce((best, p) =>
            p.probability > best.probability ? p : best
        );

        if (topPrediction.probability >= 0.5) {
            predicted_class_el.textContent =
                `Class Predicted: ${topPrediction.className} - ${(topPrediction.probability * 100).toFixed(2)}%`;

            await logInferenceImage(
                lastCapturedFile,
                topPrediction.className,
                (topPrediction.probability * 100).toFixed(2)
            );

            // ADDITIONAL CLASS INFO
            const extraInfo = getClassDescription(topPrediction.className);

            console.log(extraInfo);

            const descBox = document.getElementById("fiber-description");
            descBox.classList.remove("hidden");
            descBox.innerHTML = `
                <h3 class="font-bold text-lg">${extraInfo.Name}</h3>
                <p><b>Quality:</b> ${extraInfo.Quality}</p>
                <p><b>Meaning:</b> ${extraInfo.Meaning}</p>
                <p><b>Typical Uses:</b> ${extraInfo.TypicalUses}</p>
                <p><b>Description:</b> ${extraInfo.Description}</p>
            `;

        } else {
            predicted_class_el.textContent = "Image Not Abaca";
            Swal.fire({
                title: "Image Not Abaca",
                icon: "warning",
                text: "Image class probability is below 50%",
            });
        }
    }

    startCamera();
    window.addEventListener("beforeunload", stopCamera);

    renderEducationalInfo();
});

function getClassDescription(abacaClass) {
    switch (abacaClass) {
        case 'SS2':
            return {
                Name: "Spindle-/Machine-Stripped S2",
                Quality: "Excellent",
                Meaning: "Machine-stripped version of S2 (\"S-S2\"), very fine and clean",
                TypicalUses: "Currency paper, premium filters, specialty paper, high-quality cordage",
                Description: "Same characteristics as S2 but processed by spindle/machine. Clean, fine, light-colored; excellent stripping consistency"
            };

        case 'S2':
            return {
                Name: "",
                Quality: "Excellent",
                Meaning: "\"Streaky Two\" — very fine, clean, light ivory fiber",
                TypicalUses: "Currency paper, tea bags, specialty paper, premium cordage",
                Description: "Fiber size: 0.20–0.50 mm, Ivory white to very light brown/red streaks, Texture: Soft, very fine; Comes from inner/middle leaf sheaths"
            };

        case 'SS3':
            return {
                Name: "Spindle-/Machine-Stripped S3",
                Quality: "Excellent",
                Meaning: "Machine-stripped version of S3 (\"S-S3\"), slightly darker excellent grade",
                TypicalUses: "Filters, premium industrial paper, woven products",
                Description: "Same characteristics as S3 but processed by machine; excellent-quality fiber with more consistent strip"
            };

        case 'S3':
            return {
                Name: "",
                Quality: "Excellent",
                Meaning: "\"Streaky Three\" — fine but slightly darker than S2",
                TypicalUses: "Filters, fine papers, high-quality weaving",
                Description: "Fiber size: 0.20–0.50 mm; Color: Reddish, purple, or darker brown tones; Comes from outer leaf sheaths"
            };

        case 'I':
            return {
                Name: "Current Grade",
                Quality: "Good",
                Meaning: "Medium color & fineness",
                TypicalUses: "Rope, industrial paper, geotextiles",
                Description: "Fiber size: 0.51–0.99 mm; Color: Very light to light brown; Texture: Medium soft; Good stripping quality"
            };

        case 'G':
            return {
                Name: "Soft Seconds",
                Quality: "Good",
                Meaning: "Light brown, medium-soft good fiber",
                TypicalUses: "Rope/twine, fiber composites",
                Description: "Fiber size: 0.51–0.99 mm; Color: Dingy white, light green, dull brown; Same leaf sheath origin as S2; Good stripping quality"
            };

        case 'T':
            return {
                Name: "Tow",
                Quality: "Lowest",
                Meaning: "Short, tangled, broken fibers",
                TypicalUses: "Mats, stuffing, pulp filler, coarse brushes",
                Description: "Fiber length: < 60 cm; Made of broken, tip-cut, or tangled residues; Classified as residual grade"
            };

        case 'JK':
            return {
                Name: "Seconds",
                Quality: "Fair",
                Meaning: "Coarse, yellow-brown fiber",
                TypicalUses: "Sacks, kraft paper, lower-grade ropes",
                Description: "Fiber size: 1.00–1.50 mm; Color: Dull brown/yellow, sometimes green streaks; Fair stripping; From inner/outer leaf sheaths"
            };

        case 'M1':
            return {
                Name: "Medium Brown",
                Quality: "Fair",
                Meaning: "Dark, coarse fiber",
                TypicalUses: "Agricultural twine, heavy ropes, low-grade pulp",
                Description: "Fiber size: 1.00–1.50 mm; Color: Dark brown to almost black; Fair stripping; Usually from outer leaf sheaths"
            };

        case 'Y2':
            return {
                Name: "",
                Quality: "Low",
                Meaning: "Weak, stained, or residual fiber",
                TypicalUses: "Brown packaging paper, stuffing, low-strength rope",
                Description: "Residual fibers from grades H, JK, M1; Discolored or contaminated; Lower strength and stiffness"
            };

        default:
            return {
                Name: "Unknown Grade",
                Quality: "N/A",
                Meaning: "Unrecognized classification",
                TypicalUses: "N/A",
                Description: "The model predicted a class not found in the grading system."
            };
    }
}



const renderEducationalInfo = () => {

    const ABACA_CLASS_DESCRIPTIONS = {
        SS2: {
            Name: "Spindle-/Machine-Stripped S2",
            Quality: "Excellent",
            Meaning: "Machine-stripped version of S2 (\"S-S2\"), very fine and clean",
            TypicalUses: "Currency paper, premium filters, specialty paper, high-quality cordage",
            Description: "Same characteristics as S2 but processed by spindle/machine. Clean, fine, light-colored; excellent stripping consistency"
        },

        S2: {
            Name: "",
            Quality: "Excellent",
            Meaning: "\"Streaky Two\" — very fine, clean, light ivory fiber",
            TypicalUses: "Currency paper, tea bags, specialty paper, premium cordage",
            Description: "Fiber size: 0.20–0.50 mm, Ivory white to very light brown/red streaks, Texture: Soft, very fine; Comes from inner/middle leaf sheaths"
        },

        SS3: {
            Name: "Spindle-/Machine-Stripped S3",
            Quality: "Excellent",
            Meaning: "Machine-stripped version of S3 (\"S-S3\"), slightly darker excellent grade",
            TypicalUses: "Filters, premium industrial paper, woven products",
            Description: "Same characteristics as S3 but processed by machine; excellent-quality fiber with more consistent strip"
        },

        S3: {
            Name: "",
            Quality: "Excellent",
            Meaning: "\"Streaky Three\" — fine but slightly darker than S2",
            TypicalUses: "Filters, fine papers, high-quality weaving",
            Description: "Fiber size: 0.20–0.50 mm; Color: Reddish, purple, or darker brown tones; Comes from outer leaf sheaths"
        },

        I: {
            Name: "Current Grade",
            Quality: "Good",
            Meaning: "Medium color & fineness",
            TypicalUses: "Rope, industrial paper, geotextiles",
            Description: "Fiber size: 0.51–0.99 mm; Color: Very light to light brown; Texture: Medium soft; Good stripping quality"
        },

        G: {
            Name: "Soft Seconds",
            Quality: "Good",
            Meaning: "Light brown, medium-soft good fiber",
            TypicalUses: "Rope/twine, fiber composites",
            Description: "Fiber size: 0.51–0.99 mm; Color: Dingy white, light green, dull brown; Same leaf sheath origin as S2; Good stripping quality"
        },

        T: {
            Name: "Tow",
            Quality: "Lowest",
            Meaning: "Short, tangled, broken fibers",
            TypicalUses: "Mats, stuffing, pulp filler, coarse brushes",
            Description: "Fiber length: < 60 cm; Made of broken, tip-cut, or tangled residues; Classified as residual grade"
        },

        JK: {
            Name: "Seconds",
            Quality: "Fair",
            Meaning: "Coarse, yellow-brown fiber",
            TypicalUses: "Sacks, kraft paper, lower-grade ropes",
            Description: "Fiber size: 1.00–1.50 mm; Color: Dull brown/yellow, sometimes green streaks; Fair stripping; From inner/outer leaf sheaths"
        },

        M1: {
            Name: "Medium Brown",
            Quality: "Fair",
            Meaning: "Dark, coarse fiber",
            TypicalUses: "Agricultural twine, heavy ropes, low-grade pulp",
            Description: "Fiber size: 1.00–1.50 mm; Color: Dark brown to almost black; Fair stripping; Usually from outer leaf sheaths"
        },

        Y2: {
            Name: "",
            Quality: "Low",
            Meaning: "Weak, stained, or residual fiber",
            TypicalUses: "Brown packaging paper, stuffing, low-strength rope",
            Description: "Residual fibers from grades H, JK, M1; Discolored or contaminated; Lower strength and stiffness"
        }
    };

    const parent = document.getElementById("abaca-edu");
    
    if(parent){
        parent.innerHTML = "";
    
        for (const [code, item] of Object.entries(ABACA_CLASS_DESCRIPTIONS)) {
            const card = document.createElement("div");
            card.className = "bg-white grid basis-[24%] min-w-[300px] border border-gray-200 shadow-md";
    
            card.innerHTML = `
                <span class="block px-5 py-1 bg-violet-900 text-white font-bold text-lg rounded-tl-md rounded-tr-md m-0 h-fit">${code}</span>
    
                <div class="flex justify-center pb-4 border border-l-0 border-r-0 border-t-0 border-b-gray-300 pt-5">
                    <img src="/images/logo.png" alt="img" class="w-full max-w-[200px]" style="aspect-ratio: 1">
                </div>
    
                <div class="p-4">
                    <div class="mt-2">
                        <small class="text-sm font-bold text-white block w-fit rounded-2xl bg-blue-400 px-3 py-1 mb-4">
                            Description
                        </small>
                        <p class="text-justify mt-1 block bg-gray-100 rounded-md p-3" style="text-indent: 0.5in ">
                            ${item.Description}
                        </p>
                    </div>
                </div>
            `;
    
            parent.appendChild(card);
        }
    }
}


