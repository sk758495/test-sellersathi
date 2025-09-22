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

    <!-- Privacy Policy Section -->
    <section>
        <h2>Effective Date: [12-12-2024]</h2>
        <p>Welcome to <strong>Gujjuemarket.com</strong>. Your privacy is important to us, and we are committed to protecting the personal data you share with us. Please read our Privacy Policy to understand how we collect, use, and safeguard your information.</p>

        <h3>1. Information We Collect</h3>
        <p>We collect personal and non-personal information when you visit our website, create an account, place an order, or interact with us. This information may include:</p>
        <ul>
            <li><strong>Personal Information:</strong> When you create an account or place an order, we collect personal details such as:</li>
            <ul>
                <li>Name</li>
                <li>Email Address</li>
                <li>Shipping/Billing Address</li>
                <li>Phone Number</li>
                <li>Payment Information (credit/debit card details)</li>
            </ul>
            <li><strong>Non-Personal Information:</strong> We may collect non-personal information, such as:</li>
            <ul>
                <li>IP Address</li>
                <li>Browser Type</li>
                <li>Device Information</li>
                <li>Cookies and Tracking Technologies (for analytics purposes)</li>
            </ul>
        </ul>

        <h3>2. How We Use Your Information</h3>
        <p>We use the information we collect to provide, improve, and personalize our services, including but not limited to:</p>
        <ul>
            <li><strong>Processing Orders:</strong> To process your purchases, manage payments, and ship your orders.</li>
            <li><strong>Customer Service:</strong> To respond to inquiries, address customer support requests, and resolve issues.</li>
            <li><strong>Marketing Communications:</strong> With your consent, we may send promotional emails, discounts, and other updates related to our products and services. You can opt-out of these emails at any time by clicking the "unsubscribe" link.</li>
            <li><strong>Improving Website Experience:</strong> To analyze user behavior and improve the functionality and user experience of our website.</li>
        </ul>

        <h3>3. Cookies and Tracking Technologies</h3>
        <p>We use cookies and similar tracking technologies (such as web beacons and pixels) to enhance your experience on our website. These technologies help us:</p>
        <ul>
            <li>Remember your preferences and settings</li>
            <li>Analyze website traffic and user activity</li>
            <li>Improve website functionality and performance</li>
        </ul>
        <p>You can adjust your browser settings to block cookies, but this may affect your ability to use certain features on our website.</p>

        <h3>4. How We Protect Your Information</h3>
        <p>We implement a variety of security measures to ensure the protection of your personal information, including:</p>
        <ul>
            <li><strong>SSL Encryption:</strong> All sensitive data, such as payment information, is transmitted using SSL encryption to ensure it is secure.</li>
            <li><strong>Access Control:</strong> Access to your personal data is limited to authorized personnel only, and all transactions are processed through secure payment gateways.</li>
        </ul>
        <p>While we take reasonable steps to protect your data, no online transaction can be completely secure, and we cannot guarantee the security of your information transmitted to our site.</p>

        <h3>5. Sharing Your Information</h3>
        <p>We do not sell, rent, or lease your personal information to third parties. However, we may share your information in the following situations:</p>
        <ul>
            <li><strong>Service Providers:</strong> We may share your personal information with trusted third-party service providers (such as payment processors, shipping carriers, or email marketing services) to help us operate our business.</li>
            <li><strong>Legal Compliance:</strong> We may disclose your personal information if required by law or to protect our rights, property, and safety, or the rights, property, and safety of others.</li>
            <li><strong>Business Transfers:</strong> In the event of a merger, acquisition, or sale of assets, your personal data may be transferred to the new owner, but we will notify you via email or through a notice on our website.</li>
        </ul>

        <h3>6. Your Rights and Choices</h3>
        <p>You have certain rights regarding your personal data:</p>
        <ul>
            <li><strong>Access:</strong> You can request a copy of the personal information we hold about you.</li>
            <li><strong>Correction:</strong> You can update or correct your personal information by logging into your account or contacting us directly.</li>
            <li><strong>Deletion:</strong> You can request that we delete your personal data, subject to any legal obligations we may have to retain certain information.</li>
            <li><strong>Opt-Out:</strong> You can opt out of receiving marketing emails from us at any time by clicking the "unsubscribe" link in the email or contacting us directly.</li>
        </ul>

        <h3>7. Children's Privacy</h3>
        <p>Gujjuemarket does not knowingly collect personal information from individuals under the age of 18. If we discover that we have inadvertently collected personal data from a child under 18, we will take steps to delete that information as soon as possible.</p>
        <p>If you are a parent or guardian and believe that your child has provided us with personal information, please contact us immediately.</p>

        <h3>8. Third-Party Links</h3>
        <p>Our website may contain links to third-party websites. These websites are not governed by this Privacy Policy, and we encourage you to review the privacy policies of any third-party sites you visit. We are not responsible for the content or privacy practices of third-party sites.</p>

        <h3>9. Changes to This Privacy Policy</h3>
        <p>We may update this Privacy Policy from time to time. Any changes will be posted on this page with an updated "Effective Date". We encourage you to periodically review this policy to stay informed about how we are protecting your information.</p>

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
