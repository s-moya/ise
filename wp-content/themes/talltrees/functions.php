<?php

add_filter('use_block_editor_for_post', '__return_false');

if ( ! function_exists( 'child_theme_setup' ) ):
function child_theme_setup() {
	add_filter('wp_headers', 'remove_x_pingback');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0 );
	remove_action( 'wp_head', '_wp_render_title_tag', 1 );
	// add_action('load-post.php', 'disable_visual_editor_in_page');
	// add_action('load-post-now.php', 'disable_visual_editor_in_page');

}
endif;

// 親テーマの読み込みより後に
add_action( 'after_setup_theme', 'child_theme_setup' );

// 絵文字変換を停止
function disable_emoji() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'disable_emoji' );

// 管理画面調整（ヘッダ）
function wp_custom_admin_css() {
	// echo "\n" . '<link href="' .get_bloginfo('template_directory'). '/css/foo.css' . '" rel="stylesheet" type="text/css" />' . "\n";
	// echo "\n" . '<script src="' .get_bloginfo('template_directory'). '/js/customized_admin.js' . '" type="text/javascript"></script>' . "\n";

	echo '<script>
	jQuery(function($){
		// イベント登録ページの開催館「総合案内」を「合同開催」に置換
		$("#acf-select_hall .acf-taxonomy-field .categorychecklist-holder ul li").each(function(index){
			if(index == 0){
				var labelStr = $(this).find("label").html();
				$(this).find("label").html(labelStr.replace(/総合案内/g,"合同開催"));
				$(this).hide();
			}
		});

		$(".acf_postbox").find(".field").addClass("clearfix");
		$(".cfs_loop").addClass("clearfix");
		$("#posts-filter .tablenav").addClass("clearfix");
		$(".field-detail .cfs_loop_body").addClass("clearfix");
		// 公開期限以降のカテゴリを自動チェックさせる
		$("#expired-category-selection #post-expirator-cat-list li .selectit input:checkbox").prop("checked",true);

	});
	</script>
	';

	echo '<style type="text/css">'."\n";
	// 管理者以外のメニュー
	if (!current_user_can('level_10')) {
		// echo '#toplevel_page_ps-taxonomy-expander, #toplevel_page_uam_usergroup{display:none;}';
		echo '#toplevel_page_uam_usergroup{display:none;}'."\n";
		echo '#pageparentdiv{display:none;}'."\n";
		echo '.update-nag{display:none;}'."\n";
		echo '#expire_categorydiv { display: none;}'."\n";
		echo '#menu-posts-cfs, #wpbody-content .updated{display:none;}'."\n";
		echo '#menu-media{display:none;}'."\n";	// 「メディア」非表示
	}
	// 管理者、all以外のメニュー
	if (!current_user_can('level_8')) {
		echo '#toplevel_page_ps-taxonomy-expander{display:none;}'."\n";
		echo '.page-sougouTop{display:none;}'."\n";
		// echo '#toplevel_page_uam_usergroup{display:none;}';
		echo '#adminmenu #menu-pages,
		#adminmenu .page_sogobunka,
		#adminmenu #menu-users,
		#adminmenu .page_amigo,
		#adminmenu .page_iris,
    #adminmenu .menu-icon-mw-wp-form,
		#adminmenu .page_tsuga{display:none;}'."\n";
		echo '.post-type-page .subsubsub .all{display:none;}'."\n";
		echo '.post-type-page .subsubsub .publish{display:none;}'."\n";
		echo '.post-type-page .tablenav .actions{display:none;}'."\n";
		echo '.post-type-page .tablenav .bulkactions{display:block; width:60%;}'."\n";
	}
	// tt_sm （サイト管理者）
	if( current_user_can('tt_sitemanager') ){
		echo '#adminmenu #menu-users{display:none;}'."\n";
	}
	// sm （更新）
	if( current_user_can('editor_01') ){
		echo '#adminmenu .menu-toppage, #adminmenu .menu-settingpage{display:none;}'."\n";
	}

	echo '</style>'."\n";

}
add_action('admin_head', 'wp_custom_admin_css', 100);


//管理者以外にツールバーを表示させない
if ( ! current_user_can( 'level_10' ) ) {
 show_admin_bar( false );
}


// 管理画面調整（フッタ）
function my_footer() {
	// //固定ページで「ビジュアル」を無効にする
	// echo '<script>
	// jQuery(function($){
	// 	$(".cfs_loop").addClass("clearfix");
	// 	$(".field-detail .cfs_loop_body").addClass("clearfix");
	// 	$(".acf_postbox").find(".field").addClass("clearfix");
	// });
	// </script>
	// ';
	// // 管理者以外のメニュー
	// if (!current_user_can('level_10')) {
	// 	echo '<style type="text/css">';
	// 	// echo '#toplevel_page_ps-taxonomy-expander, #toplevel_page_uam_usergroup{display:none;}';
	// 	echo '#toplevel_page_uam_usergroup{display:none;}';
	// 	echo '</style>';
	// }
	// if (!current_user_can('level_8')) {
	// 	echo '<style type="text/css">';
	// 	echo '#toplevel_page_ps-taxonomy-expander{display:none;}';
	// 	echo '.page-sougouTop{display:none;}';
	// 	// echo '#toplevel_page_uam_usergroup{display:none;}';
	// 	echo '</style>';
	// }
}
add_action('admin_footer', 'my_footer', 11);

//pingback 削除
function remove_x_pingback($headers) {
	unset($headers['X-Pingback']);
	return $headers;
}

//-----------------------------------ショートコード
//テンプレートURL
function shortcode_templateurl() {
    return get_stylesheet_directory_uri();
}
add_shortcode('theme_path', 'shortcode_templateurl');

//ブログURL
function shortcode_blogurl() {
    return get_bloginfo('url');
}
add_shortcode('blog_path', 'shortcode_blogurl');

//自分のページのタイトル（固定ページ）
function shortcode_title() {
	return get_the_title();
}
add_shortcode('post_title', 'shortcode_title');

//自分のページのスラッグ（固定ページ）
function shortcode_slug() {
	$page = get_post(get_the_ID());
	return strtoupper($page->post_name);
}
add_shortcode('post_name', 'shortcode_slug');

//自分のページの親（固定ページ）
function shortcode_post_parent() {
	$page_slug = get_post(get_the_ID());
	$page_parent = get_most_parent_page(get_the_ID());
	$page_parent_slug = $page_parent->post_name;
	if($page_parent_slug == $page_slug){
		$page_parent_slug = $page_slug;
	}

	return $page_parent_slug;
}
add_shortcode('parent_slug', 'shortcode_post_parent');

//---------------------------------------------

/*
カスタムフィールドのショートコードを取得するには、
テンプレート内で echo apply_filters('the_content',cfs()->get("page_list_icon")); の様に記述
*/


// 管理画面にカスタムフィールドを表示
// function manage_posts_columns($columns) {
// 	$columns['date_single'] = "開催日";
// 	return $columns;
// }
// function add_column($column_name, $post_id) {
// 	if( $column_name == 'date_single' ) {
// 		var_dump(get_post_meta($post_id, 'date_single', true));
// 		echo get_post_meta($post_id, 'date_single', true);
// 	}
// }
// add_filter( 'manage_posts_columns', 'manage_posts_columns' );
// add_action( 'manage_posts_custom_column', 'add_column', 10, 5 );


// 管理画面のアドミンバーに「ログアウト」表示
function add_new_item_in_admin_bar() {
	global $wp_admin_bar;
	$wp_admin_bar->add_menu(array(
	'id' => 'new_item_in_admin_bar',
	'title' => __('ログアウト'),
	'href' => wp_logout_url()
	));
}
add_action('wp_before_admin_bar_render', 'add_new_item_in_admin_bar');

//ビジュアルエディタ無効
function disable_visual_editor_in_page() {
    global $typenow;
    if ($typenow == 'page' || $typenow == 'mw-wp-form') {
        add_filter('user_can_richedit', 'disable_visual_editor_filter');
    }
}
function disable_visual_editor_filter() {
    return false;
}
//追記
add_action( 'load-post.php', 'disable_visual_editor_in_page' );
add_action( 'load-post-new.php', 'disable_visual_editor_in_page' );

//カスタムフィールドの値いちらんを取得
function get_post_meta_values( $meta_key = '' ) {
	global $wpdb;
	if ( !is_string( $meta_key ) || trim( $meta_key ) == '' )
		return false;
	$query = $wpdb->prepare(
		"SELECT meta_value, count(*) AS count FROM $wpdb->postmeta
		WHERE meta_key = %s GROUP BY meta_value", $meta_key );
	return $wpdb->get_results( $query );
}
add_filter( 'get_post_meta_values', 'get_post_meta_values' );

add_image_size( 'myphoto', 335, 235, true );


// 抜粋
function custom_excerpt_length( $length ) {
     return 78;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
function new_excerpt_more($more) {
	return '…';
}
add_filter('excerpt_more', 'new_excerpt_more');


// スラッグでページID取得
function get_id_by_slug($slug){
	if(wbsExistPost('page', $slug)){
   global $wpdb;
   $myMeta = $wpdb->get_row("
   SELECT ID
   FROM $wpdb->posts
   WHERE
   post_type = 'page' and
   post_name = '$slug'
   LIMIT 1");
   return $myMeta->ID;
	}else{
		return false;
	}
}

function wbsExistPost($type, $slug)
{
	$loops= new wp_query();
	$loops->query("post_type={$type}&name={$slug}");
	if($loops->have_posts()) {
		return true;
	} else {
		return false;
	}
}

// function get_id_by_slug($slug){
//    global $wpdb;
//    $myMeta = $wpdb->get_row("
//    SELECT ID
//    FROM $wpdb->posts
//    WHERE
//    post_status = 'publish' and
//    post_type = 'page' and
//    post_name = '$slug'
//    LIMIT 1");
//    return $myMeta->ID;
// }

//	IDからページスラッグ取得
function get_page_slug($page_id) {
	$str = get_page($page_id);
	return $str -> post_name;
}

//固定ページの親ページをスラッグで判定
function get_parent_slug() {
	global $post;
	if ($post->post_parent) {
		$post_data = get_post($post->post_parent);
		return $post_data->post_name;
	}
}

// 最上位の親ページ情報を取得する。
function get_most_parent_page($current_id = ''){
    global $post;
    if($current_id == '') $current_id ==$post->ID;
    $current_post = get_post($current_id);
    $par_id = $current_post->post_parent;
    while($par_id!= 0) :
        $par_post = get_post($par_id);
        $current_post = $par_post;
        $par_id = $par_post->post_parent;
    endwhile;
    return $current_post;
}


//最初の画像を取得
function catch_that_image() {
    global $post, $posts;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('//i', $post->post_content, $matches);
    $first_img = $matches [1] [0];

if(empty($first_img)){ //Defines a default image
        $first_img = get_stylesheet_directory_uri().'/images/sample/img-cca.jpg';
    }
    return $first_img;
}

//whileの最初を取得
function isFirst() {
	global $wp_query;
	return ($wp_query->current_post === 0);
}
//whikeの最後を取得
function isLast() {
	global $wp_query;
	return ($wp_query->current_post+1 === $wp_query->post_count);
}


//親カテゴリを選択できないようにする（チェックボックスを外す）
/*
require_once(ABSPATH . '/wp-admin/includes/template.php');
class Danda_Category_Checklist extends Walker_Category_Checklist {

     function start_el( &$output, $category, $depth, $args, $id = 0 ) {
        extract($args);
        if ( empty($taxonomy) )
            $taxonomy = 'category';

        if ( $taxonomy == 'category' )
            $name = 'post_category';
        else
            $name = 'tax_input['.$taxonomy.']';

        $class = in_array( $category->term_id, $popular_cats ) ? ' class="popular-category"' : '';

        //親カテゴリの時はチェックボックス表示しない
        //カスタム分類が staff, categ_r の時を除く
        if($category->parent == 0 && $category->taxonomy != 'staff' && $category->taxonomy != 'categ_r' && $category->taxonomy != 'e-service'){
               $output .= "\n<li id='{$taxonomy}-{$category->term_id}'$class>" . '<label class="selectit">' . esc_html( apply_filters('the_category', $category->name )) . '</label>';
        }else{
            $output .= "\n<li id='{$taxonomy}-{$category->term_id}'$class>" . '<label class="selectit"><input value="' . $category->term_id . '" type="checkbox" name="'.$name.'[]" id="in-'.$taxonomy.'-' . $category->term_id . '"' . checked( in_array( $category->term_id, $selected_cats ), true, false ) . disabled( empty( $args['disabled'] ), false, false ) . ' /> ' . esc_html( apply_filters('the_category', $category->name )) . '</label>';
        }
    }
}

function lig_wp_category_terms_checklist_no_top( $args, $post_id = null ) {
    $args['checked_ontop'] = false;
    $args['walker'] = new Danda_Category_Checklist();
    return $args;
}
add_action( 'wp_terms_checklist_args', 'lig_wp_category_terms_checklist_no_top' );
*/


//管理画面のカテゴリ順も変更
function my_get_terms_orderby($orderby){
  if(is_admin()){
    return "t.term_order";
  }else{
    return $orderby;
  }
}
add_filter('get_terms_orderby', 'my_get_terms_orderby', 10);


function term_parent_sort($a, $b){
    if ( intval($a->parent) == intval($b->parent) && intval($a->term_order) < intval($b->term_order)) {
        return 0;
    }
    return (intval($a->parent) < intval($b->parent)) ? -1 : 1;
}


// public post previewの有効期限
add_filter( 'ppp_nonce_life', 'my_nonce_life' );
function my_nonce_life() {
	return 60 * 60 * 24 * 31; //31日間
}


//一覧表示から他ユーザーの記事を除外
// function exclude_other_posts( $wp_query ) {
// 	if ( isset( $_REQUEST['post_type'] ) && post_type_exists( $_REQUEST['post_type'] ) ) {
// 		$post_type = get_post_type_object( $_REQUEST['post_type'] );
// 		$cap_type = $post_type->cap->edit_other_posts;
// 	} else {
// 		$cap_type = 'edit_others_posts';
// 	}
// 	if ( is_admin() && $wp_query->is_main_query() && ! $wp_query->get( 'author' ) && ! current_user_can($cap_type ) ) {
// 		$user = wp_get_current_user();
// 		$wp_query->set( 'author', $user->ID );
// 	}
// }
// add_action( 'pre_get_posts', 'exclude_other_posts' );


//投稿リストから「すべて」などを消す
function custom_columns($columns) {
    if (!current_user_can('level_10')) {
         echo '<style type="text/css">';
				 echo 'li.all, li.publish .count, li.pending .count, li.draft .count, li.private .count, li.trash .count {display:none;}';
				 echo '</style>';
     }
     return $columns;
}
add_filter( 'manage_posts_columns', 'custom_columns' );


//管理画面の上の方に注意書きを表示
// function showMessage($message, $errormsg = false){
// 	if ($errormsg) {
// 		echo '<div id="message" class="error">';
// 	}else {
// 		echo '<div id="message" class="updated fade">';
// 	}	echo "<p><strong>$message</strong></p></div>";
// }
// function showAdminMessages(){
//     showMessage("1. 記入がない項目は非表示となります。 2. 表示期限の設定を確認してください。", false);
// }
// add_action('admin_notices', 'showAdminMessages');

//日付をフォーマット
function tt_format_date($date_string, $format, $target, $get_week=true, $holiday=false){
	if(!$date_string) return false;
	if(!$format) $format = 'Y/n/j';
	if(!$target) $target = 'Ymd';
	$date_w = '';
	$fotmat_date = '';
	$create_format_date	= DateTime::createFromFormat($target, $date_string);
	$format_date_w = $create_format_date->format('w');
	switch($format_date_w){
		case '0':
			$date_w = '日';
			break;
		case '1':
			$date_w = '月';
			break;
		case '2':
			$date_w = '火';
			break;
		case '3':
			$date_w = '水';
			break;
		case '4':
			$date_w = '木';
			break;
		case '5':
			$date_w = '金';
			break;
		case '6':
			$date_w = '土';
			break;
	}
	$format_date	= $create_format_date->format($format);
	if($get_week){
    return ($holiday) ? $format_date.'('.$date_w.'･祝)' : $format_date.'('.$date_w.')';
  }else{
    return $format_date;
  }
}

function tt_get_weekday($date_string, $target){
	if(!$date_string) return false;
	if(!$target) $target = 'Ymd';
	$date_w = '';
	$create_format_date	= DateTime::createFromFormat($target, $date_string);
	$format_date_w = $create_format_date->format('w');
	switch($format_date_w){
		case '0':
			$date_w = '日';
			break;
		case '1':
			$date_w = '月';
			break;
		case '2':
			$date_w = '火';
			break;
		case '3':
			$date_w = '水';
			break;
		case '4':
			$date_w = '木';
			break;
		case '5':
			$date_w = '金';
			break;
		case '6':
			$date_w = '土';
			break;
	}
	return $date_w;
}

function set_holiday($formated_schedule_date){
  global $all_holiday_array;
  $all_holiday_array[] = $formated_schedule_date;
}

function get_holiday($formated_schedule_date){
  global $all_holiday_array;
  if(empty($all_holiday_array)) $all_holiday_array = array();
  if( in_array( $formated_schedule_date, $all_holiday_array ) ){
    return true;
  }
}

// 投稿のみパーマリンクを変更（ news をはさむ）
// --------------------------------------------------------
// function add_article_post_permalink($permalink){
// 	$permalink_add = '/news'.$permalink;
// 	return $permalink_add;
// }
// add_filter( 'pre_post_link', 'add_article_post_permalink' );
//
// function add_article_post_rewrite_rules( $post_rewrite ) {
// 	$return_rule = array();
// 	foreach ( $post_rewrite as $regex => $rewrite ) {
// 		$return_rule['news/' . $regex] = $rewrite;
// 	}
// 	return $return_rule;
// }
// add_filter( 'post_rewrite_rules', 'add_article_post_rewrite_rules' );
// --------------------------------------------------------


//カスタム投稿パーマリンク「/taxonomy/」削除
// add_rewrite_rule('series/([^/]+)/?$', 'index.php?cat_series=$matches[1]', 'top');// 要注意
// add_rewrite_rule('series/([^/]+)/page/([0-9]+)/?$', 'index.php?cat_series=$matches[1]&paged=$matches[2]', 'top');


// 親ページの有無を取得
function is_parent_slug() {
	global $post;
	if ($post->post_parent) {
		$post_data = get_post($post->post_parent);
		return $post_data->post_name;
	}
}

// 自動挿入されるpタグを削除する
add_filter('the_content', 'wpautop_filter', 9);
function wpautop_filter($content) {
    global $post;
    $remove_filter = false;

    $arr_types = array('page'); //autopを無効にする投稿タイプを配列として用意する
    $post_type = get_post_type( $post->ID );
    if (in_array($post_type, $arr_types)) $remove_filter = true;

    if ( $remove_filter ) {
        remove_filter('the_content', 'wpautop');
        remove_filter('the_excerpt', 'wpautop');
    }
    return $content;
}

//ページのカテゴリ（カスタムフィールド）に属する子ページを取得
function tt_get_child_pages($cat_page_slug, $par_page_id, $this_page_slug, $arrow_class=''){
	$page_list = '';
	if($arrow_class){
		$link_class = $arrow_class;
	}else{
		$link_class = 'arrow_simple';
	}
	$current_class = '';
	$current_link = '';
	$child_page_args = array(
		'post_type'=>'page', 'posts_per_page'=>-1, 'post_parent'=>$par_page_id,
		'meta_query'=>array(
			array('key'=>'cat_page', 'value'=>$cat_page_slug, 'compare'=>'==', 'type'=>'CHAR')
		)
	);
	$child_page_array = get_posts($child_page_args);
	foreach($child_page_array as $child_page){

		// カテゴリ none の場合はリンクも出力
		if($cat_page_slug == 'none'){
			$current_link = '<a href="'.get_permalink($child_page->ID).'" class="'.$link_class.' arrow_current">'.get_the_title($child_page->ID);

		// それ以外はタイトルのみ
		}else{
			$current_link = get_the_title($child_page->ID);
		}

		// リストを出力
		if($this_page_slug == $child_page->post_name){
			$page_list .= '<li class="nav_category_current">'.$current_link.'</a>'."\n";
		}else{
			$page_list .= '<li><a href="'.get_permalink($child_page->ID).'" class="'.$link_class.'">'.get_the_title($child_page->ID).'</a>'."\n";
		}
		$page_list .= '</li>'."\n";

	}
	return $page_list;
}


// 管理画面＞イベント投稿一覧にカスタムフィールドを表示
// in_list：一覧に掲載
// schedule：開催日程（配列）
add_action( 'manage_event_posts_custom_column', 'my_add_column', 10, 2 );
function my_add_column($column_name, $post_id) {
	// 一覧に掲載を表示
	if( $column_name == 'in_list' ) {
		$in_list = esc_attr(get_post_meta($post_id, 'in_list', true));
		//チェックボックスの場合
    if ( !!get_post_meta($post_id, 'in_list', true) ) {
				$img = '<img src="/wp-content/themes/talltrees/images/check.png" alt="" />';
        $checked = 'checked';
    } else {
        $checked = '';
				$img = '';
    }
    echo "<input type='checkbox' disabled $checked/>".$img;
	}

	// 開催日程を表示
	if( $column_name == 'schedule' ) {
		$schedule_dates = array();
		$schedule_array = get_field('schedule', $post_id);
		$schedule_limit = get_field('limit', $post_id);
		foreach($schedule_array as $schedule){
			$schedule_dates[] = tt_format_date($schedule['date'], 'Y.n.j ', '', true, $schedule['is_holiday']);
		}
		// 開催日の種類によって出力を変更
		switch($schedule_limit){
		  case 'multi':
		    $glue	= '､<br>';
		    break;
		  case 'continue':
		    $glue	= ' 〜<br>';
		    break;
		  default :
		    $glue	= ' ';
		    break;
		}

		if($schedule){
			//日付が設定されていたら
			$schedule = implode($glue,$schedule_dates);
			if($schedule_limit == 'single'){
				$schedule = $schedule.'のみ';
			}
		}else{
			//日付が設定されていなかったら
			$schedule = '<font color="red">未設定</font>';
		}

		echo $schedule;
	}
}
add_filter( 'manage_event_posts_columns', 'my_manage_posts_columns' );
function my_manage_posts_columns($columns) {
	$columns['in_list'] = "一覧に掲載";
	$columns['schedule'] = "開催日程";
	return $columns;
}


// カスタムフィールド「一覧に掲載」をクイック編集から編集可能にする
// ------------------------------------------------------------------------------
function display_my_custom_quickedit( $column_name, $post_type ) {
    static $print_nonce = TRUE;
    if ( $print_nonce ) {
        $print_nonce = FALSE;
        wp_nonce_field( 'quick_edit_action', $post_type . '_edit_nonce' ); //CSRF対策
    }

    ?>
    <fieldset class="inline-edit-col-right inline-custom-meta">
        <div class="inline-edit-col column-<?php echo $column_name ?>">
            <label class="inline-edit-group">
                <?php
                switch ( $column_name ) {
                  case 'in_list':
                    //チェックボックスの場合
                    ?><span class="title">一覧に掲載</span><input name="in_list" type="checkbox" /><?php
                    break;
                }
                ?>
            </label>
        </div>
    </fieldset>
<?php
}
add_action( 'quick_edit_custom_box', 'display_my_custom_quickedit', 10, 2 );


function my_admin_edit_foot() {
    global $post_type;
    $slug = 'event'; //他の一覧ページで動作しないように投稿タイプの指定をする

    if ( $post_type == $slug ) {
        echo '<script type="text/javascript" src="', get_stylesheet_directory_uri() .'/admin/js/admin_edit.js', '"></script>';
    }
}
add_action('admin_footer-edit.php', 'my_admin_edit_foot');


function save_custom_meta( $post_id ) {
    $slug = 'event'; //カスタムフィールドの保存処理をしたい投稿タイプを指定

    if ( $slug !== get_post_type( $post_id ) ) {
        return;
    }
    if ( !current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $_POST += array("{$slug}_edit_nonce" => '');
    if ( !wp_verify_nonce( $_POST["{$slug}_edit_nonce"], 'quick_edit_action' ) ) {
        return;
    }

    //チェックボックスの場合
    if ( isset( $_REQUEST['in_list'] ) ) {
        update_post_meta($post_id, 'in_list', TRUE);
    } else {
        update_post_meta($post_id, 'in_list', FALSE);
    }
}
add_action( 'save_post', 'save_custom_meta' );
// ------------------------------------------------------------------------------


// カテゴリをチェックした際に階層構造をそのままにする
function lig_wp_category_terms_checklist_no_top( $args, $post_id = null ) {
    $args['checked_ontop'] = false;
    return $args;
}
add_action( 'wp_terms_checklist_args', 'lig_wp_category_terms_checklist_no_top' );



// 管理画面：固定ページ、記事一覧 カスタムタクソノミーでソート
// ------------------------------------------------------------------------------
function add_post_taxonomy_restrict_filter() {
    global $post_type;

    if( $post_type == 'page'){
      echo '<select name="page_category">';
      echo '<option value="">すべてのページ</option>';
      $terms = get_terms('page_category');
      foreach ($terms as $term) {
        echo '<option value="'.$term->slug.'">'.$term->name.'</option>';
      }
      echo '</select>';

    } else if( $post_type == 'event' ){
			$check_labels = filter_input( INPUT_GET, 'labels' );
			$check_ticket = filter_input( INPUT_GET, 'ticket' );
			$check_genre = filter_input( INPUT_GET, 'genre' );
			$check_author = filter_input( INPUT_GET, 'author' );
			$check_expire = filter_input( INPUT_GET, 'expire_category');
      $check_s = filter_input( INPUT_POST, 's');

      echo '<select name="labels">';
      echo '<option value="">全ての種類</option>';
      $labelsTerms = get_terms('labels');
      foreach ($labelsTerms as $labelsTerm) {
        echo '<option value="'.$labelsTerm->slug.'"';
				echo ($check_labels == $labelsTerm->slug) ? ' selected="selected"' : '';
				echo '>'.$labelsTerm->name.'</option>';
      }
      echo '</select>';
      // echo '<input type="hidden" name="s" value="'. $check_s .'">';

			echo '<select name="ticket">';
      echo '<option value="">全てのチケット</option>';
      $ticketTerms = get_terms('ticket');
      foreach ($ticketTerms as $ticketTerm) {
				echo '<option value="'.$ticketTerm->slug.'"';
				echo ($check_ticket == $ticketTerm->slug) ? ' selected="selected"' : '';
				echo '>'.$ticketTerm->name.'</option>';
      }
      echo '</select>';

			echo '<select name="genre">';
      echo '<option value="">全てのジャンル</option>';
      $genreTerms = get_terms('genre');
      foreach ($genreTerms as $genreTerm) {
				echo '<option value="'.$genreTerm->slug.'"';
				echo ($check_genre == $genreTerm->slug) ? ' selected="selected"' : '';
				echo '>'.$genreTerm->name.'</option>';
      }
      echo '</select>';

			// echo '<select name="expire_category">';
      // echo '<option value="">全てのステータス</option>';
      // $expireTerms = get_terms('expire_category');
      // foreach ($expireTerms as $expireTerm) {
			// 	echo '<option value="'.$expireTerm->slug.'"';
			// 	echo ($check_expire == $expireTerm->slug) ? ' selected="selected"' : '';
			// 	echo '>'.$expireTerm->name.'</option>';
      // }
      // echo '</select>';
			//
			// echo '<select name="author">';
      // echo '<option value="">全ての作成者</option>';
      // $authors = get_users( array('nicename'=>ID,'order'=>ASC) );
      // foreach ($authors as $author) {
			// 	$authorData = get_userdata($author->ID);
      //   echo '<option value="'.$author->ID.'"';
			// 	echo ($check_author == $author->ID) ? ' selected="selected"' : '';
			// 	echo '>'.$authorData->display_name.'</option>';
      // }
      // echo '</select>';

      // $slug_genre = get_query_var( 'genre' );
      // wp_dropdown_categories( array(
      //   'show_option_all'    => '全てのジャンル',
      //   'selected'           => $slug_genre,
      //   'name'               => 'genre',
      //   'taxonomy'           => 'genre',
      //   'value_field'        => 'slug',
      // ));

      // $slug_ticket = get_query_var( 'ticket' );
      // wp_dropdown_categories( array(
      //   'show_option_all'    => '全てのチケット',
      //   'selected'           => $slug_ticket,
      //   'name'               => 'ticket',
      //   'taxonomy'           => 'ticket',
      //   'value_field'        => 'slug',
      // ));

      // $slug_labels = get_query_var( 'labels' );
      // wp_dropdown_categories( array(
      //   'show_option_all'    => '全ての種類',
      //   'selected'           => $slug_labels,
      //   'name'               => 'labels',
      //   'taxonomy'           => 'labels',
      //   'value_field'        => 'slug',
      // ));

      $value = get_query_var('in_list');
      if ( !empty($value) ) {
        printf(
          '<span class="checkInList"><input name="in_list" id="checkInList" type="checkbox" checked="checked"><label for="checkInList"><b>一覧に掲載</b></label></span>',
          'in_list',
          esc_attr(get_query_var('in_list'))
        );

      }else{
        printf(
          '<span class="checkInList"><input name="in_list" id="checkInList" type="checkbox"><label for="checkInList"><b>一覧に掲載</b></label></span>',
          'in_list',
          esc_attr(get_query_var('in_list'))
        );
      }

    }
}
add_action( 'restrict_manage_posts', 'add_post_taxonomy_restrict_filter', 10, 2 );


// function match_tax_rewrites_to_cpt( $wp_rewrite ) {
//   $pairs = array();

//   // Set up post type and taxonomy pairs.
//   foreach ( array( 'genre', 'ticket', 'labels' ) as $slug ) {
//     $post_type = get_post_type_object( $slug );
//     $taxonomy  = get_taxonomy( $slug . '_tax' );
//     if ( is_object( $post_type ) && is_object( $taxonomy ) ) {
//       $pairs[ $slug ] = array(
//         'post_type' => $post_type,
//         'taxonomy'  => $taxonomy
//       );
//     }
//   }

//   if ( ! empty( $pairs ) ) {
//     $rules = array();

//     // Loop through the pairs.
//     foreach ( $pairs as $slug => $objects ) {

//       // Check if taxonomy is registered for this custom type.
//       if ( ! empty( $tax_obj_type = $objects['taxonomy']->object_type[0] ) ) {
//         if ( $tax_obj_type == $slug ) {

//           // Term objects.
//           $terms = get_categories( array(
//             'type'       => $tax_obj_type,
//             'taxonomy'   => $objects['taxonomy']->name,
//             'hide_empty' => false
//           ));

//           // Build your rewrites.
//           foreach ( $terms as $term ) {
//             $rules[ "{$tax_obj_type}/{$term->slug}/?$" ] = add_query_arg( $term->taxonomy, $term->slug, 'index.php' );
//           }
//         }
//       }
//     }
//     // Merge the rewrites.
//     $wp_rewrite->rules = $rules + $wp_rewrite->rules;
//   }
// }
// add_action( 'generate_rewrite_rules', 'match_tax_rewrites_to_cpt' );


// ------------------------------------------------------------------------------


// 管理画面：イベント一覧の絞込検索に「一覧に掲載」チェックボックスを追加
// ------------------------------------------------------------------------------
add_filter('query_vars', function($vars){
    array_push($vars, 'in_list');
    return $vars;
});
add_filter('posts_where', function( $where ) {
    global $wpdb;
    if ( !is_admin() )
      return $where;

    $value = get_query_var('in_list');
    if ( !empty($value) ) {
			$value = 1;
      $where .= $wpdb->prepare("
         AND EXISTS (
         SELECT 'x'
         FROM {$wpdb->postmeta} as m
         WHERE m.post_id = {$wpdb->posts}.ID
         AND m.meta_key = 'in_list'
         AND m.meta_value like %s
        )",
        "%{$value}%"
      );
    }
    return $where;
});
// ------------------------------------------------------------------------------


// イベントを日程の種類でソート（multi:1 single:2 continue:3）
function cmpEvent( $a , $b){
	$cmp = strcmp( $a->limitType , $b->limitType ); //limitTypeを比較
	if( $cmp == 0 ){
		$cmp = strcmp( $a->menuOrder , $b->menuOrder ) ; //同じならmenu_orderを比較
	}
	return $cmp;
}

// イベントを日程の種類でソート（ついたちバージョン）（continue:1 multi:2 single:3）
function cmpEventFirstDay( $a , $b){
	$cmp = strcmp( $a->limitTypeFirstDay , $b->limitTypeFirstDay ); //limitTypeを比較
	if( $cmp == 0 ){
		$cmp = strcmp( $a->menuOrder , $b->menuOrder ) ; //同じならmenu_orderを比較
	}
	return $cmp;
}

// the_contentのmore前後を切り分けて出力
function get_the_divided_content( $more_link_text = null, $stripteaser = 0, $more_file = '' ) {
	$regex = '#(<p><span id="more-[\d]+"></span></p>|<span id="more-[\d]+"></span>)#';
	$content = get_the_content( $more_link_text, $stripteaser, $more_file );
	$content = apply_filters( 'the_content', $content );
	$content = str_replace( ']]>', ']]&gt;', $content );
	if ( preg_match( $regex, $content ) ) {
		list( $content_array['before'], $content_array['after'] ) = preg_split( $regex, $content, 2 );
	} else {
		$content_array['before'] = '';
		$content_array['after'] = $content;
	}
	return $content_array;
}

//スマホ、PCの振り分け
function check_device() {
	require_once "userAgent.php";
	$ua = new UserAgent();
	if($ua->set() === "mobile") {
		return 'mobile';
	}elseif($ua->set() === "tablet"){
		return 'tablet';
	}else{
		return 'pc';
	}
}

// RSSにカスタムポストを追加
function custom_post_rss_set( $query ) {
  if ( is_feed() ) {
      $post_type = $query->get( 'post_type' );
      if ( empty( $post_type ) ) {
          $query->set( 'post_type', array(
						'event', 'culture', 'journal', 'series'
					 ) );
      }
      return $query;
  }
}
add_filter( 'pre_get_posts', 'custom_post_rss_set' );

/*-------------------------------------------*/
/*  Repeater Field内をmeta_keyで検索するため、LIKEで検索
/*-------------------------------------------*/
// add_filter('posts_where', function ($where) {
//   $where = str_replace("meta_key = 'schedule_%", "meta_key LIKE 'schedule_%", $where);
//   return $where;
// });

function get_expire_array($first_day_formated){
  $expire_query_array = array();
  $expire_query_array['relation'] = 'OR';
  for ($i=0; $i < 31; $i++) {
    $expire_query_array[$i]['key'] = 'schedule_'.$i.'_date';
    $expire_query_array[$i]['value'] = $first_day_formated;
    $expire_query_array[$i]['compare'] = '>=';
  }
  return $expire_query_array;
}




// カスタムポストも検索対象にする
// ------------------------------------------------
function searchFilter($query) {
  if ($query->is_search && !is_admin()) {
    $query->set('post_type', array('post','page','event','culture','series','artist','journal','circle'));
    $query->set('post__not_in', array(51));
  }
return $query;
}
add_filter('pre_get_posts','searchFilter');


// カスタムフィールドも検索対象にする
// ------------------------------------------------
function posts_search_custom_fields( $orig_search, $query ) {
	if ( $query->is_search() && $query->is_main_query() ) {
		global $wpdb;
		$q = $query->query_vars;
		$n = ! empty( $q['exact'] ) ? '' : '%';
		$searchand = '';
		$search = '';

    if($q['s']){
      foreach ( $q['search_terms'] as $term ) {
        $include = '-' !== substr( $term, 0, 1 );
        if ( $include ) {
          $like_op  = 'LIKE';
          $andor_op = 'OR';
        } else {
          $like_op  = 'NOT LIKE';
          $andor_op = 'AND';
          $term     = substr( $term, 1 );
        }
        $like = $n . $wpdb->esc_like( $term ) . $n;
        // カスタムフィールド用の検索条件を追加します。
        $search .= $wpdb->prepare( "{$searchand}(($wpdb->posts.post_title $like_op %s) $andor_op ($wpdb->posts.post_content $like_op %s) $andor_op (custom.meta_value $like_op %s))", $like, $like, $like );
        $searchand = ' AND ';
      }
    }

		if ( ! empty( $search ) ) {
			$search = " AND ({$search}) ";
			if ( ! is_user_logged_in() )
				$search .= " AND ($wpdb->posts.post_password = '') ";
		}
		return $search;
	}
	else {
		return $orig_search;
	}
}
add_filter( 'posts_search', 'posts_search_custom_fields', 10, 2 );

function posts_join_custom_fields( $join, $query ) {	// カスタムフィールド検索用のJOIN
	if ( $query->is_search() && $query->is_main_query() ) {
		global $wpdb;
		$join .= " INNER JOIN ( ";
		$join .= " SELECT post_id, group_concat( meta_value separator ' ') AS meta_value FROM $wpdb->postmeta ";
		$join .= " GROUP BY post_id ";
		$join .= " ) AS custom ON ($wpdb->posts.ID = custom.post_id) ";
	}
	return $join;
}
add_filter( 'posts_join', 'posts_join_custom_fields', 10, 2 );
