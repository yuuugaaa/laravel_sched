import flatpickr from "flatpickr";
import { Japanese } from "flatpickr/dist/l10n/ja.js"

flatpickr("#event_date", {
    "locale": Japanese,
    minDate: "today",
});

const timeSetting = {
    "locale": Japanese,
    minDate: "today",
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true,
}

flatpickr("#start_time", timeSetting);
flatpickr("#end_time", timeSetting);
