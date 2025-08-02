<!--====Page: Resources====
  Page Author: Aiden Johnson | TGM.One
  ====About====-->
<?php
/*
 * Template Name: Resources
 */
get_header();

$args = array(
  'post_type' => 'resources',
  'posts_per_page' => -1,
  'post_status' => 'publish',
  'orderby' => 'menu_order',
  'order' => 'ASC', 
);
$query = new WP_Query($args);
?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/resources.css">

<div class="resources-page">
  <h2 class="section-title">&lt;Resources/&gt;</h2>
  <section class="resources">
    <div class="resources-cont">
      <?php
        if ($query->have_posts()) {
          while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div class="resource" id="<?php echo get_the_ID()?>">
              <h3><?php the_title(); ?></h3>
              <div><?php the_content(); ?></div>
            </div>
            <?php
          }
        }
        wp_reset_postdata();
      ?>
    </div>
  </section>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/resources.js"></script>

<?php
get_footer();
?>   