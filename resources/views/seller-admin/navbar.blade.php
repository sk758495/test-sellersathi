<nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ route('seller-admin.dashboard', ['sellerAdminId' => auth()->user()->id]) }}">GUJJU E-MARKET</a>
    </div>

    <div class="header-right">

        <a href="message-task.html" class="btn btn-info" title="New Message"><b>30 </b><i class="fa fa-envelope-o fa-2x"></i></a>
        <a href="message-task.html" class="btn btn-primary" title="New Task"><b>40 </b><i class="fa fa-bars fa-2x"></i></a>
        <a href="login.html" class="btn btn-danger" title="Logout"><i class="fa fa-exclamation-circle fa-2x"></i></a>

    </div>
</nav>
<!-- /. NAV TOP  -->
<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">
            <li>
                <div class="user-img-div">
                    <img src="{{ asset('user/images/gujju-logo.jpg') }}" class="img-thumbnail" />

                    <div class="inner-text">
                        Seller Admin
                    <br />
                    <small>Login: <span class="green-dot" style=" display: inline-block;width: 8px; height: 8px; background-color: rgb(5, 255, 5);border-radius: 50%;margin-left: 5px;vertical-align: middle;"></span></small>
                    </div>
                </div>

            </li>


            <li>
                <a class="active-menu" href="{{ route('seller-admin.dashboard', ['sellerAdminId' => auth()->user()->id]) }}">
                    <i class="fa fa-dashboard "></i> Dashboard
                </a>

            </li>

            <li>
                <a href="{{ route('seller.products.select', ['sellerAdminId' => auth()->user()->id]) }}"><i class="fa fa-flash "></i>Add Product</a>
            </li>
             <li>
                <a href="{{ route('seller-admin.orders.received', ['sellerAdminId' => auth()->user()->id]) }}"><i class="fa fa-bicycle "></i>Order Received</a>
            </li>
            <li>
                <a href="{{ route('seller-admin.bank-details', ['sellerAdminId' => auth()->user()->id]) }}"><i class="fa fa-university "></i>Bank Account</a>
            </li>
              {{-- <li>
                <a href="gallery.html"><i class="fa fa-anchor "></i>Gallery</a>
            </li>
             <li>
                <a href="error.html"><i class="fa fa-bug "></i>Error Page</a>
            </li> --}}
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-in"></i> Log Out
                </a>

                <form id="logout-form" action="{{ route('seller-admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

            </li>
        </ul>

    </div>

</nav>
