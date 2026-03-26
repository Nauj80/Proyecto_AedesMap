<?php
$username = $_SESSION['usuario']['nombre'] . " " . $_SESSION['usuario']['apellido'];
$iniciales = "";
$names = explode(" ", $username);
foreach ($names as $name) {
	$iniciales .= strtoupper($name[0]);
}
?>

<div class="main-header">
	<div class="main-header-logo">
		<!-- Logo Header -->
		<div class="logo-header" data-background-color="dark">

			<a href="index.html" class="logo">
				<img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20">
			</a>
			<div class="nav-toggle">
				<button class="btn btn-toggle toggle-sidebar">
					<i class="gg-menu-right"></i>
				</button>
				<button class="btn btn-toggle sidenav-toggler">
					<i class="gg-menu-left"></i>
				</button>
			</div>
			<button class="topbar-toggler more">
				<i class="gg-more-vertical-alt"></i>
			</button>

		</div>
		<!-- End Logo Header -->
	</div>
	<!-- Navbar Header -->
	<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">

		<div class="container-fluid">
			

			<ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
				

				<li class="nav-item topbar-user dropdown hidden-caret">
					<a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">

						<div class="avatar">
							<span class="avatar-title rounded-circle border border-white bg-primary">
								<?php echo $iniciales; ?>
							</span>
						</div>

						<span class="profile-username">
							<span class="op-7">Hola,</span> <span
								class="fw-bold"><?php echo $_SESSION['usuario']['nombre'] . " " . $_SESSION['usuario']['apellido']; ?></span>
						</span>
					</a>
					<ul class="dropdown-menu dropdown-user animated fadeIn">
						<div class="dropdown-user-scroll scrollbar-outer">
							<li>
								<div class="user-box">
									<div class="avatar">
										<span class="avatar-title rounded-circle border border-white bg-primary">
											<?php echo $iniciales; ?>
										</span>
									</div>
									<div class="u-text">
										<h4><?php echo $_SESSION["usuario"]["nombre"]; ?></h4>
										<p class="text-muted"><?php echo $_SESSION["usuario"]["correo"]; ?></p><a
											href="profile.html" class="btn btn-xs btn-secondary btn-sm">View Profile</a>
									</div>
								</div>
							</li>
							<li>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="<?= getUrl("Login", "Login", "logout") ?>">Logout</a>
							</li>
						</div>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
	<!-- End Navbar -->
</div>