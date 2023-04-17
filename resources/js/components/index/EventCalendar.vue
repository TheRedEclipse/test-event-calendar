<template>
  <FullCalendar :options="calendarOptions"> </FullCalendar>
</template>
<script>
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import ruLocale from "@fullcalendar/core/locales/ru";

export default {
  components: {
    FullCalendar,
  },
  data: function () {
    return {
      calendarOptions: {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: "dayGridMonth",
        weekends: true,
        editable: true,
        selectable: true,
        selectMirror: true,
        dateClick: this.handleDateClick,
        eventClick: this.handleEventClick,
        initialEvents: this.calendarEvents,
        locale: ruLocale,
      },
    };
  },
  props: {
    calendarEvents: null,
  },
  watch: {
    calendarEvents(data) {
      this.calendarOptions.events = data;
    },
  },
  methods: {
    handleDateClick(arg) {
      //
    },
    handleEventClick(arg) {
      this.$emit('getCalendarEvent', arg.event.id)
    },
    handleEvents(events) {
      this.currentEvents = events;
    },
  },
};
</script>
<style>
.fc-button-primary {
  background-color: #8ec2c9!important;
  border: #8ec2c9!important;
}
</style>