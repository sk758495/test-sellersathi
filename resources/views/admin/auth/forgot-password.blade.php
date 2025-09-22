<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Password Reset</title>
    <link rel="icon" href="{{ asset('user/images/gujju-logo-removebg.png') }}" sizes="32x32" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('logincss/email_register.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <div class="email_register">
        <div class="register-form">
            <h1 class="text-center">Admin Forgot Password</h1>
            <div class="mb-4 text-sm text-gray-600">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input id="email" class="form-control" type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required autofocus/>
                    
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Email Password Reset Link') }}
                    </button>
                </div>
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
</body>

</html>
