<?php
/*
  Plugin Name: Categories
  Plugin URI: http://red-sky.pl/
  Description: Displays Categories list
  Author: Red-Sky
  Version: 1
  Author URI: http://red-sky.pl/
 */

class CategoriesWidget extends WP_Widget {

    function CategoriesWidget() {
        $widget_ops = array('classname' => 'CategoriesWidget', 'description' => 'Displays categories list');
        $this->WP_Widget('CategoriesWidget', '[MyCountdown] Categories', $widget_ops);
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => 'Categories'));
        $title = $instance['title'];
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="title" value="<?php echo esc_attr($title); ?>" /></label></p>
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        return $instance;
    }

    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        $title = empty($instance['title']) ? 'Categories' : $instance['title'];
        $nr_posts = empty($instance['nr_posts']) ? 5 : $instance['nr_posts'];
        echo $before_widget;
        ?>
        <div class="sidebar_title sidebar_color_1"><?php echo $title ?></div>
        <ul class="sidebar_list">
            <?php wp_list_categories("title_li=&depth=1"); ?>
        </ul>
        <?php
        echo $after_widget;
    }
}

add_action('widgets_init', create_function('', 'return register_widget("CategoriesWidget");'));