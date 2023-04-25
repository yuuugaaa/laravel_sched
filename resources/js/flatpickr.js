import flatpickr from "flatpickr";
import { Japanese } from "flatpickr/dist/l10n/ja.js"

const calenderSetting = {
    "locale": Japanese,
    //minDate: "today",
}

flatpickr("#calender", calenderSetting);
flatpickr("#event_date", calenderSetting);

const timeSetting = {
    "locale": Japanese,
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true,
}

flatpickr("#start_time", timeSetting);
flatpickr("#end_time", timeSetting);

