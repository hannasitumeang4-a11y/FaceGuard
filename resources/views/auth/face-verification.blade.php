<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>FaceGuard - Verifikasi Wajah</title>

    <script src="https://cdn.tailwindcss.com"></script>

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
            Verifikasi Wajah
        </p>

    </div>


    <!-- INFO -->

    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">

        <p class="text-sm text-blue-700">

            Posisikan wajah Anda di tengah kamera.
            Setelah wajah terdeteksi, silakan berkedip
            untuk melakukan liveness detection.

        </p>

    </div>


    <!-- CAMERA -->

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

        Memuat sistem verifikasi...

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


    <!-- VERIFY BUTTON -->

    <div class="mt-3">

        <button
            type="button"
            id="verifyFace"
            disabled
            class="w-full bg-green-600 hover:bg-green-700
                   disabled:bg-gray-400
                   text-white font-semibold
                   py-3 rounded-lg"
        >

            Verifikasi Wajah

        </button>

    </div>


</div>



<script>


// ======================================================
// ELEMENT
// ======================================================

const video =
    document.getElementById('video');

const statusText =
    document.getElementById('status');

const startCameraButton =
    document.getElementById('startCamera');

const verifyFaceButton =
    document.getElementById('verifyFace');


// ======================================================
// VARIABLE
// ======================================================

let cameraStream = null;

let modelsLoaded = false;

let livenessPassed = false;

let blinkDetected = false;


// ======================================================
// LOAD MODEL
// ======================================================

async function loadModels()
{
    try {

        statusText.innerText =
            'Memuat model pengenalan wajah...';


        await faceapi.nets.tinyFaceDetector.loadFromUri(
            '/models'
        );


        await faceapi.nets.faceLandmark68Net.loadFromUri(
            '/models'
        );


        await faceapi.nets.faceRecognitionNet.loadFromUri(
            '/models'
        );


        modelsLoaded = true;


        statusText.innerText =
            'Model berhasil dimuat. Silakan aktifkan kamera.';


        startCameraButton.disabled =
            false;

        startCameraButton.innerText =
            'Aktifkan Kamera';


    } catch (error) {

        console.error(
            'MODEL ERROR:',
            error
        );


        statusText.innerText =
            'Model wajah gagal dimuat. Periksa folder public/models.';


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

        if (
            ! navigator.mediaDevices ||
            ! navigator.mediaDevices.getUserMedia
        ) {

            statusText.innerText =
                'Browser tidak mendukung akses kamera.';

            return;
        }


        try {

            statusText.innerText =
                'Meminta izin kamera...';


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


            video.srcObject =
                cameraStream;


            await video.play();


            startCameraButton.disabled =
                true;

            startCameraButton.innerText =
                'Kamera Aktif';


            verifyFaceButton.disabled =
                false;


            statusText.innerText =
                'Kamera aktif. Posisikan wajah di tengah.';


            startLivenessDetection();


        } catch (error) {

            console.error(
                'CAMERA ERROR:',
                error
            );


            if (
                error.name ===
                'NotAllowedError'
            ) {

                statusText.innerText =
                    'Akses kamera ditolak. Izinkan kamera pada browser.';

            } else if (
                error.name ===
                'NotFoundError'
            ) {

                statusText.innerText =
                    'Kamera tidak ditemukan.';

            } else {

                statusText.innerText =
                    'Kamera tidak dapat digunakan.';
            }

        }

    }
);



// ======================================================
// LIVENESS DETECTION
// ======================================================
//
// Metode sederhana:
// sistem mendeteksi perubahan rasio mata
// untuk mengenali kedipan.
//
// ======================================================

function calculateEyeAspectRatio(eye)
{

    const vertical1 =
        distance(
            eye[1],
            eye[5]
        );


    const vertical2 =
        distance(
            eye[2],
            eye[4]
        );


    const horizontal =
        distance(
            eye[0],
            eye[3]
        );


    return (
        vertical1 +
        vertical2
    ) / (
        2 *
        horizontal
    );
}



function distance(point1, point2)
{

    const x =
        point1.x -
        point2.x;


    const y =
        point1.y -
        point2.y;


    return Math.sqrt(
        x * x +
        y * y
    );
}



// ======================================================
// LIVENESS PROCESS
// ======================================================

function startLivenessDetection()
{

    const interval =
        setInterval(
            async function ()
            {

                if (
                    !cameraStream ||
                    blinkDetected
                ) {

                    clearInterval(interval);

                    return;
                }


                const detection =
                    await faceapi
                        .detectSingleFace(
                            video,
                            new faceapi.TinyFaceDetectorOptions({
                                inputSize: 224,
                                scoreThreshold: 0.5
                            })
                        )
                        .withFaceLandmarks();


                if (!detection) {

                    statusText.innerText =
                        'Wajah belum terdeteksi. Posisikan wajah di tengah kamera.';

                    return;
                }


                const landmarks =
                    detection.landmarks;


                const leftEye =
                    landmarks.getLeftEye();


                const rightEye =
                    landmarks.getRightEye();


                const leftEAR =
                    calculateEyeAspectRatio(
                        leftEye
                    );


                const rightEAR =
                    calculateEyeAspectRatio(
                        rightEye
                    );


                const averageEAR =
                    (
                        leftEAR +
                        rightEAR
                    ) / 2;

                console.log('LEFT EAR:', leftEAR);
                console.log('RIGHT EAR:', rightEAR);
                console.log('AVERAGE EAR:', averageEAR);


                /*
                |--------------------------------------------------------------------------
                | DETEKSI KEDIP
                |--------------------------------------------------------------------------
                */

                if (
                    averageEAR < 0.30
                ) {

                    blinkDetected =
                        true;

                    livenessPassed =
                        true;


                    statusText.innerText =
                        'Kedipan terdeteksi. Liveness berhasil. Silakan verifikasi wajah.';

                } else {

                    statusText.innerText =
                        'Wajah terdeteksi. Silakan berkedip untuk verifikasi liveness.';

                }

            },
            100
        );
}



// ======================================================
// VERIFIKASI WAJAH
// ======================================================

verifyFaceButton.addEventListener(
    'click',
    async function ()
    {

        if (!modelsLoaded) {

            statusText.innerText =
                'Model belum selesai dimuat.';

            return;
        }


        if (!cameraStream) {

            statusText.innerText =
                'Aktifkan kamera terlebih dahulu.';

            return;
        }


        if (!livenessPassed) {

            statusText.innerText =
                'Silakan berkedip terlebih dahulu.';

            return;
        }


        verifyFaceButton.disabled =
            true;


        statusText.innerText =
            'Menganalisis wajah...';


        try {


            // ==================================================
            // DETEKSI + FACE DESCRIPTOR
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


            if (!detection) {

                statusText.innerText =
                    'Wajah tidak terdeteksi.';

                verifyFaceButton.disabled =
                    false;

                return;
            }


            // ==================================================
            // DESCRIPTOR
            // ==================================================

            const descriptor =
                Array.from(
                    detection.descriptor
                );


            console.log(
                'Current face embedding:',
                descriptor
            );


            // ==================================================
            // KIRIM KE LARAVEL
            // ==================================================

            const response =
                await fetch(
                    '{{ route("face.verification.verify") }}',
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
                                descriptor,

                            liveness_passed:
                                livenessPassed

                        })

                    }
                );


            const result =
                await response.json();


            if (!response.ok) {

                throw new Error(
                    result.message ||
                    'Verifikasi wajah gagal.'
                );
            }


            // ==================================================
            // BERHASIL
            // ==================================================

            statusText.innerText =
                result.message;


            // Matikan kamera

            if (cameraStream) {

                cameraStream
                    .getTracks()
                    .forEach(
                        track => track.stop()
                    );

            }


            // Redirect

            setTimeout(
                function ()
                {

                    window.location.href =
                        result.redirect;

                },
                1000
            );


        } catch (error) {

            console.error(
                'VERIFICATION ERROR:',
                error
            );


            statusText.innerText =
                error.message;


            verifyFaceButton.disabled =
                false;

        }

    }
);



// ======================================================
// START
// ======================================================

loadModels();

</script>


</body>

</html>