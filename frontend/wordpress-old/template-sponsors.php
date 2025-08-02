<!--====Page: Sponsors====
  Page Author: Aiden Johnson | TGM.One
  ====About====-->
<?php
/*
 * Template Name: Sponsors
 */
get_header();
?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/sponsors.css">

<div class="sponsors-page">
  <h2 class="section-title">&lt;Sponsors/&gt;</h2>
  <section class="sponsors-cont">
    <?php
      $args = array(
        'post_type' => 'sponsors',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'menu_order',
        'order' => 'ASC', 
      );
      $query = new WP_Query($args);

      if ($query->have_posts()) {
        while ($query->have_posts()) {
          $query->the_post();
      
          $post_id = get_the_ID();
          $meta = get_post_meta($post_id);

          for ($i = 0; $i < $meta['tiers'][0]; $i++) {
            $tier_prefix = 'tiers_'.$i.'_';
            $tier_name = $meta[$tier_prefix.'tier_name'][0];
            $tier_color = $meta[$tier_prefix.'tier_color'][0];

            echo "<div class='tier'><h2>Thank you to our <span style='color:".$tier_color."'>$tier_name</span> Sponsors!</h2>";
            echo "<div class='tier-sponsors'>";

            for ($j = 0; $j < $meta[$tier_prefix.'sponsors'][0]; $j++) {
              $sponsor_prefix = $tier_prefix.'sponsors_'.$j.'_';

              echo "<a href='".$meta[$sponsor_prefix.'url'][0]."' target='_blank' class='sponsor'>";
              echo "<img src='".wp_get_attachment_url($meta[$sponsor_prefix.'image'][0])."'>";
              echo "<h3>".$meta[$sponsor_prefix.'name'][0]."</h3>";
              echo "</a>";
            }
            echo "</div></div>";
          }
        }
      }
      wp_reset_postdata();
    ?>
  </section>
</div>

<?php
get_footer();
?>   