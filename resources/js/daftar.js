import Datepicker from "flowbite-datepicker/Datepicker";
import id from "flowbite-datepicker/locales/id";

const dateEl = document.getElementsByName("date")[0];
const currentDate = new Date();
// minimum date is today + 3 days
currentDate.setDate(currentDate.getDate() + 3);
new Datepicker(dateEl, {
    daysOfWeekDisabled: [0, 6],
    format: "dd/mm/yyyy",
    minDate: currentDate,
    language: "id",
});
