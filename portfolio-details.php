<?php
$projects = require __DIR__ . '/data/projects.php';

$slug = $_GET['project'] ?? '';
if (!is_string($slug) || !array_key_exists($slug, $projects)) {
  http_response_code(404);
  $page_title = 'Project not found - Meet Mehta';
  $body_class = 'portfolio-details-page';
  $is_home    = false;
  $active_nav = 'portfolio';
  include __DIR__ . '/includes/head.php';
  include __DIR__ . '/includes/header.php';
  ?>
  <main class="main">
    <section class="section">
      <div class="container text-center py-5">
        <h2>Project not found</h2>
        <p>That project doesn't exist or may have been moved.</p>
        <a href="index.php#portfolio" class="btn btn-primary">Back to portfolio</a>
      </div>
    </section>
  </main>
  <?php
  include __DIR__ . '/includes/footer.php';
  exit;
}

$p  = $projects[$slug];
$e  = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
$category_labels = ['technology' => 'Technology', 'business' => 'Business', 'education' => 'Education'];

// prev / next
$slugs = array_keys($projects);
$i     = array_search($slug, $slugs, true);
$prev  = $slugs[($i - 1 + count($slugs)) % count($slugs)];
$next  = $slugs[($i + 1) % count($slugs)];

$page_title       = $p['title'] . ' - Meet Mehta';
$meta_description = $p['heading'] ?: ($p['title'] . ' - project by Meet Mehta');
$body_class       = 'portfolio-details-page';
$is_home          = false;
$active_nav       = 'portfolio';

include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';
?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0"><?= $e($p['title']) ?></h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php#portfolio">Portfolio</a></li>
            <li class="current"><?= $e($p['title']) ?></li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Portfolio Details Section -->
    <section id="portfolio-details" class="portfolio-details section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-8">
            <div class="portfolio-details-slider swiper init-swiper">

              <script type="application/json" class="swiper-config">
                {
                  "loop": <?= count($p['images']) > 1 ? 'true' : 'false' ?>,
                  "speed": 600,
                  "autoplay": <?= count($p['images']) > 1 ? '{ "delay": 5000 }' : 'false' ?>,
                  "slidesPerView": "auto",
                  "pagination": {
                    "el": ".swiper-pagination",
                    "type": "bullets",
                    "clickable": true
                  }
                }
              </script>

              <div class="swiper-wrapper align-items-center">
                <?php foreach ($p['images'] as $img): ?>
                <div class="swiper-slide">
                  <img src="<?= $e($img) ?>" alt="<?= $e($p['title']) ?>">
                </div>
                <?php endforeach; ?>
              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="portfolio-info" data-aos="fade-up" data-aos-delay="200">
              <h3>Project information</h3>
              <ul>
                <li><strong>Category</strong>: <?= $e($category_labels[$p['category']] ?? ucfirst($p['category'])) ?></li>
                <?php if ($p['client']): ?><li><strong>Client</strong>: <?= $e($p['client']) ?></li><?php endif; ?>
                <?php if ($p['role']): ?><li><strong>My role</strong>: <?= $e($p['role']) ?></li><?php endif; ?>
                <?php if ($p['date']): ?><li><strong>Project date</strong>: <?= $e($p['date']) ?></li><?php endif; ?>
                <?php if ($p['tech']): ?><li><strong>Technologies</strong>: <?= $e(implode(', ', $p['tech'])) ?></li><?php endif; ?>
                <?php if ($p['url']): ?>
                <li><strong>Project URL</strong>: <a href="<?= $e($p['url']) ?>" target="_blank" rel="noopener"><?= $e(preg_replace('#^https?://(www\.)?#', '', rtrim($p['url'], '/'))) ?></a></li>
                <?php endif; ?>
              </ul>
            </div>
            <div class="portfolio-description" data-aos="fade-up" data-aos-delay="300">
              <?php if ($p['heading']): ?><h2><?= $e($p['heading']) ?></h2><?php endif; ?>

              <?php if ($p['description']): ?>
                <?php foreach ($p['description'] as $para): ?>
                <p><?= $e($para) ?></p>
                <?php endforeach; ?>
              <?php else: ?>
                <p>Project details coming soon.</p>
              <?php endif; ?>

              <?php if ($p['highlights']): ?>
              <ul>
                <?php foreach ($p['highlights'] as $h): ?>
                <li><?= $e($h) ?></li>
                <?php endforeach; ?>
              </ul>
              <?php endif; ?>
            </div>

            <!-- <div class="d-flex justify-content-between mt-4" data-aos="fade-up" data-aos-delay="400">
              <a href="portfolio-details.php?project=<?= $e($prev) ?>"><i class="bi bi-arrow-left"></i> <?= $e($projects[$prev]['title']) ?></a>
              <a href="portfolio-details.php?project=<?= $e($next) ?>"><?= $e($projects[$next]['title']) ?> <i class="bi bi-arrow-right"></i></a>
            </div> -->
          </div>

        </div>

      </div>

    </section><!-- /Portfolio Details Section -->

  </main>

<?php include __DIR__ . '/includes/footer.php'; ?>
