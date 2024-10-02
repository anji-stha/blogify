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

// .. After imports init TinyMCE ..
window.addEventListener("DOMContentLoaded", () => {
    tinymce.init({
        selector: "textarea#editor",

        /* TinyMCE configuration options */
        skin: false,
        content_css: false,
        plugins: "advlist autolink link image lists code",
        toolbar:
            "undo redo | styleselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image",
    });
});
