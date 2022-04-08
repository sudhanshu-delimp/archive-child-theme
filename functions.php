<?php
/*This file is part of HelloChild, hello-elementor child theme.

All functions of this file will be loaded before of parent theme functions.
Learn more at https://codex.wordpress.org/Child_Themes.

Note: this function loads the parent stylesheet before, then child theme stylesheet
(leave it in place unless you know what you are doing.)
*/

// if ( ! function_exists( 'suffice_child_enqueue_child_styles' ) ) {
// 	function HelloChild_enqueue_child_styles() {
// 	    // loading parent style
// 	    wp_register_style(
// 	      'parente2-style',
// 	      get_template_directory_uri() . '/style.css'
// 	    );

// 	    wp_enqueue_style( 'parente2-style' );
// 	    // loading child style
// 	    wp_register_style(
// 	      'childe2-style',
// 	      get_stylesheet_directory_uri() . '/style.css'
// 	    );
// 	    wp_enqueue_style( 'childe2-style');
// 	 }
// }
// add_action( 'wp_enqueue_scripts', 'HelloChild_enqueue_child_styles' );


function newsblock_child_assets() {
	if ( ! is_admin() ) {
		$version = wp_get_theme()->get( 'Version' );
		wp_enqueue_style( 'newsblock_child_assets_css', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array(), $version, 'all' );

	}
}

add_action( 'wp_enqueue_scripts', 'newsblock_child_assets', 99 );


/*Write here your own functions */
function getDateTime($datetime='',$format='mm/dd/yy H:i:s') {
	$format = trim($format)=='' ? 'mm/dd/yy H:i:s' : $format;
	$datetime = (trim($datetime)=='') ? date($format) : $datetime;
	return date($format,strtotime($datetime));
}

function getWeather(){
	  global $temperature;
		$temperature_is = 0;
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://api.weatherapi.com/v1/current.json?key=57189dc3791340df8f6121904211709&q=Riyadh&aqi=no',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response);
		$temperature = (isset($response->current))?$response->current:0;
}
getWeather();

function child_enqueue_styles() {
	wp_enqueue_script( 'child-fontawesome-script', 'https://use.fontawesome.com/aafb3aaedd.js', true );
	wp_enqueue_script( 'archive_script', get_stylesheet_directory_uri() . '/assets/js/archive.js', array('jquery'), rand(), true );
	wp_localize_script('archive_script', 'DVO', array('siteurl'=>get_option('siteurl')));
}
add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 99 );


add_action('wp_ajax_my_ajax_filter_search', 'my_ajax_filter_search_callback');
add_action('wp_ajax_nopriv_my_ajax_filter_search', 'my_ajax_filter_search_callback');

function my_ajax_filter_search_callback() {
	global $wpdb;

	$meta_query = array('relation' => 'AND');
	$tax_query = array();
	$date_query = array();
	// print_r($_GET);
	if(isset($_GET['paged'])) {
		$paged = $_GET['paged'];
	}

	if(isset($_GET['category']) && $_GET['category'] ) {
		$category = sanitize_text_field( $_GET['category'] );
		$tax_query[] = array(
			'taxonomy' => 'category',
			'field' => 'slug',
			'terms' => $category
		);
	}
	if(isset($_GET['year']) && $_GET['year']) {
		$year = $_GET['year'];
		$date_query[] = array(
			array(
				'year'  => $year,
			),
		);
	}
	if(isset($_GET['month']) && $_GET['month']) {
		$month = $_GET['month'];
		$date_query[] = array(
			array(
				'year'  => $year,
				'month' => $month,
			),
		);
	}
	if(isset($_GET['search']) && $_GET['search']) {
		$search = sanitize_text_field( $_GET['search'] );
	}

	$args = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => 10,
    	'paged'=>$paged,
		'meta_query' => $meta_query,
		'tax_query' => $tax_query,
		'date_query' => $date_query
	);

	if(isset($_GET['search'])) {
		$search = sanitize_text_field( $_GET['search'] );
		$search_query = new WP_Query( array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'posts_per_page' => 10,
				'paged'=>$paged,
				's' => $search,
				'meta_query' => $meta_query,
				'tax_query' => $tax_query,
				'date_query' => $date_query
			)
		);
	}else {
		$search_query = new WP_Query( $args );
	}
	// echo $search_query->request;

	if ( $search_query->have_posts() ) {
		$result = array();
		?>
		<h2>نتيجة البحث</h2>
		<?php

		while ( $search_query->have_posts() ) {
			$search_query->the_post();
			$cats = strip_tags( get_the_category_list(", ") );
			$cat=explode(',',$cats);

			$year = get_the_date('Y');
			$month = date('F d, Y', strtotime(get_the_date('Y-m-d H:i:s')));
			$contentData = substr(strip_tags(get_the_content()), 0, 290);
			$featuredImgs = wp_get_attachment_url(get_post_thumbnail_id($post->ID),'full');
			// if(!empty($featuredImgs)){
			// 	$featuredImg = '<img src="'.wp_get_attachment_url(get_post_thumbnail_id($post->ID),'full').'" alt="'.get_the_title().'">';
			// }
			?>

			<ul>
				<li id="article-<?php echo get_the_ID(); ?>">
					<p class="catey_gory">
					<?php
					foreach($cat as $key => $row)
					{
						$category_id = get_cat_ID( $row );
						echo '<a href="'.get_category_link( $category_id ).'" > '.$row.'</a>';
						if($key!==count($cat)-1){echo ',';}
					}
					?>
					</p>
					<a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>">
						<div class="movie-info">
							<h2 class="cs-entry__title"><?php echo get_the_title(); ?></h2>
							<p><?php echo $contentData; ?></p>
							<p class="post_year"><?php echo $year; ?></p>
							<p class="post_date"><?php echo $month; ?></p>

						</div>
					</a>
				</li>
			</ul>

		<?php
		}
		if ($search_query->max_num_pages > 1) :
			?>
			<div class="pagination">
				<?php
					$paged = isset($_GET['paged']) ? (int) $_GET['paged'] : 1;
					$paginates = paginate_links( array(
						'total'        => $search_query->max_num_pages,
						'current'      => $paged,
						'format'       => '?paged=%#%',
						'show_all'     => false,
						'type'         => 'plain',
						'end_size'     => 2,
						'mid_size'     => 1,
						'prev_next'    => true,
						'prev_text'    => __('« prev'),
            			'next_text'    => __('next »'),
						'add_args'     => false,
						'add_fragment' => '',
					) );
					echo $paginates;
				?>
			</div>
			<?php
		endif;
		wp_reset_query();

	}else{
		echo "<ul><li>عفوا، لا يوجد منشور يطابق معيارك.</li></ul>";
	}
	wp_die();
}

add_shortcode( 'helloChild_filter', 'helloChild_filter_datacallback' );

function helloChild_filter_datacallback(){
	?>
	<div class="page_inr_ctnt">
		<div id="my-ajax-filter-search">
			<form class="cs-search__nav-form" action="" method="get">

					<div class="cnvs-block-tab-section-content-inner">

					<div class="cnvs-block-tabs-content tab_ctnt">
					<div class="cnvs-block-tabs cnvs-block-tabs-active">
						<div class="wp-block-canvas-tab cnvs-block-tab">

							<div class="cs-search__group custom-search">
								<button type="submit" name="submit"  class="cs-search__submit sercch_btn">
								<i class="cs-icon cs-icon-search"></i>
								</button>
								<input data-swpparentel=".cs-header .cs-search-live-result" class="cs-search__input" data-swplive="true" type="search" name="search" id="search" value=""  placeholder="البحث بالكلمة المفتاحية ، التاريخ ، السنة أو العنوان ...">
								<button type="submit" id="submit" name="submit" class="cs-search__submit sub-btn">البحث</button>
							</div>


						</div>
					</div>
					<div class="cnvs-block-tabs">
						<div class="wp-block-canvas-tab cnvs-block-tab">
						<!-- wp:gravityforms/form {"formId":"1"} /-->
						</div>
					</div>

					</div>
				</div>

				<div class="cnvs-block-tab-section-content-inner drop_tab">
				<div class="tab">
					<ul id="tabs" class="form-tabs">
					<li data-tab-content="tab2"> اطلب نسخة</li>
					<li data-tab-content="tab1"> البحث المتقدم</li>
					</ul>
				</div>

				<div id="Paris" class="tabcontent tab-content" data-tab-content="tab1">
					<div class="cnvs-block-tabs-content">
						<div class="cnvs-block-tabs cnvs-block-tabs-active">
						<div class="wp-block-canvas-tab cnvs-block-tab">
						<div>
							<select id="category" name="category" size="1" >
							<option value="" selected>فئة</option>
								<?php
								$categories = get_categories();
								foreach($categories as $category) {
									echo '<option value="' . $category->name . '">' . $category->name . '</option>';
								}
								?>
							</select>

						</div>

						<div>
							<select id="month" name="month" size="1" >
							<option value="" selected>شهر</option>
							<option value='1'>Janaury</option>
							<option value='2'>February</option>
							<option value='3'>March</option>
							<option value='4'>April</option>
							<option value='5'>May</option>
							<option value='6'>June</option>
							<option value='7'>July</option>
							<option value='8'>August</option>
							<option value='9'>September</option>
							<option value='10'>October</option>
							<option value='11'>November</option>
							<option value='12'>December</option>
							</select>

						</div>

						<div>
							<select id="year" name="year" onchange="checkYear()">
								<option value="" disabled selected>عام</option>
								<?php
								$years = range(date('Y'), 2008);
								foreach($years as $year) {
									echo '<option value="' . $year . '">' . $year . '</option>';
								}
								?>
							</select>

						</div>

						</div>
					</div>

				</div>

				</div>
			</div>
			</form>


			<div id="ajax_filter_search_results">
			</div>
			<div class="loading"></div>
		</div>

		<div id="London" class="tabcontent tab-content" data-tab-content="tab2">
		<?php echo do_shortcode('[gravityform id="2" title="false" description="false" ajax="true" tabindex="49" field_values="check=First Choice,Second Choice"]');?>
		</div>

		</div>




	<?php
}

add_filter("wp_check_filetype_and_ext","sbs_allow_svg", 10, 4 );
add_filter( 'upload_mimes', 'cc_mime_types' );
add_action( 'admin_head', 'fix_svg' );
function sbs_allow_svg($data, $file, $filename, $mimes){
    $filetype = wp_check_filetype( $filename, $mimes );
    return [
        'ext'             => $filetype['ext'],
        'type'            => $filetype['type'],
        'proper_filename' => $data['proper_filename']
    ];
  }

  function cc_mime_types( $mimes ){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
  }

function fix_svg() {
    echo '<style type="text/css">
          .attachment-266x266, .thumbnail img {
               width: 100% !important;
               height: auto !important;
          }
          </style>';
  }
