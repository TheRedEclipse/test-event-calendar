<template>
    <div v-if="createModalDestroyUser" class="modal-mask">
        <div class="modal-wrapper">
      <div class="modal-container">
        <div class="modal-header">
          <slot name="header">
            <button class="modal-default-button" @click="$emit('destroyModalDestroyUser')">
              <img src="/images/close.svg" />
            </button>
          </slot>
        </div>
        <div class="modal-body">
          <slot name="body">
            <p>Вы уверены, что хотите скрыть пользователя?</p>
          </slot>
        </div>

        <div class="modal-footer">
          <slot name="footer">
            <button @click="$emit('destroyUser', user)">Сохранить</button>
          </slot>
        </div>
      </div>
    </div>
    </div>
  </template>
  <script>
  export default {
    props: {
      createModalDestroyUser: null,
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