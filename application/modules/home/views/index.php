<!DOCTYPE html>
<html lang="es">
<!--begin::Head-->
<head>
	<meta charset="utf-8" />
	<title>Memes</title>
	<meta name="description" content="Sistema para la venta de boletos de buses" />
	<meta name="keywords" content="Buses, boletos, pasajeros" />
	<!--    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />-->
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<!--	<link rel="shortcut icon" href="--><?//= base_url() ?><!--assets/media/logos/favicon.ico" />-->
	<!--begin::Fonts-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Global Stylesheets Bundle(used by all pages)-->
	<link href="<?= base_url() ?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url() ?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Global Stylesheets Bundle-->
	<!--Begin::Google Tag Manager -->
	<!--    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&amp;l='+l:'';j.async=true;j.src= '../../../../../../www.googletagmanager.com/gtm5445.html?id='+i+dl;f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer','GTM-5FS8GGP');</script>-->
	<!--End::Google Tag Manager -->
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" data-bs-spy="scroll" data-bs-target="#kt_landing_menu" data-bs-offset="200" class="bg-white position-relative">
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
	<!--begin::Header Section-->
	<div class="mb-0" id="home">
		<!--begin::Wrapper-->

		<!--end::Wrapper-->
		<!--begin::Curve bottom-->
		<div class="landing-curve landing-dark-color mb-10 mb-lg-20">
			<svg viewBox="15 12 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M0 11C3.93573 11.3356 7.85984 11.6689 11.7725 12H1488.16C1492.1 11.6689 1496.04 11.3356 1500 11V12H1488.16C913.668 60.3476 586.282 60.6117 11.7725 12H0V11Z" fill="currentColor"></path>
			</svg>
		</div>
		<!--end::Curve bottom-->
	</div>
	<!--end::Header Section-->
	<!--begin::How It Works Section-->
	<div class="mb-n10 mb-lg-n20 z-index-2">
		<!--begin::Container-->
		<div class="container">
			<!--begin::Heading-->
			<div class="text-center mb-17">
				<!--begin::Title-->
				<h3 class="fs-2hx text-dark mb-5" id="how-it-works" data-kt-scroll-offset="{default: 100, lg: 150}">Memes</h3>
				<!--end::Title-->
				<!--begin::Text-->
				<div class="fs-5 text-muted fw-bold">Listado de memes</div>
				<!--end::Text-->
			</div>
			<!--end::Heading-->
			<!--begin::Row-->
			<div class="row w-100 gy-10 mb-md-20">
				<?php
				if (!empty($memes)) {
					$counter = 1;
//				var_dump($memes);
					foreach($memes as $meme) {
						?>
						<!--begin::Col-->
						<div class="col-md-4 px-5">
							<!--begin::Story-->
							<div class="text-center mb-10 mb-md-0">
								<!--begin::Illustration-->
								<img src="<?=$meme->icon_url;?>" class="mh-125px mb-9" alt="" />
								<!--end::Illustration-->
								<!--begin::Heading-->
								<div class="d-flex flex-center mb-5">
									<!--begin::Badge-->
									<span class="badge badge-circle badge-light-success fw-bolder p-5 me-3 fs-3"><?=$counter;?></span>
									<!--end::Badge-->
									<!--begin::Title-->
									<div class="fs-5 fs-lg-3 fw-bolder text-dark"><?=$meme->id_meme;?></div>
									<!--end::Title-->
								</div>
								<!--end::Heading-->
								<!--begin::Description-->
								<div class="fw-bold fs-6 fs-lg-4 text-muted"><?=$meme->value;?></div>
								<!--end::Description-->
							</div>
							<!--end::Story-->
						</div>
						<!--end::Col-->
						<?php
						$counter++;
					}
				}
				?>
			</div>
			<!--end::Row-->

			<!--begin::Product slider-->

			<!--end::Product slider-->
		</div>
		<!--end::Container-->
	</div>
	<!--end::How It Works Section-->
	<!--begin::Scrolltop-->
	<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
		<!--begin::Svg Icon | path: icons/duotone/Navigation/Up-2.svg-->
		<span class="svg-icon">
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							<polygon points="0 0 24 0 24 24 0 24" />
							<rect fill="#000000" opacity="0.5" x="11" y="10" width="2" height="10" rx="1" />
							<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
						</g>
					</svg>
				</span>
		<!--end::Svg Icon-->
	</div>
	<!--end::Scrolltop-->
</div>
<!--end::Main-->
<!--begin::Javascript-->
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="<?= base_url() ?>assets/plugins/global/plugins.bundle.js"></script>
<script src="<?= base_url() ?>assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Vendors Javascript(used by this page)-->
<!--end::Page Vendors Javascript-->
<!--begin::Page Custom Javascript(used by this page)-->
<!--end::Page Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
