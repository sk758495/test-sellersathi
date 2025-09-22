<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="{{ asset('logincss/login.css') }}">
    <link rel="icon" href="{{ asset('user/images/gujju-logo-removebg.png') }}" sizes="32x32" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
   
    <div class="login">
        <div class="login-form">
            <div class="otp_verification" style="display: block;">
                <h1 class="text-center">Verify OTP</h1>
                <div>
                    <form method="POST" action="{{ route('verify.otp') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile Number</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" value="{{ session('phone') }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="otp" class="form-label">Enter the OTP sent to your phone</label>
                            <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP" required>
                            @error('otp')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary d-block mb-3">Verify</button>
                    </form>
                </div>

                <div>
                    <form method="POST" action="{{ route('resend.otp') }}">
                        @csrf
                        <input type="hidden" name="phone" value="{{ session('phone') }}">
                        <button type="submit" class="btn btn-secondary d-block">Resend OTP</button>
                    </form>
                </div>

                @if($errors->has('otp')) <!-- Check if there was an error with OTP -->
                <div class="mt-3">
                    <a href="{{ url('edit-phone-number') }}">Edit Phone Number</a>
                </div>
                @endif


            </div>
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
