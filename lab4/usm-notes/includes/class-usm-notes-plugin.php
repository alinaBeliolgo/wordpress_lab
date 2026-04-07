<?php

if (!defined('ABSPATH')) {
	exit;
}

class USM_Notes
{
	/**
	 * Plugin initialization: register hooks and shortcodes.
	 */
	public function init()
	{
		add_action('init', [$this, 'usm_register_notes']);
		add_action('init', [$this, 'usm_register_priority_taxonomy']);
		add_action('add_meta_boxes', [$this, 'usm_add_note_meta_box']);
		add_action('save_post', [$this, 'usm_save_note_meta'], 10, 2);
		add_filter('the_content', [$this, 'usm_display_due_date']);
		add_filter('manage_usm_note_posts_columns', [$this, 'usm_add_due_date_column']);
		add_action('manage_usm_note_posts_custom_column', [$this, 'usm_show_due_date_column'], 10, 2);
		add_shortcode('usm_notes', [$this, 'usm_notes_shortcode']);
		add_action('wp_head', [$this, 'usm_notes_styles']);
	}

	public function usm_register_notes()
	{
		$labels = array(
			'name' => 'Notes',
			'singular_name' => 'Note',
			'add_new' => 'Add New Note',
			'add_new_item' => 'Add New Note',
			'edit_item' => 'Edit Note',
			'all_items' => 'All Notes',
			'view_item' => 'View Note',
			'search_items' => 'Search Notes',
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => true,
			'supports' => array('title', 'editor', 'author', 'thumbnail'),
			'menu_icon' => 'dashicons-welcome-write-blog',
		);

		register_post_type('usm_note', $args);
	}

	public function usm_register_priority_taxonomy()
	{
		$labels = array(
			'name' => 'Priorities',
			'singular_name' => 'Priority',
			'search_items' => 'Search Priorities',
			'all_items' => 'All Priorities',
			'edit_item' => 'Edit Priority',
			'update_item' => 'Update Priority',
			'add_new_item' => 'Add New Priority',
			'new_item_name' => 'New Priority Name',
			'menu_name' => 'Priorities',
		);

		$args = array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_admin_column' => true,
			'rewrite' => array('slug' => 'priority'),
		);

		register_taxonomy('usm_priority', array('usm_note'), $args);
	}

	public function usm_add_note_meta_box()
	{
		add_meta_box(
			'usm_due_date',
			__('Due Date', 'usm-plugin'),
			[$this, 'usm_render_due_date_meta_box'],
			'usm_note',
			'side',
			'default'
		);
	}

	public function usm_render_due_date_meta_box($post)
	{
		$due_date = get_post_meta($post->ID, '_usm_due_date', true);

		wp_nonce_field('usm_save_due_date', 'usm_due_date_nonce');

		echo '<label for="usm_due_date">Дата напоминания:</label>';
		echo '<input type="date" id="usm_due_date" name="usm_due_date" value="' . esc_attr($due_date) . '" required />';
	}

	public function usm_save_note_meta($post_id, $post)
	{
		if (!isset($_POST['usm_due_date_nonce']) || !wp_verify_nonce($_POST['usm_due_date_nonce'], 'usm_save_due_date')) {
			return;
		}

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		if ($post->post_type !== 'usm_note') {
			return;
		}

		if (!current_user_can('edit_post', $post_id)) {
			return;
		}

		if (isset($_POST['usm_due_date'])) {
			$due_date = sanitize_text_field($_POST['usm_due_date']);

			if ($due_date < date('Y-m-d')) {
				return;
			}

			update_post_meta($post_id, '_usm_due_date', $due_date);
			return;
		}

		delete_post_meta($post_id, '_usm_due_date');
	}

	public function usm_display_due_date($content)
	{
		if (is_singular('usm_note')) {
			$due_date = get_post_meta(get_the_ID(), '_usm_due_date', true);

			if ($due_date) {
				$content .= '<p><strong>Дата напоминания:</strong> ' . esc_html($due_date) . '</p>';
			}
		}

		return $content;
	}

	public function usm_add_due_date_column($columns)
	{
		$columns['usm_due_date'] = 'Due Date';

		return $columns;
	}

	public function usm_show_due_date_column($column, $post_id)
	{
		if ($column === 'usm_due_date') {
			echo esc_html(get_post_meta($post_id, '_usm_due_date', true));
		}
	}

	public function usm_notes_shortcode($atts)
	{
		$atts = shortcode_atts(array(
			'priority' => '',
			'before_date' => '',
		), $atts);

		$args = array(
			'post_type' => 'usm_note',
			'posts_per_page' => -1,
		);

		if ($atts['priority']) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'usm_priority',
					'field' => 'slug',
					'terms' => $atts['priority'],
				),
			);
		}

		if ($atts['before_date']) {
			$args['meta_query'] = array(
				array(
					'key' => '_usm_due_date',
					'value' => $atts['before_date'],
					'compare' => '<=',
					'type' => 'DATE',
				),
			);
		}

		$query = new WP_Query($args);
		$output = '';

		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();

				$output .= '<div class="usm-note">';
				$output .= '<h2>' . get_the_title() . '</h2>';
				$output .= '<div>' . get_the_content() . '</div>';

				$due_date = get_post_meta(get_the_ID(), '_usm_due_date', true);
				if ($due_date) {
					$output .= '<p class="usm-note-date"><strong>Дата напоминания:</strong> ' . esc_html($due_date) . '</p>';
				}

				$output .= '</div>';
			}

			wp_reset_postdata();
		} else {
			$output = 'Нет заметок с заданными параметрами';
		}

		return $output;
	}

	public function usm_notes_styles()
	{
		echo '<style>
			.usm-note {
				border: 1px solid #ccc;
				padding: 10px;
				margin-bottom: 10px;
			}
			.usm-note h2 {
				margin-top: 0;
			}
		</style>';
	}
}
