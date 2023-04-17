<template>
      <table class="index-table">
  <tr>
    <th>Событие</th>
    <th>Начало</th>
    <th>Описание</th>
  </tr>
      <tr v-for="(calendarEvent, key) in calendarEvents" :key="key" @click="$emit('getCalendarEvent', calendarEvent.id)">
       
        <td> {{ calendarEvent.title }}</td>
        <td> {{ calendarEvent.start }}</td>
        <td> {{ calendarEvent.description }}</td>
      </tr>
      </table>
</template>
<script>
export default {
    props: {
        calendarEvents: null
    }
}
</script>