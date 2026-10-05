<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>FaceGuard - Registrasi Wajah</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FACE API -->
    <script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

</head>


<body class="bg-gray-100 min-h-screen flex items-center justify-center">


<div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-xl">

    <!-- HEADER -->

    <div class="text-center">

        <h1 class="text-3xl font-bold text-gray-800">
            FaceGuard
        </h1>

        <p class="mt-2 text-gray-500">
            Registrasi Wajah
        </p>

    </div>


    <!-- INFORMASI -->

    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">

        <p class="text-sm text-blue-700">

            Silakan posisikan wajah Anda di tengah kamera.
            Pastikan wajah terlihat jelas dan pencahayaan cukup.

        </p>

    </div>


    <!-- VIDEO -->

    <div class="mt-6 flex justify-center">

        <video
            id="video"
            width="400"
            height="300"
            autoplay
            muted
            playsinline
            class="rounded-xl border border-gray-300 bg-black"
        ></video>

    </div>


    <!-- STATUS -->

    <div
        id="status"
        class="mt-4 text-center text-sm text-gray-600"
    >

        Menyiapkan sistem...

    </div>


    <!-- CAMERA BUTTON -->

    <div class="mt-6">

        <button
            type="button"
            id="startCamera"
            disabled
            class="w-full bg-indigo-600 hover:bg-indigo-700
                   disabled:bg-gray-400
                   text-white font-semibold
                   py-3 rounded-lg"
        >

            Memuat Sistem...

        </button>

    </div>


    <!-- REGISTER BUTTON -->

    <div class="mt-3">

        <button
            type="button"
            id="registerFace"
            disabled
            class="w-full bg-green-600 hover:bg-green-700
                   disabled:bg-gray-400
                   text-white font-semibold
                   py-3 rounded-lg"
        >

            Daftarkan Wajah

        </button>

    </div>


</div>



<script>


// ======================================================
// ELEMENT HTML
// ======================================================

const video =
    document.getElementById('video');

const statusText =
    document.getElementById('status');

const startCameraButton =
    document.getElementById('startCamera');

const registerFaceButton =
    document.getElementById('registerFace');


// ======================================================
// VARIABLE
// ======================================================

let cameraStream = null;

let modelsLoaded = false;


// ======================================================
// LOAD MODEL FACE API
// ======================================================

async function loadModels()
{

    try {

        statusText.innerText =
            'Memuat model pengenalan wajah...';

        startCameraButton.disabled = true;

        startCameraButton.innerText =
            'Memuat Sistem...';


        console.log('Mulai memuat model...');


        // Tiny Face Detector

        await faceapi.nets.tinyFaceDetector.loadFromUri(
            '/models'
        );

        console.log(
            'Tiny Face Detector berhasil dimuat.'
        );


        // Face Landmark

        await faceapi.nets.faceLandmark68Net.loadFromUri(
            '/models'
        );

        console.log(
            'Face Landmark berhasil dimuat.'
        );


        // Face Recognition

        await faceapi.nets.faceRecognitionNet.loadFromUri(
            '/models'
        );

        console.log(
            'Face Recognition berhasil dimuat.'
        );


        modelsLoaded = true;


        statusText.innerText =
            'Model berhasil dimuat. Silakan aktifkan kamera.';


        startCameraButton.disabled = false;

        startCameraButton.innerText =
            'Aktifkan Kamera';


        console.log(
            'Semua model berhasil dimuat.'
        );


    } catch (error) {

        console.error(
            'MODEL ERROR:',
            error
        );


        statusText.innerText =
            'Model wajah gagal dimuat. Periksa folder public/models.';


        startCameraButton.disabled = true;

        startCameraButton.innerText =
            'Model Gagal Dimuat';

    }

}



// ======================================================
// AKTIFKAN KAMERA
// ======================================================

startCameraButton.addEventListener(
    'click',
    async function ()
    {

        console.log(
            'Tombol Aktifkan Kamera ditekan.'
        );


        // Cek dukungan kamera

        if (
            !navigator.mediaDevices ||
            !navigator.mediaDevices.getUserMedia
        ) {

            statusText.innerText =
                'Browser tidak mendukung akses kamera.';

            console.error(
                'getUserMedia tidak tersedia.'
            );

            return;

        }


        try {

            statusText.innerText =
                'Meminta izin kamera...';


            // Minta akses kamera

            cameraStream =
                await navigator.mediaDevices.getUserMedia({

                    video: {
                        facingMode: 'user',
                        width: {
                            ideal: 640
                        },
                        height: {
                            ideal: 480
                        }
                    },

                    audio: false

                });


            console.log(
                'Kamera berhasil diakses.'
            );


            // Masukkan kamera ke video

            video.srcObject =
                cameraStream;


            // Pastikan video berjalan

            await video.play();


            // Ubah tombol

            startCameraButton.disabled =
                true;

            startCameraButton.innerText =
                'Kamera Aktif';


            // Aktifkan tombol registrasi

            registerFaceButton.disabled =
                false;


            statusText.innerText =
                'Kamera aktif. Posisikan wajah di tengah kamera.';


        } catch (error) {

            console.error(
                'CAMERA ERROR:',
                error
            );


            let message =
                'Kamera tidak dapat diakses.';


            if (error.name === 'NotAllowedError') {

                message =
                    'Akses kamera ditolak. Izinkan kamera pada browser.';

            }

            else if (error.name === 'NotFoundError') {

                message =
                    'Kamera tidak ditemukan pada perangkat.';

            }

            else if (error.name === 'NotReadableError') {

                message =
                    'Kamera sedang digunakan aplikasi lain.';

            }

            else if (error.name === 'SecurityError') {

                message =
                    'Browser memblokir akses kamera.';

            }


            statusText.innerText =
                message;


            startCameraButton.disabled =
                false;


            startCameraButton.innerText =
                'Coba Aktifkan Kamera Lagi';

        }

    }
);



// ======================================================
// DAFTARKAN WAJAH
// ======================================================

registerFaceButton.addEventListener(
    'click',
    async function ()
    {

        // Cek model

        if (!modelsLoaded) {

            statusText.innerText =
                'Model wajah belum selesai dimuat.';

            return;

        }


        // Cek kamera

        if (!cameraStream) {

            statusText.innerText =
                'Aktifkan kamera terlebih dahulu.';

            return;

        }


        // Disable tombol

        registerFaceButton.disabled =
            true;


        statusText.innerText =
            'Mendeteksi wajah...';


        try {


            // ==================================================
            // DETEKSI WAJAH
            // ==================================================

            const detection =
                await faceapi
                    .detectSingleFace(
                        video,
                        new faceapi.TinyFaceDetectorOptions({

                            inputSize: 224,

                            scoreThreshold: 0.5

                        })
                    )
                    .withFaceLandmarks()
                    .withFaceDescriptor();


            // ==================================================
            // JIKA WAJAH TIDAK TERDETEKSI
            // ==================================================

            if (!detection) {

                statusText.innerText =
                    'Wajah tidak terdeteksi. Pastikan wajah terlihat jelas dan berada di tengah kamera.';

                registerFaceButton.disabled =
                    false;

                return;

            }


            // ==================================================
            // AMBIL FACE DESCRIPTOR
            // ==================================================

            const descriptor =
                Array.from(
                    detection.descriptor
                );


            console.log(
                'Face embedding:',
                descriptor
            );


            console.log(
                'Jumlah nilai:',
                descriptor.length
            );


            // Pastikan 128 nilai

            if (descriptor.length !== 128) {

                throw new Error(
                    'Face embedding tidak valid. Jumlah data bukan 128.'
                );

            }


            // ==================================================
            // KIRIM KE LARAVEL
            // ==================================================

            statusText.innerText =
                'Menyimpan data wajah...';


            const response =
                await fetch(
                    '{{ route("face.registration.store") }}',
                    {

                        method: 'POST',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                '{{ csrf_token() }}'

                        },

                        body: JSON.stringify({

                            face_embedding:
                                descriptor

                        })

                    }
                );


            // ==================================================
            // RESPONSE LARAVEL
            // ==================================================

            const result =
                await response.json();


            if (!response.ok) {

                throw new Error(
                    result.message ||
                    'Gagal menyimpan data wajah.'
                );

            }


            // ==================================================
            // BERHASIL
            // ==================================================

            statusText.innerText =
                result.message ||
                'Wajah berhasil didaftarkan.';


            // Matikan kamera

            if (cameraStream) {

                cameraStream
                    .getTracks()
                    .forEach(
                        track => track.stop()
                    );

            }


            // ==================================================
            // REDIRECT DASHBOARD
            // ==================================================

            setTimeout(
                function ()
                {

                    window.location.href =
                        result.redirect;

                },
                1500
            );


        } catch (error) {

            console.error(
                'REGISTRATION ERROR:',
                error
            );


            statusText.innerText =
                'Gagal mendaftarkan wajah: ' +
                error.message;


            registerFaceButton.disabled =
                false;

        }

    }
);



// ======================================================
// MULAI LOAD MODEL
// ======================================================

loadModels();

</script>


</body>

</html>