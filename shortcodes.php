<?php

/*
 * MyCountdown Shortcodes
 */

//=============ABOUT PAGE=======================================================
//function about_column($atts, $content = null) {
//    return '<div class="span3">' . do_shortcode($content) . '</div>';
//}
//
//add_shortcode('about_column', 'about_column');

function about_sub_title( $atts, $content = null ) {
	return '<div class="about_us_sub_title">' . do_shortcode( $content ) . '</div>';
}

add_shortcode( 'about_subtitle', 'about_sub_title' );

//function service_column($atts, $content = null) {
//    return '<div class="span4">' . do_shortcode($content) . '</div><div class="span1">&nbsp;</div>';
//}
//
//add_shortcode('service_column', 'service_column');

function get_img( $atts, $content = null ) {
	extract( shortcode_atts( array(
				'caption' => ''
					), $atts ) );


	$args = array(
		'post_type' => 'attachment',
		'numberposts' => -1,
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'post_mime_type' => 'image',
		'post_status' => null,
		'post_parent' => get_the_ID()
	);
	$attachments = get_posts( $args );
	if ( $attachments ) {
		$attachment_link = '';
		foreach ( $attachments as $attachment ) {
			if ( $attachment->post_excerpt == $caption ) {
				$attachment_link = $attachment->guid;
				$got_attachment = true;
				break;
			}
		}
	}

	if ( isset( $got_attachment ) )
		return "<img src='{$attachment_link}' alt='" . get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ) . "' />";
	else
		return "<img src='' alt='image' />";
}

add_shortcode( 'img', 'get_img' );

function team_member( $atts, $content = null ) {
	extract( shortcode_atts( array(
				'img_caption' => '',
				'name' => '',
				'position' => ''
					), $atts ) );
	$img = do_shortcode( "[img caption='{$img_caption}']" );
	global $team_member_nr;
	$team_member_nr ++;
	global $team_member_order;
	$team_member_order = ($team_member_nr % 3) ? '' : ' last';
	$output = "<div class='column{$team_member_order}'>
    	<div class='column_image'>{$img}</div>
        <h5>{$name}</h5>
        <h6 class='color_{$team_member_nr}'>{$position}</h6>
        <p>" . do_shortcode( $content ) . "</p>
    </div>";
	return $output;
}

add_shortcode( 'team_member', 'team_member' );

function social_icons( $atts, $content = null ) {
	extract( shortcode_atts( array(
				'facebook' => '',
				'twitter' => '',
				'dribble' => '',
				'linkedin' => '',
				'gplus' => ''
					), $atts ) );
	$output = '';
	if ( $facebook != '' )
		$facebook_icon = "<a href='{$facebook}'><img class='tool_title' src='" . get_template_directory_uri() . "/images/social/facebook_icon.png' alt='facebook' data-original-title='Facebook'></a>";
	if ( $twitter != '' )
		$twitter_icon = "<a href='{$twitter}'><img class='tool_title' src='" . get_template_directory_uri() . "/images/social/twitter_icon.png' alt='twitter' data-original-title='Twitter'></a>";
	if ( $dribble != '' )
		$dribble_icon = "<a href='{$dribble}'><img class='tool_title' src='" . get_template_directory_uri() . "/images/social/dribble_icon.png' alt='dribble' data-original-title='Dribble'></a>";
	if ( $gplus != '' )
		$gplus_icon = "<a href='{$gplus}'><img class='tool_title' src='" . get_template_directory_uri() . "/images/social/google_icon.png' alt='twitter' data-original-title='Google+'></a>";
	if ( $linkedin != '' )
		$linkedin_icon = "<a href='{$linkedin}'><img class='tool_title' src='" . get_template_directory_uri() . "/images/social/linkedin_icon.png' alt='twitter' data-original-title='LinkedIn'></a>";
	$output = @$facebook_icon . @$twitter_icon . @$dribble_icon . @$linkedin_icon . @$gplus_icon;
	return $output;
}

add_shortcode( 'social_icons', 'social_icons' );

function title( $atts, $content = null ) {
	return "<div class='section_title'>" . do_shortcode( $content ) . "</div>";
}

add_shortcode( 'title', 'title' );

//==========================================Headings============================
function h1( $atts, $content = null ) {
	return "<h1>" . do_shortcode( $content ) . "</h1>";
}

add_shortcode( 'h1', 'h1' );

function h2( $atts, $content = null ) {
	return "<h2>" . do_shortcode( $content ) . "</h2>";
}

add_shortcode( 'h2', 'h2' );

function h3( $atts, $content = null ) {
	return "<h3>" . do_shortcode( $content ) . "</h3>";
}

add_shortcode( 'h3', 'h3' );

function h4( $atts, $content = null ) {
	return "<h4>" . do_shortcode( $content ) . "</h4>";
}

add_shortcode( 'h4', 'h4' );

function h5( $atts, $content = null ) {
	return "<h5>" . do_shortcode( $content ) . "</h5>";
}

add_shortcode( 'h5', 'h5' );

function h6( $atts, $content = null ) {
	return "<h6>" . do_shortcode( $content ) . "</h6>";
}

add_shortcode( 'h6', 'h6' );

//==============Html styles=====================================================
function italic( $atts, $content = null ) {
	return "<i>" . do_shortcode( $content ) . "</i>";
}

add_shortcode( 'i', 'italic' );

function bold( $atts, $content = null ) {
	return "<b>" . do_shortcode( $content ) . "</b>";
}

add_shortcode( 'b', 'bold' );

function border( $atts, $content = null ) {
	return "<div class='content_border'></div>";
}

add_shortcode( 'border', 'border' );

//==========================testimonials========================================
function testimonial( $atts, $content = null ) {
	extract( shortcode_atts( array(
				'author' => '',
				'company' => ''
					), $atts ) );
	$output = "<div class='testimonial'><p>" . do_shortcode( $content ) . "</p></div>";
	return $output;
}

add_shortcode( 'testimonial', 'testimonial' );

function blockquote( $atts, $content = null ) {
	extract( shortcode_atts( array(
				'author' => '',
				'company' => ''
					), $atts ) );
	$output = "<div class='blackquote2'><p>" . do_shortcode( $content ) . "</p>";
	if ( $author != '' )
		$output .= "<div class='bq_author'>{$author}&nbsp;/&nbsp;{$company}</div>";
	$output .= "</div>";
	return $output;
}

add_shortcode( 'blockquote', 'blockquote' );

//==========================columns=============================================
function row( $atts, $content = null ) {

	return "<div class='row'>" . do_shortcode( $content ) . "</div>";
}

add_shortcode( 'row', 'row' );

function hr( $atts, $content = null ) {

	return "<hr>";
}

add_shortcode( 'hr', 'hr' );

function column( $atts, $content = null ) {
	extract( shortcode_atts( array(
				'size' => '6'
					), $atts ) );
	$output = "<div class='span{$size}'>" . do_shortcode( $content ) . "</div>";
	return $output;
}

add_shortcode( 'column', 'column' );

function alert( $atts, $content = null ) {
	extract( shortcode_atts( array(
				'type' => 'info'
					), $atts ) );
	$output = "<div class=''>
                        <div class='alert alert-{$type}'>
                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                            " . do_shortcode( $content ) . "
                        </div>
                    </div>";
	return $output;
}

add_shortcode( 'alert', 'alert' );

function button( $atts, $content = null ) {
	extract( shortcode_atts( array(
				'size' => '',
				'type' => '',
				'link' => '#'
					), $atts ) );
	$content = ($content == null) ? 'Button' : $content;
	$output = "<a href='{$link}' class='btn btn-{$size} btn-{$type}'>" . do_shortcode( $content ) . "</a>";
	return $output;
}

add_shortcode( 'button', 'button' );

function icon( $atts, $content = null ) {
	extract( shortcode_atts( array(
				'type' => ''
					), $atts ) );
	$output = "<i class='icon-{$type}'></i>";
	return $output;
}

add_shortcode( 'icon', 'icon' );

//=================Accordion====================================================
function accordion( $atts, $content = null ) {
	extract( shortcode_atts( array(
					), $atts ) );
	global $tab_nr;
	$tab_nr = 0;
	$output = '<div class="accordion" id="accordion">' . do_shortcode( $content ) . '</div>';
	return $output;
}

add_shortcode( 'accordion', 'accordion' );

function accordion_group( $atts, $content = null ) {
	extract( shortcode_atts( array(
				'header' => ''
					), $atts ) );
	global $tab_nr;
	$tab_nr ++;
	$height = ($tab_nr == 1 ) ? 'auto' : '0';
	$collapse = ($tab_nr == 1 ) ? 'in ' : '';
	$output = '<div class="accordion-group"><div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse' . $tab_nr . '">' . $header . '</a></div>
                                            <div id="collapse' . $tab_nr . '" class="accordion-body ' . $collapse . 'collapse" style="height:' . $height . '; ">
                                                <div class="accordion-inner">' . do_shortcode( $content ) . '</div>
                                            </div>
                                        </div>';
	return $output;
}

add_shortcode( 'accordion_tab', 'accordion_group' );

//function tabs($atts, $content = null) {
//    extract(shortcode_atts(array(
//                    ), $atts));
//    global $tab_nr;
//    $tab_nr = 0;
//    $output = '<div class="accordion" id="accordion">' . do_shortcode($content) . '</div>';
//    return $output;
//}
//
//add_shortcode('tabs', 'tabs');
//
//function tab($atts, $content = null) {
//    extract(shortcode_atts(array(
//                'header' => ''
//                    ), $atts));
//    global $tab_nr;
//    $tab_nr++;
//    $height = ($tab_nr == 1 ) ? 'auto' : '0';
//    $collapse = ($tab_nr == 1 ) ? 'in ' : '';
//    $output = '';
//    return $output;
//}
//
//add_shortcode('tab', 'tab');
// Twitter Bootstrap Tabs
add_shortcode( 'tabgroup', 'tabgroup' );

function tabgroup( $atts, $content ) {
	$GLOBALS[ 'tab_count' ] = 0;

	do_shortcode( $content );

	if ( is_array( $GLOBALS[ 'tabs' ] ) ) {
		foreach ( $GLOBALS[ 'tabs' ] as $tab ) {
			$tabs[ ] = '<li class="' . $tab[ 'state' ] . '"><a href="#' . $tab[ 'title' ] . '" data-toggle="tab">' . $tab[ 'title' ] . '</a></li>';
			$panes[ ] = '<div id="' . $tab[ 'title' ] . '" class="tab-pane fade ' . $tab[ 'state' ] . '"><p>' . $tab[ 'content' ] . '</p></div>';
		}
		$return = '<ul class="nav nav-tabs">'
				. implode( "\n", $tabs ) .
				'</ul>
                  <div class="tab-content">'
				. implode( "\n", $panes ) .
				'</div>';
	}
	return $return;
}

add_shortcode( 'tab', 'tabs' );

function tabs( $atts, $content ) {
	extract( shortcode_atts( array(
				'title' => '',
				'state' => ''
					), $atts ) );

	$x = $GLOBALS[ 'tab_count' ];
	$GLOBALS[ 'tabs' ][ $x ] = array( 'title' => $title, 'state' => $state, 'content' => $content );

	$GLOBALS[ 'tab_count' ] ++;
}

//progress bars
function progress_bar( $atts, $content = null ) {
	extract( shortcode_atts( array(
				'type' => '',
				'value' => ''
					), $atts ) );
	$output = "<div class='bar bar-{$type}' style='width: {$value}%;'>" . do_shortcode( $content ) . "</div>";
	return $output;
}

add_shortcode( 'progress_bar', 'progress_bar' );

function progress_bars( $atts, $content = null ) {
	extract( shortcode_atts( array(
				'type' => '',
				'animated' => ''
					), $atts ) );
	$output = "<div class='progress progress-{$type} {$animated}'>" . do_shortcode( $content ) . "</div>";
	return $output;
}

add_shortcode( 'progress_bars', 'progress_bars' );

function pricing_table( $atts, $content = null ) {
	extract( shortcode_atts( array(
				'title' => 'Basic',
				'price' => '',
				'price_text' => '$/mo',
				'button_text' => 'Order Now',
				'link' => '#'
					), $atts ) );
	$output = "<div class='pricing_table'>
                            <div class='pricing_table_title'>{$title}</div>
                            " . do_shortcode( $content ) . "
                            <div class='pricing_table_line price'><span>{$price}</span>{$price_text}</div>
                            <div class='pricing_table_line_last last_line'><a class='button' href='{$link}'>{$button_text}</a></div>
                        </div>";
	return $output;
}

add_shortcode( 'pricing_table', 'pricing_table' );

function pricing_line( $atts, $content = null ) {
	$output = "<div class='pricing_table_line'>" . do_shortcode( $content ) . "</div>";
	return $output;
}

add_shortcode( 'pricing_line', 'pricing_line' );

//==========single project=======================
function project_title( $atts, $content = null ) {
	$output = "<h5 class='mini_title'>" . do_shortcode( $content ) . "</h5>";
	return $output;
}

add_shortcode( 'project_title', 'project_title' );

function project_detail( $atts, $content = null ) {
	extract( shortcode_atts( array(
				'title' => 'Project Details'
					), $atts ) );
	$details = explode( ",", $content );
	$output = "<h5 class='mini_title'>" . do_shortcode( $title ) . "</h5><ul class='project_tech'>";
	foreach ( $details as $detail ) {
		$output.="<li>{$detail}</li>";
	}
	return $output . "</ul>";
}

add_shortcode( 'project_detail', 'project_detail' );

function project_link( $atts, $content = null ) {
	extract( shortcode_atts( array(
				'to' => '#'
					), $atts ) );
	$output = "<div class='project_link'><a href='{$to}' class='button'>" . do_shortcode( $content ) . "</a></div>";
	return $output;
}

add_shortcode( 'project_link', 'project_link' );

function custom_link( $atts, $content = null ) {
	extract( shortcode_atts( array(
				'to' => '#'
					), $atts ) );
	$output = "<a href='{$to}'>" . do_shortcode( $content ) . "</a>";
	return $output;
}

add_shortcode( 'custom_link', 'custom_link' );

function slider( $atts, $content = null ) {
	extract( shortcode_atts( array(
				'caption' => '',
				'description' => 'false'
					), $atts ) );
	$output = "<div class='slider'>
                <div class='rs_mainslider'>
                    <ul class='rs_mainslider_items'>";

	$args = array(
		'post_type' => 'attachment',
		'numberposts' => -1,
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'post_mime_type' => 'image',
		'post_status' => null
	);

	$attachments = get_posts( $args );
	if ( $attachments ) {
		$i = 1;
		foreach ( $attachments as $attachment ) {
			if ( $attachment->post_excerpt == $caption ) {
				$active = ( $i == 1 ) ? 'class="rs_mainslider_items_active"' : '';
				$descr = ( $description == 'false') ? '' : "<br /><span>" . $attachment->post_content . "</span>";
				$output .="
                                            <li " . $active . ">
                                                <img class='rs_mainslider_items_image' src=" . $attachment->guid . " />
                                                <div class='rs_mainslider_items_text'>
                                                        <span>" . $attachment->post_title . "</span>
                                                            " . $descr . "
                                                </div>
                                            </li>";
				$i ++;
			}
		}
	}

	$output .= "</ul>
                    <div class='rs_mainslider_left_container rs_center_vertical_container'>
                        <div class='rs_mainslider_left rs_center_vertical'></div>
                    </div>
                    <div class='rs_mainslider_right_container rs_center_vertical_container'>
                        <div class='rs_mainslider_right rs_center_vertical'></div>
                    </div>
                    <div class='rs_mainslider_dots_container rs_center_horizontal_container'>
                        <ul class='rs_mainslider_dots rs_center_horizontal'>
                        </ul>
                    </div>
                </div>
            </div>";
	return $output;
}

add_shortcode( 'slider', 'slider' );
?>
