(function ($) {
    "use strict";
    var HT = {};

    HT.setupCkeditor = () => {
        if ($(".ckeditor")) {
            $(".ckeditor").each(function () {
                let editor = $(this);
                let elementId = editor.attr("id");
                let elementHeight = editor.attr("data-height");
                HT.ckeditor4(elementId, elementHeight);
            });
        }
    };

    HT.ckeditor4 = (elementId, elementHeight) => {
        if (typeof elementHeight == "undefined") {
            elementHeight = 500;
        }
        CKEDITOR.replace(elementId, {
            autoUpdateElement: false,
            height: elementHeight,
            removeButtons: "",
            entities: true,
            allowedContent: true,
            toolbarGroups: [
                { name: "clipboard", groups: ["clipboard", "undo"] },
                {
                    name: "editing",
                    groups: ["find", "selection", "spellchecker"],
                },
                { name: "links" },
                { name: "insert" },
                { name: "forms" },
                { name: "tools" },
                { name: "document", groups: ["mode", "document", "doctools"] },
                { name: "colors" },
                { name: "others" },
                "/",
                { name: "basicstyles", groups: ["basicstyles", "cleanup"] },
                {
                    name: "paragraph",
                    groups: ["list", "indent", "blocks", "align", "bidi"],
                },
                { name: "styles" },
            ],
        });
    };

    HT.uploadImageAvatar = () => {
        $(".img-target").click(function () {
            let input = $(this);
            let type = "Images";
            HT.BrowseServerAvatar(input, type);
        });
    };

    HT.inputImage = () => {
        $(".input-image").click(function () {
            let input = $(this);
            let type = input.attr("data-type");
            HT.BrowseServerInput(input, type);
        });
    };

    HT.BrowseServerInput = (object, type) => {
        if (typeof type == "undefined") {
            type = "Images";
        }
        var finder = new CKFinder();
        finder.resourceType = type;

        finder.selectActionFunction = function (fileUrl, data) {
            object.val(fileUrl);
        };
        finder.popup();
    };

    HT.BrowseServerAvatar = (object, type) => {
        if (typeof type == "undefined") {
            type = "Images";
        }
        var finder = new CKFinder();
        finder.resourceType = type;

        finder.selectActionFunction = function (fileUrl, data) {
            object.attr("src", fileUrl);
            object.siblings("input").val(fileUrl);
        };
        finder.popup();
    };

    $(document).ready(function () {
        HT.inputImage();
        HT.setupCkeditor();
        HT.uploadImageAvatar();
    });
})(jQuery);
