<script>
    import BaseCanvasLayout from '@/Shared/CanvasLayout'
    
    export default {
        name: "CreateAlumni",
        layout: (h, dashboard) => h(BaseCanvasLayout, {
            props: {
              errors: Object,
            }
        }, [dashboard]),

        metaInfo: {
            title: 'Alumni'
        },
        components: {
            
        },
        data () {
          return {
            form: this.$inertia.form({
            course_id: null,
            student_full_name: null,
            year: null,
            summary: null,
            featured_image: null,
            imagepreview: null,
            documents: null,
          })
        }
        },
        methods: {
            imageSelected(e) {
              let reader = new FileReader();
              reader.readAsDataURL(this.form.featured_image ? this.form.featured_image : new Blob());
              reader.onload = e => {
                this.form.imagepreview = e.target.result ? e.target.result : null;
              }
            }
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
          <h4 class="mb-0 font-size-18">Alumni</h4>

          <div class="page-title-right">
            <b-button-group class="btn-group-sm mt-2">
                <b-button v-b-modal.action-info variant="secondary">
                    <i class="bx bx-info-circle"></i>
                </b-button>
                <inertia-link class="btn btn-secondary" :href="route('canvas.alumnis.index')" method="get">
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
            <b-form @submit.prevent="form.post('/canvas/alumnis')">
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
              <b-form-group label="Ano Lectivo" label-for="year">
                <b-form-input id="year" type="text" v-model="form.year" :class="{'is-invalid': form.errors.year}"></b-form-input>
                <div v-if="form.errors.year" class="invalid-feedback animated fadeIn">{{form.errors.year}}</div>
              </b-form-group>
              <b-form-group label="Nome Completo" label-for="student_full_name">
                <b-form-input id="student_full_name" type="text" v-model="form.student_full_name" :class="{'is-invalid': form.errors.student_full_name}"></b-form-input>
                <div v-if="form.errors.student_full_name" class="invalid-feedback animated fadeIn">{{form.errors.student_full_name}}</div>
              </b-form-group>
              <b-form-group label="Sumário" label-for="summary">
                <b-form-textarea
                  id="summary"
                  v-model="form.summary"
                  placeholder=""
                  rows="3"
                  max-rows="6"
                ></b-form-textarea>
                <div v-if="form.errors.summary" class="invalid-feedback animated fadeIn">{{form.errors.summary}}</div>
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
            <h4 class="card-title mb-4">Imagem e Documentos</h4>
            <b-form-group label="Image" label-for="image">
            <b-input-group>
                <b-form-file id="image"
                          size="sm"
                          name="image"
                          browse-text="Procurar"
                          v-model="form.featured_image"
                          placeholder="Escolha uma imagem ou arraste-o aqui"
                          drop-placeholder="Solte a imagem aqui"
                          @input="imageSelected">
                </b-form-file>
                <template #append>
                  <b-button size="sm" @click="form.imagepreview = null, form.featured_image = null">
                      <i class="bx bx-trash"></i>
                  </b-button>
                </template>
              </b-input-group>
            </b-form-group>
            <b-form-group label="Image Preview" label-for="imagepreview">
              <div class="col-md-5">
                  <img class="rounded" :src="form.imagepreview" alt="" width="200">
              </div>
            </b-form-group>
            <hr>
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