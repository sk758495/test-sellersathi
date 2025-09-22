<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gujju E Market</title>
    @include('user.head')
    <style>
        /* Basic reset and body styles */
        
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        
       
        /* Section Styling */
        
        section {
            padding: 40px;
            margin: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        h2 {
            font-size: 28px;
            color: #0044cc;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .content {
            max-width: 1000px;
            margin: 0 auto;
            line-height: 1.6;
            font-size: 16px;
        }
        
        .content p {
            margin-bottom: 20px;
        }
        
        .content ul {
            margin: 20px 0;
            list-style-type: none;
            padding: 0;
        }
        
        .content ul li {
            background-color: #e0f7fa;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        /* Styling for the button */
        
        /* Add a simple fade-in effect */
        
        .fade-in {
            opacity: 0;
            animation: fadeIn 2s forwards;
        }
        
        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
        /* Styling for the "Why Choose Us" Section */
        
        .feature-box {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        
        .feature-box div {
            background-color: #e0e0e0;
            padding: 20px;
            width: 30%;
            margin: 10px 0;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }
        
        .feature-box div:hover {
            transform: translateY(-10px);
        }
        /* Responsive styling */
        
        @media (max-width: 768px) {
            .feature-box div {
                width: 45%;
            }
        }
        
        @media (max-width: 480px) {
            .feature-box div {
                width: 100%;
            }
        }
       
    </style>
</head>

<body>

    @include('user.navbar')


        {{-- <div class="about-us" style="background-color: #0044cc;
                color: white;
                padding: 20px 0;
                text-align: center;">
            <h1>Welcome to Gujjuemarket</h1>
        </div> --}}

    <!-- About Us Section -->
    <section class="content fade-in mt-3 my-3">
        <h2>About Us</h2>
        <p>Welcome to Gujjuemarket – Your Trusted Tech Partner. At Gujjuemarket, we are passionate about providing cutting-edge IT products, ranging from the latest laptops, mobile accessories, and much more, all at the most competitive prices.</p>
        <p>Our goal is simple: to offer premium tech products and excellent customer service, while ensuring a seamless shopping experience for every customer.</p>

        <h3>Our Story</h3>
        <p>Founded on the principles of quality, affordability, and customer satisfaction, Gujjuemarket started with one vision: to make top-tier tech products accessible to everyone. Whether you're a tech enthusiast, a business looking for bulk products,
            or someone in need of daily tech essentials, we are here to provide everything you need under one roof.</p>
        <p>What started as a small local business is now growing rapidly to reach customers globally. We take pride in offering a wide range of IT products from trusted brands, ensuring you receive only the best when you shop with us.</p>

        <h3>Our Mission</h3>
        <p>Our mission is to deliver top-quality technology at unbeatable prices, while maintaining a strong focus on customer satisfaction. We aim to be the go-to e-commerce platform for tech lovers around the world. With plans to expand globally, we are
            committed to offering a smooth shopping experience, whether you are purchasing for personal use or bulk buying for your business.</p>

        <h3>What Makes Us Different?</h3>
        <div class="feature-box">
            <div>
                <h4>Top-Notch Products</h4>
                <p>We offer products from trusted brands in the market, ensuring that every item meets your expectations and delivers excellent performance.</p>
            </div>
            <div>
                <h4>Competitive Prices</h4>
                <p>We provide affordable prices and exclusive discounts, making it easier for you to stay updated with the latest tech without breaking the bank.</p>
            </div>
            <div>
                <h4>Reliable Service</h4>
                <p>Our customer support team is always ready to assist you, ensuring a seamless shopping experience from start to finish.</p>
            </div>
        </div>

        <h3>Why Choose Gujjuemarket?</h3>
        <ul>
            <li>Global Reach: Expanding worldwide to provide you with the best tech, no matter where you are.</li>
            <li>Customer-Centric Service: Quick, helpful, and responsive customer support to ensure your satisfaction.</li>
            <li>Secure Shopping: We protect your information with SSL encryption and secure payment methods.</li>
        </ul>

        <h3>Our Promise to You</h3>
        <p><strong>Quality</strong>: Only the best tech products from trusted brands.</p>
        <p><strong>Affordability</strong>: Competitive prices and discounts that make shopping easy on your wallet.</p>
        <p><strong>Service</strong>: Responsive customer support and fast, reliable delivery.</p>
        <p><strong>Global Reach</strong>: Bringing technology to your doorstep, no matter where you are.</p>

        <a href="#shop-now" class="btn">Join the Gujjuemarket Family Today!</a>
    </section>

    <script>
        // Fade-in effect on page load
        document.addEventListener("DOMContentLoaded", function() {
            const content = document.querySelector(".fade-in");
            content.style.opacity = 1;
        });
    </script>

   <!-- Footer -->
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
