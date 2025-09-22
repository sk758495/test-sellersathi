<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('logincss/email_register.css') }}">
    <link rel="icon" href="{{ asset('user/images/gujju-logo-removebg.png') }}" sizes="32x32" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="email_register">
        <div class="register-form">
            <h1 class="text-center">Login</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="login">Email or Phone</label>
                    <div class="input-group">
                        <!-- Country Code, initially hidden -->
                        <div class="input-group-prepend" id="country-code" style="display: none;">
                            <span class="input-group-text">+91</span>
                        </div>
                        <!-- Input Field for Phone or Email -->
                        <input type="text" class="form-control" id="login" name="login" placeholder="Enter your email or phone" required oninput="toggleCountryCode()" autofocus>
                    </div>
                    @error('login')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Log in</button>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('register') }}" class="text-muted">New User</a>
                    <a href="{{ route('password.request') }}" class="text-muted">Forget Password?</a>
                </div>
            </form>

        </div>
    </div>
</body>
<script>
    function toggleCountryCode() {
        var inputField = document.getElementById('login');
        var countryCode = document.getElementById('country-code');
        var inputValue = inputField.value.trim();

        // Show the country code only if the user has typed something
        if (inputValue) {
            // Check if the input starts with a number (likely a phone number)
            if (/^\d/.test(inputValue)) {
                countryCode.style.display = 'block'; // Show +91 for phone number
            } else {
                countryCode.style.display = 'none'; // Hide +91 for email
            }
        } else {
            countryCode.style.display = 'none'; // Hide +91 if the input is empty
        }
    }
</script>
<!-- JavaScript to show custom pop-up -->
<script>
document.addEventListener('DOMContentLoaded', function () {
// Check if there's a success, error or info message in the session
@if(session('success'))
    showPopup("{{ session('success') }}", "success");
@elseif(session('error'))
    showPopup("{{ session('error') }}", "error");
@elseif(session('info'))
    showPopup("{{ session('info') }}", "info");
@endif
});

// Function to display pop-up message
function showPopup(message, type) {
// Create the pop-up element
const popup = document.createElement('div');
popup.classList.add('popup', type); // Add class based on message type
popup.innerText = message;

// Append the pop-up to the body
document.body.appendChild(popup);

// Make the pop-up visible with a delay to allow the browser to render it
setTimeout(() => {
    popup.style.transform = 'translateY(0)'; // Show the popup with animation
}, 100);

// Hide the pop-up after 5 seconds
setTimeout(() => {
    popup.style.transform = 'translateY(-100px)'; // Move the popup out of the screen
    // Remove the pop-up from DOM after animation
    setTimeout(() => {
        popup.remove();
    }, 300);
}, 5000);
}
</script>

<style>
/* Pop-up styles */
.popup {
    position: fixed;
    top: 20px;  /* Change to top */
    left: 50%;
    transform: translateX(-50%) translateY(-100px); /* Start above the screen */
    background-color: #333;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 16px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    opacity: 0.9;
    transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
    z-index: 9999;
}

/* Success message styles */
.popup.success {
    background-color: #28a745;
}

/* Error message styles */
.popup.error {
    background-color: #dc3545;
}

/* Info message styles */
.popup.info {
    background-color: #17a2b8; /* Blue color for info messages */
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>
