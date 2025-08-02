<!--====Page: About====
  Page Author: Aiden Johnson | TGM.One
  ====About====-->
<?php
/*
 * Template Name: About Us
 */
get_header();

$args = array(
  'post_type' => 'officers',
  'posts_per_page' => -1,
  'post_status' => 'publish',
  'orderby' => 'menu_order',
  'order' => 'ASC', 
);
$query = new WP_Query($args);

$years = array();

if ($query->have_posts()) {
  while ($query->have_posts()) {
    $query->the_post();

    $post_id = get_the_ID();
    $meta = get_post_meta($post_id);

    $boards = array();

    // Loop through boards
    for ($i = 0; $i < $meta['boards'][0]; $i++) {
      $title = $meta['boards_'.$i.'_title'][0];
      $board_prefix = 'boards_'.$i.'_';

      $officers = array();

      // Loop through officers in the board
      for ($j = 0; $j < $meta[$board_prefix.'officers'][0]; $j++) {
        $officer_prefix = $board_prefix.'officers_'.$j.'_';

        $officers[] = array(
          'name' => $meta[$officer_prefix.'name'][0],
          'position' => $meta[$officer_prefix.'position'][0],
          'img' => wp_get_attachment_url($meta[$officer_prefix.'picture'][0]),
          'url' => $meta[$officer_prefix.'url'][0]
        );
      }

      $boards[] = array(
        'title' => $title,
        'officers' => $officers
      );
    }

    $years[] = array(
      'title' => get_the_title(),
      'boards' => $boards
    );
  }
}
wp_reset_postdata();


echo "<script>var years=".json_encode($years)."</script>"
?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/about.css">

<div class="about-page">
  <section class="home-about">
    <div class="container">
      <div class="row featured-section">
        <h2 class="section-title">&lt;About Us/&gt;</h2>
        <p style="text-align: center">The purpose of the Penn State Competitive Cyber Security Organization is to provide members with an academic outlet to pursue and refine their cyber defense and security skills, collaborate with members of other technology-related clubs, expand their technical acumen, and provide the opportunity to apply such acumen in competitive environments through participation in various cyber security competitions.</p>
      </div>
    </div>
  </section>
  <section class="club-officers">
    <div class="container">
      <div class="row officers">
        <span class="year-selector" id="prev-year"></span>
        <span class="year-selector" id="next-year"></span>
        <h3 id="current_year_title" class="section-title">&lt;Spring 2024/&gt;</h3>
        <div id="boards-container"></div>
      </div>
    </div>
  </section>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/about.js"></script>

<?php
get_footer();
?>   