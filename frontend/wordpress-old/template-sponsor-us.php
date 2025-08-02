<!--====Page: Sponsors====
  Page Author: Aiden Johnson | TGM.One
  ====About====-->
<?php
/*
 * Template Name: Sponsor Us
 */
get_header();
?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/sponsors.css">

<div class="sponsors-page">
  <h2 class="section-title">&lt;Sponsor Us/&gt;</h2>
  <section class="sponsors-cont">
    <?php echo do_shortcode('[pdf-embedder url="https://psuccso.org/wp-content/uploads/2024/09/CCSO-Sponsorship-Package.pdf"]'); ?>
    <a href="http://raise.psu.edu/CCSO" target="_blank" class="btn mb-20 btn-warning text-uppercase" style="margin-top: 1em;">Become a Sponsor!</a>
  </section>
</div>

<?php
get_footer();
?>   