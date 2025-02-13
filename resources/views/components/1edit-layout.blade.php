<!DOCTYPE html>
<html lang="zxx">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  	<meta name="description" content="Orbitor,business,company,agency,modern,bootstrap4,tech,software">
  	<meta name="author" content="themefisher.com">

  <title>Homepage</title>

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico" />

  <!-- bootstrap.min css -->
  <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
  <!-- Icon Font Css -->
  <link rel="stylesheet" href="plugins/icofont/icofont.min.css">
  <!-- Slick Slider  CSS -->
  <link rel="stylesheet" href="plugins/slick-carousel/slick/slick.css">
  <link rel="stylesheet" href="plugins/slick-carousel/slick/slick-theme.css">

  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="css/style.css">
    <style>
        .hidden {
            display: none;
        }

        .date-time-picker {
        display: flex;
        flex-direction: column;
        width: 300px;
        margin: auto;
        }

        .time-button {
            display: inline-block;
            margin: 5px;
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .time-button:hover {
            background-color: #0056b3;
        }



    </style>
     @livewireStyles
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
 <!-- Include SweetAlert2 CSS -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>


<body>


    <header class="bg-blue-700 text-white p-4" id="rhu-homepage" style="position: sticky; top: 0; z-index: 1;">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex-none">
                <a href="#"><img src="images\ehealth.png" alt="EHEALTH LUCBAN Logo" class="h-6 w-auto sm:h-8"></a>
            </div>
            <nav>
                <ul class="flex space-x-2">
                    <li><a href="/" class="nav-button bg-blue-800">Home</a></li>
                    <li><a href="#rhu-services" class="nav-button">Services</a></li>
                    <li><a href="#rhu-about" class="nav-button">About</a></li>
                    <li><a href="#rhu-contact" class="nav-button">Contacts</a></li>

                    <!-- Guest (Not Authenticated) -->
                    @guest
                    <li>
                        <a href="/login" class="bg-red-500 px-4 py-2 rounded-full hover:bg-green-600 transition duration-300">Login</a>
                    </li>
                    @endguest

                    <!-- Authenticated User -->
                    @auth
                    <li class="relative">
                        <a href="#">
                            {{-- <img id="profile-menu-button" src="images/img/user.png" alt="Profile Picture" class="profile-pic"
                                 style="width:2rem; height:2rem; padding: 0; border-radius:50%"> --}}

                                 <img  id="profile-menu-button" style="width:2rem; height:2rem; padding: 0; border-radius:50%" class=" profile-pic img-thumbnail mt-2"
                                 src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                                 alt="Profile Picture">
                        </a>
                        <span class="text-white">Hi, {{ Auth::user()->f_name }}</span>
                        <div id="profile-menu" style="display: none; position: absolute; bottom: -3rem;"
                        class="mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                       <a href="{{ route('edits') }}"
                          class="w-full block text-left px-4 py-2 text-gray-800 hover:bg-gray-200">
                           Edit Profile
                       </a>
                       <form method="POST" action="{{ route('logout') }}">
                           @csrf
                           <button type="submit" class="w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-200">
                               Logout
                           </button>
                       </form>
                   </div>

                    </li>
                    @endauth
                </ul>


            </nav>
        </div>
    </header>








    <div class="container overflow-auto auto-refresh" style="height: 100%; ">
        {{ $slot }}
    </div>

    <!-- footer Start -->
<footer class="footer section gray-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 mr-auto col-sm-6">
				<div class="widget mb-5 mb-lg-0">
					<div class="logo mb-4">
						<img src="images/logo.png" alt="" class="img-fluid">
					</div>
					<p>In its early years, the RHU of Lucban focused on basic healthcare services, maternal and child health, and the control of communicable diseases. </p>
					<ul class="list-inline footer-socials mt-4">
						<li class="list-inline-item"><a href="https://www.facebook.com/profile.php?id=61559717789864"><i class="icofont-facebook"></i></a></li>
						<li class="list-inline-item"><a href="https://www.facebook.com/LGULucbanQuezon"><i class="icofont-twitter"></i></a></li>
						<li class="list-inline-item"><a href="https://healthcarephilippines.com/directory/lucban-rural-health-unit/"><i class="icofont-linkedin"></i></a></li>
					</ul>
					<p>Rural Health Unit 4HC4+X3X, Lucban-Sampaloc road
						Barangay Abang, Lucban, Quezon, 4328
						Philippines</p>
				</div>
			</div>

			<div class="col-lg-2 col-md-6 col-sm-6">
				<div class="widget mb-5 mb-lg-0">
					<h4 class="text-capitalize mb-3">Services</h4>
					<div class="divider mb-4"></div>

					<ul class="list-unstyled footer-menu lh-35">
						<li><a href="#">Blood Donation </a></li>
						<li><a href="#">Consultation</a></li>
						<li><a href="#">Laboratory</a></li>
						<li><a href="#">Operating Hours</a></li>
						<li><a href="#">Laboratory Quotation</a></li>
					</ul>
				</div>
			</div>

			<div class="col-lg-2 col-md-6 col-sm-6">
				<div class="widget mb-5 mb-lg-0">
					<h4 class="text-capitalize mb-3">Support</h4>
					<div class="divider mb-4"></div>

					<ul class="list-unstyled footer-menu lh-35">
						<li><a href="#">Terms & Conditions</a></li>
						<li><a href="#">Privacy Policy</a></li>
						<li><a href="#">Company Support </a></li>
						<li><a href="#">FAQuestions</a></li>
						<li><a href="#">Company Licence</a></li>
					</ul>
				</div>
			</div>

			<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="widget widget-contact mb-5 mb-lg-0">
					<h4 class="text-capitalize mb-3">Get in Touch</h4>
					<div class="divider mb-4"></div>

					<div class="footer-contact-block mb-4">
						<div class="icon d-flex align-items-center">
							<i class="icofont-email mr-3"></i>
							<span class="h6 mb-0">Support Available for 24/7</span>
						</div>
						<h4 class="mt-2"><a href="tel:+23-345-67890">JimuelHepana@gmail.com</a></h4>
					</div>

					<div class="footer-contact-block">
						<div class="icon d-flex align-items-center">
							<i class="icofont-support mr-3"></i>
							<span class="h6 mb-0">Mon to Fri : 09:00am - 5:00pm</span>
						</div>
						<h4 class="mt-2"><a href="tel:+23-345-67890">+63 9363 423105</a></h4>
					</div>
				</div>
			</div>

			<div class="col-lg-12 col-md-6 col-sm-6">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3869.270935568038!2d121.55486607417356!3d14.12015768631123!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd540c892008ad%3A0xab8ec4ddd4130b68!2sRural%20Health%20Unit-%20Lucban%2C%20Quezon!5e0!3m2!1sen!2sph!4v1726574582136!5m2!1sen!2sph"
				width="100%" height="220" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
			</div>

		</div>

		<div class="footer-btm py-4 mt-5">
			<div class="row align-items-center justify-content-between">
				<div class="col-lg-6">
					<div class="copyright">
						&copy; Copyright Reserved to RHU Lucban by Hipana, Madrid, Pondivida @2024-2025
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-4">
					<a class="backtop js-scroll-trigger" href="#top">
						<i class="icofont-long-arrow-up"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
</footer>


<script>
    // JavaScript to toggle between display: none and display: block
    document.getElementById('profile-menu-button').addEventListener('click', function (e) {
        e.preventDefault(); // Prevent default anchor behavior
        const profileMenu = document.getElementById('profile-menu');
        if (profileMenu.style.display === 'none' || profileMenu.style.display === '') {
            profileMenu.style.display = 'block';
        } else {
            profileMenu.style.display = 'none';
        }
    });

    // Optional: Close the menu when clicking outside
    document.addEventListener('click', function (e) {
        const profileMenu = document.getElementById('profile-menu');
        const profileButton = document.getElementById('profile-menu-button');
        if (!profileMenu.contains(e.target) && e.target !== profileButton) {
            profileMenu.style.display = 'none';
        }
    });
</script>
<!-- Main jQuery -->
<script src="plugins/jquery/jquery.js"></script>
<!-- Bootstrap 4.3.2 -->
<script src="plugins/bootstrap/js/popper.js"></script>
<script src="plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/counterup/jquery.easing.js"></script>
<!-- Slick Slider -->
<script src="plugins/slick-carousel/slick/slick.min.js"></script>
<!-- Counterup -->
<script src="plugins/counterup/jquery.waypoints.min.js"></script>
<script src="plugins/shuffle/shuffle.min.js"></script>
<script src="plugins/counterup/jquery.counterup.min.js"></script>
<!-- Google Map -->
<script src="plugins/google-map/map.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkeLMlsiwzp6b3Gnaxd86lvakimwGA6UA&callback=initMap"></script>
<script src="js/script.js"></script>
<script src="js/contact.js"></script>
<script src="js/faq.js"></script>
<script src="js/service.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>

</body>
