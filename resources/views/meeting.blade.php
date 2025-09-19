<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Zego Meeting</title>
    <script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt/zego-uikit-prebuilt.js"></script>
</head>

<body>
    <div id="root" style="width: 100vw; height: 100vh;"></div>

    <script>
        // Values from Laravel controller
        const appId = {{ $appId }};
        const roomId = "{{ $roomId }}";
        const userId = "{{ $userId }}";
        const token = "{{ $token }}";

        // Create the Kit Token
        const kitToken = ZegoUIKitPrebuilt.generateKitTokenForTest(
            appId,
            token, // pass the server-generated token
            roomId,
            userId,
            userId
        );

        // Join the room
        const zp = ZegoUIKitPrebuilt.create(kitToken);
        zp.joinRoom({
            container: document.querySelector("#root"),
            scenario: {
                mode: ZegoUIKitPrebuilt.VideoConference, // or .OneONoneCall
            }
        });
    </script>
</body>

</html>
