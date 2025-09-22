<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Phone Number</title>
    <link rel="stylesheet" href="{{ asset('logincss/login.css') }}">
    <link rel="icon" href="{{ asset('user/images/gujju-logo-removebg.png') }}" sizes="32x32" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="login">
        <div class="login-form">
            <h1 class="text-center">Edit Phone Number</h1>
            <form method="POST" action="{{ route('update.phone.number') }}">
                @csrf
                <div class="mb-3">
                    <label for="phone" class="form-label">New Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                    @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Update Phone Number</button>
            </form>
        </div>
    </div>
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

</body>

</html>
