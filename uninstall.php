<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Clean up any plugin data if needed
// For example, delete any options or transients
delete_option('aswc_version');