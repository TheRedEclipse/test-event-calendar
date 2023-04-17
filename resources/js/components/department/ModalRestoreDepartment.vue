<template>
  <div v-if="createModalRestoreDepartment" class="modal-mask">
    <div class="modal-wrapper">
      <div class="modal-container">
        <div class="modal-header">
          <slot name="header">
            <button
              class="modal-default-button"
              @click="$emit('destroyModalRestoreDepartment')"
            >
              <img src="/images/close.svg" />
            </button>
          </slot>
        </div>
        <div class="modal-body">
          <slot name="body">
            <p>Вы уверены, что хотите восстановить отдел?</p>
          </slot>
        </div>

        <div class="modal-footer">
          <slot name="footer">
            <button @click="$emit('restoreDepartment', department)">
              Сохранить
            </button>
          </slot>
        </div>
      </div>
    </div>
  </div>
</template>
  <script>
export default {
  props: {
    createModalRestoreDepartment: null,
    currentDepartment: null,
  },
  data() {
    return {
      department: {
        title: null,
        description: null,
      },
    };
  },
  watch: {
    currentDepartment(data) {
      if (data) {
        this.department.id = data.id;
        this.department.title = data.title;
        this.department.description = data.title;
      }
    },
  },
};
</script>