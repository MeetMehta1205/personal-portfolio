<?php
// $is_home = true on index.php (links become in-page anchors); false on other pages.
// $active_nav = which menu item is highlighted (hero, about, resume, portfolio, key-contributions, contact)
$is_home    = $is_home    ?? false;
$active_nav = $active_nav ?? 'hero';
$base       = $is_home ? '' : 'index.php';

$nav = [
  'hero'              => ['bi-house',              'Home'],
  'about'             => ['bi-person',             'About'],
  'skills'            => ['bi-code-slash',         'Skills'],
  'resume'            => ['bi-file-earmark-text',  'Resume'],
  'portfolio'         => ['bi-images',             'Portfolio'],
  'key-contributions' => ['bi-patch-check',        'Key Contributions'],
  'contact'           => ['bi-chat-dots',          'Contact'],
];
?>
  <header id="header" class="header dark-background d-flex flex-column">
    <i class="header-toggle d-xl-none bi bi-list"></i>

    <div class="profile-img">
      <img src="assets/img/profile-img.png" alt="" class="img-fluid rounded-circle">
    </div>

    <a href="index.php" class="logo d-flex align-items-center justify-content-center">
      <h1 class="sitename">Meet Mehta</h1>
    </a>

    <div class="social-links text-center">
      <a href="mailto:meetmehta664@gmail.com" target="_blank" class="email"><i class="bi bi-envelope"></i></a>
      <a href="tel:+917046367782" target="_blank" class="telephone"><i class="bi bi-telephone"></i></a>
      <a href="https://www.linkedin.com/in/meetmehta1205" target="_blank" class="linkedin"><i class="bi bi-linkedin"></i></a>
      <a href="https://www.instagram.com/meetmehta111" target="_blank" class="instagram"><i class="bi bi-instagram"></i></a>
    </div>

    <nav id="navmenu" class="navmenu">
      <ul>
        <?php foreach ($nav as $id => [$icon, $label]): ?>
        <li><a href="<?= $base ?>#<?= $id ?>"<?= $id === $active_nav ? ' class="active"' : '' ?>><i class="bi <?= $icon ?> navicon"></i> <?= $label ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>

  </header>
