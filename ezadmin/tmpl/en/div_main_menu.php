<?php
include 'config.inc';
global $classrooms_category_enabled;
global $recorders_category_enabled;

$threshold_num_options = 100; // The number of options in the sidebar above which we choose to collapse the categories together

// Each element is a category in the list; each element of the subarray
// is an entry in the category. Syntax: $options[category][webobject]=text (shown)
// IMPORTANT NOTE: webobjects ending in _list means the page is a list
// webobjects ending in _new are pages for creating new items
$options = array();
$options['Courses'] = array(
    array(
        'name' => 'Courses list', 
        'action' => 'view_courses'
        //'args' => array('table' => 'podcastcours_users_courses')
    ),
    array(
        'name' => 'Create course',
        'action' => 'create_course'
    )
);

$options['Users'] = array(
    array(
        'name' => 'User list',
        'action' => 'view_users'
    )
);

global $add_users_enabled;
if($add_users_enabled) {
    $options['Users']['create_user'] = array(
        'name' => 'Create user',
        'action' => 'create_user'
    );
}

if($classrooms_category_enabled) {
    $options['Classrooms'] = array(
        array(
            'name' => 'Classroom list',
            'action' => 'view_classrooms'
        ),
        array(
            'name' => 'Create classroom',
            'action' => 'create_classroom'
        )
    );
}

$options['EZadmin'] = array(
    array(
        'name' => 'Configure',
        'action' => 'edit_config'
    ),
    array(
        'name' => 'Edit admins',
        'action' => 'edit_admins'
    ),
    array(
        'name' => 'Admin activity history',
        'action' => 'view_logs'
    )
);

$options['Renderers'] = array(
    array(
        'name' => 'Job queue',
        'action' => 'view_queue'
    ),
    array(
        'name' => 'Renderers list',
        'action' => 'view_renderers'
    ),
    array(
        'name' => 'Create renderer',
        'action' => 'create_renderer'
    )
);

$options['Monitoring'] = array(
    array(
        'name' => 'Events list',
        'action' => 'view_events'
    ),
    array(
        'name' => 'Track Recording',
        'action' => 'view_track_asset'
    ),
    array(
        'name' => 'Record calendar',
        'action' => 'view_classroom_calendar'
    ),
    array(
        'name' => 'Errors calendar',
        'action' => 'view_event_calendar'
    )
);

$options['Stats'] = array(
    array(
       'name' => 'Discussions',
       'action' => 'view_stats_ezplayer_threads'
    ),
    array(
       'name' => 'Bookmarks and TOC',
       'action' => 'view_stats_ezplayer_bookmarks'
    ),
    array(
        'name' => 'Automated Report',
        'action' => 'view_report'
    )
);

// Each element is the translation in the destination language of the keyword used to reference the category in the above array.
// Used for display purposes only.
$category_names = array(
    'Courses' => 'Courses',
    'Classrooms' => 'Classrooms',
    'Recorders' => 'Recorders',
    'EZadmin' => 'EZadmin',
    'Stats' => 'Stats',
    'Users' => 'Users',
    'Renderers' => 'Rendering',
    'Monitoring' => 'Monitor'
);

?>

<div class="col-md-2 hidden-print">
<ul class="nav nav-list">
    <?php foreach($options as $cat => $suboptions) { ?>
        <li class="nav-header">
            <?php echo $category_names[$cat]; ?>
        </li>
        <?php $nb_options = count($options, COUNT_RECURSIVE) - count($options); ?>
        <?php foreach($suboptions as $option) { ?>
            <li <?php if($nb_options > $threshold_num_options) { echo 'style="display: none;"'; } ?> 
                class="sidebar <?php // TODO not work when no operation with input in this page
                if(isset($input) && isset($input['action']) && ($option['action'] == $input['action'])) {
                    echo ' active '; 
                } ?> ">
                
                <a href="index.php?&action=<?php echo $option['action'] ?>">
                    <?php echo $option['name']; ?>
                </a>
                
            </li>
            <?php
        } // end foreach?>
    <?php } // end foreach ?>
    <li class="nav-header" style="cursor: pointer;">Misc</li>
    <li class="sidebar" title="Push changes to recorders and manager"><a style="<?php echo (isset($_SESSION['changes_to_push']) && $_SESSION['changes_to_push']) ? 'color: #dd0000;' : ''; ?>" href="index.php?action=push_changes">Push changes</a></li>
    <li class="sidebar"><a href="index.php?action=sync_externals">Sync externals</a></li>
    <li class="sidebar"><a href="?<?php echo SID."&action=logout"?>">Log out</a></li>
</ul>
<!-- <a class="btn" style="margin-top: 10px; width: 80%;" href="?<?php echo SID."&action=logout"?>">Log out</a> -->
</div>
