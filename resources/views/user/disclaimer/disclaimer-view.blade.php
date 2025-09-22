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

        h2 {
            color: #0044cc;
            font-size: 28px;
            text-align: center;
            margin-bottom: 20px;
        }

        h3 {
            font-size: 22px;
            margin-top: 20px;
            color: #333;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        ul {
            list-style-type: none;
            padding-left: 0;
        }

        li {
            margin: 10px 0;
            font-size: 16px;
            line-height: 1.6;
        }

        .highlight {
            background-color: #e0f7fa;
            padding: 5px 10px;
            border-radius: 5px;
        }

      
        /* Smooth Scroll and Scroll Effect */
        html {
            scroll-behavior: smooth;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            section {
                padding: 20px;
            }

            h2 {
                font-size: 24px;
            }

            h3 {
                font-size: 20px;
            }
        }
    </style>
  
</head>

<body>

    @include('user.navbar')

       <!-- Disclaimer Section -->
       <section>
        <h2>Effective Date: [12-12-2024]</h2>
        <p>Welcome to <strong>Gujjuemarket.com</strong>. By using our website, you agree to be bound by the following disclaimers. Please read this carefully before browsing or purchasing from our site.</p>

        <h3>1. General Information</h3>
        <p>The information provided on Gujjuemarket.com is for general informational purposes only. We make every effort to ensure the accuracy and reliability of the information on our website; however, we do not make any representations or warranties regarding the completeness, accuracy, reliability, or suitability of the information provided. Any reliance you place on such information is strictly at your own risk.</p>

        <h3>2. Product Descriptions</h3>
        <p>While we strive to ensure that the product descriptions and specifications on Gujjuemarket.com are accurate, we do not warrant that the descriptions are free from errors. The images, pricing, and availability of products are subject to change without notice. We reserve the right to correct any errors or inaccuracies and to update product details as necessary.</p>

        <h3>3. Pricing and Availability</h3>
        <p>The prices and availability of products are subject to change without prior notice. Gujjuemarket.com makes no guarantees regarding the availability of products, and we are not responsible for any out-of-stock or unavailable items. We reserve the right to limit the quantity of any product that can be purchased and to modify product prices at any time without notice.</p>

        <h3>4. Third-Party Links</h3>
        <p>Our website may contain links to third-party websites that are not controlled or operated by Gujjuemarket.com. We are not responsible for the content, privacy policies, or practices of any third-party websites. Any interaction with third-party sites is at your own risk, and we encourage you to review their terms and conditions and privacy policies before engaging with them.</p>

        <h3>5. Limitation of Liability</h3>
        <p>To the fullest extent permitted by law, Gujjuemarket shall not be liable for any direct, indirect, incidental, special, consequential, or punitive damages arising out of your use of, or inability to use, the website, including any content or products purchased through the website. We shall not be responsible for any loss of data, profits, or business interruption caused by your use of the website.</p>

        <h3>6. No Warranties</h3>
        <p>Gujjuemarket.com provides its website and content "as is" and makes no warranties, express or implied, regarding the operation, availability, or functionality of the website. We do not warrant that the website will be free from errors, interruptions, viruses, or defects.</p>

        <h3>7. Product Use</h3>
        <p>By purchasing products from Gujjuemarket.com, you agree to use them according to the manufacturer's instructions and guidelines. We are not responsible for any damage or injury caused by improper use, misuse, or failure to follow instructions related to the products sold on our website.</p>

        <h3>8. Indemnification</h3>
        <p>You agree to indemnify, defend, and hold harmless Gujjuemarket, its employees, agents, affiliates, and suppliers from any claim, loss, liability, or expense (including legal fees) arising from your use of this website or violation of these disclaimers.</p>

        <h3>9. Changes to the Disclaimer</h3>
        <p>We reserve the right to modify, update, or change this disclaimer at any time without prior notice. All changes will be effective immediately upon posting on this page, and your continued use of the website will constitute your acceptance of such changes.</p>

        <!-- Back to Top Button -->
        <a href="#top" class="btn">Back to Top</a>
    </section>

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
