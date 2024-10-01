<?php
echo "<ul class='pagination pull-left margin-zero mt0'>";
if($page>1){
    $prev_page = $page - 1;
    echo "<li>
        <a href='{$page_url}page={$prev_page}'>
            <span style='margin:0 .5em;'>«</span>
        </a>
    </li>";
}
$total_pages = ceil($total_rows / $records_per_page);
$range = 1;
$initial_num = $page - $range;
$condition_limit_num = ($page + $range)  + 1;
for ($x=$initial_num; $x<$condition_limit_num; $x++) {
    if (($x > 0) && ($x <= $total_pages)) {
        if ($x == $page) {
            echo "<li class='active'>
                <a href='javascript::void();'>{$x}</a>
            </li>";
        }
        else {
            echo "<li>
                <a href='{$page_url}page={$x}'>{$x}</a> 
            </li>";
        }
    }
}

if($page<$total_pages){
    $next_page = $page + 1;
    echo "<li>
        <a href='{$page_url}page={$next_page}'>
            <span style='margin:0 .5em;'>»</span>
        </a>
    </li>";
}
echo "</ul>";
?>