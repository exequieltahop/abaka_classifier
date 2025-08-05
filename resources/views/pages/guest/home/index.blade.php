<x-guest-layout title="Home">
    <video src="" autoplay playsinline id="video" class="border" style="width: 500px; height: 500px;"></video>

    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const video = document.getElementById('video');
            // Request access to the webcam
            navigator.mediaDevices.getUserMedia({ video: true, audio: false })
            .then(stream => {
                video.srcObject = stream; // Set the stream as the source
            })
            .catch(err => {
                console.error("Error accessing camera: ", err);
            });
        })
    </script>
</x-guest-layout>