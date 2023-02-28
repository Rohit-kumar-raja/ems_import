<?php
function success_alert($message)
{
    return '<div class="alert alert-success" role="alert">
   <b> <i class="fas fa-check-circle"></i> Success</b>' . $message . '
  </div>';
}

function danger_alert($message)
{
    return '<div class="alert alert-danger" role="alert">
   <b><i class="fas fa-times"></i> Error</b>' . $message . '
  </div>';
}

function warning_alert($message)
{
    return '<div class="alert alert-warning" role="alert">
   <b><i class="fas fa-exclamation-triangle"></i> Warning </b>' . $message . '
  </div>';
}
