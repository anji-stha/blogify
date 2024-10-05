import tinymce from "tinymce/tinymce";
import "tinymce/themes/silver/theme";
import "tinymce/icons/default";
import "tinymce/models/dom"; // Basic functionality
import "tinymce/plugins/advlist";
import "tinymce/plugins/autolink";
import "tinymce/plugins/link";
import "tinymce/plugins/image";
import "tinymce/plugins/lists";
import "tinymce/plugins/code";
import "tinymce/skins/ui/oxide/skin.js";
import 'tinymce/skins/ui/oxide/content.js';
import 'tinymce/skins/content/default/content.js';


window.addEventListener("DOMContentLoaded", () => {
    tinymce.init({
        selector: "textarea#editor",
        license_key: "gpl",
        skin: "oxide",
        skin_url: 'default',
        content_css: 'default',
        plugins: "advlist autolink link image lists code",
        toolbar:
            "undo redo | styleselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image",
    });
});
