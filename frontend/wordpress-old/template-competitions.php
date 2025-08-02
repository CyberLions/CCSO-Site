<!--====Page: Competitions====
  Page Author: Aiden Johnson | TGM.One
  ====About====-->
<?php
/*
 * Template Name: Competitions
 */
get_header();

$args = array(
  'post_type' => 'competitions',
  'posts_per_page' => -1,
  'post_status' => 'publish',
  'orderby' => 'menu_order',
  'order' => 'ASC', 
);
$query = new WP_Query($args);
?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/competitions.css">

<div class="competitions-page">
  <?php
    $years = array();

    if ($query->have_posts()) {
      while ($query->have_posts()) {
        $query->the_post();
        $meta = get_post_meta(get_the_ID());

        if (!isset($years[$meta['year'][0]])) {
          $years[$meta['year'][0]] = array();
        }

        $years[$meta['year'][0]][] = array(
          'title' => get_the_title(),
          'placing' => $meta['placing'][0],
          'excerpt' => $meta['article_excerpt'][0],
          'url' => $meta['article_url'][0],
          'members' => $meta['members_members'][0],
          'picture' => wp_get_attachment_url($meta['members_picture'][0])
        );
      }
    }
    wp_reset_postdata();

    foreach ($years as $year => $competitions) {
      ?>
      <section class="year">
        <h2 class="section-title">&lt;<?php echo $year; ?>/&gt;</h2>
        <div class="year-cont">
          <?php
            foreach ($competitions as $competition) {
              ?>
              <div class="competition">
                <div class="competition-details">
                  <h2><?php echo $competition['title']; ?> - </h2>
                  <h2 class="placing"><?php echo $competition['placing']; ?></h2>
                  <a href="<?php echo $competition['url']; ?>" class="excerpt"><?php echo $competition['excerpt']; ?></a>
                  <p class="members">Members: <?php echo $competition['members']; ?></p>
                </div>
                <div class="members-img">
                  <img src="<?php echo $competition['picture']; ?>" alt="Members" class="img-responsive">
            </div>
              </div>
              <?php
            }
          ?>
        </div>
      </section>
      <?php
    }
  ?>
</div>

<?php
get_footer();
?>   