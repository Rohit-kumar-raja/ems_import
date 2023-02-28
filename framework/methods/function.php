<?php

// project name into the Server due to url management and for absolute path of the url 
// if the project on directly on public_html and htdoc folder please do not write any kind of project name
$get_directory = explode('/', __DIR__);
$lastKey = key(array_slice($get_directory, -3, 1, true));
$project_name = $get_directory[$lastKey];

function image_url($location_of_image = '')
{
    global $get_directory;
    global $project_name;
    $image_key = key(array_slice($get_directory, -4, 1, true));
    return '/'.$get_directory[$image_key] . '/' . $project_name . 'images/' . $location_of_image;
}


function url($url)
{
    global $project_name;
    if ($_SERVER['HTTP_HOST'] == 'localhost') {
        return 'http://localhost/' . 'cmp/nsucms-aws' . '/' . $url;
    } else {
        return 'https://' . $_SERVER['HTTP_HOST'] . '/' . '' . $project_name . '/' . $url;
    }
}

function redirect($url)
{
    echo ' <script>
    setTimeout(function(){
window.location.replace("' . url($url) . '")
    },500);
</script>';
}

function reload($reload_time_second = 3)
{
    echo ' <script>
    setTimeout(function(){
window.location.replace("' . $_SERVER['HTTP_REFERER'] . '")
    },' . $reload_time_second . '000);
</script>';
}

// added new
