<!--====Page: Get Involved====
  Page Author: Aiden Johnson | TGM.One
  ====About====-->
<?php
/*
 * Template Name: Get Involved
 */
get_header();

$calandar = 'https://outlook.office365.com/owa/calendar/cf25a4f7d0204f569b41143580630f05@psu.edu/413a9df4b16a46f58a1788e0389cab3a12905045537426276961/calendar.ics';
$calandar_array = r34ics_get_ics_data(array(
    'limitdays' => 455,
    'pastdays' => 90,
    'url' => $calandar,
  ));

function find_next_event_by_keyword($events, $keyword) {
  $current_date = date('Ymd');
  $next_event = null;

  foreach ($events as $year => $months) {
    foreach ($months as $month => $days) {
      foreach ($days as $day => $times) {
        foreach ($times as $time => $event_array) {
          foreach ($event_array as $event) {
            if (strpos(strtolower($event['label']), strtolower($keyword)) !== false || strpos(strtolower($event['eventdesc']), strtolower($keyword)) !== false) {
              if ($event['dtstart_date'] >= $current_date) {
                if ($next_event === null || $event['dtstart_date'] < $next_event['dtstart_date']) {
                  $next_event = $event;
                }
              }
            }
          }
        }
      }
    }
  }

  return $next_event;
}
function next_event_print( $keyword ) {
  global $calandar_array;
  try {
    $next_event = find_next_event_by_keyword($calandar_array['events'], $keyword);
  } catch (Exception $e) {
    echo "None Scheduled";
  }
  try {
    if ($next_event) {
      echo $next_event['label']." on ".date('F j, Y', strtotime($next_event['dtstart_date']))." at ". date('g:i A', strtotime($next_event['dtstart_time']));
    } else {
      echo "None Scheduled";
    }
  } catch (Exception $e) {
    echo "None Scheduled";
  }
}
?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/involved.css">

<div class="get-involved-page">
  <section class="socials-discord">
    <div class="container">
      <h2 class="section-title">&lt;Discord/&gt;</h2>
      <div class="row discord-cont">
        <a href="https://discord.gg/NhN5RpBXkm/" target="_blank" class="btn discord-btn"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons8-discord.svg" alt="Discord Icon" /></a>
        <p>Discord is a popular communication platform designed for creating communities, offering text, voice, and video chat. The Competitive Cyber Security Organization (CCSO) uses Discord as its primary tool for all communication, allowing members to collaborate, share information, and stay connected effectively in real-time.</p>
      </div>
    </div>
  </section>
  <section class="socials-others">
    <div class="container">
      <h2 class="section-title">&lt;Other Socials/&gt;</h2>
      <div class="row socials-cont">
        <a class="social social-linkedin" href="https://www.linkedin.com/company/ccsopsu/" target="_blank">
          <p>Connect with us on LinkedIn!</p>
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons8-linkedin.png" alt="LinkedIn Icon" />
        </a>    
        <a class="social social-instagram" href="https://www.instagram.com/ccsopsu/" target="_blank">
          <p>Follow us on Instagram!</p>
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons8-instagram.png" alt="Instagram Icon" />
        </a>    
      </div>
    </div>
  </section>
  <section class="calendar">
    <div class="container">
      <h2 class="section-title">&lt;Calendar/&gt;</h2>
      <div class="calendar-cont">
        <div class="calendar-event calendar-event-gbm">
          <p><strong>Next General Body Meeting:</strong> <br><?php next_event_print('GBM');?></p>
        </div>
        <div class="calendar-event calendar-event-social">
          <p><strong>Next Social:</strong> <br><?php next_event_print('Social');?></p>
        </div>
        <div class="calendar-event calendar-event-red">
          <p><strong>Next Red Team Meeting:</strong> <br><?php next_event_print('Red');?></p>
        </div>
        <div class="calendar-event calendar-event-blue">
          <p><strong>Next Blue Team Meeting:</strong> <br><?php next_event_print('Blue');?></p>
        </div>
        <div class="calendar-event calendar-event-comp">
          <p><strong>Next Competition:</strong> <br><?php next_event_print('Competition');?></p>
        </div>
      </div>
    </div>
  </section>
  <!--section class="past-events">
    <div class="container">
      <h2 class="section-title">&lt;Past Events/&gt;</h2>
      <div class="row past-events-cont">
        
      </div>
    </div>
  </section-->
</div>

<?php
get_footer();
?>   