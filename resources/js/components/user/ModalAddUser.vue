<template>
    <div v-if="createModalAddUser" class="modal-mask">
        <div class="modal-wrapper">
      <div class="modal-container">
        <div class="modal-header">
          <slot name="header">
            <button class="modal-default-button" @click="$emit('destroyModalAddUser')">
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
            <p>Администратор?</p>
            <label class="container">
  <input v-model="checkboxState"   true-value="admin"
  false-value="user" type="checkbox">
  <span class="checkmark"></span>
</label>
          </slot>
        </div>

        <div class="modal-footer">
          <slot name="footer">
            <button @click="$emit('createUser', user)">Сохранить</button>
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
        createModalAddUser: null,
        departments: null
    },
    data() {
        return {
            user: {
                username: null,
                password: null,
                userRoleId: 2,
                department: null
            },
            checkboxState: "user"
        }
    },
    watch: {
      checkboxState(data) {
        if(data === 'admin') {
          this.user.userRoleId = 1
        } else {
          this.user.userRoleId = 2
        }
      },
      createModalAddUser(data) {
      if (!data) {
        this.user.username = null;
        this.user.password = null;
        this.user.userRoleId = null;
        this.user.department = null;
      }
    },

    }
  }
  </script>