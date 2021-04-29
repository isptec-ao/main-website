<template>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-soft-brand">
                            <div class="row">
                                <div class="col-7">
                                    <div class="p-4">
                                        <h5 class="">Bemvindo!</h5>
                                        <p>Eu sou o Projecto X</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="/images/profile-img.png" alt class="img-fluid" />
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <inertia-link href="/">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-brand">
                                          <img src="/images/logo.svg" alt height="34" />
                                        </span>
                                    </div>
                                </inertia-link>
                            </div>

                            <b-form class="p-2" @submit.prevent="form.post('/login')">
                                <slot />
                                <b-form-group label="Email / Usuário" label-for="login">
                                    <b-form-input v-model="form.login" type="text" :class="{'is-invalid': form.errors.email || form.errors.username}" id="login" name="login" placeholder="Email / Usuário"></b-form-input>
                                    <div v-if="form.errors.email || form.errors.username" class="invalid-feedback animated fadeIn">{{( form.errors.email ? form.errors.email : form.errors.username )}}</div>
                                </b-form-group>

                                <b-form-group label="Password" label-for="password">
                                    <b-form-input
                                        :class="{'is-invalid': form.errors.password}"
                                        v-model="form.password"
                                        :errors="form.errors.password"
                                        type="password"
                                        id="password"
                                        name="password"
                                        placeholder="Inserir Senha"
                                    ></b-form-input>
                                    <div v-if="form.errors.password" class="invalid-feedback animated fadeIn">{{ form.errors.password }}</div>
                                </b-form-group>
                                <div class="custom-control custom-checkbox">
                                    <input v-model="form.remember" type="checkbox" id="login-remember" name="login-remember" class="custom-control-input" />
                                    <label class="custom-control-label" for="login-remember">Lembrar Acesso?</label>
                                </div>
                                <div class="mt-3">
                                    <b-button type="submit" variant="brand" class="btn-block btn-rounded" v-if="!form.processing">LOGIN</b-button>
                                    <b-button class="btn btn-block btn-rounded" variant="brand" v-if="form.processing">
                                        <b-spinner small type="grow"></b-spinner>
                                    </b-button>
                                </div>
                                <div class="mt-4 text-center">
                                    <inertia-link class="text-muted" :href="route('canvas.password.email')" method="get">
                                        <i class="mdi mdi-lock mr-1"></i> Recuperar Senha?
                                   </inertia-link>
                                </div>
                        </b-form>
                    </div>
                            <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="mt-5 text-center">
                        <p>
                            © {{new Date().getFullYear()}} Project X. Desenvolvido com
                            <i class="mdi mdi-heart text-brand"></i> pelo ISPTEC
                        </p>
                    </div>
                    <!-- end row -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
            </div>
    </div>

</template>

<script>

export default {
  metaInfo: { title: 'Login' },
  components: {

  },
  props: {
    errors: Object,
  },
  data() {
    return {
        form: this.$inertia.form({
        login: null,
        password: null,
        remember: false,
      }),
    //   sending: false,
    //   form: {
    //     login: '',
    //     password: '',
    //     remember: null,
    //   },
    }
  },
  methods: {
    // submit() {
    //   this.sending = true
    //   this.$inertia.post(this.route('login.attempt'), {
    //     login: this.form.login,
    //     password: this.form.password,
    //     remember: this.form.remember,
    //   }).then(() => this.sending = false)
    // },
    // toast(toaster, append = false, title, message) {
    //     this.counter++
    //     this.$bvToast.toast(`Toast ${this.counter} body content`, {
    //       title: `Toaster ${toaster}`,
    //       toaster: toaster,
    //       solid: true,
    //       appendToast: append
    //     })
    //   }

  },
}
</script>
