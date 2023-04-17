<template>
    <div v-if="createModalEditUser" class="modal-mask">
        <div class="modal-wrapper">
      <div class="modal-container">
        <div class="modal-header">
          <slot name="header">
            <button class="modal-default-button" @click="$emit('destroyModalEditUser')">
              <img src="/images/close.svg" />
            </button>
          </slot>
        </div>
        <div class="modal-body">
          <slot name="body">
            <p>Имя</p>
            <input  v-model="user.username" type="text" placeholder="Имя" />
            <p>Пароль</p>
            <input  v-model="user.password" type="password" placeholder="Пароль" />
            <p>Отдел</p>
            <multiselect v-model="user.department" placeholder="Выберете отдел" label="title" track-by="id" :options="departments" :multiple="false" :taggable="true"></multiselect>
          </slot>
        </div>

        <div class="modal-footer">
          <slot name="footer">
            <button @click="$emit('updateUser', user)">Сохранить</button>
          </slot>
        </div>
      </div>
    </div>
    </div>
  </template>
  <script>
  import Multiselect from 'vue-multiselect'

  export default {
    components: {
      Multiselect
    },
    props: {
      createModalEditUser: null,
      currentUser: null,
      departments: null
    },
    watch: {
      currentUser(data) {
        if(data) {
        this.user.id = data.id
        this.user.username = data.username
        this.user.department = data.department
        this.user.departmentId = data.departmentId
        }
      }
    },
    data() {
        return {
            user: {
                id: null,
                username: null,
                password: null,
                department: null
            }
        }
    }
  }
  </script>