(function ($) {
    "use strict";
    var HT = {};

    HT.switchery = () => {
        $(".js-switch").each(function () {
            var switchery = new Switchery(this, {
                color: "#1AB394",
            });
        });
    };

    HT.select2 = () => {
        if ($(".setupSelect2").length) {
            $(".setupSelect2").select2();
        }
    };

    HT.changeStatus = () => {
        if ($(".status").length) {
            $(document).on("change", ".status", function () {
                let _this = $(this);
                let option = {
                    value: _this.val(),
                    modelId: _this.attr("data-modelid"),
                    model: _this.attr("data-model"),
                    field: _this.attr("data-field"),
                    _token: $('meta[name="csrf-token"]').attr("content"),
                };

                $.ajax({
                    url: "ajax/dashboard/changeStatus",
                    type: "POST",
                    data: option,
                    dataType: "json",
                    success: function (res) {
                        console.log(res);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log("Lỗi: " + textStatus + " " + errorThrown);
                    },
                });
            });
        }
    };

    $(document).ready(function () {
        HT.switchery();
        HT.select2();
        HT.changeStatus();
    });
})(jQuery);
