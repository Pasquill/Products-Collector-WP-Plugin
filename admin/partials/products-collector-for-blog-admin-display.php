<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/Pasquill
 * @since      1.0.0
 *
 * @package    Products_Collector_For_Blog
 * @subpackage Products_Collector_For_Blog/admin/partials
 */
?>

<form method="post" action="options.php">

    <?php
    $options = get_option( $this->plugin_name );

    $endpoint = $options['endpoint'];
    $ck = $options['ck'];
    $cs = $options['cs'];
    $cron = ( isset( $options['cron'] ) ) ? $options['cron'] : null;
    $css = ( isset( $options['css'] ) ) ? true : false;

    settings_fields( $this->plugin_name );
    do_settings_sections( $this->plugin_name );
    ?>

    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

    <fieldset>
        <legend class="screen-reader-text"><span><?php _e( 'Endpoint address', $this->plugin_name ); ?></span></legend>
        <label for="<?php echo $this->plugin_name; ?>-endpoint">
            <span><?php esc_attr_e( 'Endpoint address', $this->plugin_name ); ?></span>
        </label>
        <input type="text"
                class="regular-text" id="<?php echo $this->plugin_name; ?>-endpoint"
                name="<?php echo $this->plugin_name; ?>[endpoint]"
                value="<?php if( !empty( $endpoint ) ) esc_attr_e( $endpoint, $this->plugin_name ); ?>"
                placeholder="<?php esc_attr_e( 'Endpoint address', $this->plugin_name ); ?>"
        />
    </fieldset>

    <fieldset>
        <legend class="screen-reader-text"><span><?php _e( 'Consumer key', $this->plugin_name ); ?></span></legend>
        <label for="<?php echo $this->plugin_name; ?>-ck">
            <span><?php esc_attr_e( 'Consumer key', $this->plugin_name ); ?></span>
        </label>
        <input type="password"
                class="regular-text" id="<?php echo $this->plugin_name; ?>-ck"
                name="<?php echo $this->plugin_name; ?>[ck]"
                value="<?php if( !empty( $ck ) ) esc_attr_e( $ck, $this->plugin_name ); ?>"
                placeholder="<?php esc_attr_e( 'Consumer key', $this->plugin_name ); ?>"
        />
    </fieldset>

    <fieldset>
        <legend class="screen-reader-text"><span><?php _e( 'Consumer secret', $this->plugin_name ); ?></span></legend>
        <label for="<?php echo $this->plugin_name; ?>-cs">
            <span><?php esc_attr_e( 'Consumer secret', $this->plugin_name ); ?></span>
        </label>
        <input type="password"
                class="regular-text" id="<?php echo $this->plugin_name; ?>-cs"
                name="<?php echo $this->plugin_name; ?>[cs]"
                value="<?php if( !empty( $cs ) ) esc_attr_e( $cs, $this->plugin_name ); ?>"
                placeholder="<?php esc_attr_e( 'Consumer secret', $this->plugin_name ); ?>"
        />
    </fieldset>

    <fieldset>
        <legend class="screen-reader-text"><span><?php _e( 'Set schedule to retrieve updated data', $this->plugin_name ); ?></span></legend>
        <label for="<?php echo $this->plugin_name; ?>-cron">
            <span><?php esc_attr_e( 'Set schedule to retrieve updated data', $this->plugin_name ); ?></span>
        </label>
        <select id="<?php echo $this->plugin_name; ?>-cron" name="<?php echo $this->plugin_name; ?>[cron]">
            <option><?php _e( 'Disable', $this->plugin_name ); ?></option>
            <option value="Daily"><?php _e( 'Daily', $this->plugin_name ); ?></option>
            <option value="Weekly"><?php _e( 'Weekly', $this->plugin_name ); ?></option>
            <option value="Monthly"><?php _e( 'Monthly', $this->plugin_name ); ?></option>
        </select>
    </fieldset>

    <fieldset>
        <legend class="screen-reader-text"><span><?php _e( 'Use plugin css', $this->plugin_name ); ?></span></legend>
        <label for="<?php echo $this->plugin_name; ?>-css">
            <span><?php esc_attr_e( 'Use plugin css', $this->plugin_name ); ?></span>
        </label>
        <input type="checkbox"
                id="<?php echo $this->plugin_name; ?>-css"
                name="<?php echo $this->plugin_name; ?>[css]"
                <?php if( !!$css ) { echo 'checked'; } ?>
        >
    </fieldset>

    <?php submit_button( __( 'Save all changes', $this->plugin_name), 'primary','submit', TRUE ); ?>

</form>
