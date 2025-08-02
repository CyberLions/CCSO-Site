<?php

/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package CCSO
 */

?>
</div>
   <!--====Footer====
      Site Author: Aiden Johnson | TGM.One
      Site URL: https://psuccso.org/
      Site Hosted and Maintained by: TGM.One
      ====Footer====-->
<footer class="footer">
    <section class="bottom-footer padding-bottom-3">
        <div class="container">
            <div class="row pr-40 pl-40 footer-cont">
                <div class="col-md-3 col-sm-6 col-xs-12 footer-contact">
                    <img class="f-logo" src="<?php echo get_template_directory_uri() ?>/assets/images/ccso_logo.png">
                    <div class="textwidget">
                        <li>
                            <p>288 N. Burrowes Rd.<br>
                            State College, PA 16802</p>
                        </li>
                        <li>
                            <p style='margin-top: 5px;'>
                                <a href="tel:8148658947">
                                    <i class="fa fa-phone text-color-3"></i>
                                    (814) 865-8947
                                </a>
                            </p>
                        </li>
                        <li>
                            <p style='margin-top: 5px;' class="text-lowercase">
                                <a href="mailto:ccso@psu.edu"><i class="fa fa-envelope text-color-3"></i> ccso@psu.edu</a>
                            </p>
                        </li>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12 footer-nav">
                    <div class="textwidget">
                        <p class="footer-nav-title">Resources:</p>
                        <li id="menu-item-48455" class="footer-nav-item">
                            <a title="Sponsors" href="/sponsors">Sponsors</a></li>
	                    <li id="menu-item-48451" class="footer-nav-item">
                            <a title="Sponsor Us" target="_blank" href="/sponsor-us">Sponsor Us</a></li>
	                    <li id="menu-item-48454" class="footer-nav-item">
                            <a title="Competitions" href="/comp">Competitions</a></li>
	                    <li id="menu-item-48453" class="footer-nav-item">
                            <a title="Helpful Sites" target="_blank" href="https://psuccso.org/resources/#113">Helpful Sites</a></li>
	                    <li id="menu-item-48452" class="footer-nav-item">
                            <a title="CPTC Guide" target="_blank" href="https://psuccso.org/resources/#115">CPTC Guide</a></li>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12 footer-social ">
                    <div class="textwidget">
                        <li>
                            <a href="/get-involved" class="btn mb-20 btn-warning text-uppercase">Attend a GBM</a>
                        </li>
                        <li>
                            <a href="https://discord.gg/NhN5RpBXkm" target="_blank" class="btn btn-social-icon btn-discord">
                                <span class="fa-brands fa-discord"></span>
                            </a>
                            <a href="https://www.linkedin.com/company/ccsopsu/" target="_blank" class="btn btn-social-icon btn-linkedin">
                                <span class="fa fa-linkedin"></span>
                            </a>
                            <a href="https://github.com/CyberLions" target="_blank" class="btn btn-social-icon btn-github">
                                <span class="fa fa-github"></span>
                            </a>
                            <a href="https://www.instagram.com/ccsopsu/" target="_blank" class="btn btn-social-icon btn-instagram">
                                <span class="fa fa-instagram"></span>
                            </a>
                        </li>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
            <p class="text-color-1">Copyright © CCSO <?php echo date('Y'); ?> - All rights reserved</p>
            <p class="text-color-1 credit">Concept by UXPA | Designed & Developed by <a href="https://www.linkedin.com/in/aiden-johnson-cs/" target="_blank">Aiden Johnson</a></p>
        </div>
    </section>
</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>