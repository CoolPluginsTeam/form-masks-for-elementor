jQuery(document).ready(function () {
    function addCoolformAdmingPageToElementor() {
        let $elementorEditorPage = jQuery('.wp-submenu a[href="admin.php?page=elementor"]').closest('li');
        if (!$elementorEditorPage.length) {
            return;
        }

        let $submenu = $elementorEditorPage.closest('ul.wp-submenu');
        if (!$submenu.length) {
            return;
        }

        $submenu.find('.cool-formkit-page-list').remove();

        let $coolFormkitItem = jQuery('<li class="cool-formkit-page-list"><a href="admin.php?page=cool-formkit">Cool Formkit</a></li>');


        if($submenu.find('a[href="admin.php?page=elementor-one-upgrade"]').length > 0){

            $elementorEditorPage.after($coolFormkitItem)            
        }else{

            $submenu.append($coolFormkitItem);
        }

    }

    addCoolformAdmingPageToElementor();

    document.addEventListener('cfkef_dashboard_toggle:settings:changed', function (e) {
        addCoolformAdmingPageToElementor()
    });
});
