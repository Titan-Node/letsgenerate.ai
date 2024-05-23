// Function to set a cookie with a random numeric value and return the value
function setCookie() {
// Calculate the date 6 months from now
const now = new Date();
const sixMonthsFromNow = new Date(now.setMonth(now.getMonth() + 6));

// Format the expiration date in a way that the cookie will accept
const expires = "expires=" + sixMonthsFromNow.toUTCString();

// Assuming you want to store a numeric value, e.g., 42
const cookieValue = Math.floor(Math.random() * Math.floor(10000000000));;

// Set the cookie with the name 'myCookie', the numeric value, and the expiration date
document.cookie = "letsGenerateCookie=" + cookieValue + ";" + expires + ";path=/";

console.log("Created New Cookie Number:", cookieValue);

return cookieValue;
}

function getCookieValue(cookieName) {
    const name = cookieName + "=";
    const decodedCookie = decodeURIComponent(document.cookie);
    const ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
    }
    return 0;
}

// Use the function to get the cookie's value and parse it as a number
var myAssetsCookie = parseInt(getCookieValue("letsGenerateCookie"), 10);

if (myAssetsCookie == 0) {
    // If the cookie's value is not a number, set cookie function
    myAssetsCookie = setCookie();
    }

console.log("My Assets Cookie Value:", myAssetsCookie);
