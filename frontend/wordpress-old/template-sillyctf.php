<!--====Page: SillyCTF====
  Page Author: Aiden Johnson | TGM.One
  ====About====-->
<?php
/*
 * Template Name: SillyCTF
 */
get_header();
?>

<script type="text/javascript">
  window.location.href = 'https://sillyctf.psuccso.org';
</script>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/sillyctf.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/sponsors.css">

<div class="sillyctf-page">
  <h2 class="section-title">&lt;SillyCTF/&gt;</h2>
  <section class="sillyctf">
    <div class="sillyctf-cont">
        <h2>Join Us for SillyCTF!</h2>

        <img src="/wp-content/uploads/2024/12/signal-2024-12-08-152743_002.png" alt="Cyber Security Competition" class="image-placeholder">

        <p class="description">Get ready for an exciting Capture The Flag competition hosted by Penn State's Competitive Cyber Security Organization.</p>
        
        <h3>Event Details:</h3>
        <ul>
            <li><strong>Date:</strong> March 29th, 2025</li>
            <li><strong>Location:</strong> Remote</li>
        </ul>

        <p><strong>Check back for sign-up details!</strong></p>

        <h3>Connect with Us:</h3>
        <p>Join our Discord community for updates and discussions:</p>
        <a href="https://discord.gg/sEcYRUTAvj" class="cta-button">Join Discord</a>

        <div class="sponsors-cont">
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

                  if ($tier_name != 'SillyCTF') continue;

                  echo "<div class='tier'><h3>Thank you to our <span style='color:".$tier_color."'>$tier_name</span> Sponsors!</h3>";
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
        </div>
    </div>
  </section>
</div>

<?php
get_footer();
?>   