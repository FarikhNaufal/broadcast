<div>
    <div id="container">
    </div>
    <div id="informationDisplay"
        class="hidden absolute bottom-0 m-3 left-0 bg-white bg-opacity-70 text-sm min-w-72 rounded shadow-lg text-neutral-700 p-4 z-50">
        <h5 class="text-sm font-semibold">Client: <span class="font-normal" id="clientname"></span></h5>
        <hr class="my-1">
        <h5 class="text-sm font-semibold">Media:</h5>
        <ul id="medialist"></ul>
    </div>
</div>

<script>
    document.addEventListener('mousemove', function(event) {
        const informationDisplay = document.getElementById('informationDisplay');
        const boundary = 100;

        const screenWidth = window.innerWidth;
        const screenHeight = window.innerHeight;

        if (event.clientX < boundary && event.clientY > (screenHeight - boundary)) {
            informationDisplay.classList.remove('hidden');
            informationDisplay.classList.add('visible');
        } else {
            informationDisplay.classList.remove('visible');
            informationDisplay.classList.add('hidden');
        }
    });

    function setClientInformation(data) {

        const clientData = JSON.parse(data);
        const clientName = document.getElementById('clientname');
        const mediaList = document.getElementById('medialist');
        mediaList.innerHTML = '';
        clientData.media.forEach(media => {
            const li = document.createElement('li');
            li.textContent = media.name + " - " + media.duration + "s";
            mediaList.appendChild(li);
        });
        clientName.textContent = clientData.clientName;
    }
</script>


<script type="module">
    document.addEventListener('DOMContentLoaded', function() {
        const clientID = "{{ Auth::guard('client')->id() }}";
        const websocketHost = "{{ env('REVERB_HOST') }}";
        const key = "{{ env('REVERB_APP_KEY') }}";
        let psID;
        let client;
        let reconnectInterval;
        let disconnectInterval;
        let currentMediaIndex = 0;
        let mediaTimeout;
        const container = document.getElementById('container');

        function connect() {
            console.log(key);
            client = new WebSocket(
                `ws://${websocketHost}:8080/app/${key}?protocol=7&client=js&version=8.4.0-rc2&flash=false`
            );
            client.addEventListener('open', onOpen);
            client.addEventListener('message', onMessage);
            client.addEventListener('close', onClose);
            client.addEventListener('error', onError);
            // disconnectInterval = setInterval(() => {
            //     client.close();
            // }, 10000);
        }

        function onOpen(event) {
            console.log('WebSocket connection established');
            clearTimeout(reconnectInterval);
            container.innerHTML = '';
            initContent();
        }

        function onMessage(event) {
            const data = JSON.parse(event.data);

            switch (data.event) {
                case 'pusher:connection_established':
                    setPusherSocketId(data);
                    subscribePrivateChannel();
                    sendClientStatus();
                    break;
                case 'pusher:ping':
                    pong();
                    break;
                case 'App\\Events\\SendDataEvent':
                    handleSendDataEvent(data);
                    // getTimesNow(data);
                    setClientInformation(data.data)
                    break;
                case 'App\\Events\\NoDataEvent':
                    console.log('deleted');
                    reset();
                    initContent();
                    break;
                default:
            }
        }

        function onClose(event) {
            console.log('WebSocket connection closed, attempting to reconnect...');
            displayReconnectingMessage();
            sendClientStatus();
            reconnectInterval = setInterval(connect, 3000);
            clearInterval(disconnectInterval);
        }

        function onError(event) {
            console.log('WebSocket error:', event);
            displayReconnectingMessage();
        }

        async function subscribePrivateChannel() {
            try {
                const token = await getPusherAuthToken();
                const msg = JSON.stringify({
                    event: 'pusher:subscribe',
                    data: {
                        auth: token,
                        channel: 'private-' + clientID,
                    }
                });
                client.send(msg);
                console.log('Subscribed to private channel:', clientID);
            } catch (error) {
                console.error('Error subscribing to private channel:', error);
            }
        }

        async function getPusherAuthToken() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch(`http://${websocketHost}:8000/broadcasting/auth`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': csrfToken,
                },
                body: JSON.stringify({
                    socket_id: psID,
                    channel_name: "private-" + clientID,
                }),
            });
            const data = await response.json();
            console.log(csrfToken);
            console.log(psID);
            console.log(clientID);
            return data.auth;
        }

        function setPusherSocketId(data) {
            const connectionData = JSON.parse(data.data);
            psID = connectionData.socket_id;
        }

        async function sendClientStatus() {
            const response = await fetch('https://api.ipify.org?format=json');
            const data = await response.json();
            const ipAddress = data.ip;
            const message = JSON.stringify({
                event: 'updateWebsocketIdOnClientDB',
                data: {
                    clientID: clientID,
                    agent: window.navigator.userAgent + ' | ' + ipAddress
                }
            });
            client.send(message);
        }

        function pong() {
            const message = {
                event: 'pusher:pong',
                data: []
            };
            client.send(JSON.stringify(message));
        }

        function handleSendDataEvent(data) {
            reset();
            const parsedData = JSON.parse(data.data);
            if (parsedData.media.length > 0) {
                localStorage.setItem('cachedMedia', JSON.stringify(parsedData.media));
                localStorage.setItem('mediaIndex', '0');
                startMedia(parsedData.media); // Start media playback after handling event
            } else {
                initContent();
            }
        }

        function reset() {
            container.innerHTML = '';
            currentMediaIndex = 0;
            localStorage.removeItem('cachedMedia');
            localStorage.removeItem('mediaIndex');
            clearTimeout(mediaTimeout);
        }

        function displayData(data) {
            reset();
            switch (data.type) {
                case 'text':
                    displayText(data.data);
                    break;
                case 'image':
                    displayImage(data.data);
                    break;
                case 'youtube':
                    displayYoutube(data.data);
                    break;
            }
        }

        function initContent() {
            const defaultImage = new Image();
            defaultImage.src = "/Assets/default.jpg";
            defaultImage.classList.add('w-screen', 'h-screen');
            container.appendChild(defaultImage);

            const cachedMedia = localStorage.getItem('cachedMedia');
            const cachedIndex = localStorage.getItem('mediaIndex');
            if (cachedMedia && cachedIndex !== null) {
                currentMediaIndex = parseInt(cachedIndex, 10);
                startMedia(JSON.parse(cachedMedia));
            }
        }

        function displayText(content) {
            const md = markdownit();
            const textContainer = document.createElement('div');
            const text = document.createElement('div');
            textContainer.classList.add('text-center', 'w-screen', 'h-screen', 'flex', 'flex-col',
                'items-center', 'justify-center', 'p-4');
            text.classList.add('prose', 'lg:prose-2xl')
            text.innerHTML = md.render(content);
            textContainer.appendChild(text);
            container.appendChild(textContainer);
        }

        function displayImage(content) {
            const image = new Image();
            image.classList.add('object-contain', 'aspect-video', 'w-screen', 'h-screen');
            image.src = "{{ Storage::url('') }}" + content.replace('public/', '');
            container.appendChild(image);
        }

        function displayYoutube(content) {
            const youtube = document.createElement('iframe');
            youtube.src = "http://www.youtube.com/embed/" + content +
                "?&rel=0wmode=opaque&modestbranding=1&enablejsapi=1&origin=http://127.0.0.1:8000/client-view&autoplay=1&loop=1&mute=1&controls=0&fs=1&vq=720p&playlist=" +
                content;
            youtube.classList.add('w-screen', 'h-screen');
            youtube.frameBorder = 0;
            youtube.allowFullscreen = true;
            youtube.allow = "geolocation *";
            container.appendChild(youtube);
        }

        function startMedia(data) {
            if (currentMediaIndex >= data.length) {
                currentMediaIndex = 0;
            }
            const media = data[currentMediaIndex];
            displayData(media);
            mediaTimeout = setTimeout(() => {
                container.classList.add('opacity-0', 'ease-out', 'transition-opacity', 'duration-500');
                setTimeout(() => {
                    currentMediaIndex++;
                    localStorage.setItem('mediaIndex', currentMediaIndex);
                    container.classList.remove('opacity-0', 'ease-out', 'transition-opacity',
                        'duration-500');
                    startMedia(data);
                }, 200);
            }, media.duration * 1000);
        }

        function displayReconnectingMessage() {
            container.innerHTML = '';
            const reconnect = document.createElement('h1');
            reconnect.classList.add('text-center', 'text-neutral-600');
            reconnect.textContent = 'Reconnecting...';
            container.appendChild(reconnect);
        }

        function getTimesNow(data) {
            const parseddata = JSON.parse(data.data);
            const serverTime = parseddata.status;
            console.log("tipe: " + parseddata.media[0].type + ", total media: " + parseddata.media.length);
            let clientTime = new Date();

            let serverDateTime = new Date(clientTime.toDateString() + ' ' + serverTime);

            let timeDiff = clientTime.getTime() - serverDateTime.getTime();

            let delaySeconds = timeDiff / 1000;
            console.log(`Delay waktu: ${delaySeconds} detik / ${timeDiff} ms`);
        }

        initContent();
        connect();


    });
</script>

{{-- <script>
    const clientIDModal = document.getElementById('clientModal');
    const clientIDDisplay = document.getElementById('clientIDDisplay');

    function displayClientID() {
        if (!document.fullscreenElement) {
            clientIDModal.classList.remove('hidden');
        }
    }

    function hideClientID() {
        clientIDModal.classList.add('hidden');
    }

    function openFullscreen() {
        var elem = document.documentElement;
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.webkitRequestFullscreen) {
            /* Safari */
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) {
            /* IE11 */
            elem.msRequestFullscreen();
        }
    }

    document.addEventListener('fullscreenchange', function() {
        if (document.fullscreenElement) {
            hideClientID();
        } else {
            displayClientID();
        }
    });
</script> --}}
