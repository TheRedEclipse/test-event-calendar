<template>
    <div v-if="createModalAddCalendarEvent" class="modal-mask">
        <div class="modal-wrapper">
      <div class="modal-container">
        <div class="modal-header">
          <slot name="header">
            <button class="modal-default-button" @click="$emit('destroyModalAddCalendarEvent')">
              <img src="/images/close.svg" />
            </button>
          </slot>
        </div>
        <div class="modal-body">
          <slot name="body">
            <p>Название</p>
            <input  v-model="calendarEvent.title" type="text" placeholder="Название" />
            <p>Описание</p>
            <textarea  v-model="calendarEvent.description" placeholder="Описание"></textarea>
            <p>Начало</p>
            <VueDatePicker v-model="calendarEvent.start" auto-apply :enable-time-picker="true"></VueDatePicker>
            <p>Отделы</p>
            <multiselect v-model="calendarEvent.departments" placeholder="Найдите и добавьте тег" label="title" track-by="id" :options="departments" :multiple="true" :taggable="true"></multiselect>
            <p>Сотрудники</p>
            <multiselect v-model="calendarEvent.users" placeholder="Найдите и добавьте тег" label="username" track-by="id" :options="users" :multiple="true" :taggable="true"></multiselect>
          </slot>
        </div>

        <div class="modal-footer">
          <slot name="footer">
            <button @click="$emit('createCalendarEvent', calendarEvent)">Сохранить</button>
          </slot>
        </div>
      </div>
    </div>
    </div>
  </template>
  <script>
    import VueDatePicker from '@vuepic/vue-datepicker';
  import '@vuepic/vue-datepicker/dist/main.css'
  import Multiselect from 'vue-multiselect'

  export default {
    components: {
        VueDatePicker,
        Multiselect
    },
    props: {
        createModalAddCalendarEvent: null,
        departments: null,
        users: null,
    },
    data() {
        return {
            calendarEvent: {
                title: null,
                description: null,
                start: null,
                departments: [],
                users: []
            },
        }
    },
    watch: {
      createModalAddCalendarEvent(data) {
        if(!data) {
          this.calendarEvent.title = null,
          this.calendarEvent.description = null
          this.calendarEvent.start = null
          this.calendarEvent.departments = []
          this.calendarEvent.users = []
        }
      }
    }
  }
  </script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>