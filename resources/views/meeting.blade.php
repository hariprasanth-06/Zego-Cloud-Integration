<html>

<head>
    <style>
        #root {
            width: 100vw;
            height: 100vh;
        }
    </style>
</head>

<body>
    <div id="root"></div>
</body>

<!-- ✅ Load Zego UIKit Prebuilt -->
<script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt/zego-uikit-prebuilt.js"></script>
<script>
    // Laravel values injected from backend
    const roomID = @json($room_id);
    const appID = @json($app_id);
    const token = @json($token); // ✅ JWT you generated in backend
    const userID = @json($user_id);
    const userName = "user_" + userID;

    // ✅ Generate KitToken (client-side, with token from backend)
    const kitToken = ZegoUIKitPrebuilt.generateKitTokenForProduction(
        appID,
        token, // use your server-generated JWT here
        roomID,
        userID,
        userName
    );

    // ✅ Create instance
    const zp = ZegoUIKitPrebuilt.create(kitToken);

    // ✅ Join Room with full UI
    zp.joinRoom({
        container: document.querySelector("#root"),
        sharedLinks: [{
            name: "Copy Link",
            url: window.location.href
        }],
        scenario: {
            mode: ZegoUIKitPrebuilt.GroupCall, // or VideoConference, OneONoneCall
        },
    });
</script>

</html>
