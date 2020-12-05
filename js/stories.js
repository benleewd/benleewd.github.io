// Typewriter effect
var speed = 100; /* The speed/duration of the effect in milliseconds */

var descriptionCounter = 0;
var description = 'Coming soon...';
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