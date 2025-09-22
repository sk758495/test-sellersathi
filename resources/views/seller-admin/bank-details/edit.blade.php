<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Seller-Admin Add Product</title>

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
        @include('seller-admin.navbar')

        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Add and Update your bank details</h1>
                        <h1 class="page-subhead-line">Please add your bank details properly to receive payments.</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <h1>Bank Details</h1>
                            <div class="container">
                                <form action="{{ route('seller-admin.bank-details.save', ['sellerAdminId' => $sellerAdminId]) }}" method="POST" onsubmit="return validateForm()">
                                    @csrf
                                    <div class="form-group">
                                        <label for="account_name">Account Name</label>
                                        <input type="text" id="account_name" name="account_name" value="{{ old('account_name', $bankDetails->account_name ?? '') }}" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="account_number">Account Number</label>
                                        <input type="text" id="account_number" name="account_number" value="{{ old('account_number', $bankDetails->account_number ?? '') }}" class="form-control" required maxlength="16" minlength="10" oninput="this.value = this.value.replace(/\D/g, '')">
                                    </div>

                                    <div class="form-group">
                                        <label for="ifsc_code">IFSC Code</label>
                                        <input type="text" id="ifsc_code" name="ifsc_code" value="{{ old('ifsc_code', $bankDetails->ifsc_code ?? '') }}" class="form-control" required pattern="[A-Za-z]{4}0[A-Z0-9]{6}" title="IFSC code should start with 4 alphabets, followed by a 0 and 6 alphanumeric characters">
                                    </div>

                                    <div class="form-group">
                                        <label for="bank_name">Bank Name</label>
                                        <input type="text" id="bank_name" name="bank_name" value="{{ old('bank_name', $bankDetails->bank_name ?? '') }}" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="branch_name">Branch Name</label>
                                        <input type="text" id="branch_name" name="branch_name" value="{{ old('branch_name', $bankDetails->branch_name ?? '') }}" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="upi_id">UPI ID</label>
                                        <input type="text" name="upi_id" id="upi_id" value="{{ old('upi_id', $bankDetails->upi_id ?? '') }}" class="form-control" required pattern="^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Enter a valid UPI ID (e.g., name@upi)">
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone" value="{{ old('phone', $bankDetails->phone ?? '') }}" class="form-control" required minlength="10" maxlength="10" oninput="this.value = this.value.replace(/\D/g, '')">
                                    </div>

                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="footer-sec">
            &copy; 2014 YourCompany | Design By : <a href="http://www.binarytheme.com/" target="_blank">BinaryTheme.com</a>
        </div>

        <!-- JQUERY SCRIPTS -->
        <script src="{{ asset('assets/js/jquery-1.10.2.js') }}"></script>
        <!-- BOOTSTRAP SCRIPTS -->
        <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
        <!-- METISMENU SCRIPTS -->
        <script src="{{ asset('assets/js/jquery.metisMenu.js') }}"></script>
        <!-- CUSTOM SCRIPTS -->
        <script src="{{ asset('assets/js/custom.js') }}"></script>

        <!-- JavaScript to show custom pop-up -->
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                showPopup("{{ session('success') }}", "success");
            @elseif(session('error'))
                showPopup("{{ session('error') }}", "error");
            @elseif(session('info'))
                showPopup("{{ session('info') }}", "info");
            @endif
        });

        function showPopup(message, type) {
            const popup = document.createElement('div');
            popup.classList.add('popup', type);
            popup.innerText = message;
            document.body.appendChild(popup);

            setTimeout(() => {
                popup.style.transform = 'translateY(0)';
            }, 100);

            setTimeout(() => {
                popup.style.transform = 'translateY(-100px)';
                setTimeout(() => {
                    popup.remove();
                }, 300);
            }, 5000);
        }

        function validateForm() {
            let isValid = true;
            const phone = document.getElementById("phone");
            const accountNumber = document.getElementById("account_number");

            // Validate phone number length
            if (phone.value.length !== 10) {
                alert("Phone number must be 10 digits.");
                isValid = false;
            }

            // Validate account number length
            if (accountNumber.value.length < 10 || accountNumber.value.length > 16) {
                alert("Account number must be between 10 and 16 digits.");
                isValid = false;
            }

            return isValid;
        }
        </script>

        <style>
        /* Pop-up styles */
        .popup {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%) translateY(-100px);
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

        .popup.success {
            background-color: #28a745;
        }

        .popup.error {
            background-color: #dc3545;
        }

        .popup.info {
            background-color: #17a2b8;
        }
        </style>
</body>
</html>
