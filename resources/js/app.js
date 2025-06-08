import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import './echo.js';

window.FullCalendar = {
    Calendar,
    dayGridPlugin,
    interactionPlugin
};