<div class="wrapper-inner">
    <div class="overview-header">
        <h1>{{$title}} - Video Call</h1>
    </div>
    <div class="row page-body messages-view-page">
        <div class="ibox">
            <div data-template="body-content" class="body-content">
                <div class="callButtons">
                    <button id="startButton" class="efficio-btn efficio-button-cta--primary"><i class="fa fa-play" aria-hidden="true"></i> Start</button>
                    <button id="callButton" class="efficio-btn efficio-button-cta--primary"><i class="fa fa-phone" aria-hidden="true"></i> Call</button>
                    <button id="hangupButton" class="efficio-btn efficio-button-cta--primary"><i class="fa fa-times" aria-hidden="true"></i> End Call</button>
                    <button id="settingsButton" class="efficio-btn efficio-button-cta--primary"><i class="fa fa-cog" aria-hidden="true"></i> Settings</button>
                    <div class="overlay" id="overlay"></div>
                    <div class="settings-modal" id="settings-modal">
                        <button class="settings-modal-modal-close-btn" id="settings-modal-close-btn"><i class="fa fa-times" title="Modal"></i></button>
                        <div class="select">
                            <label for="audioSource">Audio input source: </label><select id="audioSource"></select>
                        </div>
                        <div class="select">
                            <label for="audioOutput">Audio output destination: </label><select id="audioOutput"></select>
                        </div>
                        <div class="select">
                            <label for="videoSource">Video source: </label><select id="videoSource"></select>
                        </div>
                        <video id="video" playsinline autoplay></video>
                    </div>
                </div>
            </div>
            <div class="videoFeeds">
                <video id="video1" class="yourFeed" playsinline autoplay muted></video>
                <video id="video2" playsinline autoplay></video>
                <video id="video3" playsinline autoplay></video>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        document.getElementById('settingsButton').addEventListener('click', function() {
            document.getElementById('overlay').classList.add('is-visible');
            document.getElementById('settings-modal').classList.add('is-visible');
        });

        document.getElementById('settings-modal-close-btn').addEventListener('click', function() {
            document.getElementById('overlay').classList.remove('is-visible');
            document.getElementById('settings-modal').classList.remove('is-visible');
        });
        document.getElementById('overlay').addEventListener('click', function() {
            document.getElementById('overlay').classList.remove('is-visible');
            document.getElementById('settings-modal').classList.remove('is-visible');
        });

        const startButton = document.getElementById('startButton');
        const callButton = document.getElementById('callButton');
        const hangupButton = document.getElementById('hangupButton');

        const videoElement = document.querySelector('video');
        const audioInputSelect = document.querySelector('select#audioSource');
        const audioOutputSelect = document.querySelector('select#audioOutput');
        const videoSelect = document.querySelector('select#videoSource');
        const selectors = [audioInputSelect, audioOutputSelect, videoSelect];

        audioOutputSelect.disabled = !('sinkId' in HTMLMediaElement.prototype);

        function gotDevices(deviceInfos) {
            // Handles being called several times to update labels. Preserve values.
            const values = selectors.map(select => select.value);
            selectors.forEach(select => {
                while (select.firstChild) {
                    select.removeChild(select.firstChild);
                }
            });
            for (let i = 0; i !== deviceInfos.length; ++i) {
                const deviceInfo = deviceInfos[i];
                const option = document.createElement('option');
                option.value = deviceInfo.deviceId;
                if (deviceInfo.kind === 'audioinput') {
                    option.text = deviceInfo.label || `microphone ${audioInputSelect.length + 1}`;
                    audioInputSelect.appendChild(option);
                } else if (deviceInfo.kind === 'audiooutput') {
                    option.text = deviceInfo.label || `speaker ${audioOutputSelect.length + 1}`;
                    audioOutputSelect.appendChild(option);
                } else if (deviceInfo.kind === 'videoinput') {
                    option.text = deviceInfo.label || `camera ${videoSelect.length + 1}`;
                    videoSelect.appendChild(option);
                } else {
                    console.log('Some other kind of source/device: ', deviceInfo);
                }
            }
            selectors.forEach((select, selectorIndex) => {
                if (Array.prototype.slice.call(select.childNodes).some(n => n.value === values[selectorIndex])) {
                    select.value = values[selectorIndex];
                }
            });
        }
        navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);

        // Attach audio output device to video element using device/sink ID.
        function attachSinkId(element, sinkId) {
            if (typeof element.sinkId !== 'undefined') {
                element.setSinkId(sinkId)
                    .then(() => {
                        console.log(`Success, audio output device attached: ${sinkId}`);
                    })
                    .catch(error => {
                        let errorMessage = error;
                        if (error.name === 'SecurityError') {
                            errorMessage = `You need to use HTTPS for selecting audio output device: ${error}`;
                        }
                        console.error(errorMessage);
                        // Jump back to first output device in the list as it's the default.
                        audioOutputSelect.selectedIndex = 0;
                    });
            } else {
                console.warn('Browser does not support output device selection.');
            }
        }

        function changeAudioDestination() {
            const audioDestination = audioOutputSelect.value;
            attachSinkId(videoElement, audioDestination);
        }

        function gotSettingsStream(stream) {
            window.stream = stream; // make stream available to console
            videoElement.srcObject = stream;
            // Refresh button list in case labels have become available
            return navigator.mediaDevices.enumerateDevices();
        }

        function handleError(error) {
            console.log('navigator.MediaDevices.getUserMedia error: ', error.message, error.name);
        }

        function startSettingsStream() {
            if (window.stream) {
                window.stream.getTracks().forEach(track => {
                    track.stop();
                });
            }
            const audioSource = audioInputSelect.value;
            const videoSource = videoSelect.value;
            const constraints = {
                audio: {deviceId: audioSource ? {exact: audioSource} : undefined},
                video: {deviceId: videoSource ? {exact: videoSource} : undefined}
            };
            navigator.mediaDevices.getUserMedia(constraints).then(gotSettingsStream).then(gotDevices).catch(handleError);
        }

        audioInputSelect.onchange = startSettingsStream;
        audioOutputSelect.onchange = changeAudioDestination;

        videoSelect.onchange = startSettingsStream;

        startSettingsStream();

        callButton.disabled = true;
        hangupButton.disabled = true;
        startButton.onclick = start;
        callButton.onclick = call;
        hangupButton.onclick = hangup;

        const video1 = document.querySelector('video#video1');
        const video2 = document.querySelector('video#video2');
        const video3 = document.querySelector('video#video3');

        let pc1Local;
        let pc1Remote;
        let pc2Local;
        let pc2Remote;
        const offerOptions = {
            offerToReceiveAudio: 1,
            offerToReceiveVideo: 1
        };

        function gotStream(stream) {
            console.log('Received local stream');
            video1.srcObject = stream;
            window.localStream = stream;
            callButton.disabled = false;
        }

        function start() {
            console.log('Requesting local stream');
            startButton.disabled = true;
            navigator.mediaDevices
                .getUserMedia({
                    audio: true,
                    video: true
                })
                .then(gotStream)
                .catch(e => console.log('getUserMedia() error: ', e));
        }

        function call() {
            callButton.disabled = true;
            hangupButton.disabled = false;
            console.log('Starting calls');
            const audioTracks = window.localStream.getAudioTracks();
            const videoTracks = window.localStream.getVideoTracks();
            if (audioTracks.length > 0) {
                console.log(`Using audio device: ${audioTracks[0].label}`);
            }
            if (videoTracks.length > 0) {
                console.log(`Using video device: ${videoTracks[0].label}`);
            }
            // Create an RTCPeerConnection via the polyfill.
            const servers = null;
            pc1Local = new RTCPeerConnection(servers);
            pc1Remote = new RTCPeerConnection(servers);
            pc1Remote.ontrack = gotRemoteStream1;
            pc1Local.onicecandidate = iceCallback1Local;
            pc1Remote.onicecandidate = iceCallback1Remote;
            console.log('pc1: created local and remote peer connection objects');

            pc2Local = new RTCPeerConnection(servers);
            pc2Remote = new RTCPeerConnection(servers);
            pc2Remote.ontrack = gotRemoteStream2;
            pc2Local.onicecandidate = iceCallback2Local;
            pc2Remote.onicecandidate = iceCallback2Remote;
            console.log('pc2: created local and remote peer connection objects');

            window.localStream.getTracks().forEach(track => pc1Local.addTrack(track, window.localStream));
            console.log('Adding local stream to pc1Local');
            pc1Local
                .createOffer(offerOptions)
                .then(gotDescription1Local, onCreateSessionDescriptionError);

            window.localStream.getTracks().forEach(track => pc2Local.addTrack(track, window.localStream));
            console.log('Adding local stream to pc2Local');
            pc2Local.createOffer(offerOptions)
                .then(gotDescription2Local, onCreateSessionDescriptionError);
        }

        function onCreateSessionDescriptionError(error) {
            console.log(`Failed to create session description: ${error.toString()}`);
        }

        function gotDescription1Local(desc) {
            pc1Local.setLocalDescription(desc);
            console.log(`Offer from pc1Local\n${desc.sdp}`);
            pc1Remote.setRemoteDescription(desc);
            // Since the 'remote' side has no media stream we need
            // to pass in the right constraints in order for it to
            // accept the incoming offer of audio and video.
            pc1Remote.createAnswer().then(gotDescription1Remote, onCreateSessionDescriptionError);
        }

        function gotDescription1Remote(desc) {
            pc1Remote.setLocalDescription(desc);
            console.log(`Answer from pc1Remote\n${desc.sdp}`);
            pc1Local.setRemoteDescription(desc);
        }

        function gotDescription2Local(desc) {
            pc2Local.setLocalDescription(desc);
            console.log(`Offer from pc2Local\n${desc.sdp}`);
            pc2Remote.setRemoteDescription(desc);
            // Since the 'remote' side has no media stream we need
            // to pass in the right constraints in order for it to
            // accept the incoming offer of audio and video.
            pc2Remote.createAnswer().then(gotDescription2Remote, onCreateSessionDescriptionError);
        }

        function gotDescription2Remote(desc) {
            pc2Remote.setLocalDescription(desc);
            console.log(`Answer from pc2Remote\n${desc.sdp}`);
            pc2Local.setRemoteDescription(desc);
        }

        function hangup() {
            console.log('Ending calls');
            pc1Local.close();
            pc1Remote.close();
            pc2Local.close();
            pc2Remote.close();
            pc1Local = pc1Remote = null;
            pc2Local = pc2Remote = null;
            hangupButton.disabled = true;
            callButton.disabled = false;
        }

        function gotRemoteStream1(e) {
            if (video2.srcObject !== e.streams[0]) {
                video2.srcObject = e.streams[0];
                console.log('pc1: received remote stream');
            }
        }

        function gotRemoteStream2(e) {
            if (video3.srcObject !== e.streams[0]) {
                video3.srcObject = e.streams[0];
                console.log('pc2: received remote stream');
            }
        }

        function iceCallback1Local(event) {
            handleCandidate(event.candidate, pc1Remote, 'pc1: ', 'local');
        }

        function iceCallback1Remote(event) {
            handleCandidate(event.candidate, pc1Local, 'pc1: ', 'remote');
        }

        function iceCallback2Local(event) {
            handleCandidate(event.candidate, pc2Remote, 'pc2: ', 'local');
        }

        function iceCallback2Remote(event) {
            handleCandidate(event.candidate, pc2Local, 'pc2: ', 'remote');
        }

        function handleCandidate(candidate, dest, prefix, type) {
            dest.addIceCandidate(candidate)
                .then(onAddIceCandidateSuccess, onAddIceCandidateError);
            console.log(`${prefix}New ${type} ICE candidate: ${candidate ? candidate.candidate : '(null)'}`);
        }

        function onAddIceCandidateSuccess() {
            console.log('AddIceCandidate success.');
        }

        function onAddIceCandidateError(error) {
            console.log(`Failed to add ICE candidate: ${error.toString()}`);
        }

        self.app.container.get('views.supplier.activities.messages.view')();
    </script>

</div>
</div>
