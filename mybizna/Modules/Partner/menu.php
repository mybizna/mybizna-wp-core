<?php

$this->add_module_info("partner", [
    'title' => 'Partner',
    'description' => 'Partner',
    'icon' => 'fas fa-store',
    'path' => '/partner/admin/partner',
    'class_str' => 'text-info border-info',
    'position' => 2,
]);

$this->add_menu("partner", "partner", "Partners", "/partner/admin/partner", "fas fa-cogs", 5);
