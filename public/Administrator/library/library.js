(function ($) {
    "use strict";
    var HT = {};

    HT.switchery = () => {
        $(".js-switch").each(function () {
            var switchery = new Switchery(this, {
                color: "#1AB394",
                size: "small",
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

    HT.checkAll = () => {
        if ($("#checkAll").length) {
            $(document).on("click", "#checkAll", function () {
                let isChecked = $(this).prop("checked");
                $(".checkboxItem").prop("checked", isChecked);
                $(".checkboxItem").each(function () {
                    HT.changeBackground($(this));
                });
            });
        }
    };

    HT.checkBoxItem = () => {
        if ($(".checkboxItem").length) {
            $(document).on("click", ".checkboxItem", function () {
                HT.changeBackground($(this));
                HT.allCheck();
            });
        }
    };

    HT.allCheck = () => {
        let allChecked =
            $(".checkboxItem:checked").length === $(".checkboxItem").length;
        $("#checkAll").prop("checked", allChecked);
    };

    HT.changeBackground = (object) => {
        let isChecked = object.prop("checked");
        if (isChecked) {
            object.closest("tr").addClass("active-bg");
        } else {
            object.closest("tr").removeClass("active-bg");
        }
    };

    HT.changeStatusAll = () => {
        if ($(".changeStatasAll").length) {
            $(document).on("click", ".changeStatasAll", function (e) {
                let _this = $(this);
                let id = [];
                $(".checkboxItem").each(function () {
                    let checkBox = $(this);
                    if (checkBox.prop("checked")) {
                        id.push(checkBox.val());
                    }
                });

                let option = {
                    value: _this.attr("data-value"),
                    model: _this.attr("data-model"),
                    field: _this.attr("data-field"),
                    id: id,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                };

                $.ajax({
                    url: "ajax/dashboard/changeStatusAll",
                    type: "POST",
                    data: option,
                    dataType: "json",
                    success: function (res) {
                        if (res.flag == true) {
                            let cssActive1 =
                                "background-color: rgb(26, 179, 148); border-color: rgb(26, 179, 148); box-shadow: rgb(26, 179, 148) 0px 0px 0px 16px inset; transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;";
                            let cssActive2 =
                                "left: 20px; background-color: rgb(255, 255, 255); transition: background-color 0.4s ease 0s, left 0.2s ease 0s;";

                            let cssUnActive1 =
                                "background-color: rgb(255, 255, 255); border-color: rgb(223, 223, 223); box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset; transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s;";
                            let cssUnActive2 =
                                "left: 0px; transition: background-color 0.4s ease 0s, left 0.2s ease 0s;";

                            for (let i = 0; i < id.length; i++) {
                                if (option.value == 1) {
                                    $(".js-switch-" + id[i])
                                        .find("span.switchery")
                                        .attr("style", cssActive1)
                                        .find("small")
                                        .attr("style", cssActive2);
                                } else if (option.value == 0) {
                                    $(".js-switch-" + id[i])
                                        .find("span.switchery")
                                        .attr("style", cssUnActive1)
                                        .find("small")
                                        .attr("style", cssUnActive2);
                                }
                            }
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log("Lỗi: " + textStatus + " " + errorThrown);
                    },
                });
                e.preventDefault();
            });
        }
    };

    $(document).ready(function () {
        HT.switchery();
        HT.select2();
        HT.changeStatus();
        HT.checkAll();
        HT.checkBoxItem();
        HT.changeStatusAll();
    });
})(jQuery);
