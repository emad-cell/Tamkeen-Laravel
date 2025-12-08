<?php

namespace App\Enum;

enum PermissionEnum:string
{
    case ManageUsers = "manage_users";
    case ManageServices = "manage_services";
    case ManageJops="manage_jops";
    case RequestService= "request_service";
    case AddSuccessStory = "add_success_story";
    case ManageSuccessStory = "manage_success_story";
}
