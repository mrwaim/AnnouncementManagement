@include('elements.side-menu-parent-item', [
'folder' => 'announcement-management',
'menu' => $auth->admin ? 'Announcement' : 'Announcements',
'menuIcon' => 'fa-volume-up',
'url' => 'list',
'menuId' => 'announcement_menu',
])