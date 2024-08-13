import "./bootstrap";
import "flowbite";
import "flowbite/dist/datepicker.js";
import "tinymce/tinymce";
import "tinymce/skins/ui/oxide/skin.min.css";
import "tinymce/icons/default/icons";
import "tinymce/themes/silver/theme";
import "tinymce/models/dom/model";
import "tinymce/plugins/image/plugin";
import Datepicker from "flowbite-datepicker/Datepicker";
import DateRangePicker from "flowbite-datepicker/DateRangePicker";
import id from "flowbite-datepicker/locales/id";
// const datepickerEl = document.getElementById("datepickerId");
// add .view-switch class to display none
Object.assign(Datepicker.locales, id);

const datepickerOptions = {
    format: "d/mm/yyyy",
    language: "id",
    autohide: true,
};

// const dateRangePickerEl = document.getElementById("date-rangepicker");
// const dateRangePicker = new DateRangePicker(dateRangePickerEl, {
//     format: "dd/mm/yyyy",
//     language: "id",
//     autohide: true,
// });

document.addEventListener("DOMContentLoaded", function () {
    document
        .querySelectorAll(".date-rangepicker")
        .forEach(function (datepickerEl) {
            const d = new DateRangePicker(datepickerEl, {
                format: "dd/mm/yyyy",
                language: "id",
                autohide: true,
            });
        });
});

// const datepickerEl2 = document.getElementById("datepicker2Id");
// new Datepicker(datepickerEl2, {
//     pickLevel: 2,
//     format: "yyyy",
// });
// new Datepicker(datepickerEl, {
//     pickLevel: 1,
//     format: "M",
// });
// datepickerEl.addEventListener("click", function () {
//     const datepickerEl = document.querySelector(".datepicker:not(.hidden)");
//     // set header to hidden
//     datepickerEl.querySelector(".datepicker-header").classList.add("hidden");
// });
