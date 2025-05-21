<?php
if (!defined('ABSPATH')) {
    exit;
}

class ASWC_Admin {
    var $countries;
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        $this->countries = new WC_Countries();
    }

    public function add_admin_menu() {
        add_submenu_page(
            'woocommerce',
            __('Algeria States Settings', 'algeria-states-wc'),
            __('Algeria States', 'algeria-states-wc'),
            'manage_woocommerce',
            'algeria-states-wc',
            array($this, 'settings_page')
        );
    }

    public function register_settings() {
        register_setting('aswc_options', 'aswc_show_postal_code');
        register_setting('aswc_options', 'aswc_default_language');
        register_setting('aswc_options', 'aswc_default_fields');

        add_settings_section(
            'aswc_general_section',
            __('General Settings', 'algeria-states-wc'),
            null,
            'algeria-states-wc'
        );

        add_settings_field(
            'aswc_show_postal_code',
            __('Show Postal Code', 'algeria-states-wc'),
            array($this, 'show_postal_code_callback'),
            'algeria-states-wc',
            'aswc_general_section'
        );

        add_settings_field(
            'aswc_default_language',
            __('Default Language', 'algeria-states-wc'),
            array($this, 'default_language_callback'),
            'algeria-states-wc',
            'aswc_general_section'
        );
        add_settings_field(
            'aswc_default_fields',
            __('Support us', 'algeria-states-wc'),
            array($this, 'aswc_default_fields_callback'),
            'algeria-states-wc',
            'aswc_general_section'
        );
    }

    public function settings_page() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html__('Algeria States Settings', 'algeria-states-wc'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('aswc_options');
                do_settings_sections('algeria-states-wc');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function show_postal_code_callback() {
        $value = get_option('aswc_show_postal_code', 'yes');
        ?>
        <select name="aswc_show_postal_code">
            <option value="yes" <?php selected($value, 'yes'); ?>>
                <?php esc_html_e('Yes', 'algeria-states-wc'); ?>
            </option>
            <option value="no" <?php selected($value, 'no'); ?>>
                <?php esc_html_e('No', 'algeria-states-wc'); ?>
            </option>
        </select>
        <?php
    }

    public function default_language_callback() {
        $value = get_option('aswc_default_language', 'en');
        ?>
        <select name="aswc_default_language">
            <option value="en" <?php selected($value, 'en'); ?>>
                <?php esc_html_e('English', 'algeria-states-wc'); ?>
            </option>
            <option value="fr" <?php selected($value, 'fr'); ?>>
                <?php esc_html_e('French', 'algeria-states-wc'); ?>
            </option>
            <option value="ar" <?php selected($value, 'ar'); ?>>
                <?php esc_html_e('Arabic', 'algeria-states-wc'); ?>
            </option>
        </select>
        <?php
    }

    public function aswc_default_fields_callback() {
        ?>
        <div>
            <?php echo esc_html__('We hope you will support us by donating to us via my BaridiMob: 00799999001143517007', 'algeria-states-wc'); ?>          
        </div>
        <?php
    }
}