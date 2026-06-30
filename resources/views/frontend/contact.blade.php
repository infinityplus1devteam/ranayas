@extends('layouts.master')
@section('title', 'Contact')
@section('content')


    <!-- breadcrumb start -->
    <section class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-start">
                        <ul class="breadcrumb-url">
                            <li class="breadcrumb-url-li">
                                <a href="{{ route('index') }}">Home</a>
                            </li>
                            <li class="breadcrumb-url-li">
                                <span>Contact Us</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb end -->

    <!-- Main Content Wrapper Start -->
    <div id="content" class="main-content-wrapper section-tb-padding">
        <div class="page-content-inner">
            <div class="container">
                <div class="row">
                    <!-- Contact form Start Here -->
                    <div class="col-lg-7">
                        <div class="contact-form-wrapper">
                            <h2 class="heading-secondary mb-4">Get in touch</h2>
                            <p class="mb-4 text-muted">Have a question or feedback? We would love to hear from you. Fill out the form below and we'll get back to you as soon as possible.</p>
                            
                            <form action="{{ url('contact') }}" class="form custom-contact-form" method="POST">
                                @csrf
                                <!-- Honeypot field -->
                                <input type="text" name="website" style="display:none !important;" tabindex="-1" autocomplete="off">
                                
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-floating">
                                            <input type="text" placeholder="Name *"
                                                class="form-control" id="floatingInput" name="name"
                                                required="required" value="{{ old('name') }}"
                                                oninvalid="this.setCustomValidity('Please enter name')"
                                                oninput="setCustomValidity('')">
                                            <label for="floatingInput">Name *</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="form-floating">
                                            <input type="email" placeholder="E-mail *"
                                                class="form-control" name="email" id="floatingEmail"
                                                required="required" value="{{ old('email') }}"
                                                oninvalid="this.setCustomValidity('Please enter email')"
                                                oninput="setCustomValidity('')">
                                            <label for="floatingEmail">Email *</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="form-floating">
                                            <input type="text" placeholder="Phone"
                                                class="form-control" id="floatingPhone" name="mobile"
                                                required="required" value="{{ old('mobile') }}"
                                                oninvalid="this.setCustomValidity('Please enter mobile')"
                                                oninput="setCustomValidity('')">
                                            <label for="floatingPhone">Phone *</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="form-floating">
                                            <input type="text" placeholder="Subject"
                                                class="form-control" id="floatingSubject" name="subject"
                                                value="{{ old('subject') }}">
                                            <label for="floatingSubject">Subject</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <div class="form-floating">
                                            <textarea placeholder="Type Your Message" name="message" id="messageArea"
                                                class="form-control" style="height: 150px">{{ old('message') }}</textarea>
                                            <label for="messageArea">Message *</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-contact-submit">Send Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Contact form end Here -->

                    <!-- Contact info widget start here -->
                    <div class="col-lg-5 col-xl-4 offset-xl-1 mt-5 mt-lg-0">
                        <div class="contact-info-card p-4 shadow-sm rounded bg-white">
                            <h2 class="heading-secondary mb-4">Contact Info</h2>
                            
                            <div class="contact-info-item d-flex mb-4">
                                <div class="icon-box me-3">
                                    <i class="ion-ios-location-outline"></i>
                                </div>
                                <div class="info-content">
                                    <h5>Our Location</h5>
                                    <p class="mb-0 text-muted">Kandivali West, Mumbai, Maharashtra, India</p>
                                </div>
                            </div>

                            <div class="contact-info-item d-flex mb-4">
                                <div class="icon-box me-3">
                                    <i class="ion-ios-email-outline"></i>
                                </div>
                                <div class="info-content">
                                    <h5>Email</h5>
                                    <a href="mailto:info@ranayas.com" class="text-muted">info@ranayas.com</a>
                                </div>
                            </div>

                            <div class="contact-info-item d-flex mb-4">
                                <div class="icon-box me-3">
                                    <i class="ion-ios-telephone-outline"></i>
                                </div>
                                <div class="info-content">
                                    <h5>Contact Us</h5>
                                    <a href="tel:+919820760951" class="text-muted">(+91) 982 076 0951</a>
                                </div>
                            </div>

                            <div class="contact-info-item d-flex mb-4">
                                <div class="icon-box me-3">
                                    <i class="ion-ios-clock-outline"></i>
                                </div>
                                <div class="info-content">
                                    <h5>Business Hours</h5>
                                    <p class="mb-0 text-muted">Monday to Friday<br>10:30 AM to 6:30 PM</p>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="social-links-contact">
                                <h5 class="mb-3">Follow Us</h5>
                                <div class="d-flex gap-3">
                                    <a href="https://wa.me/9820760951" class="social-icon-btn wa"><i class="fa fa-whatsapp"></i></a>
                                    <a href="https://www.facebook.com/ranayas2016" class="social-icon-btn fb"><i class="fa fa-facebook"></i></a>
                                    <a href="https://www.instagram.com/ranayas2016/" class="social-icon-btn ig"><i class="fa fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Contact info widget End here -->
                </div>

                <!-- Google Map Section -->
                <div class="row mt-5 pt-4">
                    <div class="col-12">
                        <div class="map-wrapper shadow-sm rounded overflow-hidden">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d60287.67500582531!2d72.78536109919736!3d19.20263630691523!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7b0d771036f01%3A0x83e2003c00000000!2sKandivali%2C%20Kandivali%20West%2C%20Mumbai%2C%20Maharashtra!5e0!3m2!1sen!2sin!4v1714800000000!5m2!1sen!2sin" 
                                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content Wrapper End -->

    <style>
        .btn-contact-submit {
            background-color: transparent;
            color: var(--theme-color);
            border: 2px solid var(--theme-color);
            padding: 12px 35px;
            font-weight: 600;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .btn-contact-submit:hover {
            background-color: var(--theme-color);
            color: #fff;
        }
        .icon-box {
            background: #f8f1ff;
            color: var(--theme-color);
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }
        .social-icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            transition: transform 0.3s ease;
        }
        .social-icon-btn:hover {
            transform: translateY(-3px);
            color: #fff;
        }
        .social-icon-btn.wa { background-color: #25d366; }
        .social-icon-btn.fb { background-color: #3b5998; }
        .social-icon-btn.ig { background-color: #e4405f; }
        
        .form-control:focus {
            border-color: var(--theme-color);
            box-shadow: 0 0 0 0.25rem rgba(103, 12, 177, 0.1);
        }
        .contact-info-card {
            border: 1px solid #eee;
        }
    </style>


@endsection
