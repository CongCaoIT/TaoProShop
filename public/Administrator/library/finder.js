(function ($) {
    "use strict";
    var HT = {};

    HT.setupCkeditor = () => {
        if ($(".ckeditor").length) {
            $(".ckeditor").each(function () {
                let editor = $(this);
                let elementId = editor.attr("id");
                let elementHeight = editor.attr("data-height");

                if (CKEDITOR.instances[elementId]) {
                    CKEDITOR.instances[elementId].destroy(true);
                }

                HT.ckeditor4(elementId, elementHeight);
            });
        }
    };

    HT.uploadAlbum = () => {
        $(document).on("click", ".upload-picture", function (e) {
            HT.BrowseServerAlbum();
            e.preventDefault();
        });
    };

    HT.multipleUploadImageCkeditor = () => {
        $(document).on("click", ".multipleUploadImageCkeditor", function (e) {
            let object = $(this);
            let target = object.attr("data-target");
            HT.BrowseServerCkeditor(object, "Images", target);

            e.preventDefault();
        });
    };

    HT.ckeditor4 = (elementId, elementHeight) => {
        if (typeof elementHeight === "undefined") {
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
        if (typeof type === "undefined") {
            type = "Images";
        }
        var finder = new CKFinder();
        finder.resourceType = type;
        finder.selectActionFunction = function (fileUrl) {
            object.val(fileUrl);
        };
        finder.popup();
    };

    HT.BrowseServerAvatar = (object, type) => {
        if (typeof type === "undefined") {
            type = "Images";
        }
        var finder = new CKFinder();
        finder.resourceType = type;
        finder.selectActionFunction = function (fileUrl) {
            object.attr("src", fileUrl);
            object.siblings("input").val(fileUrl);
        };
        finder.popup();
    };

    HT.BrowseServerCkeditor = (object, type, target) => {
        if (typeof type == "undefined") {
            type = "Images";
        }
        var finder = new CKFinder();
        finder.resourceType = type;
        finder.selectActionFunction = function (fileUrl, data, allFiles) {
            let html = "";
            for (var i = 0; i < allFiles.length; i++) {
                var image = allFiles[i].url;

                html +=
                    '<div class="image-content"><figure><img src="' +
                    image +
                    '" alt="' +
                    image +
                    '"><figcaption>Nhập vào mô tả cho ảnh</figcaption></figure></div>';
            }
            CKEDITOR.instances[target].insertHtml(html);
        };
        finder.popup();
    };

    HT.BrowseServerAlbum = () => {
        var type = "Images";
        var finder = new CKFinder();
        finder.resourceType = type;
        finder.selectActionFunction = function (fileUrl, data, allFiles) {
            let html = "";
            for (var i = 0; i < allFiles.length; i++) {
                var image = allFiles[i].url;
                html += '<li class="ui-state-default">';
                html += '<div class="thumb">';
                html += '<span class="image img-scaledown">';
                html += '<img src="' + image + '" alt="' + image + '">';
                html +=
                    '<input type="hidden" name="album[]" value="' +
                    image +
                    '">';
                html += "</span>";
                html +=
                    '<button class="delete-image"><i class="fa fa-trash"></i></button>';
                html += "</div>";
                html += "</li>";
            }

            $(".click-to-upload").addClass("hidden");
            $("#sorttable").append(html);
            $(".upload-list").removeClass("hidden");
        };
        finder.popup();
    };

    HT.detetePicture = () => {
        $(document).on("click", ".delete-image", function () {
            let _this = $(this);
            _this.parents(".ui-state-default").remove();

            if ($(".ui-state-default").length == 0) {
                $(".click-to-upload").removeClass("hidden");
                $(".upload-list").addClass("hidden");
            }
        });
    };

    $(document).ready(function () {
        HT.inputImage();
        HT.setupCkeditor();
        HT.uploadImageAvatar();
        HT.multipleUploadImageCkeditor();
        HT.uploadAlbum();
        HT.detetePicture();
    });
})(jQuery);
