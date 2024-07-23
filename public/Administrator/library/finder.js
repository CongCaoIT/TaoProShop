(function ($) {
    "use strict";
    var HT = {};

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

    $(document).ready(function () {
        HT.inputImage();
    });
})(jQuery);
