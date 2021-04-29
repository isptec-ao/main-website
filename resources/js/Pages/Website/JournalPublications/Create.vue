<script>
    import BaseCanvasLayout from '@/Shared/CanvasLayout'
    
    export default {
        name: "CreateJournalPublication",
        layout: (h, dashboard) => h(BaseCanvasLayout, {
            props: {
              errors: Object,
            }
        }, [dashboard]),

        metaInfo: {
            title: 'Revistas - Publicações'
        },
        components: {
            
        },
        data () {
          return {
            form: this.$inertia.form({
            title: null,
            summary: null,
            extra_data: null,
            journal_name: null,
            authors: null,
            category_id: null,
            reference: null,
            lecturers: null,
            external_url: null,
            published_at: null,
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
          <h4 class="mb-0 font-size-18">Revistas - Publicações</h4>

          <div class="page-title-right">
            <b-button-group class="btn-group-sm mt-2">
                <b-button v-b-modal.action-info variant="secondary">
                    <i class="bx bx-info-circle"></i>
                </b-button>
                <inertia-link class="btn btn-secondary" :href="route('canvas.journalpublications.index')" method="get">
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
            <b-form @submit.prevent="form.post('/canvas/journalpublications')">
              <slot />
              <b-form-group label="Revista - Categoria" label-for="category_id">
              <multiselect
                  id="ajax"
                  v-model="form.category_id"
                  :options="$page.props.categories"
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
              <div v-if="form.errors.category_id" class="invalid-feedback animated fadeIn">{{form.errors.category_id}}</div>
              </b-form-group>
              <b-form-group label="Título" label-for="title">
                <b-form-input id="title" type="text" v-model="form.title" :class="{'is-invalid': form.errors.title}"></b-form-input>
                <div v-if="form.errors.title" class="invalid-feedback animated fadeIn">{{form.errors.title}}</div>
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
            <b-form-group label="Dados Adicionais" label-for="extra_data">
                <b-form-textarea
                  id="extra_data"
                  v-model="form.extra_data"
                  placeholder=""
                  rows="3"
                  max-rows="6"
                ></b-form-textarea>
                <div v-if="form.errors.extra_data" class="invalid-feedback animated fadeIn">{{form.errors.extra_data}}</div>
            </b-form-group>
            <b-form-group label="Revista" label-for="journal_name">
                <b-form-input id="journal_name" type="text" v-model="form.journal_name" :class="{'is-invalid': form.errors.journal_name}"></b-form-input>
                <div v-if="form.errors.journal_name" class="invalid-feedback animated fadeIn">{{form.errors.journal_name}}</div>
              </b-form-group>
            <b-form-group label="Data - Publicação" label-for="published_at">
                <b-form-datepicker id="published_at" v-model="form.published_at" locale="pt" class="mb-2"></b-form-datepicker>
                <div v-if="form.errors.published_at" class="invalid-feedback animated fadeIn">{{form.errors.published_at}}</div>
              </b-form-group>
              <b-form-group label="Referência" label-for="reference">
                <b-form-input id="reference" type="text" v-model="form.reference" :class="{'is-invalid': form.errors.reference}"></b-form-input>
                <div v-if="form.errors.reference" class="invalid-feedback animated fadeIn">{{form.errors.reference}}</div>
              </b-form-group>
              <b-form-group label="Link Externo" label-for="external_url">
                <b-form-input id="external_url" type="url" v-model="form.external_url" :class="{'is-invalid': form.errors.external_url}"></b-form-input>
                <div v-if="form.errors.external_url" class="invalid-feedback animated fadeIn">{{form.errors.external_url}}</div>
              </b-form-group>
              <b-form-group label="Autores" label-for="authors">
                <b-form-input id="authors" type="text" v-model="form.authors" :class="{'is-invalid': form.errors.authors}"></b-form-input>
                <div v-if="form.errors.authors" class="invalid-feedback animated fadeIn">{{form.errors.authors}}</div>
              </b-form-group>
              <b-form-group label="Docentes" label-for="lecturers">
                <b-form-input id="lecturers" type="text" v-model="form.lecturers" :class="{'is-invalid': form.errors.lecturers}"></b-form-input>
                <div v-if="form.errors.lecturers" class="invalid-feedback animated fadeIn">{{form.errors.lecturers}}</div>
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