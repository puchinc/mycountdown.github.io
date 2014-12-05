<?php
/*
  Plugin Name: Archives
  Plugin URI: http://red-sky.pl/
  Description: Displays Archives list
  Author: Red-Sky
  Version: 1
  Author URI: http://red-sky.pl/
 */

class ArchivesWidget extends WP_Widget {

    function ArchivesWidget() {
        $widget_ops = array('classname' => 'ArchivesWidget', 'description' => 'Displays archives list');
        $this->WP_Widget('ArchivesWidget', '[MyCountdown] Archives', $widget_ops);
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => 'Archives'));
        $title = $instance['title'];
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','mycountdown');?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="title" value="<?php echo esc_attr($title); ?>" /></label></p>
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        return $instance;
    }

    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        $title = empty($instance['title']) ? 'Archives' : $instance['title'];
        $nr_posts = empty($instance['nr_posts']) ? 5 : $instance['nr_posts'];
        echo $before_widget;
        ?>
        <div class="sidebar_title sidebar_color_2"><?php echo $title ?></div>
        <ul class="sidebar_list">
            <?php wp_get_archives("title_li=", 'type=monthly'); ?>
        </ul>
        <?php
        echo $after_widget;
    }

}

add_action('widgets_init', create_function('', 'return register_widget("ArchivesWidget");'));