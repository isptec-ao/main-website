<script>
    import BaseCanvasLayout from '@/Shared/CanvasLayout'
    
    export default {
        name: "CreateCoursePlan",
        layout: (h, dashboard) => h(BaseCanvasLayout, {
            props: {
              errors: Object,
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
            course_id: null,
            subject_id: null,
            semester_id: null,
            theoretical: null,
            practical: null,
            theoretical_practical: null,
            weekly_hours: null,
            semester_hours: null,
            documents: null,
          })
        }
        },
        methods: {
            
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
            <h4 class="card-title mb-4">Adicionar</h4>

            <!-- Create Departments Form -->
            <b-form @submit.prevent="form.post('/canvas/courseplans')">
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
        </div>  
    </div>
    <!-- end row -->
  </div>
  </div>
</template>