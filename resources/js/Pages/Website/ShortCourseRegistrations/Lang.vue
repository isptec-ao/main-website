<script>
    import BaseCanvasLayout from '@/Shared/CanvasLayout'
    
    export default {
        name: "LangShortCourseRegistration",
        layout: (h, dashboard) => h(BaseCanvasLayout, {
            props: {
              errors: Object,
              shortcourseregistration: Object,
              lang: String,
            }
        }, [dashboard]),

        metaInfo: {
            title: 'Cursos de Curta Duração'
        },
        components: {
            
        },
        data () {
          return {
            form: this.$inertia.form({
            class_id: this.$page.props.shortcourseregistration.class,
            full_name: this.$page.props.shortcourseregistration.full_name,
            description: this.$page.props.shortcourseregistration.description,
            dob: this.$page.props.shortcourseregistration.dob,
            id_no: this.$page.props.shortcourseregistration.id_no,
            email: this.$page.props.shortcourseregistration.email,
            tel_no: this.$page.props.shortcourseregistration.tel_no,
            institution: this.$page.props.shortcourseregistration.institution,
            paid: this.$page.props.shortcourseregistration.paid,
            registration_active: this.$page.props.shortcourseregistration.registration_active,
            is_student: this.$page.props.shortcourseregistration.is_student,
            documents: null,
            lang: this.$page.props.lang,
            _method: 'PUT'
          })
        }
        },
        methods: {
            settranslation(id) {
              this.$inertia.put(this.route('canvas.shortcourseregistrations.settranslation', id));
          },
          downloadAllAttachments () {
                window.open(route('canvas.shortcourseregistrations.downloadallattachments') + '?model_id=' + this.$page.post.id);
            },

            downloadSingleAttachment (id) {
                window.open(route('canvas.shortcourseregistrations.downloadsingleattachment') + '?model_id=' + id);
            },
            deleteSingleAttachment (id) {
                window.open(route('canvas.shortcourseregistrations.deletesingleattachment') + '?model_id=' + id);
            },  
        },
        computed: {

        },
        mounted() {

        },
    }
</script>
<template>
  <div>
      <!-- start page title -->
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="mb-0 font-size-18">Cursos de Curta Duração</h4>

          <div class="page-title-right">
            <b-button-group class="btn-group-sm mt-2">
                <b-button v-b-modal.action-info variant="secondary">
                    <i class="bx bx-info-circle"></i>
                </b-button>
                <inertia-link class="btn btn-secondary" :href="route('canvas.shortcourseregistrations.index')" method="get">
                    <i class="bx bx-arrow-back"></i>
                </inertia-link>
            </b-button-group>
          </div>
        </div>
      </div>
    </div>
    <!-- end page title -->

    <div class="row">
      <div class="col-lg-7">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Adicionar Translation: {{ $page.props.lang.toUpperCase() }}</h4>

            <!-- Create Service Categories Form -->
            <b-form @submit.prevent="form.post(route('canvas.shortcourseregistrations.settranslation', $page.props.shortcourseregistration.id))">
              <slot />
              <b-form-group label="Turma" label-for="class_id">
              <multiselect
                  id="ajax"
                  v-model="form.class_id"
                  :options="$page.props.classes"
                  label="name"
                  track-by="id"
                  placeholder="Escreva para pesquisar"
                  open-direction="bottom"
                  deselect-label="Pressione Enter para excluir"
                  select-label="Pressione Enter para seleccionar"
                  selected-label="Seleccionado"
                  tag-placeholder="Pressione Enter para criar etiqueta"
              >
              <span slot="noOptions">A lista está vazia</span>
              </multiselect>
              <div v-if="form.errors.class_id" class="invalid-feedback animated fadeIn">{{form.errors.class_id}}</div>
              </b-form-group>
              <b-form-group label="Formando" label-for="full_name">
                <b-form-input id="full_name" type="text" v-model="form.full_name" :class="{'is-invalid': form.errors.full_name}"></b-form-input>
                <div v-if="form.errors.full_name" class="invalid-feedback animated fadeIn">{{form.errors.full_name}}</div>
              </b-form-group>
              <b-form-group label="Descrição" label-for="description">
                <b-form-textarea
                  id="description"
                  v-model="form.description"
                  placeholder=""
                  rows="3"
                  max-rows="6"
                ></b-form-textarea>
                <div v-if="form.errors.description" class="invalid-feedback animated fadeIn">{{form.errors.description}}</div>
            </b-form-group>

              <b-form-group label="Data de Nascimento" label-for="dob">
                <b-form-datepicker id="dob" v-model="form.dob" locale="pt" class="mb-2"></b-form-datepicker>
                <div v-if="form.errors.dob" class="invalid-feedback animated fadeIn">{{form.errors.dob}}</div>
              </b-form-group>
              
              <b-form-group label="N. B.I." label-for="id_no">
                <b-form-input id="id_no" type="text" v-model="form.id_no" :class="{'is-invalid': form.errors.id_no}"></b-form-input>
                <div v-if="form.errors.id_no" class="invalid-feedback animated fadeIn">{{form.errors.id_no}}</div>
              </b-form-group>

              <b-form-group label="Email" label-for="email">
                <b-form-input id="email" type="text" v-model="form.email" :class="{'is-invalid': form.errors.email}"></b-form-input>
                <div v-if="form.errors.email" class="invalid-feedback animated fadeIn">{{form.errors.email}}</div>
              </b-form-group>

              <b-form-group label="Tel No" label-for="tel_no">
                <b-form-input id="tel_no" type="text" v-model="form.tel_no" :class="{'is-invalid': form.errors.tel_no}"></b-form-input>
                <div v-if="form.errors.tel_no" class="invalid-feedback animated fadeIn">{{form.errors.tel_no}}</div>
              </b-form-group>

              <b-form-group label="Instituição" label-for="institution">
                <b-form-input id="institution" type="text" v-model="form.institution" :class="{'is-invalid': form.errors.institution}"></b-form-input>
                <div v-if="form.errors.institution" class="invalid-feedback animated fadeIn">{{form.errors.institution}}</div>
              </b-form-group>

              <b-form-group label="Estudante?" label-for="is_student">
                  <b-form-checkbox switch class="mt-2 custom-control custom-switch" v-model="form.is_student" id="is_student">
                      {{ (form.is_student ? 'SIM' : 'NÃO') }}
                  </b-form-checkbox>
              </b-form-group>

              <b-form-group label="Inscrição Activa?" label-for="registration_active">
                  <b-form-checkbox switch class="mt-2 custom-control custom-switch" v-model="form.registration_active" id="registration_active">
                      {{ (form.registration_active ? 'SIM' : 'NÃO') }}
                  </b-form-checkbox>
              </b-form-group>

              <b-form-group label="Pagamento Efectuado?" label-for="paid">
                  <b-form-checkbox switch class="mt-2 custom-control custom-switch" v-model="form.paid" id="paid">
                      {{ (form.paid ? 'SIM' : 'NÃO') }}
                  </b-form-checkbox>
              </b-form-group>
                <b-button type="submit" class="btn btn-rounded" variant="brand" v-if="!form.processing">Registar</b-button>
                <b-button class="btn btn-block btn-rounded" variant="brand" v-if="form.processing">
                    <b-spinner small type="grow"></b-spinner>
                </b-button>
            </b-form>
          </div>
        </div>

      </div>
      <!-- end col -->

      <div class="col-lg-5">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Documentos</h4>
            <b-form-group label="Documentos" label-for="documents">
              <b-input-group>
                <b-form-file id="documents"
                          multiple
                          size="sm"
                          name="documents"
                          browse-text="Procurar"
                          v-model="form.documents"
                          placeholder="Escolha um ficheiro ou arraste-o aqui"
                          drop-placeholder="Solte o ficheiro aqui">
                </b-form-file>
                <template #append>
                  <b-button size="sm" @click="form.documents = null">
                      <i class="bx bx-trash"></i>
                  </b-button>
                </template>
              </b-input-group>
            </b-form-group>
          </div>
          <b-form-group>
          <table class="table table-centered table-hover" v-if="$page.props.documents">
                <tbody>
                  <tr v-for="(document, index) in $page.props.documents" :key="index">
                    <td>
                      <h5 class="font-size-14 mb-1">
                        <small><a href="javascript: void(0);" class="text-dark">{{ document.name }}</a></small>
                      </h5>
                      <small>{{ document.size }}</small>
                    </td>
                    <td>
                      <div class="text-center">
                        <a href="javascript: void(0);" class="text-dark">
                          <i class="bx bx-trash h6 text-danger m-0" @click="deleteSingleAttachment(document.id)"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
              </b-form-group>
        </div>  
    </div>
    </div>
    <!-- end row -->
  </div>
</template>