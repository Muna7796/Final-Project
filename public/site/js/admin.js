// Add an event listener to the window object to resize the dashboard
window.addEventListener('resize', function () {
    // Get the width of the window
    var width = window.innerWidth;
    // If the width is less than 768 pixels, add a class to the card header
    if (width < 768) {
        document.querySelector('.card-header').classList.add('small');
    } else {
        document.querySelector('.card-header').classList.remove('small');
    }
});

/* JS for making the blood profile section interactive */

// Get the blood profile element
var bloodProfile = document.querySelector('.row h5');

// Add a click event listener to the blood profile element
bloodProfile.addEventListener('click', function () {
    // Get the blood profile details element
    var bloodProfileDetails = document.createElement('p');
    bloodProfileDetails.textContent = 'Your blood type is AB+ and your blood pressure is normal.';

    // Append the blood profile details element to the blood profile element
    bloodProfile.appendChild(bloodProfileDetails);

    // Change the blood profile element's color to indicate that it has been clicked
    bloodProfile.style.color = '#ff0000';
});

// JS for adding responsive navigation

// Get the navigation element
var navigation = document.querySelector('nav');

// Get the button that toggles the navigation
var toggleNavigationButton = document.querySelector('.navbar-toggler');

// Add a click event listener to the toggle navigation button
toggleNavigationButton.addEventListener('click', function () {
    // Toggle the "show" class on the navigation element
    navigation.classList.toggle('show');
});
