<template>
    <div v-if="createModalForceDestroyUser" class="modal-mask">
        <div class="modal-wrapper">
      <div class="modal-container">
        <div class="modal-header">
          <slot name="header">
            <button class="modal-default-button" @click="$emit('destroyModalForceDestroyUser')">
              <img src="/images/close.svg" />
            </button>
          </slot>
        </div>
        <div class="modal-body">
          <slot name="body">
            <p>Вы уверены, что хотите удалить пользователя?</p>
          </slot>
        </div>

        <div class="modal-footer">
          <slot name="footer">
            <button @click="$emit('forceDestroyUser', user)">Сохранить</button>
          </slot>
        </div>
      </div>
    </div>
    </div>
  </template>
  <script>
  export default {
    props: {
      createModalForceDestroyUser: null,
      currentUser: null
    },
    data() {
        return {
            user: {
                username: null,
                password: null
            }
        }
    },
    watch: {
      currentUser(data) {
        if(data) {
        this.user.id = data.id
        this.user.username = data.username
        }
      }
    }
  }
  </script>