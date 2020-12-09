// Typewriter effect
var speed = 50; /* The speed/duration of the effect in milliseconds */

var descriptionCounter = 0;
var description = 'Hello, my name is Benjamin/Weida and I am an undergraduate based in Singapore, pursing a degree in Information System, majoring in Software Development';
function descriptionTypeWriter() {
    if (descriptionCounter < description.length) {
        document.getElementById("description").innerHTML += description.charAt(descriptionCounter);
        descriptionCounter++;
        setTimeout(descriptionTypeWriter, speed);
    }
}

window.addEventListener('DOMContentLoaded', (event) => {
    descriptionTypeWriter();
});