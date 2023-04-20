$(document).ready(function () {
    // Validate form before submitting
    $("#distance-form").submit(function (event) {
        var name = $("#name").val();
        var location = $("#location").val();
        if (name == "" || location == "") {
            event.preventDefault();
            alert("Please enter a name and location.");
        } else {
            // Prevent default form submit and show popup box with result
            event.preventDefault();
            var distance = calculateDistance(name, location);
            $("#distance-result").text(distance + " km");
            $("#result-popup").fadeIn();
        }
    });

    // Hide popup box when close button is clicked
    $(".close").click(function () {
        $("#result-popup").fadeOut();
    });

    // Hide popup box when clicked outside of it
    $(window).click(function (event) {
        if (event.target == $("#result-popup")[0]) {
            $("#result-popup").fadeOut();
        }
    });
});


