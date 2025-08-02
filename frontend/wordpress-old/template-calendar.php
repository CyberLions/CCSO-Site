<!--====Page: Calendar====
  Page Author: Aiden Johnson | TGM.One
  ====About====-->
<?php
/*
 * Template Name: Calendar
 */
get_header();
?>

<div class="calandar-page">
  <h2 class="section-title">&lt;Calendar/&gt;</h2>
  <section class="calandar">
    <?php echo do_shortcode('[ccso_calendar]'); ?>
  </section>
</div>

<?php
get_footer();
?>   