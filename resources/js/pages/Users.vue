<template>
  <div class="block" v-if="users">
    <h2>Пользователи</h2>
    <button @click="createModalAddUser = true" class="primary-button">Создать пользователя</button>
    <div :class="{
        inactive: user.deletedAt
      }" v-for="(user, key) in users.data" :key="key">
        {{ user.username }}
        <button @click="createModalEditUser = true, getUser(user.id)" class="block-button"><img src="/images/edit.svg" /></button>
        <button v-if="!user.deletedAt" @click="createModalDestroyUser = true, getUser(user.id)" class="block-button" style="background-color: #dab759; margin: 0 4px"><img src="/images/trash.svg" /></button>
        <button v-if="user.deletedAt" @click="createModalForceDestroyUser = true, getUser(user.id)" class="block-button" style="background-color: #cc9595; margin: 0 4px"><img src="/images/trash.svg" /></button>
        <button v-if="user.deletedAt" @click="createModalRestoreUser = true, getUser(user.id)" class="block-button" style="background-color: #22ce8c; margin: 0 4px"><img src="/images/restore.svg" /></button>
      <hr />
    </div>
  </div>
  <div>
    <Pagination :data="users" @getPage="getPage" />

    <ModalAddUser
      :createModalAddUser="createModalAddUser"
      :departments="departments"
      @destroyModalAddUser="createModalAddUser = null"
      @createUser="createUser"
    >
    </ModalAddUser>

    <ModalEditUser
      :createModalEditUser="createModalEditUser"
      :currentUser="user"
      :departments="departments"
      @destroyModalEditUser="createModalEditUser = null"
      @updateUser="updateUser"
    >
    </ModalEditUser>

    <ModalDestroyUser
      :createModalDestroyUser="createModalDestroyUser"
      :currentUser="user"
      @destroyModalDestroyUser="createModalDestroyUser = null"
      @destroyUser="destroyUser"
    >
    </ModalDestroyUser>

    <ModalRestoreUser
      :createModalRestoreUser="createModalRestoreUser"
      :currentUser="user"
      @destroyModalRestoreUser="createModalRestoreUser = null"
      @restoreUser="restoreUser"
    >
    </ModalRestoreUser>

    <ModalForceDestroyUser
      :createModalForceDestroyUser="createModalForceDestroyUser"
      :currentUser="user"
      @destroyModalForceDestroyUser="createModalForceDestroyUser = null"
      @forceDestroyUser="forceDestroyUser"
    >
    </ModalForceDestroyUser>
  </div>
</template>
<script>
import Pagination from "../components/Pagination.vue";
import ModalAddUser from "../components/user/ModalAddUser.vue";
import ModalEditUser from "../components/user/ModalEditUser.vue";
import ModalDestroyUser from "../components/user/ModalDestroyUser.vue";
import ModalRestoreUser from "../components/user/ModalRestoreUser.vue";
import ModalForceDestroyUser from "../components/user/ModalForceDestroyUser.vue";
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
    ModalAddUser,
    ModalEditUser,
    ModalDestroyUser,
    ModalRestoreUser,
    ModalForceDestroyUser
  },
  data() {
    return {
      users: null,
      page: null,
      createModalAddUser: null,
      createModalEditUser: null,
      createModalDestroyUser: null,
      createModalRestoreUser: null,
      createModalForceDestroyUser: null,
      user: null,
      departments: null
    };
  },
  created() {
    this.getUsers();

    this.getDepartments();
  },
  watch: {
    page() {
      this.getUsers();
    },
  },
  methods: {
    getUsers() {
      this.$axios
        .get(
          this.page
            ? this.page
            : this.$route.query.page
            ? "/users?page=" + this.$route.query.page
            : "/users"
        )
        .then((response) => {
          if (response.data.success === true) {
            this.users = response.data.users;
          }
        });
    },
    getDepartments() {
      this.$axios
        .get('/departments/public')
        .then((response) => {
          if (response.data.success === true) {
            this.departments = response.data.departments;
          }
        });
    },
    getUser(id) {
        this.$axios
        .get(`/users/${id}`
        )
        .then((response) => {
          if (response.data.success === true) {
            this.user = response.data.user;
          }
        });
    },
    getPage(link) {
      this.page = link;
    },
    createUser(user) {
      this.$axios
      .post(`/users`, user)
      .then((response) => {
        if(response.data.success === true) {
          this.createModalAddUser = false
          
          this.toast.success('Пользователь создан')

          this.getUsers()
        }
      })
    },
    updateUser(user) {
        this.$axios
        .put(`/users/${user.id}`, user)
        .then((response) => {
            if(response.data.success === true) {
                this.createModalEditUser = null

                this.user = null

                this.toast.success('Пользователь изменён')

                this.getUsers()
            } 
        })
    },
    destroyUser(user) {
        this.$axios
        .delete(`/users/${user.id}`, user)
        .then((response) => {
            if(response.data.success === true) {
                this.createModalDestroyUser = null

                this.user = null

                this.toast.success('Пользователь скрыт')

                this.getUsers()
            } 
        })
    },
    restoreUser(user) {
        this.$axios
        .put(`/users/${user.id}/restore`, user)
        .then((response) => {
            if(response.data.success === true) {
                this.createModalRestoreUser = null

                this.user = null

                this.toast.success('Пользователь восстановлен')

                this.getUsers()
            } 
        })
    },
    forceDestroyUser(user) {
        this.$axios
        .delete(`/users/${user.id}/force`, user)
        .then((response) => {
            if(response.data.success === true) {
                this.createModalForceDestroyUser = null

                this.user = null

                this.toast.success('Пользователь удалён')

                this.getUsers()
            } 
        })
    },
  },
};
</script>