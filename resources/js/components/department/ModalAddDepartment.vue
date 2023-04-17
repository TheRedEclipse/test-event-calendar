<template>
  <div v-if="createModalAddDepartment" class="modal-mask">
    <div class="modal-wrapper">
      <div class="modal-container">
        <div class="modal-header">
          <slot name="header">
            <button
              class="modal-default-button"
              @click="$emit('destroyModalAddDepartment')"
            >
              <img src="/images/close.svg" />
            </button>
          </slot>
        </div>
        <div class="modal-body">
          <slot name="body">
            <p>Название</p>
            <input
              v-model="department.title"
              type="text"
              placeholder="Название"
            />
            <p>Описание</p>
            <textarea
              v-model="department.description"
              placeholder="Описание"
            ></textarea>
          </slot>
        </div>

        <div class="modal-footer">
          <slot name="footer">
            <button @click="$emit('createDepartment', department)">
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
    createModalAddDepartment: null,
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
    createModalAddDepartment(data) {
      if (!data) {
        this.department.title = null;
        this.department.description = null;
      }
    },
  },
};
</script>