<?php

  if (!defined("WP_UNINSTALL_PLUGIN")) {
    exit();
  }

  $option_username = "reach_login_email";
  $option_password = "reach_login_password";

  delete_option( $option_username );
  delete_option( $option_password );

 ?>
