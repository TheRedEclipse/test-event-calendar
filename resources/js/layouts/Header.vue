<template>
    <button @click="dropdown = true" class="menu-btn"><img src="/images/menu.svg" alt=""/></button>

  <div class="dropdown">
      <a @click="dropdownStatus" class="btn btn-secondary-light rounded-circle">
        <i class="fa fa-bars"></i>
      </a>
      <div :class="{ active: dropdown === true }" class="dropdown-content">
        <button  @click="dropdown = null" class="dropdown-close-button">
              <img src="/images/close.svg" />
            </button>

        <h5 class="text-center p-2">аккаунт</h5>
        <span>
          <template v-if="currentUser">
            <a @click="signOut">Выйти</a>
        </template>
        <template v-else>
         <router-link  :to="{ name: 'signIn' }">Войти</router-link>
          <a href="/registration"> Регистрация </a>
       
        </template>
    </span>
        <h5 class="text-center p-2">навигация</h5>
        <span>
            <router-link  :to="{ name: 'index' }">Календарь</router-link>
            <template v-if="currentUser && currentUser.userRole.name === 'admin'">
              <router-link  :to="{ name: 'users' }">Пользователи</router-link>
              <router-link  :to="{ name: 'departments' }">Отделы</router-link>
            </template>
            
        </span>
      </div>
    </div>
</template>
<script>
import { useToast } from "vue-toastification";

export default {
  setup() {
    const toast = useToast();

    return {
      toast,
    };
  },
  data() {
    return {
      dropdown: null,
    };
  },
  computed: {
    currentUser() {
      return this.$store.getters["currentUser"].user;
    },
  },
  methods: {
    signOut() {
      if (this.currentUser) {
        this.$cookies.remove("token");

        this.$store.dispatch("logout");

        this.toast.success("Вы успешно вышли из аккаунта");

        this.$router.push("/sign-in");
      }
    },
  },
};
</script>
<style>
.menu-btn {
  float:right;
  margin: 0 20px 20px 0;
  padding: 8px;
  background-color: white;
  border-radius: 4px;
  line-height: 40px;
}
.menu-btn img {
  width: 45px;
  height: 45px;
  display: block;
  margin: auto;
  
}
</style>