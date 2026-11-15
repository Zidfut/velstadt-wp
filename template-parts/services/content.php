<?php
/**
 * Static Services page content copied from the original markup.
 *
 * The sections are intentionally isolated here so they can be migrated to
 * SCF one by one without changing the page template.
 *
 * @package Velstadt
 */

$images_uri = get_template_directory_uri() . '/markup/images';
$page_id    = get_queried_object_id();
$has_scf    = function_exists( 'get_field' );

$hero_show        = $has_scf ? (bool) get_field( 'services_hero_show', $page_id ) : true;
$hero_eyebrow     = velstadt_get_services_field( 'services_hero_eyebrow', 'Offensive security services', $page_id );
$hero_title       = velstadt_get_services_field( 'services_hero_title', 'Find the paths attackers would take-before they do', $page_id );
$hero_description = velstadt_get_services_field( 'services_hero_description', 'Expert-led penetration testing combines real-world attack techniques, threat intelligence, and manual validation to expose exploitable risk and give your team a clear remediation path.', $page_id );
$expert_value     = velstadt_get_services_field( 'services_hero_expert_link', velstadt_header_default_link( 'Talk to an expert' ), $page_id );
$demo_value       = velstadt_get_services_field( 'services_hero_demo_link', velstadt_header_default_link( 'Request a demo' ), $page_id );
$hero_image       = velstadt_get_services_field( 'services_hero_image', null, $page_id );
$expert_link      = $expert_value ? velstadt_normalize_header_link( $expert_value, __( 'Talk to an expert', 'velstadt' ) ) : null;
$demo_link        = $demo_value ? velstadt_normalize_header_link( $demo_value, __( 'Request a demo', 'velstadt' ) ) : null;
$hero_image_url   = velstadt_header_image_url( $hero_image );
$hero_image_alt   = is_array( $hero_image ) && ! empty( $hero_image['alt'] ) ? $hero_image['alt'] : $hero_eyebrow;

$about_show        = $has_scf ? (bool) get_field( 'services_about_show', $page_id ) : true;
$about_eyebrow     = velstadt_get_services_field( 'services_about_eyebrow', 'Security tested in practice', $page_id );
$about_title       = velstadt_get_services_field( 'services_about_title', 'Know what attackers can actually exploit', $page_id );
$about_description = velstadt_get_services_field( 'services_about_description', 'Velstadt validates real attack paths, connects technical findings to business impact, and helps your team focus remediation where it reduces risk fastest', $page_id );
$about_cards       = velstadt_get_services_field( 'services_about_cards', array(), $page_id );
$about_cards       = is_array( $about_cards ) ? $about_cards : array();

$challenge_show        = $has_scf ? (bool) get_field( 'services_challenge_show', $page_id ) : true;
$challenge_eyebrow     = velstadt_get_services_field( 'services_challenge_eyebrow', 'The challenge', $page_id );
$challenge_title       = velstadt_get_services_field( 'services_challenge_title', 'Risk hides between individual findings', $page_id );
$challenge_description = velstadt_get_services_field( 'services_challenge_description', 'Modern attacks rarely depend on a single critical vulnerability. They exploit combinations of weaknesses, assumptions, and control gaps.', $page_id );
$challenge_items       = velstadt_get_services_field( 'services_challenge_items', array(), $page_id );
$challenge_items       = is_array( $challenge_items ) ? $challenge_items : array();
$challenge_image       = velstadt_get_services_field( 'services_challenge_image', null, $page_id );
$challenge_image_url   = velstadt_header_image_url( $challenge_image );
$challenge_image_alt   = is_array( $challenge_image ) && ! empty( $challenge_image['alt'] ) ? $challenge_image['alt'] : $challenge_title;

$testing_show                = $has_scf ? (bool) get_field( 'services_testing_show', $page_id ) : true;
$testing_eyebrow             = velstadt_get_services_field( 'services_testing_eyebrow', 'What’s included', $page_id );
$testing_title               = velstadt_get_services_field( 'services_testing_title', 'Testing designed around your environment.', $page_id );
$testing_description         = velstadt_get_services_field( 'services_testing_description', 'Choose a focused assessment or combine multiple surfaces into one coordinated engagement.', $page_id );
$testing_feature_subtitle    = velstadt_get_services_field( 'services_testing_feature_subtitle', 'OWASP-aligned manual testing', $page_id );
$testing_feature_title       = velstadt_get_services_field( 'services_testing_feature_title', 'Web applications & APIs', $page_id );
$testing_feature_description = velstadt_get_services_field( 'services_testing_feature_description', 'Test authentication, authorization, business logic, sessions, data exposure, and application-specific attack paths.', $page_id );
$testing_cards               = velstadt_get_services_field( 'services_testing_cards', array(), $page_id );
$testing_cards               = is_array( $testing_cards ) ? $testing_cards : array();

$outcomes_show        = $has_scf ? (bool) get_field( 'services_outcomes_show', $page_id ) : true;
$outcomes_eyebrow     = velstadt_get_services_field( 'services_outcomes_eyebrow', 'Business outcomes', $page_id );
$outcomes_title       = velstadt_get_services_field( 'services_outcomes_title', 'Close the gaps that matter most', $page_id );
$outcomes_description = velstadt_get_services_field( 'services_outcomes_description', 'Translate offensive-security evidence into confident decisions across security, engineering, risk, and leadership.', $page_id );
$outcome_cards        = velstadt_get_services_field( 'services_outcomes_cards', array(), $page_id );
$outcome_cards        = is_array( $outcome_cards ) ? $outcome_cards : array();

$deliverables_show        = $has_scf ? (bool) get_field( 'services_deliverables_show', $page_id ) : true;
$deliverables_eyebrow     = velstadt_get_services_field( 'services_deliverables_eyebrow', 'Deliverables', $page_id );
$deliverables_title       = velstadt_get_services_field( 'services_deliverables_title', 'Evidence for engineers. Clarity for leadership', $page_id );
$deliverables_description = velstadt_get_services_field( 'services_deliverables_description', 'Every engagement ends with a practical decision package—not a generic scan export.', $page_id );
$deliverables             = velstadt_get_services_field( 'services_deliverables_items', array(), $page_id );
$deliverables             = is_array( $deliverables ) ? $deliverables : array();
$deliverables_image       = velstadt_get_services_field( 'services_deliverables_image', null, $page_id );
$deliverables_image_url   = velstadt_header_image_url( $deliverables_image );
$deliverables_image_alt   = is_array( $deliverables_image ) && ! empty( $deliverables_image['alt'] ) ? $deliverables_image['alt'] : $deliverables_title;

$standards_show        = $has_scf ? (bool) get_field( 'services_standards_show', $page_id ) : true;
$standards_eyebrow     = velstadt_get_services_field( 'services_standards_eyebrow', 'Standards & frameworks', $page_id );
$standards_title       = velstadt_get_services_field( 'services_standards_title', 'Aligned with recognized testing practices', $page_id );
$standards_description = velstadt_get_services_field( 'services_standards_description', 'Engagements can be mapped to the frameworks and compliance obligations relevant to your organization.', $page_id );
$standards             = velstadt_get_services_field( 'services_standards_items', array(), $page_id );
$standards             = is_array( $standards ) ? $standards : array();

$methodology_show        = $has_scf ? (bool) get_field( 'services_methodology_show', $page_id ) : true;
$methodology_eyebrow     = velstadt_get_services_field( 'services_methodology_eyebrow', 'Methodology', $page_id );
$methodology_title       = velstadt_get_services_field( 'services_methodology_title', 'Controlled, transparent, and built for action', $page_id );
$methodology_description = velstadt_get_services_field( 'services_methodology_description', 'A repeatable engagement model keeps testing safe, evidence clear, and remediation connected to the original risk.', $page_id );
$methodology             = velstadt_get_services_field( 'services_methodology_items', array(), $page_id );
$methodology             = is_array( $methodology ) ? $methodology : array();

$resources_show        = $has_scf ? (bool) get_field( 'services_resources_show', $page_id ) : true;
$resources_eyebrow     = velstadt_get_services_field( 'services_resources_eyebrow', 'Reports and Research', $page_id );
$resources_title       = velstadt_get_services_field( 'services_resources_title', 'Intelligence for your next decision', $page_id );
$resources_description = velstadt_get_services_field( 'services_resources_description', 'Proprietary intelligence for security leaders, technical teams, and executives—based on what Velstadt observes in real-world operations.', $page_id );
$resources             = velstadt_get_services_field( 'services_resources_items', array(), $page_id );
$resources             = is_array( $resources ) ? $resources : array();

$customer_show        = $has_scf ? (bool) get_field( 'services_customer_show', $page_id ) : true;
$customer_eyebrow     = velstadt_get_services_field( 'services_customer_eyebrow', 'Customer Stories', $page_id );
$customer_title       = velstadt_get_services_field( 'services_customer_title', 'From signal to measurable impact', $page_id );
$customer_archive_raw = velstadt_get_services_field( 'services_customer_archive_link', velstadt_header_default_link( 'View customer stories' ), $page_id );
$customer_archive     = $customer_archive_raw ? velstadt_normalize_header_link( $customer_archive_raw, __( 'View customer stories', 'velstadt' ) ) : null;
$stories              = velstadt_get_services_field( 'services_customer_items', array(), $page_id );
$stories              = is_array( $stories ) ? $stories : array();

$faq_show        = $has_scf ? (bool) get_field( 'services_faq_show', $page_id ) : true;
$faq_eyebrow     = velstadt_get_services_field( 'services_faq_eyebrow', 'FAQ', $page_id );
$faq_title       = velstadt_get_services_field( 'services_faq_title', 'What security teams ask before testing begins', $page_id );
$faq_description = velstadt_get_services_field( 'services_faq_description', 'Need to discuss a specific environment or deadline? Talk directly with a Velstadt specialist.', $page_id );
$faq_link_raw    = velstadt_get_services_field( 'services_faq_link', velstadt_header_default_link( 'Ask a question' ), $page_id );
$faq_link        = $faq_link_raw ? velstadt_normalize_header_link( $faq_link_raw, __( 'Ask a question', 'velstadt' ) ) : null;
$faq_items       = velstadt_get_services_field( 'services_faq_items', array(), $page_id );
$faq_items       = is_array( $faq_items ) ? $faq_items : array();

$cta_show           = $has_scf ? (bool) get_field( 'services_cta_show', $page_id ) : true;
$cta_eyebrow        = velstadt_get_services_field( 'services_cta_eyebrow', 'Request a proposal', $page_id );
$cta_title          = velstadt_get_services_field( 'services_cta_title', 'Test what matters before attackers do', $page_id );
$cta_description    = velstadt_get_services_field( 'services_cta_description', 'Tell us what you need to assess. A Velstadt specialist will help define the right scope, timeline, and deliverables.', $page_id );
$cta_primary_raw    = velstadt_get_services_field( 'services_cta_primary_link', velstadt_header_default_link( 'Request a demo' ), $page_id );
$cta_secondary_raw  = velstadt_get_services_field( 'services_cta_secondary_link', velstadt_header_default_link( 'Talk to an expert' ), $page_id );
$cta_primary_link   = $cta_primary_raw ? velstadt_normalize_header_link( $cta_primary_raw, __( 'Request a demo', 'velstadt' ) ) : null;
$cta_secondary_link = $cta_secondary_raw ? velstadt_normalize_header_link( $cta_secondary_raw, __( 'Talk to an expert', 'velstadt' ) ) : null;
?>

<main class="services-page">
	<?php if ( $hero_show ) : ?>
	<section class="section hero__services">
		<div class="header__duplicate header__duplicate--dark"><div class="container header__duplicate-container section__lines"></div></div>
		<div class="container hero__services-container section__lines">
			<div class="hero__services-left section__header">
				<div>
					<?php if ( $hero_eyebrow ) : ?><h2 class="h3 section__subtitle"><?php echo esc_html( $hero_eyebrow ); ?></h2><?php endif; ?>
					<?php if ( $hero_title ) : ?><h1 class="h2 section__title"><?php echo esc_html( $hero_title ); ?></h1><?php endif; ?>
				</div>
				<?php if ( $hero_description ) : ?><p><?php echo esc_html( $hero_description ); ?></p><?php endif; ?>
				<?php if ( $expert_link || $demo_link ) : ?><div class="hero__services-buttons">
					<?php if ( $expert_link ) : ?><a href="<?php echo esc_url( $expert_link['url'] ); ?>" class="btn btn--lg"<?php if ( $expert_link['target'] ) : ?> target="<?php echo esc_attr( $expert_link['target'] ); ?>" rel="noopener noreferrer"<?php endif; ?>><?php echo esc_html( $expert_link['title'] ); ?></a><?php endif; ?>
					<?php if ( $demo_link ) : ?><a href="<?php echo esc_url( $demo_link['url'] ); ?>" class="btn btn--lg btn--primary"<?php if ( $demo_link['target'] ) : ?> target="<?php echo esc_attr( $demo_link['target'] ); ?>" rel="noopener noreferrer"<?php endif; ?>><?php echo esc_html( $demo_link['title'] ); ?></a><?php endif; ?>
				</div><?php endif; ?>
			</div>
			<?php if ( $hero_image_url ) : ?><div class="hero__services-right"><div class="hero__services-preview"><img src="<?php echo esc_url( $hero_image_url ); ?>" alt="<?php echo esc_attr( $hero_image_alt ); ?>" /></div></div><?php endif; ?>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $about_show ) : ?>
	<section class="section about">
		<div class="section__header"><div class="container section__header-container section__lines">
			<div class="section__header-left"><?php if ( $about_eyebrow ) : ?><h3 class="h3 section__subtitle"><?php echo esc_html( $about_eyebrow ); ?></h3><?php endif; ?><?php if ( $about_title ) : ?><h2 class="h2 section__title"><?php echo esc_html( $about_title ); ?></h2><?php endif; ?></div>
			<?php if ( $about_description ) : ?><div class="section__header-right"><p><?php echo esc_html( $about_description ); ?></p></div><?php endif; ?>
		</div></div>
		<?php if ( $about_cards ) : ?><div class="container about__container section__lines">
			<?php foreach ( $about_cards as $card ) : ?>
				<?php $icon_url = velstadt_header_image_url( isset( $card['icon'] ) ? $card['icon'] : null ); ?>
				<div class="about__card"><?php if ( $icon_url ) : ?><span class="about__card-icon" style="background-image: url('<?php echo esc_url( $icon_url ); ?>');"></span><?php endif; ?><?php if ( ! empty( $card['title'] ) ) : ?><h3 class="h3 about__card-title"><?php echo esc_html( $card['title'] ); ?></h3><?php endif; ?><?php if ( ! empty( $card['description'] ) ) : ?><p class="about__card-description"><?php echo esc_html( $card['description'] ); ?></p><?php endif; ?></div>
			<?php endforeach; ?>
		</div><?php endif; ?>
	</section>
	<?php endif; ?>

	<?php if ( $challenge_show ) : ?>
	<section class="section challenge">
		<div class="section__header"><div class="container section__header-container section__lines">
			<div class="section__header-left"><?php if ( $challenge_eyebrow ) : ?><h3 class="h3 section__subtitle"><?php echo esc_html( $challenge_eyebrow ); ?></h3><?php endif; ?><?php if ( $challenge_title ) : ?><h2 class="h2 section__title"><?php echo esc_html( $challenge_title ); ?></h2><?php endif; ?></div>
			<?php if ( $challenge_description ) : ?><div class="section__header-right"><p><?php echo esc_html( $challenge_description ); ?></p></div><?php endif; ?>
		</div></div>
		<div class="container challenge__container section__lines">
			<div class="challenge__list">
				<?php foreach ( $challenge_items as $item ) : ?>
					<div class="challenge__item"><div class="challenge__header"><span class="challenge__number"></span><h3 class="h3 challenge__title"><?php echo esc_html( $item['title'] ); ?></h3></div><div class="challenge__content"><p><?php echo esc_html( $item['description'] ); ?></p></div></div>
				<?php endforeach; ?>
			</div>
			<?php if ( $challenge_image_url ) : ?><div class="challenge__preview"><div class="challenge__preview-img"><img src="<?php echo esc_url( $challenge_image_url ); ?>" alt="<?php echo esc_attr( $challenge_image_alt ); ?>" /></div></div><?php endif; ?>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $testing_show ) : ?>
	<section class="section testing">
		<div class="section__header"><div class="container section__header-container section__lines">
			<div class="section__header-left"><?php if ( $testing_eyebrow ) : ?><h3 class="h3 section__subtitle"><?php echo esc_html( $testing_eyebrow ); ?></h3><?php endif; ?><?php if ( $testing_title ) : ?><h2 class="h2 section__title"><?php echo esc_html( $testing_title ); ?></h2><?php endif; ?></div>
			<?php if ( $testing_description ) : ?><div class="section__header-right"><p><?php echo esc_html( $testing_description ); ?></p></div><?php endif; ?>
		</div></div>
		<div class="container testing__container section__lines">
			<?php if ( $testing_feature_subtitle || $testing_feature_title || $testing_feature_description ) : ?><div class="testing__main"><div class="testing__preview"><?php if ( $testing_feature_subtitle ) : ?><span class="testing__preview-subtitle"><?php echo esc_html( $testing_feature_subtitle ); ?></span><?php endif; ?><?php if ( $testing_feature_title ) : ?><h3 class="h3 testing__preview-title"><?php echo esc_html( $testing_feature_title ); ?></h3><?php endif; ?><?php if ( $testing_feature_description ) : ?><p class="testing__preview-description"><?php echo esc_html( $testing_feature_description ); ?></p><?php endif; ?></div></div><?php endif; ?>
			<?php if ( $testing_cards ) : ?><div class="testing__grid">
				<?php foreach ( $testing_cards as $card ) : ?>
					<div class="testing__card"><?php if ( ! empty( $card['subtitle'] ) ) : ?><span class="testing__card-subtitle"><?php echo esc_html( $card['subtitle'] ); ?></span><?php endif; ?><?php if ( ! empty( $card['title'] ) ) : ?><h3 class="h3 testing__card-title"><?php echo esc_html( $card['title'] ); ?></h3><?php endif; ?><?php if ( ! empty( $card['description'] ) ) : ?><p class="testing__card-description"><?php echo esc_html( $card['description'] ); ?></p><?php endif; ?></div>
				<?php endforeach; ?>
			</div><?php endif; ?>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $outcomes_show ) : ?>
	<section class="section about">
		<div class="section__header"><div class="container section__header-container section__lines">
			<div class="section__header-left"><?php if ( $outcomes_eyebrow ) : ?><h3 class="h3 section__subtitle"><?php echo esc_html( $outcomes_eyebrow ); ?></h3><?php endif; ?><?php if ( $outcomes_title ) : ?><h2 class="h2 section__title"><?php echo esc_html( $outcomes_title ); ?></h2><?php endif; ?></div>
			<?php if ( $outcomes_description ) : ?><div class="section__header-right"><p><?php echo esc_html( $outcomes_description ); ?></p></div><?php endif; ?>
		</div></div>
		<?php if ( $outcome_cards ) : ?><div class="container about__container about__container-transparent section__lines">
			<?php foreach ( $outcome_cards as $card ) : ?>
				<?php $icon_url = velstadt_header_image_url( isset( $card['icon'] ) ? $card['icon'] : null ); ?>
				<div class="about__card"><?php if ( $icon_url ) : ?><span class="about__card-icon" style="background-image: url('<?php echo esc_url( $icon_url ); ?>');"></span><?php endif; ?><?php if ( ! empty( $card['title'] ) ) : ?><h3 class="h3 about__card-title"><?php echo esc_html( $card['title'] ); ?></h3><?php endif; ?><?php if ( ! empty( $card['description'] ) ) : ?><p class="about__card-description"><?php echo esc_html( $card['description'] ); ?></p><?php endif; ?></div>
			<?php endforeach; ?>
		</div><?php endif; ?>
	</section>
	<?php endif; ?>

	<?php if ( $deliverables_show ) : ?>
	<section class="section media">
		<div class="section__header"><div class="container section__header-container section__lines">
			<div class="section__header-left"><?php if ( $deliverables_eyebrow ) : ?><h3 class="h3 section__subtitle"><?php echo esc_html( $deliverables_eyebrow ); ?></h3><?php endif; ?><?php if ( $deliverables_title ) : ?><h2 class="h2 section__title"><?php echo esc_html( $deliverables_title ); ?></h2><?php endif; ?></div>
			<?php if ( $deliverables_description ) : ?><div class="section__header-right"><p><?php echo esc_html( $deliverables_description ); ?></p></div><?php endif; ?>
		</div></div>
		<div class="container media__container section__lines"><?php if ( $deliverables ) : ?><div class="media__left"><ul><?php foreach ( $deliverables as $item ) : ?><?php if ( ! empty( $item['label'] ) ) : ?><li><?php echo esc_html( $item['label'] ); ?></li><?php endif; ?><?php endforeach; ?></ul></div><?php endif; ?><?php if ( $deliverables_image_url ) : ?><div class="media__right"><img src="<?php echo esc_url( $deliverables_image_url ); ?>" alt="<?php echo esc_attr( $deliverables_image_alt ); ?>" /></div><?php endif; ?></div>
	</section>
	<?php endif; ?>

	<?php if ( $standards_show ) : ?>
	<section class="section expertise">
		<div class="section__header"><div class="container section__header-container section__lines">
			<div class="section__header-left"><?php if ( $standards_eyebrow ) : ?><h3 class="h3 section__subtitle"><?php echo esc_html( $standards_eyebrow ); ?></h3><?php endif; ?><?php if ( $standards_title ) : ?><h2 class="h2 section__title"><?php echo esc_html( $standards_title ); ?></h2><?php endif; ?><?php if ( $standards_description ) : ?><p><?php echo esc_html( $standards_description ); ?></p><?php endif; ?></div>
			<div class="section__header-right">
				<?php foreach ( $standards as $standard ) : ?><div class="expertise__card"><?php if ( ! empty( $standard['title'] ) ) : ?><h3 class="h3 expertise__card-title"><?php echo esc_html( $standard['title'] ); ?></h3><?php endif; ?><?php if ( ! empty( $standard['description'] ) ) : ?><span class="expertise__card-description"><?php echo esc_html( $standard['description'] ); ?></span><?php endif; ?></div><?php endforeach; ?>
			</div>
		</div></div>
	</section>
	<?php endif; ?>

	<?php if ( $methodology_show ) : ?>
	<section class="section timeline">
		<div class="section__header"><div class="container section__header-container section__lines">
			<div class="section__header-left"><?php if ( $methodology_eyebrow ) : ?><h3 class="h3 section__subtitle"><?php echo esc_html( $methodology_eyebrow ); ?></h3><?php endif; ?><?php if ( $methodology_title ) : ?><h2 class="h2 section__title"><?php echo esc_html( $methodology_title ); ?></h2><?php endif; ?></div>
			<?php if ( $methodology_description ) : ?><div class="section__header-right"><p><?php echo esc_html( $methodology_description ); ?></p></div><?php endif; ?>
		</div></div>
		<div class="container timeline__container section__lines"><div class="timeline__swiper swiper"><div class="swiper-wrapper">
			<?php foreach ( $methodology as $item ) : ?>
				<?php $icon_url = velstadt_header_image_url( isset( $item['icon'] ) ? $item['icon'] : null ); ?>
				<div class="timeline__card swiper-slide"><div class="timeline__card-header"><span class="timeline__card-number"></span></div><div class="timeline__card-content"><div class="timeline__card-top"><?php if ( ! empty( $item['step_label'] ) ) : ?><span class="timeline__card-step"><?php echo esc_html( $item['step_label'] ); ?></span><?php endif; ?><?php if ( $icon_url ) : ?><span class="timeline__card-icon" style="background-image: url('<?php echo esc_url( $icon_url ); ?>');"></span><?php endif; ?></div><div class="timeline__card-details"><?php if ( ! empty( $item['title'] ) ) : ?><h3 class="h3 timeline__card-title"><?php echo esc_html( $item['title'] ); ?></h3><?php endif; ?><?php if ( ! empty( $item['description'] ) ) : ?><p><?php echo esc_html( $item['description'] ); ?></p><?php endif; ?></div></div></div>
			<?php endforeach; ?>
		</div></div></div>
	</section>
	<?php endif; ?>

	<?php if ( $resources_show ) : ?>
	<section class="section resources">
		<div class="section__header"><div class="container section__header-container section__lines">
			<div class="section__header-left"><?php if ( $resources_eyebrow ) : ?><h3 class="h3 section__subtitle"><?php echo esc_html( $resources_eyebrow ); ?></h3><?php endif; ?><?php if ( $resources_title ) : ?><h2 class="h2 section__title"><?php echo esc_html( $resources_title ); ?></h2><?php endif; ?></div>
			<?php if ( $resources_description ) : ?><div class="section__header-right"><p><?php echo esc_html( $resources_description ); ?></p></div><?php endif; ?>
		</div></div>
		<div class="container section__lines swiper resources__swiper"><div class="swiper-wrapper">
			<?php foreach ( $resources as $resource ) : ?>
				<?php
				$image     = isset( $resource['image'] ) ? $resource['image'] : null;
				$image_url = velstadt_header_image_url( $image );
				$image_alt = is_array( $image ) && ! empty( $image['alt'] ) ? $image['alt'] : ( $resource['title'] ?? '' );
				$link      = ! empty( $resource['link'] ) ? velstadt_normalize_header_link( $resource['link'] ) : null;
				?>
				<div class="resources__card swiper-slide"><?php if ( $link ) : ?><a href="<?php echo esc_url( $link['url'] ); ?>" class="resources__card-preview"<?php if ( $link['target'] ) : ?> target="<?php echo esc_attr( $link['target'] ); ?>" rel="noopener noreferrer"<?php endif; ?>><?php else : ?><div class="resources__card-preview"><?php endif; ?><?php if ( ! empty( $resource['badge'] ) ) : ?><span class="resources__card-badge"><?php echo esc_html( $resource['badge'] ); ?></span><?php endif; ?><?php if ( $image_url ) : ?><img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" class="resources__card-img" /><?php endif; ?><?php if ( $link ) : ?></a><?php else : ?></div><?php endif; ?><div class="resources__card-details"><?php if ( ! empty( $resource['title'] ) ) : ?><h3 class="h3 resources__card-title"><?php echo esc_html( $resource['title'] ); ?></h3><?php endif; ?><?php if ( ! empty( $resource['description'] ) ) : ?><p class="resources__card-description"><?php echo esc_html( $resource['description'] ); ?></p><?php endif; ?><?php if ( ! empty( $resource['author'] ) || ! empty( $resource['date'] ) ) : ?><div class="resources__card-info"><?php if ( ! empty( $resource['author'] ) ) : ?><span class="resources__card-author"><?php echo esc_html( $resource['author'] ); ?></span><?php endif; ?><?php if ( ! empty( $resource['date'] ) ) : ?><span class="resources__card-date"><?php echo esc_html( $resource['date'] ); ?></span><?php endif; ?></div><?php endif; ?></div></div>
			<?php endforeach; ?>
		</div></div>
	</section>
	<?php endif; ?>

	<?php if ( $customer_show ) : ?>
	<section class="section customer">
		<div class="section__header"><div class="container section__header-container section__lines"><div class="section__header-left"><?php if ( $customer_eyebrow ) : ?><h3 class="h3 section__subtitle"><?php echo esc_html( $customer_eyebrow ); ?></h3><?php endif; ?><?php if ( $customer_title ) : ?><h2 class="h2 section__title"><?php echo esc_html( $customer_title ); ?></h2><?php endif; ?></div><?php if ( $customer_archive ) : ?><div class="section__header-right"><a href="<?php echo esc_url( $customer_archive['url'] ); ?>" class="link link--arrow"<?php if ( $customer_archive['target'] ) : ?> target="<?php echo esc_attr( $customer_archive['target'] ); ?>" rel="noopener noreferrer"<?php endif; ?>><?php echo esc_html( $customer_archive['title'] ); ?></a></div><?php endif; ?></div></div>
		<div class="container customer__container customer__swiper swiper section__lines"><div class="swiper-wrapper">
			<?php foreach ( $stories as $story ) : ?>
				<?php
				$link     = ! empty( $story['link'] ) ? velstadt_normalize_header_link( $story['link'] ) : null;
				$logo     = isset( $story['logo'] ) ? $story['logo'] : null;
				$logo_url = velstadt_header_image_url( $logo );
				$logo_alt = is_array( $logo ) && ! empty( $logo['alt'] ) ? $logo['alt'] : '';
				?>
				<?php if ( $link ) : ?><a href="<?php echo esc_url( $link['url'] ); ?>" class="customer__card swiper-slide"<?php if ( $link['target'] ) : ?> target="<?php echo esc_attr( $link['target'] ); ?>" rel="noopener noreferrer"<?php endif; ?>><?php else : ?><div class="customer__card swiper-slide"><?php endif; ?><?php if ( ! empty( $story['quote'] ) ) : ?><p class="customer__card-quote"><?php echo esc_html( $story['quote'] ); ?></p><?php endif; ?><div class="customer__card-info"><?php if ( ! empty( $story['stat'] ) ) : ?><span class="customer__card-issue"><?php echo esc_html( $story['stat'] ); ?></span><?php endif; ?><?php if ( ! empty( $story['stat_label'] ) ) : ?><span class="customer__card-service"><?php echo esc_html( $story['stat_label'] ); ?></span><?php endif; ?></div><?php if ( $logo_url ) : ?><div class="customer__card-footer"><span class="<?php echo $link ? 'link--arrow' : ''; ?>"><img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $logo_alt ); ?>" class="customer__card-logo" /></span></div><?php endif; ?><?php if ( $link ) : ?></a><?php else : ?></div><?php endif; ?>
			<?php endforeach; ?>
		</div></div>
	</section>
	<?php endif; ?>

	<?php if ( $faq_show ) : ?>
	<section class="section faq">
		<div class="container faq__container section__lines">
			<div class="faq__left section__header"><?php if ( $faq_eyebrow ) : ?><h3 class="h3 section__subtitle"><?php echo esc_html( $faq_eyebrow ); ?></h3><?php endif; ?><?php if ( $faq_title ) : ?><h2 class="h2 section__title"><?php echo esc_html( $faq_title ); ?></h2><?php endif; ?><?php if ( $faq_description ) : ?><p><?php echo esc_html( $faq_description ); ?></p><?php endif; ?><?php if ( $faq_link ) : ?><a href="<?php echo esc_url( $faq_link['url'] ); ?>" class="link link--arrow"<?php if ( $faq_link['target'] ) : ?> target="<?php echo esc_attr( $faq_link['target'] ); ?>" rel="noopener noreferrer"<?php endif; ?>><?php echo esc_html( $faq_link['title'] ); ?></a><?php endif; ?></div>
			<div class="faq__right"><div class="services__accardion"><div class="services__accardion-list">
				<?php foreach ( $faq_items as $index => $item ) : ?>
					<?php
					$faq_content = ! empty( $item['content'] ) ? $item['content'] : '';
					if ( ! $faq_content && ! empty( $item['answer'] ) ) {
						$faq_content = '<p>' . esc_html( $item['answer'] ) . '</p>';
						if ( ! empty( $item['bullets'] ) && is_array( $item['bullets'] ) ) {
							$list = '';
							foreach ( $item['bullets'] as $bullet ) {
								if ( ! empty( $bullet['label'] ) ) {
									$list .= '<li>' . esc_html( $bullet['label'] ) . '</li>';
								}
							}
							$faq_content .= $list ? '<ul>' . $list . '</ul>' : '';
						}
					}
					?>
					<div class="services__accardion-item<?php echo 0 === $index ? ' active' : ''; ?>"><div class="services__accardion-header"><span class="services__accardion-number"><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span><?php if ( ! empty( $item['question'] ) ) : ?><h3 class="h3 services__accardion-title"><?php echo esc_html( $item['question'] ); ?></h3><?php endif; ?></div><div class="services__accardion-content-wrapper"><div class="services__accardion-content"><?php if ( $faq_content ) : ?><?php echo wp_kses_post( $faq_content ); ?><?php endif; ?></div></div></div>
				<?php endforeach; ?>
			</div></div></div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $cta_show ) : ?>
	<section class="section cta"><div class="container cta__container section__lines"><div class="cta__wrap"><div class="cta__block"><div class="cta__content">
		<?php if ( $cta_eyebrow ) : ?><span class="cta__step"><?php echo esc_html( $cta_eyebrow ); ?></span><?php endif; ?>
		<?php if ( $cta_title ) : ?><h2 class="h2 cta__title"><?php echo esc_html( $cta_title ); ?></h2><?php endif; ?>
		<?php if ( $cta_description ) : ?><h3 class="h3 cta__subtitle"><?php echo esc_html( $cta_description ); ?></h3><?php endif; ?>
		<?php if ( $cta_primary_link || $cta_secondary_link ) : ?><div class="cta__buttons">
			<?php if ( $cta_primary_link ) : ?><a href="<?php echo esc_url( $cta_primary_link['url'] ); ?>" class="btn btn--lg btn--primary"<?php if ( $cta_primary_link['target'] ) : ?> target="<?php echo esc_attr( $cta_primary_link['target'] ); ?>" rel="noopener noreferrer"<?php endif; ?>><?php echo esc_html( $cta_primary_link['title'] ); ?></a><?php endif; ?>
			<?php if ( $cta_secondary_link ) : ?><a href="<?php echo esc_url( $cta_secondary_link['url'] ); ?>" class="btn btn--lg btn--transparent"<?php if ( $cta_secondary_link['target'] ) : ?> target="<?php echo esc_attr( $cta_secondary_link['target'] ); ?>" rel="noopener noreferrer"<?php endif; ?>><?php echo esc_html( $cta_secondary_link['title'] ); ?></a><?php endif; ?>
		</div><?php endif; ?>
	</div></div></div></div></section>
	<?php endif; ?>
</main>
