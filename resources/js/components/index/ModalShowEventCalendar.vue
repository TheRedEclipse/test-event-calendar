<template>
    <div v-if="calendarEvent" class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <div class="modal-header">
            <slot name="header">
              <button
                class="modal-default-button"
                @click="$emit('destroyModalShowEventCalendar')"
              >
                <img src="/images/close.svg" />
              </button>
            </slot>
          </div>
          <div class="modal-body">
            <slot name="body">
              <b>Заголовок</b>
              <p>{{ calendarEvent.title }}</p>
              <hr>
              <b>Описание</b>
              <p>{{ calendarEvent.description }}</p>
              <hr>
              <b>Участники</b>
              <div v-for="(user, key) in calendarEvent.users" :key="key">
                <p>Имя: {{ user.username }} Роль: {{ user.userRole.name }}
                <template v-if="user.department">Отдел: {{ user.department.title }}</template></p>
            </div>
              <hr>

            </slot>
          </div>
        </div>
      </div>
    </div>
  </template>
    <script>
  export default {
    props: {
        calendarEvent: null
    },
  };
  </script>
  <style>
  hr {
    background-color: white;
  }
</style>