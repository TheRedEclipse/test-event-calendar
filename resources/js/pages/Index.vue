<template>
  <div>
    <div>
      <div class="block">
        <div v-if="currentUser" class="block-buttons">
          <p>
            <b>Добро пожаловать, {{ currentUser.username }}</b>
          </p>
          <button
            @click="createModalAddCalendarEvent = true"
            class="primary-button"
          >
            Создать событие
          </button>
          <p class="small-txt">Изменить вид</p>
          <button
            v-if="calendarEventView === 'calendar'"
            @click="calendarEventView = 'list'"
            class="primary-button"
          >
            Список
          </button>
          <button
            v-else
            @click="calendarEventView = 'calendar'"
            class="primary-button"
          >
            Календарь
          </button>
        </div>
        <template v-if="calendarEventView === 'calendar'">
          <EventCalendar
            :calendarEvents="calendarEvents"
            @getCalendarEvent="getCalendarEvent"
          >
          </EventCalendar>
        </template>
        <template v-else>
          <EventCalendarList
            :calendarEvents="calendarEvents"
            @getCalendarEvent="getCalendarEvent"
          >
          </EventCalendarList>
        </template>
      </div>
    </div>
    <ModalAddCalendarEvent
      :createModalAddCalendarEvent="createModalAddCalendarEvent"
      :users="users"
      :departments="departments"
      @destroyModalAddCalendarEvent="createModalAddCalendarEvent = null"
      @createCalendarEvent="createCalendarEvent"
    >
    </ModalAddCalendarEvent>
    <ModalShowEventCalendar
      :calendarEvent="calendarEvent"
      @destroyModalShowEventCalendar="calendarEvent = null"
    >
    </ModalShowEventCalendar>
  </div>
</template>
<script>
import EventCalendar from "../components/index/EventCalendar.vue";
import EventCalendarList from "../components/index/EventCalendarList.vue";
import ModalAddCalendarEvent from "../components/index/ModalAddCalendarEvent.vue";
import ModalShowEventCalendar from "../components/index/ModalShowEventCalendar.vue";
import { useToast } from "vue-toastification";

export default {
  setup() {
    const toast = useToast();

    return {
      toast,
    };
  },
  components: {
    EventCalendar,
    ModalAddCalendarEvent,
    ModalShowEventCalendar,
    EventCalendarList,
  },
  data() {
    return {
      createModalAddCalendarEvent: null,
      users: null,
      departments: null,
      calendarEvents: null,
      calendarEventView: "calendar",
      calendarEvent: null,
    };
  },
  created() {
    this.getCalendarEvents();

    this.getUsers();

    this.getDepartments();
  },
  computed: {
    currentUser() {
      return this.$store.getters["currentUser"].user;
    },
  },
  methods: {
    getCalendarEvents() {
      this.$axios.get(`/calendar-events`).then((response) => {
        if (response.data.success === true) {
          this.calendarEvents = response.data.calendarEvents;
        }
      });
    },
    getUsers() {
      this.$axios.get("/users/public").then((response) => {
        if (response.data.success === true) {
          this.users = response.data.users;
        }
      });
    },
    getDepartments() {
      this.$axios.get("/departments/public").then((response) => {
        if (response.data.success === true) {
          this.departments = response.data.departments;
        }
      });
    },
    createCalendarEvent(eventCalendar) {
      this.$axios.post(`/calendar-events`, eventCalendar).then((response) => {
        if (response.data.success === true) {
          this.createModalAddCalendarEvent = null;

          this.toast.success("Событие создано");

          this.getCalendarEvents();
        }
      });
    },
    getCalendarEvent(id) {
      this.$axios.get(`/calendar-events/${id}`).then((response) => {
        if (response.data.success === true) {
          this.calendarEvent = response.data.calendarEvent;
        }
      });
    },
  },
};
</script>
<style>
.small-txt {
  font-size: 12px;
}
.index-table {
  border-collapse: collapse;
  width: 100%;
}

.index-table td,
.index-table th {
  text-align: left;
  padding: 8px;
}

.index-table tr:nth-child(even) {
  background-color: #aacfd4;
}
</style>