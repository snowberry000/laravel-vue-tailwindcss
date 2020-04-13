<?php
return [
    'Admin' => [
        ['route' => 'home', 'label' => 'Dashboard'],
        ['route' => 'admin.payouts', 'label' => 'Payouts'],
        ['route' => 'admin.videos', 'label' => 'Video Approval'],
        //['route' => 'home', 'label' => 'Downloads'],
        //['route' => 'home', 'label' => 'Contributors'],
    ],
    'Contributor' => [
        ['route' => 'home', 'label' => 'Dashboard'],
        ['route' => 'downloads.show', 'label' => 'Downloads'],
    ],
];