function myFunction() {

    var x = document.getElementById("applyFormId");
    var y = document.getElementById("availableGroups");
    var z = document.getElementById("joinButton");

    if (x.style.display === "none") {
        x.style.display = "none";
        y.style.display = "block";
        z.style.display = "block";
    } else {
        x.style.display = "block";
        y.style.display = "none";
        z.style.display = "none";
    }
}