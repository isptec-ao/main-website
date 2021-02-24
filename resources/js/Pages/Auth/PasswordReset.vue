<template>
<div id="page-container">
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
                                        <p>Este é o último passo.</p>
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
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Nova Senha</label>
                                        <input :class="{'is-invalid': $page.errors.password}" v-model="form.password" :errors="$page.errors.password" type="password" class="form-control" id="password" name="password" placeholder="Senha">
                                        <div v-if="$page.errors.password" class="invalid-feedback animated fadeIn">{{ $page.errors.password[0] }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirmar Nova Senha</label>
                                        <input :class="{'is-invalid': $page.errors.password_confirmation}" v-model="form.password_confirmation" :errors="$page.errors.password_confirmation" type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmar Senha">
                                        <div v-if="$page.errors.password_confirmation" class="invalid-feedback animated fadeIn">{{ $page.errors.password_confirmation[0] }}</div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-12 text-right">
                                            <button class="btn btn-brand btn-block btn-rounded w-md" type="submit" v-if="!sending">Repor Senha</button>
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
                            © {{new Date().getFullYear()}} Project X. Desenvolvido com
                            <i class="mdi mdi-heart text-brand"></i> pelo ISPTEC
                        </p>
                    </div>
                </div>
                <!-- end col -->
            </div>
        </div>
    </div>
</div>

</template>

<script>

export default {
  metaInfo: { title: 'Recuperação de Senha' },
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
        password_confirmation: '',
        token: window.location.href.substr(window.location.href.lastIndexOf('/')+1)
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.route('canvas.password.reset'), {
        email: this.form.email,
        password: this.form.password,
        password_confirmation: this.form.password_confirmation,
        token: this.form.token
      }).then(() => this.sending = false)
    },
    token() {
        window.location.href.substr(window.location.href.lastIndexOf('/')+1);
    }

  },
}
</script>
