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
                                        <h5 class="">Recuperação de Senha</h5>
                                        <p>Vou ajudar-lhe a reestabelecer o acesso.</p>
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
                            <div class="p-2">

                                <form @submit.prevent="submit">
                                    <slot />
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input :class="{'is-invalid': $page.errors.email, 'is-valid': $page.status.length>0}" v-model="form.email" :errors="$page.errors.email" type="email" name="email" class="form-control" id="email" placeholder="Insira o seu email" />
                                        <div v-if="$page.errors.email" class="invalid-feedback animated fadeIn">{{ $page.errors.email[0] }}</div>
                                        <div v-if="$page.status.length>0" class="valid-feedback animated fadeIn">{{ $page.status }}</div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-12 text-right">
                                            <button class="btn btn-block btn-brand btn-rounded w-md" type="submit" v-if="!sending">Enviar Instruções</button>
                                            <b-button class="btn btn-block btn-rounded" variant="brand" disabled v-if="sending">
                                                <b-spinner small type="grow"></b-spinner>
                                            </b-button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="mt-5 text-center">
                            <p>
                                Lembrou-se?
                                <inertia-link class="font-weight-medium text-primary" :href="route('canvas.login')" method="get">
                                    Faça o Login AQUI
                                </inertia-link>
                            </p>
                            <p>
                                © {{new Date().getFullYear()}} Project X. Desenvolvido com
                                <i class="mdi mdi-heart text-brand"></i> pelo ISPTEC
                            </p>
                        </div>
                    </div>
                    <!-- end col -->
            </div>
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
      sending: false,
      form: {
        email: '',
        password: '',
        remember: null,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.route('canvas.password.email'), {
        email: this.form.email,
        password: this.form.password,
      }).then(() => this.sending = false)
    },
    toast(toaster, append = false, title, message) {
        this.counter++
        this.$bvToast.toast(`Toast ${this.counter} body content`, {
          title: `Toaster ${toaster}`,
          toaster: toaster,
          solid: true,
          appendToast: append
        })
      }

  },
}
</script>
