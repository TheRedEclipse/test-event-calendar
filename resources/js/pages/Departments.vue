<template>
  <div class="block" v-if="departments">
    <h2>Отделы</h2>
    <button @click="createModalAddDepartment = true" class="primary-button">Создать отдел</button>
    <div v-if="departments.data && departments.data.length === 0">
    <p>Нет записей</p>
    </div>
    <div :class="{
        inactive: department.deletedAt
      }" v-for="(department, key) in departments.data" :key="key">
        {{ department.title }}
        <button @click="createModalEditDepartment = true, getDepartment(department.id)" class="block-button"><img src="/images/edit.svg" /></button>
        <button v-if="!department.deletedAt" @click="createModalDestroyDepartment = true, getDepartment(department.id)" class="block-button" style="background-color: #dab759; margin: 0 4px"><img src="/images/trash.svg" /></button>
        <button v-if="department.deletedAt" @click="createModalForceDestroyDepartment = true, getDepartment(department.id)" class="block-button" style="background-color: #cc9595; margin: 0 4px"><img src="/images/trash.svg" /></button>
        <button v-if="department.deletedAt" @click="createModalRestoreDepartment = true, getDepartment(department.id)" class="block-button" style="background-color: #22ce8c; margin: 0 4px"><img src="/images/restore.svg" /></button>
      <hr />
    </div>
  </div>
  <div>
    <Pagination :data="departments" @getPage="getPage" />

    <ModalAddDepartment
      :createModalAddDepartment="createModalAddDepartment"
      @destroyModalAddDepartment="createModalAddDepartment = null"
      @createDepartment="createDepartment"
    >
    </ModalAddDepartment>

    <ModalEditDepartment
      :createModalEditDepartment="createModalEditDepartment"
      :currentDepartment="department"
      @destroyModalEditDepartment="createModalEditDepartment = null"
      @updateDepartment="updateDepartment"
    >
    </ModalEditDepartment>

    <ModalDestroyDepartment
      :createModalDestroyDepartment="createModalDestroyDepartment"
      :currentDepartment="department"
      @destroyModalDestroyDepartment="createModalDestroyDepartment = null"
      @destroyDepartment="destroyDepartment"
    >
    </ModalDestroyDepartment>

    <ModalRestoreDepartment
      :createModalRestoreDepartment="createModalRestoreDepartment"
      :currentDepartment="department"
      @destroyModalRestoreDepartment="createModalRestoreDepartment = null"
      @restoreDepartment="restoreDepartment"
    >
    </ModalRestoreDepartment>

    <ModalForceDestroyDepartment
      :createModalForceDestroyDepartment="createModalForceDestroyDepartment"
      :currentDepartment="department"
      @destroyModalForceDestroyDepartment="createModalForceDestroyDepartment = null"
      @forceDestroyDepartment="forceDestroyDepartment"
    >
    </ModalForceDestroyDepartment>
  </div>
</template>
<script>
import Pagination from "../components/Pagination.vue";
import ModalAddDepartment from "../components/department/ModalAddDepartment.vue";
import ModalEditDepartment from "../components/department/ModalEditDepartment.vue";
import ModalDestroyDepartment from "../components/department/ModalDestroyDepartment.vue";
import ModalRestoreDepartment from "../components/department/ModalRestoreDepartment.vue";
import ModalForceDestroyDepartment from "../components/department/ModalForceDestroyDepartment.vue";
import { useToast } from "vue-toastification";

export default {
    setup() {
    const toast = useToast();

    return {
      toast,
    };
  },
  components: {
    Pagination,
    ModalAddDepartment,
    ModalEditDepartment,
    ModalDestroyDepartment,
    ModalRestoreDepartment,
    ModalForceDestroyDepartment
  },
  data() {
    return {
      departments: null,
      page: null,
      createModalAddDepartment: null,
      createModalEditDepartment: null,
      createModalDestroyDepartment: null,
      createModalRestoreDepartment: null,
      createModalForceDestroyDepartment: null,
      department: null
    };
  },
  created() {
    this.getDepartments();
  },
  watch: {
    page() {
      this.getDepartments();
    },
  },
  methods: {
    getDepartments() {
      this.$axios
        .get(
          this.page
            ? this.page
            : this.$route.query.page
            ? "/departments?page=" + this.$route.query.page
            : "/departments"
        )
        .then((response) => {
          if (response.data.success === true) {
            this.departments = response.data.departments;
          }
        });
    },
    getDepartment(id) {
        this.$axios
        .get(`/departments/${id}`
        )
        .then((response) => {
          if (response.data.success === true) {
            this.department = response.data.department;
          }
        });
    },
    getPage(link) {
      this.page = link;
    },
    createDepartment(department) {
      this.$axios
      .post(`/departments`, department)
      .then((response) => {
        if(response.data.success === true) {
          this.createModalAddDepartment = false
          
          this.toast.success('Отдел создан')

          this.getDepartments()
        }
      })
    },
    updateDepartment(department) {
        this.$axios
        .put(`/departments/${department.id}`, department)
        .then((response) => {
            if(response.data.success === true) {
                this.createModalEditDepartment = null

                this.department = null

                this.toast.success('Отдел изменён')

                this.getDepartments()
            } 
        })
    },
    destroyDepartment(department) {
        this.$axios
        .delete(`/departments/${department.id}`, department)
        .then((response) => {
            if(response.data.success === true) {
                this.createModalDestroyDepartment = null

                this.department = null

                this.toast.success('Отдел скрыт')

                this.getDepartments()
            } 
        })
    },
    restoreDepartment(department) {
        this.$axios
        .put(`/departments/${department.id}/restore`, department)
        .then((response) => {
            if(response.data.success === true) {
                this.createModalRestoreDepartment = null

                this.department = null

                this.toast.success('Пользователь восстановлен')

                this.getDepartments()
            } 
        })
    },
    forceDestroyDepartment(department) {
        this.$axios
        .delete(`/departments/${department.id}/force`, department)
        .then((response) => {
            if(response.data.success === true) {
                this.createModalForceDestroyDepartment = null

                this.department = null

                this.toast.success('Пользователь удалён')

                this.getDepartments()
            } 
        })
    },
  },
};
</script>