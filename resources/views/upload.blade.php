<!DOCTYPE html>
<html>

<head>
    <title>Upload Video</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('js/sweetalert.all.js')}}"></script>
</head>

<body>


@if (isset($successMessage))
    {{--        <p style="background-color: chartreuse">{{ $successMessage }}</p>--}}
    <script>

        Swal.fire({
            title: 'success',
            text: "video uploaded successfully",
            icon: 'success',
            confirmButtonText: 'ok',
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',

            // showCancelButton: true,
            showCloseButton: true,

        })
    </script>
@elseif(isset($errorMessage))
    {{--        <p style="background-color: red">{{ $errorMessage }}</p>--}}
    <script>

        Swal.fire({
            title: 'error',
            text: "{{ $errorMessage }}",
            icon: 'error',
            confirmButtonText: 'ok',
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',

            // showCancelButton: true,
            showCloseButton: true,

        })
    </script>
@endif

<form action="{{ url('/upload-video') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="video">
    <button type="submit">Upload</button>
    <h1 id="progress" style="font-family:sans-serif">JavaScript is turned off, or your browser is realllllly slow
    </h1>

</form>

@if (isset($video))
    <div class="mt-4 d-flex align-items-center justify-content-center">

        <video style="display: none" id="video" poster="" width="500px" height="300px" autoplay controls></video>
        <div class="controls">
{{--            <button class="controls__button toggleButton" title="Toggle Play">►</button>--}}
            <select class="toggleButton">
                <option>240</option>
                <option>360</option>
                <option>720</option>

            </select>
        </div>
    </div>
@endif
<script src="{{asset('jquery/jquery.js')}}"></script>

<script>
    //JUST AN EXAMPLE, PLEASE USE YOUR OWN PICTURE!
    var imageAddr =
        "https://upload.wikimedia.org/wikipedia/commons/3/3a/Bloemen_van_adderwortel_%28Persicaria_bistorta%2C_synoniem%2C_Polygonum_bistorta%29_06-06-2021._%28d.j.b%29.jpg";
    var downloadSize = 7300000; //bytes

    // function ShowProgressMessage(msg) {
    //     if (console) {
    //         if (typeof msg == "string") {
    //             console.log(msg);
    //         } else {
    //             for (var i = 0; i < msg.length; i++) {
    //                 console.log(msg[i]);
    //             }
    //         }
    //     }

    //     var oProgress = document.getElementById("progress");
    //     if (oProgress) {
    //         var actualHTML = (typeof msg == "string") ? msg : msg.join("<br />");
    //         oProgress.innerHTML = actualHTML;
    //     }
    // }

    function InitiateSpeedDetection() {
        // ShowProgressMessage("Loading the image, please wait...");
        window.setTimeout(MeasureConnectionSpeed, 1);
    };

    if (window.addEventListener) {
        // window.addEventListener('load', InitiateSpeedDetection, false);
    } else if (window.attachEvent) {
        // window.attachEvent('onload', InitiateSpeedDetection);
    }

    function MeasureConnectionSpeed() {
        var startTime, endTime;
        var download = new Image();
        download.onload = function () {
            endTime = (new Date()).getTime();
            showResults();
        }

        download.onerror = function (err, msg) {
            // ShowProgressMessage("Invalid image, or error downloading");
        }

        startTime = (new Date()).getTime();
        var cacheBuster = "?nnn=" + startTime;
        download.src = imageAddr + cacheBuster;

        // function showResults() {
        //     var duration = (endTime - startTime) / 1000;
        //     var bitsLoaded = downloadSize * 8;
        //     var speedBps = (bitsLoaded / duration).toFixed(2);
        //     var speedKbps = (speedBps / 1024).toFixed(2);
        //     var speedMbps = (speedKbps / 1024).toFixed(2);


        //     // ShowProgressMessage([
        //     //     "Your connection speed is:",
        //     //     speedBps + " bps",
        //     //     speedKbps + " kbps",
        //     //     speedMbps + " Mbps"
        //     // ]);
        // }
    }


    $(
        function () {
            var data = {
                speed: 1,
                'name': "{{ $fileName ?? null }}"
            };

            getdata = (data) => {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('fit') }}",
                    data: JSON.stringify(data),
                    contentType: 'application/json'
                })
                    .done(function (res) {
                        $("#video").attr("src", res.url);
                        $('#video').show();
                    })
                    .fail(function (error) {
                        // alert('Oops... ' + JSON.stringify(error.responseJSON));
                    })
                // .always(() => alert("The request is over !"));
            }
            // if ("{{ isset($fileName) }}") {
            // console.log('test');
            getdata(data)
        }
    );

    // }
</script>


<script>
    $(document).ready(function () {

        var select = $('.toggleButton')
        select.change(function (target) {
            // changeVidQualityFunction();
            var data = {
                speed: 5,
                'name': "{{ $fileName ?? null }}"
            };
            getdata(data)
        });
    });
</script>
</body>

</html>
