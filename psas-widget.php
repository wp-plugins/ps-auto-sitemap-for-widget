<?php

/*
  Plugin Name: PS AUTO SITEMAP for Widget
  Version: 0.1
  Description: Display a sitemap that was created in PS AUTO SITEMAP.
  Author: YANO Yasuhiro
  Author URI: https://plus.google.com/u/0/+YANOYasuhiro/
  Plugin URI: PLUGIN SITE HERE
  Text Domain: psas-widget
  Domain Path: /languages
 */
add_action(
		'widgets_init', create_function( '', 'return register_widget("PSAS_Widget");' )
);

//  Description: PS AUTO SITEMAPで作成されたサイトマップをウィジットに表示する


class PSAS_Widget extends WP_Widget {

	const TEXT_DOMAIN = 'psas-widget';

	function __construct() {

		$widget_ops = array( 'description' => __( 'Display a sitemap that was created in PS AUTO SITEMAP.', TEXT_DOMAIN ) );
		$control_ops = array( 'width' => 400, 'height' => 350 );
		parent::__construct(
				false, 'SITEMAP', $widget_ops, $control_ops
		);
	}

	function form( $par ) {

		//タイトル
		if ( isset( $par['title'] ) && $par['title'] ) {
			$title = $par['title'];
		} else {
			$title = '';
		}

		$title_id = $this->get_field_id( 'title' );
		$title_name = $this->get_field_name( 'title' );

		echo '<p>';
		echo esc_html( __( 'Title :', TEXT_DOMAIN ) ) . '<br />';
		printf( '<input type="text" id="%s" name="%s" value="%s" class="widefat">', $title_id, $title_name, esc_attr( $title ) );
		echo '</p>';

		//URL
		if ( isset( $par['sitemap_url'] ) && $par['sitemap_url'] ) {
			$sitemap_url = $par['sitemap_url'];
		} else {
			$sitemap_url = '';
		}
		$url_id = $this->get_field_id( 'sitemap_url' );
		$url_name = $this->get_field_name( 'sitemap_url' );

		echo '<p>';
		echo esc_html( __( 'Sitemap page URL :', TEXT_DOMAIN ) ) . '<br />';
		printf( '<input type="text" id="%s" name="%s" value="%s" class="widefat">', $url_id, $url_name, esc_attr( $sitemap_url ) );
		echo '</p>';

		//文言
		if ( isset( $par['sitemap_word'] ) && $par['sitemap_word'] ) {
			$sitemap_url = $par['sitemap_word'];
		} else {
			$sitemap_url = '';
		}
		$word_id = $this->get_field_id( 'sitemap_word' );
		$word_name = $this->get_field_name( 'sitemap_word' );

		echo '<p>';
		echo esc_html( __( 'Message when there is none sitemap cache :', TEXT_DOMAIN ) ) . '<br />';
		printf( '<input type="text" id="%s" name="%s" value="%s" class="widefat">', $word_id, $word_name, esc_attr( $sitemap_word ) );
		echo '</p>';
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	function widget( $args, $par ) {

		$uploads = wp_upload_dir();
		$cache_file = $uploads['basedir'] . '/ps_auto_sitemap/site_map_cache.html';

		if ( file_exists( $cache_file ) ) {
			$html = file_get_contents( $cache_file );
		} else {
			$html = sprintf( '<a href="%s">%s</a>', esc_html( $par['sitemap_url'] ), esc_html( $par['sitemap_word'] ) );
		}

		echo $args['before_widget'];
		echo $args['before_title'];
		echo esc_html( $par['title'] );
		echo $args['after_title'];
		echo $html;
		echo $args['after_widget'];
	}

}
