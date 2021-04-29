<script>
    import BaseCanvasLayout from '@/Shared/CanvasLayout'
    
    export default {
        name: "LangCoursePlan",
        layout: (h, dashboard) => h(BaseCanvasLayout, {
            props: {
              errors: Object,
              courseplan: Object,
              lang: String,
            }
        }, [dashboard]),

        metaInfo: {
            title: 'Plano Curricular'
        },
        components: {
            
        },
        data () {
          return {
            form: this.$inertia.form({
            theoretical: this.$page.props.courseplan.theoretical,
            practical: this.$page.props.courseplan.practical,
            theoretical_practical: this.$page.props.courseplan.theoretical_practical,
            weekly_hours: this.$page.props.courseplan.weekly_hours,
            semester_hours: this.$page.props.courseplan.semester_hours,
            course_id: this.$page.props.courseplan.course,
            subject_id: this.$page.props.courseplan.subject,
            semester_id: this.$page.props.courseplan.semester,
            documents: null,
            lang: this.$page.props.lang,
            _method: 'PUT'
          })
        }
        },
        methods: {
            settranslation(id) {
              this.$inertia.put(this.route('canvas.courseplans.settranslation', id));
          },
        
          downloadAllAttachments () {
                window.open(route('canvas.courseplans.downloadallattachments') + '?model_id=' + this.$page.post.id);
            },

            downloadSingleAttachment (id) {
                window.open(route('canvas.courseplans.downloadsingleattachment') + '?model_id=' + id);
            },
            deleteSingleAttachment (id) {
                window.open(route('canvas.courseplans.deletesingleattachment') + '?model_id=' + id);
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
          <h4 class="mb-0 font-size-18">Plano Curricular</h4>

          <div class="page-title-right">
            <b-button-group class="btn-group-sm mt-2">
                <b-button v-b-modal.action-info variant="secondary">
                    <i class="bx bx-info-circle"></i>
                </b-button>
                <inertia-link class="btn btn-secondary" :href="route('canvas.courseplans.index')" method="get">
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
            <b-form @submit.prevent="form.post(route('canvas.courseplans.settranslation', $page.props.courseplan.id))">
              <slot />
              <b-form-group label="Curso" label-for="course_id">
              <multiselect
                  id="ajax"
                  v-model="form.course_id"
                  :options="$page.props.courses"
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
              <div v-if="form.errors.course_id" class="invalid-feedback animated fadeIn">{{form.errors.course_id}}</div>
              </b-form-group>
              <b-form-group label="Disciplina" label-for="subject_id">
              <multiselect
                  id="ajax"
                  v-model="form.subject_id"
                  :options="$page.props.subjects"
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
              <div v-if="form.errors.subject_id" class="invalid-feedback animated fadeIn">{{form.errors.subject_id}}</div>
              </b-form-group>
              <b-form-group label="Semestre" label-for="semester_id">
              <multiselect
                  id="ajax"
                  v-model="form.semester_id"
                  :options="$page.props.semesters"
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
              <div v-if="form.errors.semester_id" class="invalid-feedback animated fadeIn">{{form.errors.semester_id}}</div>
              </b-form-group>
              <b-form-group label="T" label-for="theoretical">
                <b-form-input id="theoretical" type="number" v-model="form.theoretical" :class="{'is-invalid': form.errors.theoretical}"></b-form-input>
                <div v-if="form.errors.theoretical" class="invalid-feedback animated fadeIn">{{form.errors.theoretical}}</div>
              </b-form-group>
              <b-form-group label="P" label-for="practical">
                <b-form-input id="practical" type="number" v-model="form.practical" :class="{'is-invalid': form.errors.practical}"></b-form-input>
                <div v-if="form.errors.practical" class="invalid-feedback animated fadeIn">{{form.errors.practical}}</div>
              </b-form-group>
              <b-form-group label="TP" label-for="theoretical_practical">
                <b-form-input id="theoretical_practical" type="number" v-model="form.theoretical_practical" :class="{'is-invalid': form.errors.theoretical_practical}"></b-form-input>
                <div v-if="form.errors.theoretical_practical" class="invalid-feedback animated fadeIn">{{form.errors.theoretical_practical}}</div>
              </b-form-group>
              <b-form-group label="Horas / Semana" label-for="weekly_hours">
                <b-form-input id="weekly_hours" type="number" v-model="form.weekly_hours" :class="{'is-invalid': form.errors.weekly_hours}"></b-form-input>
                <div v-if="form.errors.weekly_hours" class="invalid-feedback animated fadeIn">{{form.errors.weekly_hours}}</div>
              </b-form-group>
              <b-form-group label="Horas / Semestre" label-for="semester_hours">
                <b-form-input id="semester_hours" type="number" v-model="form.semester_hours" :class="{'is-invalid': form.errors.semester_hours}"></b-form-input>
                <div v-if="form.errors.semester_hours" class="invalid-feedback animated fadeIn">{{form.errors.semester_hours}}</div>
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