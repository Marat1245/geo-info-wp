import { showListSelector } from './show_list_skils.js';
import { sortList } from './sort_list.js';
import { badgeManagement } from './badge_management.js';
import { deleteBadge } from './delete_badge.js';
import { addSkills } from './add_skills.js';
import { heightList } from './height_list.js';
$(document).ready(function () {
    showListSelector();
    sortList();
    badgeManagement();
    deleteBadge();
    addSkills();
    heightList();

});