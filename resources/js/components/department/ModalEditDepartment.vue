<template>
  <div v-if="createModalEditDepartment" class="modal-mask">
    <div class="modal-wrapper">
      <div class="modal-container">
        <div class="modal-header">
          <slot name="header">
            <button
              class="modal-default-button"
              @click="$emit('destroyModalEditDepartment')"
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
            <button @click="$emit('updateDepartment', department)">
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
    createModalEditDepartment: null,
    currentDepartment: null,
  },
  data() {
    return {
      department: {
        id: null,
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
        this.department.description = data.description;
      }
    },
  },
};
</script>