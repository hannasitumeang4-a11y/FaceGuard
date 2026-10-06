```php
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>FaceGuard - Registrasi Wajah</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FACE API -->
    <script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

</head>

<body class="min-h-screen bg-slate-950 text-white">

<div class="min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-2xl">

        <div class="bg-slate-900 rounded-3xl shadow-2xl border border-slate-800 p-6 md:p-8">

            <!-- HEADER -->

            <div class="text-center mb-6">

                <h1 class="text-2xl md:text-3xl font-bold">
                    Registrasi Wajah
                </h1>

                <p class="text-slate-400 mt-2">
                    Ikuti instruksi liveness sebelum mendaftarkan wajah.
                </p>

            </div>


            <!-- CAMERA -->

            <div class="relative bg-black rounded-2xl overflow-hidden">

                <video
                    id="video"
                    autoplay
                    muted
                    playsinline
                    class="w-full aspect-video object-cover"
                ></video>

                <div
                    id="cameraStatus"
                    class="absolute top-4 left-4 bg-black/70 px-4 py-2 rounded-full text-sm"
                >
                    Menyiapkan kamera...
                </div>

            </div>


            <!-- LIVENESS PANEL -->

            <div class="mt-6 bg-slate-800 rounded-2xl p-5">

                <div class="flex justify-between items-center mb-4">

                    <div>

                        <p class="text-sm text-slate-400">
                            Liveness Challenge
                        </p>

                        <h2
                            id="challengeTitle"
                            class="text-xl font-bold mt-1"
                        >
                            Menyiapkan...
                        </h2>

                    </div>

                    <div
                        id="challengeCounter"
                        class="bg-slate-700 px-4 py-2 rounded-full text-sm"
                    >
                        0 / 3
                    </div>

                </div>


                <!-- INSTRUCTION -->

                <div
                    id="instruction"
                    class="bg-slate-950 rounded-xl p-4 text-center"
                >
                    Menyiapkan deteksi...
                </div>


                <!-- STATUS -->

                <div
                    id="livenessStatus"
                    class="mt-4 text-center text-sm text-slate-300"
                >
                    Tunggu sebentar...
                </div>


                <!-- PROGRESS -->

                <div class="mt-4">

                    <div class="h-2 bg-slate-700 rounded-full overflow-hidden">

                        <div
                            id="progressBar"
                            class="h-full bg-emerald-500 transition-all duration-300"
                            style="width: 0%"
                        ></div>

                    </div>

                </div>


                <!-- RETRY -->

                <button
                    id="retryButton"
                    type="button"
                    class="hidden w-full mt-4 py-2 rounded-xl bg-amber-600 hover:bg-amber-500 font-semibold transition"
                >
                    Ulangi Liveness
                </button>

            </div>


            <!-- REGISTER BUTTON -->

            <button
                id="registerButton"
                type="button"
                disabled
                class="w-full mt-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 disabled:bg-slate-700 disabled:text-slate-500 disabled:cursor-not-allowed font-semibold transition"
            >
                Daftar Wajah
            </button>


            <!-- MESSAGE -->

            <div
                id="message"
                class="mt-4 text-center text-sm"
            ></div>

        </div>

    </div>

</div>


<script>

/*
|--------------------------------------------------------------------------
| ELEMENTS
|--------------------------------------------------------------------------
*/

const video =
    document.getElementById("video");

const cameraStatus =
    document.getElementById("cameraStatus");

const challengeTitle =
    document.getElementById("challengeTitle");

const challengeCounter =
    document.getElementById("challengeCounter");

const instruction =
    document.getElementById("instruction");

const livenessStatus =
    document.getElementById("livenessStatus");

const progressBar =
    document.getElementById("progressBar");

const registerButton =
    document.getElementById("registerButton");

const retryButton =
    document.getElementById("retryButton");

const message =
    document.getElementById("message");


/*
|--------------------------------------------------------------------------
| SERVER CHALLENGE
|--------------------------------------------------------------------------
*/

const livenessChallenge =
    @json(session('face_liveness_challenge', []));


/*
|--------------------------------------------------------------------------
| STATE
|--------------------------------------------------------------------------
*/

let currentStep = 0;

let livenessPassed = false;

let isDetecting = false;

let detectionInterval = null;

let challengeTimer = null;

let challengeStartTime = null;

let savedDescriptor = null;


/*
|--------------------------------------------------------------------------
| BLINK STATE
|--------------------------------------------------------------------------
*/

let earSamples = [];

let baselineEAR = null;

let eyeWasClosed = false;

let blinkCooldown = false;


/*
|--------------------------------------------------------------------------
| CONFIGURATION
|--------------------------------------------------------------------------
*/

const MAX_CHALLENGE_TIME = 15000;

const CALIBRATION_SAMPLES = 12;


/*
|--------------------------------------------------------------------------
| LOAD MODELS
|--------------------------------------------------------------------------
*/

async function loadModels()
{
    cameraStatus.innerText =
        "Memuat model face detection...";

    await faceapi.nets.tinyFaceDetector.loadFromUri(
        "/models"
    );


    cameraStatus.innerText =
        "Memuat face landmark...";

    await faceapi.nets.faceLandmark68Net.loadFromUri(
        "/models"
    );


    cameraStatus.innerText =
        "Memuat face recognition...";

    await faceapi.nets.faceRecognitionNet.loadFromUri(
        "/models"
    );


    cameraStatus.innerText =
        "Model berhasil dimuat.";
}


/*
|--------------------------------------------------------------------------
| CAMERA
|--------------------------------------------------------------------------
*/

async function startCamera()
{
    try {

        const stream =
            await navigator.mediaDevices.getUserMedia({

                video: {
                    facingMode: "user",

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
            stream;


        await new Promise(resolve => {

            video.onloadedmetadata = () => {

                video.play();

                resolve();

            };

        });


        cameraStatus.innerText =
            "Kamera aktif";


        return true;

    } catch (error) {

        console.error(error);


        cameraStatus.innerText =
            "Kamera gagal digunakan.";


        message.innerText =
            "Akses kamera ditolak atau kamera sedang digunakan aplikasi lain.";


        message.className =
            "mt-4 text-center text-sm text-red-400";


        return false;
    }
}


/*
|--------------------------------------------------------------------------
| DISTANCE
|--------------------------------------------------------------------------
*/

function distance(point1, point2)
{
    return Math.sqrt(
        Math.pow(
            point1.x - point2.x,
            2
        )
        +
        Math.pow(
            point1.y - point2.y,
            2
        )
    );
}


/*
|--------------------------------------------------------------------------
| EAR
|--------------------------------------------------------------------------
*/

function calculateEAR(eye)
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


    if (horizontal === 0) {

        return 0;

    }


    return (
        (vertical1 + vertical2)
        /
        (2 * horizontal)
    );
}


/*
|--------------------------------------------------------------------------
| HEAD DIRECTION
|--------------------------------------------------------------------------
*/

function getHeadDirection(landmarks)
{
    const nose =
        landmarks.getNose();


    const jaw =
        landmarks.getJawOutline();


    const noseX =
        nose[3].x;


    const leftSide =
        jaw[0].x;


    const rightSide =
        jaw[16].x;


    const faceWidth =
        rightSide - leftSide;


    if (faceWidth <= 0) {

        return null;

    }


    const relativePosition =
        (noseX - leftSide)
        /
        faceWidth;


    /*
    |--------------------------------------------------------------------------
    | LEFT
    |--------------------------------------------------------------------------
    */

    if (relativePosition > 0.57) {

        return "left";

    }


    /*
    |--------------------------------------------------------------------------
    | RIGHT
    |--------------------------------------------------------------------------
    */

    if (relativePosition < 0.43) {

        return "right";

    }


    return "center";
}


/*
|--------------------------------------------------------------------------
| INSTRUCTION
|--------------------------------------------------------------------------
*/

function getInstruction(action)
{
    if (action === "blink") {

        return "👁️ Kedipkan mata satu kali.";

    }


    if (action === "left") {

        return "⬅️ Gerakkan kepala ke kiri.";

    }


    if (action === "right") {

        return "➡️ Gerakkan kepala ke kanan.";

    }


    return "Ikuti instruksi.";
}


/*
|--------------------------------------------------------------------------
| RESET BLINK
|--------------------------------------------------------------------------
*/

function resetBlink()
{
    earSamples = [];

    baselineEAR = null;

    eyeWasClosed = false;

    blinkCooldown = false;
}


/*
|--------------------------------------------------------------------------
| START CHALLENGE TIMER
|--------------------------------------------------------------------------
*/

function startChallengeTimer()
{
    clearTimeout(
        challengeTimer
    );


    challengeStartTime =
        Date.now();


    challengeTimer =
        setTimeout(() => {

            if (
                !livenessPassed &&
                currentStep <
                livenessChallenge.length
            ) {

                failLiveness(
                    "⏱️ Challenge terlalu lama. Silakan ulangi liveness."
                );

            }

        }, MAX_CHALLENGE_TIME);
}


/*
|--------------------------------------------------------------------------
| STOP TIMER
|--------------------------------------------------------------------------
*/

function stopChallengeTimer()
{
    clearTimeout(
        challengeTimer
    );

    challengeTimer =
        null;
}


/*
|--------------------------------------------------------------------------
| SHOW CHALLENGE
|--------------------------------------------------------------------------
*/

function showCurrentChallenge()
{
    if (
        !livenessChallenge.length
    ) {

        challengeTitle.innerText =
            "Challenge tidak ditemukan";


        instruction.innerText =
            "Silakan refresh halaman.";


        return;

    }


    const action =
        livenessChallenge[
            currentStep
        ];


    challengeTitle.innerText =
        action.toUpperCase();


    instruction.innerText =
        getInstruction(action);


    challengeCounter.innerText =
        `${currentStep + 1} / ${livenessChallenge.length}`;


    progressBar.style.width =
        `${(
            currentStep /
            livenessChallenge.length
        ) * 100}%`;


    livenessStatus.innerText =
        "Menunggu aksi...";


    livenessStatus.className =
        "mt-4 text-center text-sm text-slate-300";


    resetBlink();


    startChallengeTimer();
}


/*
|--------------------------------------------------------------------------
| FAIL LIVENESS
|--------------------------------------------------------------------------
*/

function failLiveness(reason)
{
    stopChallengeTimer();


    livenessPassed =
        false;


    currentStep =
        0;


    savedDescriptor =
        null;


    registerButton.disabled =
        true;


    retryButton.classList.remove(
        "hidden"
    );


    challengeTitle.innerText =
        "LIVENESS GAGAL";


    challengeCounter.innerText =
        "0 / 3";


    instruction.innerText =
        reason;


    livenessStatus.innerText =
        "Tekan tombol Ulangi Liveness untuk mencoba lagi.";


    livenessStatus.className =
        "mt-4 text-center text-sm text-red-400 font-semibold";


    progressBar.style.width =
        "0%";
}


/*
|--------------------------------------------------------------------------
| MOVE TO NEXT
|--------------------------------------------------------------------------
*/

async function moveToNextChallenge()
{
    stopChallengeTimer();


    currentStep++;


    if (
        currentStep >=
        livenessChallenge.length
    ) {

        await completeLiveness();

        return;

    }


    showCurrentChallenge();
}


/*
|--------------------------------------------------------------------------
| COMPLETE LIVENESS
|--------------------------------------------------------------------------
*/

async function completeLiveness()
{
    livenessPassed =
        true;


    progressBar.style.width =
        "100%";


    challengeCounter.innerText =
        `${livenessChallenge.length} / ${livenessChallenge.length}`;


    challengeTitle.innerText =
        "LIVENESS BERHASIL";


    instruction.innerText =
        "✅ Semua challenge berhasil dilakukan.";


    livenessStatus.innerText =
        "Mengambil data wajah...";


    livenessStatus.className =
        "mt-4 text-center text-sm text-emerald-400 font-semibold";


    retryButton.classList.add(
        "hidden"
    );


    /*
    |--------------------------------------------------------------------------
    | TAKE DESCRIPTOR NOW
    |--------------------------------------------------------------------------
    */

    try {

        const detection =
            await faceapi
                .detectSingleFace(
                    video,
                    new faceapi.TinyFaceDetectorOptions({

                        inputSize: 320,

                        scoreThreshold: 0.45

                    })
                )
                .withFaceLandmarks()
                .withFaceDescriptor();


        if (!detection) {

            failLiveness(
                "❌ Wajah tidak terdeteksi setelah liveness selesai."
            );

            return;

        }


        savedDescriptor =
            Array.from(
                detection.descriptor
            );


        livenessStatus.innerText =
            "✅ Liveness dan wajah berhasil dibaca.";


        instruction.innerText =
            "Sekarang klik Daftar Wajah.";


        registerButton.disabled =
            false;


    } catch (error) {

        console.error(error);


        failLiveness(
            "❌ Data wajah gagal dibaca. Silakan ulangi."
        );

    }
}


/*
|--------------------------------------------------------------------------
| BLINK DETECTION
|--------------------------------------------------------------------------
*/

function detectBlink(landmarks)
{
    const leftEye =
        landmarks.getLeftEye();


    const rightEye =
        landmarks.getRightEye();


    const leftEAR =
        calculateEAR(
            leftEye
        );


    const rightEAR =
        calculateEAR(
            rightEye
        );


    const currentEAR =
        (
            leftEAR +
            rightEAR
        )
        /
        2;


    /*
    |--------------------------------------------------------------------------
    | CALIBRATION
    |--------------------------------------------------------------------------
    */

    if (
        baselineEAR === null
    ) {

        earSamples.push(
            currentEAR
        );


        livenessStatus.innerText =
            `Kalibrasi mata... ${earSamples.length}/${CALIBRATION_SAMPLES}`;


        if (
            earSamples.length >=
            CALIBRATION_SAMPLES
        ) {

            baselineEAR =
                earSamples.reduce(
                    (a, b) => a + b,
                    0
                )
                /
                earSamples.length;


            livenessStatus.innerText =
                "Kalibrasi selesai. Kedipkan mata satu kali.";

        }


        return false;

    }


    /*
    |--------------------------------------------------------------------------
    | TOLERANT THRESHOLD
    |--------------------------------------------------------------------------
    */

    const closeThreshold =
        baselineEAR * 0.88;


    const openThreshold =
        baselineEAR * 0.94;


    /*
    |--------------------------------------------------------------------------
    | EYE CLOSED
    |--------------------------------------------------------------------------
    */

    if (
        currentEAR <
        closeThreshold
        &&
        !eyeWasClosed
        &&
        !blinkCooldown
    ) {

        eyeWasClosed =
            true;


        livenessStatus.innerText =
            "😑 Mata tertutup... buka kembali.";

        return false;

    }


    /*
    |--------------------------------------------------------------------------
    | EYE OPEN AGAIN
    |--------------------------------------------------------------------------
    */

    if (
        eyeWasClosed
        &&
        currentEAR >
        openThreshold
        &&
        !blinkCooldown
    ) {

        eyeWasClosed =
            false;


        blinkCooldown =
            true;


        livenessStatus.innerText =
            "✅ Kedipan terdeteksi!";


        setTimeout(() => {

            blinkCooldown =
                false;

        }, 700);


        return true;

    }


    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */

    if (
        !eyeWasClosed
    ) {

        livenessStatus.innerText =
            "👁️ Silakan kedipkan mata...";

    }


    return false;
}


/*
|--------------------------------------------------------------------------
| DETECT LIVENESS
|--------------------------------------------------------------------------
*/

async function detectLiveness()
{
    if (
        isDetecting ||
        livenessPassed ||
        !video.srcObject
    ) {

        return;

    }


    isDetecting =
        true;


    try {

        const detection =
            await faceapi
                .detectSingleFace(
                    video,
                    new faceapi.TinyFaceDetectorOptions({

                        inputSize: 320,

                        scoreThreshold: 0.45

                    })
                )
                .withFaceLandmarks();


        /*
        |--------------------------------------------------------------------------
        | FACE NOT FOUND
        |--------------------------------------------------------------------------
        */

        if (!detection) {

            livenessStatus.innerText =
                "❌ Wajah tidak terdeteksi. Posisikan wajah di depan kamera.";


            isDetecting =
                false;


            return;

        }


        const action =
            livenessChallenge[
                currentStep
            ];


        /*
        |--------------------------------------------------------------------------
        | BLINK
        |--------------------------------------------------------------------------
        */

        if (
            action === "blink"
        ) {

            const success =
                detectBlink(
                    detection.landmarks
                );


            if (success) {

                await moveToNextChallenge();

            }

        }


        /*
        |--------------------------------------------------------------------------
        | LEFT
        |--------------------------------------------------------------------------
        */

        else if (
            action === "left"
        ) {

            const direction =
                getHeadDirection(
                    detection.landmarks
                );


            if (
                direction === "left"
            ) {

                livenessStatus.innerText =
                    "✅ Gerakan kiri terdeteksi!";


                await moveToNextChallenge();

            } else {

                livenessStatus.innerText =
                    "⬅️ Gerakkan kepala ke kiri...";

            }

        }


        /*
        |--------------------------------------------------------------------------
        | RIGHT
        |--------------------------------------------------------------------------
        */

        else if (
            action === "right"
        ) {

            const direction =
                getHeadDirection(
                    detection.landmarks
                );


            if (
                direction === "right"
            ) {

                livenessStatus.innerText =
                    "✅ Gerakan kanan terdeteksi!";


                await moveToNextChallenge();

            } else {

                livenessStatus.innerText =
                    "➡️ Gerakkan kepala ke kanan...";

            }

        }

    } catch (error) {

        console.error(
            "Liveness detection error:",
            error
        );

    }


    isDetecting =
        false;
}


/*
|--------------------------------------------------------------------------
| START LIVENESS
|--------------------------------------------------------------------------
*/

function startLivenessDetection()
{
    showCurrentChallenge();


    clearInterval(
        detectionInterval
    );


    detectionInterval =
        setInterval(
            detectLiveness,
            180
        );
}


/*
|--------------------------------------------------------------------------
| RETRY BUTTON
|--------------------------------------------------------------------------
*/

retryButton.addEventListener(
    "click",
    function()
    {
        retryButton.classList.add(
            "hidden"
        );


        registerButton.disabled =
            true;


        message.innerText =
            "";


        livenessPassed =
            false;


        currentStep =
            0;


        savedDescriptor =
            null;


        resetBlink();


        startLivenessDetection();
    }
);


/*
|--------------------------------------------------------------------------
| REGISTER FACE
|--------------------------------------------------------------------------
*/

registerButton.addEventListener(
    "click",
    async function()
    {

        if (
            !livenessPassed
        ) {

            message.innerText =
                "Selesaikan liveness terlebih dahulu.";


            message.className =
                "mt-4 text-center text-sm text-red-400";


            return;

        }


        if (
            !savedDescriptor
        ) {

            message.innerText =
                "Data wajah belum tersedia. Silakan ulangi liveness.";


            message.className =
                "mt-4 text-center text-sm text-red-400";


            return;

        }


        registerButton.disabled =
            true;


        retryButton.classList.add(
            "hidden"
        );


        message.innerText =
            "Mendaftarkan wajah...";


        message.className =
            "mt-4 text-center text-sm text-slate-300";


        try {

            const csrfToken =
                document
                    .querySelector(
                        'meta[name="csrf-token"]'
                    )
                    ?.getAttribute(
                        "content"
                    );


            if (!csrfToken) {

                throw new Error(
                    "CSRF token tidak ditemukan."
                );

            }


            const response =
                await fetch(
                    "{{ route('face.registration.store') }}",
                    {

                        method: "POST",

                        headers: {

                            "Content-Type":
                                "application/json",

                            "Accept":
                                "application/json",

                            "X-CSRF-TOKEN":
                                csrfToken

                        },

                        credentials:
                            "same-origin",

                        body:
                            JSON.stringify({

                                face_embedding:
                                    savedDescriptor,

                                liveness_passed:
                                    true,

                                liveness_sequence:
                                    livenessChallenge

                            })

                    }
                );


            const data =
                await response.json();


            if (
                !response.ok ||
                !data.success
            ) {

                throw new Error(
                    data.message ||
                    "Registrasi wajah gagal."
                );

            }


            message.innerText =
                data.message ||
                "Wajah berhasil didaftarkan.";


            message.className =
                "mt-4 text-center text-sm text-emerald-400 font-semibold";


            setTimeout(() => {

                window.location.href =
                    data.redirect;

            }, 1000);


        } catch (error) {

            console.error(error);


            message.innerText =
                error.message;


            message.className =
                "mt-4 text-center text-sm text-red-400";


            registerButton.disabled =
                false;

        }

    }
);


/*
|--------------------------------------------------------------------------
| INITIALIZE
|--------------------------------------------------------------------------
*/

async function initialize()
{
    try {

        await loadModels();


        const cameraStarted =
            await startCamera();


        if (!cameraStarted) {

            return;

        }


        await new Promise(resolve => {

            if (
                video.readyState >= 3
            ) {

                resolve();

            } else {

                video.addEventListener(
                    "canplay",
                    resolve,
                    {
                        once: true
                    }
                );

            }

        });


        livenessStatus.innerText =
            "Kamera siap. Ikuti challenge.";


        startLivenessDetection();


    } catch (error) {

        console.error(
            error
        );


        message.innerText =
            "Gagal menyiapkan sistem face recognition.";


        message.className =
            "mt-4 text-center text-sm text-red-400";

    }
}


initialize();

</script>

</body>

</html>
```
