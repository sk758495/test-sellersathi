<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gujju E Market</title>
    @include('user.head')
    <style>
        /* General Body Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        
        section {
            padding: 40px 20px;
            background-color: white;
            max-width: 1000px;
            margin: 40px auto;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

       
        .contact-info {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
        }

        .contact-info div {
            flex: 1;
        }

        .contact-info h3 {
            font-size: 22px;
            color: #0044cc;
            margin-bottom: 10px;
        }

        .contact-info p {
            font-size: 16px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 16px;
            margin-bottom: 5px;
            display: block;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-group textarea {
            resize: vertical;
            height: 150px;
        }

        .btn-sub {
            display: inline-block;
            padding: 12px 20px;
            background-color: #0044cc;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
            text-align: center;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #002f80;
        }

        .map-container {
            margin-top: 40px;
        }

        iframe {
            width: 100%;
            height: 400px;
            border: 0;
            border-radius: 10px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .contact-info {
                flex-direction: column;
            }

            .contact-info div {
                margin-bottom: 20px;
            }
        }

    </style>
</head>
<body>

    @include('user.navbar')

    <!-- Contact Section -->
    <section>
        <h2>Get in Touch</h2>

        <!-- Contact Information -->
        <div class="contact-info">
            <div>
                <h3>Our Office</h3>
                <p>104 Gouri Nandan Complex B/S Dominos Uma Crosing,</p>
                <p>Waghodia Road Vadodara, Gujarat, India</p>
                <p>Postal Code: 390019</p>
            </div>
            <div>
                <h3>Email Us</h3>
                <p>support@gujjuemarket.com</p>
            </div>
            <div>
                <h3>Call Us</h3>
                <p>+91 96244 02490</p>
            </div>
        </div>
     
    
        <!-- Contact Form -->
        <h3>Send Us a Message</h3>
        <form action="{{ route('contact.form.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required placeholder="Enter your name">
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required placeholder="Enter your email">
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" required placeholder="Enter the subject">
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" required placeholder="Write your message here"></textarea>
            </div>
            <button type="submit" class="btn btn-sub">Send Message</button>
        </form>
        

        <!-- Google Maps Embed -->
        <div class="map-container">
            <h3>Find Us Here</h3>
            <!-- Replace with your actual Google Maps embed link -->
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1644.337976743147!2d73.23077606381779!3d22.30017736960861!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395fc57f71dc077f%3A0x65246980452ec6e7!2sGauri%20Nandan%20Complex%2C%2020%2C%20Society%2C%20Uma%20Colony%2C%20Prabhat%20Nagar%2C%20Waghodia%2C%20Vadodara%2C%20Gujarat%20390025!5e0!3m2!1sen!2sin!4v1735037084435!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>        </div>
    </section>
    @include('user.footer')


    <!-- Js Plugins -->
    <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dd.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        function changeMainImage(imageSrc) {
            document.getElementById('main-image').src = imageSrc;
            
            // Update active thumbnail
            document.querySelectorAll('.thumb-item').forEach(item => {
                item.classList.remove('active');
            });
            event.target.closest('.thumb-item').classList.add('active');
        }

        // Tab functionality
        $(document).ready(function() {
            $('.pd-tab-list a').click(function(e) {
                e.preventDefault();
                
                // Remove active class from all tabs and content
                $('.pd-tab-list a').removeClass('active');
                $('.tab-pane').removeClass('active');
                
                // Add active class to clicked tab
                $(this).addClass('active');
                
                // Show corresponding content
                var target = $(this).data('target');
                $(target).addClass('active');
            });
        });
    </script>

</body>

</html>