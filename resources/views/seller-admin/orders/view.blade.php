<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Seller-Admin Received Orders</title>

    <!-- BOOTSTRAP STYLES-->
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="{{ asset('assets/css/font-awesome.css') }}" rel="stylesheet" />
    <!--CUSTOM BASIC STYLES-->
    <link href="{{ asset('assets/css/basic.css') }}" rel="stylesheet" />
    <!--CUSTOM MAIN STYLES-->
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    
    <link rel="icon" href="{{ asset('user/images/gujju-logo-removebg.png') }}" sizes="32x32" type="image/x-icon">
</head>
<body>
    <div id="wrapper">
        @include('seller-admin.navbar')  <!-- Navbar inclusion -->

        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">ORDER INVOICE </h1>

                    </div>
                </div>
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                       <div >

      <div class="row pad-top-botm ">
         <div class="col-lg-6 col-md-6 col-sm-6 ">
            <img src="{{ asset('storage/'.$order->product->main_image) }}" alt="{{ $order->product->name }}" style="max-width: 200px; height: auto; border: 1px solid #ddd; padding: 5px; margin-top: 10px;"" />
            <h2>(Order ID: {{ $order->id }})</h2>
         </div>
          <div class="col-lg-6 col-md-6 col-sm-6">

               <strong> Gujju e-Market.</strong>
              <br />
                  <i>Address :</i> 15 Giriraj Bagh,
              <br />
              Waghodia Road, Vadodara,
              <br />
              Gujarat 390019.

         </div>
     </div>
     <div  class="row text-center contact-info">
         <div class="col-lg-12 col-md-12 col-sm-12">
             <hr />
             <span>
                 <strong>Email : </strong>  arjuncableconverters@gmail.com
             </span>
             <span>
                 <strong>Call : </strong>  +91 - 96244 02490
             </span>
              <span>
                 <strong>Fax : </strong>  +91 0000000000
             </span>
             <hr />
         </div>
     </div>
     <div  class="row pad-top-botm client-info">
         <div class="col-lg-6 col-md-6 col-sm-6">
         <h4>  <strong>Customer Information</strong></h4>
           <strong>   {{ $order->sellerAdmin->name }}</strong>
             <br />
                  <b>Address :</b> {{ $order->address->address_line1 }},
              <br />
           {{ $order->address->address_line2 }},
            <br />
              {{ $order->address->city }}
             <br />
             <b>Call :</b> {{ $order->user->phone }}
              <br />
             <b>E-mail :</b> {{ $order->user->email }}
         </div>
          <div class="col-lg-6 col-md-6 col-sm-6">

               <h4>  <strong>Payment Details </strong></h4>
            <b>Bill Amount :  ₹{{ $order->total_price }}</b>
              <br />
               Bill Date :  {{ $order->created_at->format('d M Y, H:i') }}
              <br />
               <b>Payment Status :  {{ ucfirst($order->status) }} </b>
               <br />
               Delivery Time :  After Confirm Order - 7 Days
              <br />
               {{-- Purchase Date :  30th July 2014 --}}
         </div>
     </div>
     <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12">
           <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>S. No.</th>
                                    <th>Product Name</th>
                                    <th>Quantity.</th>
                                    <th>Unit Price</th>
                                     <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>{{ $order->product->product_name }}</td>
                                    <td>{{ $order->quantity }}</td>
                                    <td>₹{{ $order->product->price }}</td>
                                    <td>₹{{ $order->total_price }}</td>
                                </tr>

                            </tbody>
                        </table>
               </div>
             <hr />
             <div class="ttl-amts">
               <h5>  Total Amount : ₹{{ $order->total_price }}</h5>
             </div>
             {{-- <hr />
              <div class="ttl-amts">
                  <h5>  Tax : 90 USD ( by 10 % on bill ) </h5>
             </div> --}}
             <hr />
              <div class="ttl-amts">
                  <h4> <strong>Bill Amount : ₹{{ $order->total_price }}</strong> </h4>
             </div>
         </div>
     </div>
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12">
            <strong> Important: </strong>
             <ol>
                  <li>
                    This is an electronic generated invoice so doesn't require any signature.

                 </li>
                 <li>
                     Please read all terms and polices on  www.gujjuemarket.com for returns, replacement and other issues.

                 </li>
             </ol>
             </div>
         </div>
      <div class="row pad-top-botm">
         <div class="col-lg-12 col-md-12 col-sm-12">
             <hr />
             <a href="{{ route('seller-admin.orders.received', ['sellerAdminId' => $sellerAdminId]) }}" class="btn btn-primary btn-lg" >back</a>
             &nbsp;&nbsp;&nbsp;
              <a href="{{ route('seller-admin.orders.downloadInvoice', ['orderId' => $order->id, 'sellerAdminId' => $sellerAdminId]) }}" class="btn btn-success btn-lg" >Download In Pdf</a>

             </div>
         </div>
 </div>
                    </div>
                </div>

            </div>
            <!-- /. PAGE INNER  -->
        </div>


    </div>
 </div>
        </div>
    </div>

    <div id="footer-sec">
        &copy; 2024 YourCompany | Design By : <a href="http://www.binarytheme.com/" target="_blank">BinaryTheme.com</a>
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
            
    <!-- JQUERY SCRIPTS -->
    <script src="{{ asset('assets/js/jquery-1.10.2.js') }}"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="{{ asset('assets/js/jquery.metisMenu.js') }}"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>
</html>
