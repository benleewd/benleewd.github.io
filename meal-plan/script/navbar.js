document.getElementById("CollapsibleBtn").addEventListener("click", function () {
    document.getElementById("navbar").style.display = "flex";
    document.getElementById("main").setAttribute("class", "col-10 p-0");
    document.getElementById("CollapsibleBtn").style.display = "none";
    document.getElementById("CollapsibleBtn2").style.display = "block";
});

document.getElementById("CollapsibleBtn2").addEventListener("click", function () {
    document.getElementById("navbar").style.display = "none";
    document.getElementById("main").setAttribute("class", "col-12 p-0");
    document.getElementById("contentTargetCalories").style.backgroundColor = "blue";
    document.getElementById("CollapsibleBtn").style.display = "block";
    document.getElementById("CollapsibleBtn2").style.display = "none";
});

document.getElementById("signupBtn").addEventListener("click", function () {
    if (getComputedStyle(document.getElementById("form")).display == "none") {
        document.getElementById("form").style.display = "block";
    } else {
        document.getElementById("form").style.display = "none";
    }
});