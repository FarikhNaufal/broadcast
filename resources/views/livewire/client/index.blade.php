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
    document.addEventListener('mousemove', (event) => {
        const informationDisplay = document.getElementById('informationDisplay');
        const BOUNDARY = 100;
        const {
            innerWidth: screenWidth,
            innerHeight: screenHeight
        } = window;

        if (event.clientX < BOUNDARY && event.clientY > screenHeight - BOUNDARY) {
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
            li.textContent = `${media.name} - ${media.duration}s`;
            mediaList.appendChild(li);
        });
        clientName.textContent = clientData.clientName;
    }
</script>

<script type="module">
    document.addEventListener('DOMContentLoaded', () => {
        const clientID = "{{ Auth::guard('client')->id() }}";
        const websocketHost = "{{ env('REVERB_HOST') }}";
        const key = "{{ env('REVERB_APP_KEY') }}";
        const container = document.getElementById('container');
        let psID;
        let client;
        let reconnectInterval;
        let currentMediaIndex = 0;
        let mediaTimeout;

        const connect = () => {
            client = new WebSocket(
                `ws://${websocketHost}:8080/app/${key}?protocol=7&client=js&version=8.4.0-rc2&flash=false`
            );
            client.addEventListener('open', onOpen);
            client.addEventListener('message', onMessage);
            client.addEventListener('close', onClose);
            client.addEventListener('error', onError);
        };

        const onOpen = () => {
            clearTimeout(reconnectInterval);
            container.innerHTML = '';
            initContent();
        };

        const onMessage = (event) => {
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
                    setClientInformation(data.data);
                    break;
                case 'App\\Events\\NoDataEvent':
                    handleNoDataEvent(data);
                    break;
                default:
                    break;
            }
        };

        const onClose = () => {
            displayReconnectingMessage();
            reconnectInterval = setInterval(connect, 3000);
        };

        const onError = () => {
            displayReconnectingMessage();
        };

        const subscribePrivateChannel = async () => {
            try {
                const token = await getPusherAuthToken();
                const msg = JSON.stringify({
                    event: 'pusher:subscribe',
                    data: {
                        auth: token,
                        channel: `private-${clientID}`,
                    }
                });
                client.send(msg);
            } catch (error) {
                console.error('Error subscribing to private channel:', error);
            }
        };

        const getPusherAuthToken = async () => {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch(`http://${websocketHost}:8000/broadcasting/auth`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': csrfToken,
                },
                body: JSON.stringify({
                    socket_id: psID,
                    channel_name: `private-${clientID}`,
                }),
            });
            const data = await response.json();
            return data.auth;
        };

        const setPusherSocketId = (data) => {
            const connectionData = JSON.parse(data.data);
            psID = connectionData.socket_id;
        };

        const sendClientStatus = async () => {
            const response = await fetch('https://api.ipify.org?format=json');
            const data = await response.json();
            const message = JSON.stringify({
                event: 'updateWebsocketIdOnClientDB',
                data: {
                    clientID: clientID,
                    agent: `${window.navigator.userAgent} | ${data.ip}`
                }
            });
            client.send(message);
        };

        const pong = () => {
            const message = {
                event: 'pusher:pong',
                data: []
            };
            client.send(JSON.stringify(message));
        };

        const handleSendDataEvent = (data) => {
            reset();
            const parsedData = JSON.parse(data.data);
            if (parsedData.media.length > 0) {
                localStorage.setItem('cachedMedia', JSON.stringify(parsedData.media));
                localStorage.setItem('mediaIndex', '0');
                startMedia(parsedData.media);
            } else {
                initContent();
            }
        };

        const handleNoDataEvent = (data) => {
            reset();
            initContent();
            const noData = JSON.parse(data.data);
            console.log(noData);
            if (noData.setLogout) {
                location.reload();
            }
        }

        const reset = () => {
            container.innerHTML = '';
            currentMediaIndex = 0;
            localStorage.removeItem('cachedMedia');
            localStorage.removeItem('mediaIndex');
            clearTimeout(mediaTimeout);
        };

        const displayData = (data) => {
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
                default:
                    break;
            }
        };

        const initContent = () => {
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
        };

        const displayText = (content) => {
            const md = markdownit();
            const textContainer = document.createElement('div');
            textContainer.classList.add('text-center', 'w-screen', 'h-screen', 'flex', 'flex-col',
                'items-center', 'justify-center', 'p-4');
            const text = document.createElement('div');
            text.classList.add('prose', 'lg:prose-2xl');
            text.innerHTML = md.render(content);
            textContainer.appendChild(text);
            container.appendChild(textContainer);
        };

        const displayImage = (content) => {
            const image = new Image();
            image.classList.add('object-contain', 'aspect-video', 'w-screen', 'h-screen');
            image.src = `{{ Storage::url('') }}${content.replace('public/', '')}`;
            container.appendChild(image);
        };

        const displayYoutube = (content) => {
            const youtube = document.createElement('iframe');
            youtube.src =
                `http://www.youtube-nocookie.com/embed/${content}?&rel=0wmode=opaque&modestbranding=1&enablejsapi=1&origin=http://127.0.0.1:8000/client-view&autoplay=1&loop=1&mute=1&controls=0&fs=1&vq=720p&playlist=${content}`;
            youtube.classList.add('w-screen', 'h-screen');
            youtube.frameBorder = 0;
            youtube.allowFullscreen = true;
            youtube.allow = "geolocation *";
            container.appendChild(youtube);
        };

        const startMedia = (data) => {
            if (currentMediaIndex >= data.length) {
                currentMediaIndex = 0;
            }
            const media = data[currentMediaIndex];
            displayData(media);
            mediaTimeout = setTimeout(() => {
                container.classList.add('opacity-0', 'ease-out', 'transition-opacity',
                    'duration-500');
                setTimeout(() => {
                    currentMediaIndex++;
                    localStorage.setItem('mediaIndex', currentMediaIndex);
                    container.classList.remove('opacity-0', 'ease-out',
                        'transition-opacity', 'duration-500');
                    startMedia(data);
                }, 200);
            }, media.duration * 1000);
        };

        const displayReconnectingMessage = () => {
            container.innerHTML = '';
            const reconnect = document.createElement('h1');
            reconnect.classList.add('text-center', 'text-neutral-600');
            reconnect.textContent = 'Reconnecting...';
            container.appendChild(reconnect);
        };


        initContent();
        connect();
    });
</script>
