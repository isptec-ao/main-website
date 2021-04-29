<script>
    import BaseCanvasLayout from '@/Shared/CanvasLayout'
    
    export default {
        name: "LangShortCourseClass",
        layout: (h, dashboard) => h(BaseCanvasLayout, {
            props: {
              errors: Object,
              shortcourseclass: Object,
              lang: String,
            }
        }, [dashboard]),

        metaInfo: {
            title: 'Cursos de Curta Duração - Turmas'
        },
        components: {
            
        },
        data () {
          return {
            form: this.$inertia.form({
            course_id: this.$page.props.shortcourseclass.course,
            name: this.$page.props.shortcourseclass.name,
            description: this.$page.props.shortcourseclass.description,
            total_hours: this.$page.props.shortcourseclass.total_hours,
            start_date: this.$page.props.shortcourseclass.start_date,
            end_date: this.$page.props.shortcourseclass.end_date,
            start_time: this.$page.props.shortcourseclass.start_time,
            end_time: this.$page.props.shortcourseclass.end_time,
            price: this.$page.props.shortcourseclass.price,
            registration_fee: this.$page.props.shortcourseclass.registration_fee,
            featured_image: null,
            imagepreview: null,
            documents: null,
            lang: this.$page.props.lang,
            _method: 'PUT'
          })
        }
        },
        methods: {
            settranslation(id) {
              this.$inertia.put(this.route('canvas.shortcourseclasses.settranslation', id));
          },
          imageSelected(e) {
              let reader = new FileReader();
              reader.readAsDataURL(this.form.featured_image ? this.form.featured_image : new Blob());
              reader.onload = e => {
                this.form.imagepreview = e.target.result ? e.target.result : null;
              }
            },
          downloadAllAttachments () {
                window.open(route('canvas.shortcourseclasses.downloadallattachments') + '?model_id=' + this.$page.post.id);
            },

            downloadSingleAttachment (id) {
                window.open(route('canvas.shortcourseclasses.downloadsingleattachment') + '?model_id=' + id);
            },
            deleteSingleAttachment (id) {
                window.open(route('canvas.shortcourseclasses.deletesingleattachment') + '?model_id=' + id);
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
          <h4 class="mb-0 font-size-18">Cursos de Curta Duração - Turmas</h4>

          <div class="page-title-right">
            <b-button-group class="btn-group-sm mt-2">
                <b-button v-b-modal.action-info variant="secondary">
                    <i class="bx bx-info-circle"></i>
                </b-button>
                <inertia-link class="btn btn-secondary" :href="route('canvas.shortcourseclasses.index')" method="get">
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
            <b-form @submit.prevent="form.post(route('canvas.shortcourseclasses.settranslation', $page.props.shortcourseclass.id))">
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
              <b-form-group label="Turma" label-for="name">
                <b-form-input id="name" type="text" v-model="form.name" :class="{'is-invalid': form.errors.name}"></b-form-input>
                <div v-if="form.errors.name" class="invalid-feedback animated fadeIn">{{form.errors.name}}</div>
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
            <b-form-group label="Carga Horária" label-for="total_hours">
                <b-form-input id="total_hours" type="number" v-model="form.total_hours" :class="{'is-invalid': form.errors.total_hours}"></b-form-input>
                <div v-if="form.errors.total_hours" class="invalid-feedback animated fadeIn">{{form.errors.total_hours}}</div>
              </b-form-group>
              <b-form-group label="Data - Início" label-for="start_date">
                <b-form-datepicker id="start_date" v-model="form.start_date" locale="pt" class="mb-2"></b-form-datepicker>
                <div v-if="form.errors.start_date" class="invalid-feedback animated fadeIn">{{form.errors.start_date}}</div>
              </b-form-group>
              <b-form-group label="Data - Fim" label-for="end_date">
                <b-form-datepicker id="end_date" v-model="form.end_date" locale="pt" class="mb-2"></b-form-datepicker>
                <div v-if="form.errors.end_date" class="invalid-feedback animated fadeIn">{{form.errors.end_date}}</div>
              </b-form-group>
              <b-form-group label="Hora - Início" label-for="start_time">
                <b-form-timepicker v-model="form.start_time" locale="pt"></b-form-timepicker>
                <div v-if="form.errors.start_time" class="invalid-feedback animated fadeIn">{{form.errors.start_time}}</div>
              </b-form-group>
              <b-form-group label="Hora - Fim" label-for="end_time">
                <b-form-timepicker v-model="form.end_time" locale="pt-pt"></b-form-timepicker>
                <div v-if="form.errors.end_time" class="invalid-feedback animated fadeIn">{{form.errors.end_time}}</div>
              </b-form-group>
              <b-form-group label="Preço" label-for="price">
                <b-form-input id="price" type="number" v-model="form.price" :class="{'is-invalid': form.errors.price}"></b-form-input>
                <div v-if="form.errors.price" class="invalid-feedback animated fadeIn">{{form.errors.price}}</div>
              </b-form-group>
              <b-form-group label="Taxa de Inscrição" label-for="registration_fee">
                <b-form-input id="registration_fee" type="number" v-model="form.registration_fee" :class="{'is-invalid': form.errors.registration_fee}"></b-form-input>
                <div v-if="form.errors.registration_fee" class="invalid-feedback animated fadeIn">{{form.errors.registration_fee}}</div>
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
            <b-form-group label="Pre-visualização" label-for="imagepreview">
              <div class="col-md-5">
                  <img class="rounded" :src="$page.props.featured_image !== null && !form.featured_image ? $page.props.featured_image.image_url : form.imagepreview" alt="" width="200">
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