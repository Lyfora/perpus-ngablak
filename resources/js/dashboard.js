import Datepicker from "flowbite-datepicker/Datepicker";
import id from "flowbite-datepicker/locales/id";

const startMonthEl = document.getElementsByName("start_month")[0];
const endMonthEl = document.getElementsByName("end_month")[0];
const yearEl = document.getElementsByName("year")[0];
new Datepicker(startMonthEl, {
    pickLevel: 1,
    format: "M",
    language: "id",
});
new Datepicker(endMonthEl, {
    pickLevel: 1,
    format: "M",
    language: "id",
});
new Datepicker(yearEl, {
    pickLevel: 2,
    format: "yyyy",
    language: "id",
});

startMonthEl.addEventListener("click", function () {
    const datepickerEl = document.querySelector(".datepicker:not(.hidden)");
    // set header to hidden
    datepickerEl.querySelector(".datepicker-header").classList.add("hidden");
    datepickerEl.querySelector(".datepicker-footer").classList.add("hidden");
});
endMonthEl.addEventListener("click", function () {
    const datepickerEl = document.querySelector(".datepicker:not(.hidden)");
    // set header to hidden
    datepickerEl.querySelector(".datepicker-header").classList.add("hidden");
    datepickerEl.querySelector(".datepicker-footer").classList.add("hidden");
});
