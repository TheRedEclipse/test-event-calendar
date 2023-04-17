<template>
<div class="block">
            <div class="card-header">Войти в аккаунт</div>
            <div class="modal-body">
          <slot name="body">
            <p>Имя</p>
            <input  v-model="form.username" type="text" placeholder="Имя" />
            <p>Пароль</p>
            <input  v-model="form.password" type="password" placeholder="Пароль" />
          </slot>
        </div>
        <div class="modal-footer">
          <slot name="footer">
            <button  @click="sendCredentials()">Войти</button>
          </slot>
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
      form: {
        username: null,
        password: null
      },
    };
  },
  methods: {
    sendCredentials() {
      this.emailError = null

      this.passwordError = null

      this.$axios
        .post("auth/sign-in", this.form)
        .then((response) => {
          if (response.data.success === true) {
            this.$cookies.set('token', response.data.accessToken, response.data.expiresIn)

            this.$store.commit('logined', { user: response.data })

            this.toast.success("Вы успешно зашли в аккаунт");

            this.$router.push('/')
          }
        })
    },
  },
};
</script>