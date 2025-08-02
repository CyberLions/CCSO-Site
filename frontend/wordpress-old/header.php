<?php
   /**
    * The header for our theme
    *
    * This is the template that displays all of the <head> section and everything up until <div id="content">
    *
    * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
    *
    * @package _s
    */
   
   ?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
   <!--====Header====
      Site Author: Aiden Johnson | TGM.One
      Site URL: https://psuccso.org/
      Site Hosted and Maintained by: TGM.One
      ====Header====-->
   <head>
      <meta charset="<?php bloginfo( 'charset' ); ?>">
      <meta name="viewport" content="width=device-width, initial-scale = 1.0,maximum-scale=1.0, user-scalable=no" />
      <link rel="profile" href="http://gmpg.org/xfn/11">
      <?php wp_head(); ?>
   <body <?php body_class(); ?>>
      <div class="full-page-background">
      <header class="header">
         <!--=================== Header Top Section ===================-->
         <section class="header-top full-width">
            <div class="container">
               <div class="row">
                  <!--=================== logo ===================-->
                  <div class="col-md-3 col-sm-4 col-xs-5 logo">
                     <a href="
                        <?php echo esc_url( home_url( '/' ) ); ?>">
                     <img src="
                        <?php echo get_template_directory_uri() ?>/assets/images/PSU-CCSO-PRIMARY-notext.png" alt="CCSO at Penn State" class="img-responsive">
                     </a>
                  </div>
                  <!--=================== Main Menu ===================-->
                  <div class="col-md-12 col-sm-12 col-xs-12 mega-menu clearfix">
                     <nav class="navbar navbar-default margin-clear pull-right">
                        <div class="navbar-header">
                           <button type="button" data-toggle="collapse" data-target="#navbar-collapse" class="navbar-toggle">
                           <span class="icon-bar"></span>
                           <span class="icon-bar"></span>
                           <span class="icon-bar"></span>
                           </button>
                        </div>
                        <div id="navbar-collapse" class="navbar-collapse collapse text-capitalize"> <?php wp_nav_menu(
                           array( 'theme_location' => 'primary',
                           'depth'             => 3,
                           'items_wrap' => '
                           <ul id="%1$s" class="%2$s nav navbar-nav">%3$s</ul>',
                           'container'  => '','fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                           'walker' => new wp_bootstrap_navwalker() ) );
                               ?> </div>
                     </nav>
                  </div>
               </div>
            </div>
         </section>
         <script>
            //Check if header is pinned 
            const el = document.querySelector(".header");
            var cooldown = Date.now();
            const observer = new IntersectionObserver( 
                ([e]) => {
                    if (Date.now() - cooldown < 100) return;
                    e.target.classList.toggle("is-pinned", e.intersectionRatio < 1); 
                    if (document.querySelector(".page-header-title")) document.querySelector(".page-header-title").classList.toggle("is-pinned", e.intersectionRatio < 1);
                    cooldown = Date.now();
                },
                { threshold: [1] }
            );
            
            observer.observe(el);
         </script>
      </header>
      <div id="content" class="site-content">
            