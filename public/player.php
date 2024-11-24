<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    header('Location: login.php');
    exit;
}

// The URL for the HLS playlist file
$hlsUrl = "secure.php?file=output.m3u8";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HLS Video Player</title>
    <link href="https://vjs.zencdn.net/8.0.4/video-js.css" rel="stylesheet">
    <script src="https://vjs.zencdn.net/8.0.4/video.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
</head>
<body>
    <h1>HLS Video Player</h1>
    <video id="my-video" class="video-js vjs-default-skin" controls preload="auto" width="640" height="360">
        <source src="<?php echo $hlsUrl; ?>" type="application/x-mpegURL">
        Your browser does not support HLS playback.
    </video>

    <script>
        var video = document.getElementById('my-video');
        var firstSegmentPlayed = false;

        if (Hls.isSupported()) {
            var hls = new Hls({
                startLevel: -1,  // Do not start loading any level initially
                autoStartLoad: true,  // Auto start loading after attaching media
                startFromLevel: -1,   // Avoid loading all segments on first hit
                maxMaxBufferLength: 10,  // Limit the buffer length to keep network usage low
                maxBufferLength: 10,     // Limit how much video is buffered at once
                maxBufferSize: 60 * 1000 * 1000,  // Set a max buffer size of 60MB (you can adjust based on your needs)
                startFrag: 0   // Start by loading the first fragment
            });

            hls.loadSource('<?php echo $hlsUrl; ?>');
            hls.attachMedia(video);

            // Listen for the first fragment to start playing
            hls.on(Hls.Events.FRAG_CHANGED, function(event, data) {
                // If the first segment is completed, trigger re-authentication
                if (!firstSegmentPlayed) {
                    firstSegmentPlayed = true;
                    // Trigger re-authentication here
                    console.log("First segment completed, re-authenticating...");

                    // Call the re-authentication logic (this could involve checking session validity)
                    reauthenticateUser();
                }
            });

            hls.on(Hls.Events.MANIFEST_PARSED, function() {
                video.play();
            });

        } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
            // If the browser supports HLS natively (e.g., Safari)
            video.src = '<?php echo $hlsUrl; ?>';
            video.addEventListener('loadedmetadata', function() {
                video.play();
            });
        }

        // Re-authenticate the user (you can expand this function to actually perform session checks)
        function reauthenticateUser() {
            // Example: Send an AJAX request to a server-side PHP script to check if the user is still authenticated
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'reauthenticate.php', true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Handle re-authentication success or failure here
                    if (xhr.responseText === 'success') {
                        console.log('User successfully re-authenticated!');
                    } else {
                        console.log('Re-authentication failed!');
                        window.location.href = 'login.php'; // Redirect to login page if failed
                    }
                }
            };
            xhr.send();
        }
    </script>
</body>
</html>
