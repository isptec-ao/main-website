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
                                        <h5 class="">Confirmação de Senha</h5>
                                        <p>Não voltarei a pedir durante algumas horas.</p>
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
                                        <input :class="{'is-invalid': $page.errors.password}" v-model="form.password" :errors="$page.errors.password" type="password" class="form-control form-control-lg form-control" id="password" name="password" placeholder="Senha">
                                        <div v-if="$page.errors.password" class="invalid-feedback animated fadeIn">{{ $page.errors.password[0] }}</div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-12 text-right">
                                            <button class="btn btn-block btn-brand btn-rounded w-md" type="submit" v-if="!sending">Confirmar</button>
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
                            Esqueceu-se?
                            <inertia-link class="text-muted" :href="route('canvas.password.email')" method="get">
                                <i class="mdi mdi-lock mr-1"></i> Recupera AQUI
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
  metaInfo: { title: 'Confirmação de Senha' },
  components: {

  },
  props: {
    errors: Object,
  },
  data() {
    return {
      sending: false,
      form: {
        password: '',
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.route('canvas.password.confirm'), {
        password: this.form.password,
      }).then(() => this.sending = false)
    }

  },
}
</script>
