<!--====Page: Home====
  Page Author: Aiden Johnson | TGM.One
  ====About====-->
<?php
/*
 * Template Name: Home
 */
get_header();
?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/home.css">

<div class="home-page">
  <section class="home-about">
    <div class="container">
      <div class="row top-about">
        <h2 class="section-title">&lt;Competitive Cyber Security Organization/&gt;</h2>
        <div class="col-md-6 col-lg-6 col-xs-12">
          <p>CCSO members gain hands-on experience in offense, defense, physical security, and computer science. Meetings feature interactive challenges like internal competitions, lockpicking workshops, and resume-building events. Members also represent Penn State nationally and globally, consistently earning podium placements at major competitions including CyberForce, CPTC, and CCDC</p>

          <a href="https://discord.gg/NhN5RpBXkm" target="_blank" class="btn discord-btn"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons8-discord.svg" alt="Discord Icon" /> Join Our Discord</a>
        </div>
        <div class="col-md-6 col-lg-6 col-xs-12 featured-image">
          <img src="/wp-content/uploads/2025/07/2025-2026-Exec-Board.jpg" alt="Team.png" />
        </div>
      </div>
    </div>
  </section>
  <section class="what-we-do">
    <div class="container">
      <div class="row what-we-do">
        <h2 class="section-title">&lt;What We Do/&gt;</h2>
        <div class="col-md-6 col-lg-6 col-xs-12 img-container">
          <img src="/wp-content/uploads/2025/08/ccdc_working_2025.jpg" alt="Meeting.png" />
          <img src="/wp-content/uploads/2024/08/IMG_4221.jpg" alt="Team.png" />
        </div>
        <div class="col-md-6 col-lg-6 col-xs-12">
          <div class="dropdown-menus">
            <div class="dropdown-menu-hamburger general-body-meeting active" menu-id="general-body-meeting">
              <h3>General Body Meetings</h3>
              <div class="menu-content">
                <p>Our general body meetings are held every other week on Wednesdays at 6:00 PM in the Cybertorium. We discuss upcoming events, workshops, and competitions. We also have guest speakers from industry and academia.</p>
              </div>
            </div>
            <div class="dropdown-menu-hamburger offense-meeting" menu-id="offense-meeting">
              <h3>Offense Meetings</h3>
              <div class="menu-content">
                <p>Offense meetings focus on developing skills in ethical hacking and penetration testing. These sessions dive into offensive security techniques, preparing members for competitions and real-world scenarios.</p>
              </div>
            </div>
            <div class="dropdown-menu-hamburger defense-meeting" menu-id="defense-meeting">
              <h3>Defense Meetings</h3>
              <div class="menu-content">
                <p>Defense meetings are dedicated to learning and practicing defensive cybersecurity strategies. Members explore topics like network security, incident response, and system hardening to strengthen their defensive capabilities.</p>
              </div>
            </div>
            <div class="dropdown-menu-hamburger workshops" menu-id="workshops">
              <h3>Workshops</h3>
              <div class="menu-content">
                <p>Our workshops provide hands-on learning experiences in various cybersecurity topics. These sessions are designed to enhance technical skills through practical exercises and guided instruction.</p>
              </div>
            </div>
            <div class="dropdown-menu-hamburger education" menu-id="education">
              <h3>Education</h3>
              <div class="menu-content">
                <p>The education track offers structured learning paths in cybersecurity, covering foundational to advanced topics. We provide resources, tutorials, and guided study sessions to help members expand their knowledge.</p>
              </div>
            </div>
            <div class="dropdown-menu-hamburger capture-the-flag" menu-id="capture-the-flag">
              <h3>Capture the Flag</h3>
              <div class="menu-content">
                <p>Capture the Flag (CTF) competitions are a key part of our organization. These events challenge members to solve cybersecurity puzzles and problems, fostering a competitive spirit and sharpening their technical skills.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="home-calandar">
    <?php echo do_shortcode('[ccso_calendar]'); ?>
  </section>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/home.js"></script>

<?php
get_footer();
?>   