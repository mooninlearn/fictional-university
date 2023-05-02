<?php get_header(); ?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>)"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">Past Events</h1>
    <div class="page-banner__intro">
    <p>A recap of our past events.</p>
    </div>
  </div>
</div>

<div class="container container--narrow page-section">
<?php
  $today = date('Ymd');
  $pastEvents = new WP_Query(array(
    'paged' => get_query_var('paged', 1),  // pagination의 `next`, `previous` 클릭시 페이지 지정 / url에서 paged를 가져옴, default=1
    'posts_per_page' => 10,  // -1: 전체
    'post_type' => 'event',
    'meta_key' => 'event_date',
    'orderby' => 'meta_value_num',  // 'post_date': 포스트 날짜, 'rand': 랜덤, 'title': 글제목, 'meta_value': 사용자 필드 사용시
    'order' => 'ASC',  // 'DESC' 내림차순, 'ASC' 오름차순
    'meta_query' => array(
      array(
        'key' => 'event_date',
        'compare' => '<',
        'value' => $today,
        'type' => 'numeric'
      )
    )
  ));

  while($pastEvents->have_posts()) {
    $pastEvents->the_post(); ?>
    <div class="event-summary">
      <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
        <span class="event-summary__month"><?php 
          $eventDate = new DateTime(get_field('event_date'));
          echo $eventDate->format('M');
        ?></span>
        <span class="event-summary__day"><?php echo $eventDate->format('d')?></span>
      </a>
    <div class="event-summary__content">
      <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
      <p><?php echo wp_trim_words(get_the_content(), 18); ?><a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
    </div>
    </div>
  <?php }
  echo paginate_links(array(
    'total' => $pastEvents->max_num_pages,
  ));
?>
</div>

<?php get_footer(); ?>