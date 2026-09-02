<header class="site-header">
  <nav class="navbar navbar-expand-lg container">
    <a class="navbar-brand d-flex align-items-center" href="<?= base_url() ?>">
      <img class="brand-logo" src="<?= esc($logo_url) ?>" alt="Peak Potential Academy logo">
    </a>

    <button class="navbar-toggler nav-toggle border-0 p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navContent" aria-controls="navContent" aria-expanded="false" aria-label="Toggle navigation" id="navToggleBtn">
      <span></span>
      <span></span>
      <span></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navContent">
      <ul class="navbar-nav align-items-lg-center me-lg-3">
        <li class="nav-item"><a class="nav-link<?= peak_nav_active('home') ?>" href="<?= base_url() ?>">Home</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle<?= peak_nav_active('for-parents', 'for-school', 'for-students', 'for-corporate') ?>" href="#" id="solutionsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Solutions
          </a>
          <ul class="dropdown-menu" aria-labelledby="solutionsDropdown">
            <li><a class="dropdown-item<?= peak_nav_active('for-parents') ?>" href="<?= base_url('for-parents') ?>">For Parents</a></li>
            <li><a class="dropdown-item<?= peak_nav_active('for-school') ?>" href="<?= base_url('for-school') ?>">For Schools</a></li>
            <li><a class="dropdown-item<?= peak_nav_active('for-students') ?>" href="<?= base_url('for-students') ?>">For Students</a></li>
            <li><a class="dropdown-item<?= peak_nav_active('for-corporate') ?>" href="<?= base_url('for-corporate') ?>">For Corporates</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link<?= peak_nav_active('our-story') ?>" href="<?= base_url('our-story') ?>">Our Story</a></li>
        <li class="nav-item"><a class="nav-link<?= peak_nav_active('contact-us') ?>" href="<?= base_url('contact-us') ?>">Contact Us</a></li>
      </ul>
      <a href="<?= peak_enquiry_url() ?>" class="btn btn-book">Book a Discovery Call</a>
    </div>
  </nav>
</header>
