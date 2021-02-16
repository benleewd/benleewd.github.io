//W3C Web Speech API . Supported in Chrome
//Reference: https://codeburst.io/html5-speech-recognition-api-670846a50e92
window.SpeechRecognition = window.webkitSpeechRecognition || window.SpeechRecognition;
let recognition = new window.SpeechRecognition();
recognition.interimResults = false;
recognition.maxAlternatives = 10;
recognition.continuous = true;
recognition.onresult = (event) => {
    let interimTranscript = '';
    for (let i = event.resultIndex, len = event.results.length; i < len; i++) {
        let transcript = event.results[i][0].transcript;
        interimTranscript += transcript;
    }
    document.getElementById("food").value = interimTranscript;
}

document.getElementById("startRecord").addEventListener("click", function () {
    recognition.start();
    document.getElementById("startRecord").style.display = "none";
    document.getElementById("stopRecord").style.display = "block";
});

document.getElementById("stopRecord").addEventListener("click", function () {
    recognition.stop();
    document.getElementById("startRecord").style.display = "block";
    document.getElementById("stopRecord").style.display = "none";
});