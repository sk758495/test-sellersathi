<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gujju E Market</title>
    @include('user.head')

</head>

<body>

    @include('user.navbar')

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product-details-pic">
                        <div class="product-pic-container">
                            <div class="product-thumbnails">
                                <div class="thumb-item active" onclick="changeMainImage('{{ asset('storage/' . $product->main_image) }}')">
                                    <img src="{{ asset('storage/' . $product->main_image) }}" alt="">
                                </div>
                                @if($product->images)
                                    @foreach(json_decode($product->images) as $image)
                                        <div class="thumb-item" onclick="changeMainImage('{{ asset('storage/' . $image) }}')">
                                            <img src="{{ asset('storage/' . $image) }}" alt="">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="product-details-pic-item">
                                <img class="product-details-pic-item-large" id="main-image" src="{{ asset('storage/' . $product->main_image) }}" alt="">
                            </div>
                        </div>
                        <div class="product-brand-info">
                            <div class="brand-badge">
                                <span class="badge-label">Top Brand</span>
                                <span class="brand-name">{{ $product->brand->name ?? 'Brand' }}</span>
                            </div>
                            <ul class="brand-features">
                                <li><i class="fa fa-check-circle"></i> 83% positive ratings from 100K+ customers</li>
                                <li><i class="fa fa-check-circle"></i> 100K+ recent orders from this brand</li>
                                <li><i class="fa fa-check-circle"></i> 2+ years on Gujju E-market</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product-details-text">
                        <div class="pd-title">
                            <span id="category">{{ $product->brandCategory->name ?? 'Category' }}</span>
                            <h3 id="title">{{ $product->product_name }}</h3>
                            <a href="#" class="heart-icon"><i class="icon_heart_alt"></i></a>
                        </div>
                        <div class="pd-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                            <span>(5)</span>
                        </div>
                        <div class="pd-desc">
                            <p id="description">{!! $product->short_description ?? 'Latest product with advanced features and premium build quality.' !!}</p>
                            <h4 id="price">₹{{ number_format($product->discount_price, 2) }} <span id="original-price">₹{{ number_format($product->price, 2) }}</span></h4>
                        </div>
                        <div class="pd-color">
                            <h6>Color</h6>
                            <div class="pd-color-choose">
                                <div class="cc-item">
                                    <input type="radio" id="cc-black" name="color">
                                    <label for="cc-black" class="cc-black"></label>
                                </div>
                                <div class="cc-item">
                                    <input type="radio" id="cc-yellow" name="color">
                                    <label for="cc-yellow" class="cc-yellow"></label>
                                </div>
                                <div class="cc-item">
                                    <input type="radio" id="cc-violet" name="color">
                                    <label for="cc-violet" class="cc-violet"></label>
                                </div>
                            </div>
                        </div>
                        <div class="pd-size-choose">
                            <div class="sc-item">
                                <input type="radio" id="sm-size" name="size">
                                <label for="sm-size">s</label>
                            </div>
                            <div class="sc-item">
                                <input type="radio" id="md-size" name="size">
                                <label for="md-size">m</label>
                            </div>
                            <div class="sc-item">
                                <input type="radio" id="lg-size" name="size">
                                <label for="lg-size">l</label>
                            </div>
                            <div class="sc-item">
                                <input type="radio" id="xl-size" name="size">
                                <label for="xl-size">xl</label>
                            </div>
                        </div>
                        <div class="quantity">
                            <div class="pro-qty">
                                <input type="text" value="1">
                            </div>
                            <a href="{{ route('user.add_cart', ['id' => $product->id]) }}" class="primary-btn pd-cart">Add To Cart</a>
                        </div>
                        <ul class="pd-tags">
                            <li><span>CATEGORIES</span>: <span id="tags">{{ $product->brandCategory->name ?? 'Category' }}</span></li>
                            <li><span>TAGS</span>: <span>{{ $product->brand->name ?? 'Brand' }}, {{ $product->product_name }}</span></li>
                        </ul>
                        <div class="pd-features">
                            <div class="feature-item">
                                <i class="fa fa-shield"></i>
                                <span>1 Year Warranty</span>
                            </div>
                            <div class="feature-item">
                                <i class="fa fa-lock"></i>
                                <span>Secure Transaction</span>
                            </div>
                            <div class="feature-item">
                                <i class="fa fa-refresh"></i>
                                <span>Return</span>
                            </div>
                            <div class="feature-item">
                                <i class="fa fa-money"></i>
                                <span>Cash/Pay on Delivery</span>
                            </div>
                            <div class="feature-item">
                                <i class="fa fa-truck"></i>
                                <span>Free Delivery</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-details-tab">
                <div class="pd-tab-list">
                    <a href="#" class="active" data-toggle="tab" data-target="#tab-1">Description</a>
                    <a href="#" data-toggle="tab" data-target="#tab-2">Information</a>
                    <a href="#" data-toggle="tab" data-target="#tab-3">Features</a>
                    <a href="#" data-toggle="tab" data-target="#tab-4">What's Included</a>
                    <a href="#" data-toggle="tab" data-target="#tab-5">Reviews <span>(5)</span></a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-1">
                        <div class="pd-desc-detail">
                            <h4>Product Description</h4>
                            <p>{!! $product->long_description ?? 'Experience the future with our latest product featuring cutting-edge technology and premium design.' !!}</p>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-2">
                        <div class="pd-information">
                            <h4>Product Information</h4>
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label"><i class="fa fa-tag"></i> Brand</div>
                                    <div class="info-value" id="brand">{{ $product->brand->name ?? 'Brand' }}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label"><i class="fa fa-mobile"></i> Model</div>
                                    <div class="info-value" id="model">{{ $product->product_name }}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label"><i class="fa fa-hdd-o"></i> SKU</div>
                                    <div class="info-value">{{ $product->sku }}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label"><i class="fa fa-desktop"></i> Category</div>
                                    <div class="info-value">{{ $product->brandCategory->name ?? 'Category' }}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label"><i class="fa fa-shield"></i> Warranty</div>
                                    <div class="info-value">1 Year</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label"><i class="fa fa-palette"></i> Color</div>
                                    <div class="info-value">{{ $product->color_name ?? 'Multiple' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-3">
                        <div class="pd-features-detail">
                            <h4>Product Features</h4>
                            <div>{!! $product->features ?? 'No features available.' !!}</div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-4">
                        <div class="pd-whats-included">
                            <h4>What's Included</h4>
                            <div>{!! $product->whats_included ?? 'No information available.' !!}</div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-5">
                        <div class="pd-reviews">
                            <h4>Customer Reviews</h4>
                            <div class="review-item">
                                <div class="ri-pic">
                                    <img src="{{ asset('assets/img/product-single/review-1.jpg') }}" alt="">
                                </div>
                                <div class="ri-text">
                                    <span>27 Aug 2019</span>
                                    <div class="ri-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-o"></i>
                                    </div>
                                    <h5>Brandon Kelley</h5>
                                    <p>Excellent product! Great quality and fast delivery.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

      <!-- Related Accessories Section Begin -->
    {{-- <section class="related-accessories">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related-accessories-title">
                        <h2>Related Accessories</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product-item">
                        <div class="pi-pic">
                            <img src="img/products/spk.png" alt="">
                            <!-- <ul>
                                <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
                                <li class="quick-view"><a href="#">+ Quick View</a></li>
                                <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul> -->
                        </div>
                        <div class="pi-text">
                            <div class="catagory-name">Accessories</div>
                            <a href="#">
                                <h5>Wireless Charger</h5>
                            </a>
                            <div class="product-price">₹25.00 <span>₹40.00</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product-item">
                        <div class="pi-pic">
                            <img src="img/products/len.png" alt="">
                            <!-- <ul>
                                <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
                                <li class="quick-view"><a href="#">+ Quick View</a></li>
                                <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul> -->
                        </div>
                        <div class="pi-text">
                            <div class="catagory-name">Accessories</div>
                            <a href="#">
                                <h5>Phone Case</h5>
                            </a>
                            <div class="product-price">₹15.00 <span>₹25.00</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product-item">
                        <div class="pi-pic">
                            <img src="img/products/ph.png" alt="">
                            <!-- <ul>
                                <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
                                <li class="quick-view"><a href="#">+ Quick View</a></li>
                                <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul> -->
                        </div>
                        <div class="pi-text">
                            <div class="catagory-name">Accessories</div>
                            <a href="#">
                                <h5>Screen Protector</h5>
                            </a>
                            <div class="product-price">₹8.00 <span>₹15.00</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product-item">
                        <div class="pi-pic">
                            <img src="img/products/spk.png" alt="">
                            <!-- <ul>
                                <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
                                <li class="quick-view"><a href="#">+ Quick View</a></li>
                                <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul> -->
                        </div>
                        <div class="pi-text">
                            <div class="catagory-name">Accessories</div>
                            <a href="#">
                                <h5>Bluetooth Earbuds</h5>
                            </a>
                            <div class="product-price">₹45.00 <span>₹60.00</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- Related Accessories Section End -->

        <!-- Product Description Images Section Begin -->

    {{-- <section class="product-description-images spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="desc-image-item">
                        <img src="img/products/spe.png" alt="">
                        <div class="desc-overlay">
                            <div class="desc-content left-bottom">
                                <h3>Premium Design</h3>
                                <p>Crafted with precision and attention to detail for the ultimate user experience</p>
                            </div>
                        </div>
                    </div>
                    <div class="image-description">
                        <h4>Elegant Craftsmanship</h4>
                        <p>Every curve and detail has been meticulously designed to create a device that's not just
                            functional, but beautiful. The premium materials and flawless finish make this more than
                            just a phone - it's a statement of style.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="desc-image-item">
                        <img src="img/products/spec1.png" alt="">
                    </div>
                    <div class="image-description">
                        <h4>Next-Gen Performance</h4>
                        <p>Experience lightning-fast processing speeds and seamless multitasking with our most advanced
                            chip yet. Whether you're gaming, streaming, or working, everything runs smoothly and
                            efficiently.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="desc-image-item">
                        <img src="img/products/spec2.png" alt="">
                    </div>
                    <div class="image-description">
                        <h4>Intelligent Innovation</h4>
                        <p>AI-powered features learn your habits and preferences to make your daily tasks easier. From
                            smart camera modes to predictive text, technology works for you in ways you never imagined.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="desc-image-item">
                        <img src="img/products/spec3.png" alt="">
                    </div>
                    <div class="image-description">
                        <h4>All-Day Power</h4>
                        <p>Revolutionary battery technology ensures your device stays powered throughout your busiest
                            days. Fast charging capabilities mean you're never far from full power when you need it
                            most.</p>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Product Description Images Section End -->


    <!-- Related Product Section Begin -->
    <section class="related-product">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related-product-title">
                        <h2>Related Products</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($relatedProducts as $relatedProduct)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product-item">
                        <div class="pi-pic">
                            <img src="{{ asset('storage/' . $relatedProduct->main_image) }}" alt="">
                        </div>
                        <div class="pi-text">
                            <div class="catagory-name">{{ $relatedProduct->brandCategory->name ?? 'Category' }}</div>
                            <a href="{{ route('user.view_product', $relatedProduct->id) }}">
                                <h5>{{ $relatedProduct->product_name }}</h5>
                            </a>
                            <div class="product-price">₹{{ number_format($relatedProduct->discount_price, 2) }} <span>₹{{ number_format($relatedProduct->price, 2) }}</span></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Related Product Section End -->

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